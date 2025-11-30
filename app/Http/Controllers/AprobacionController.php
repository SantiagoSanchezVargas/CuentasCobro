<?php

namespace App\Http\Controllers;

use App\Models\CuentaCobro;
use App\Models\Interaccion;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AprobacionController extends Controller
{
    /**
     * Mostrar formulario de aprobación
     */
    public function mostrarModalAprobacion($id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        $usuario = Auth::user();

        // Verificar que puede aprobar
        if (!$cuenta->canUserApprove($usuario)) {
            return response()->json(['error' => 'No puedes aprobar esta cuenta'], 403);
        }

        return response()->json([
            'cuenta' => $cuenta,
            'resumenFinanciero' => $cuenta->getResumenFinanciero(),
            'documentosOk' => $cuenta->tieneTodosDocumentosObligatorios(),
            'etapaActual' => $cuenta->getEtapaTexto(),
        ]);
    }

    /**
     * Enviar al siguiente nivel
     */
    public function enviarAlSiguiente(Request $request, $id)
    {
        $cuenta = CuentaCobro::with('items', 'contrato')->findOrFail($id);
        $usuario = Auth::user();

        // Verificar autorización
        if (!$cuenta->canUserApprove($usuario)) {
            return response()->json(['error' => 'No tienes permiso para esta acción'], 403);
        }

        $request->validate([
            'comentario' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $estadoAnterior = $cuenta->estado_aprobacion;
            $etapaAnterior = $cuenta->etapa_aprobacion;

            // Mapeo de etapas
            $siguienteEtapa = match($etapaAnterior) {
                'supervisor' => 'ordenador_gasto',
                'ordenador_gasto' => 'contratacion',
                'contratacion' => 'alcalde',
                'alcalde' => 'tesoreria',
                default => null,
            };

            if (!$siguienteEtapa) {
                return response()->json(['error' => 'No hay siguiente etapa'], 400);
            }

            // Actualizar cuenta
            $cuenta->update([
                'etapa_aprobacion' => $siguienteEtapa,
                'estado_aprobacion' => 'en_revision',
                'fecha_ultima_modificacion' => now(),
                'modificado_por' => $usuario->id,
            ]);

            // Registrar en historial
            $cuenta->registrarHistorial(
                $usuario->id,
                'Enviado al Siguiente Nivel',
                $estadoAnterior,
                'en_revision',
                $request->comentario ?? "Enviado a {$cuenta->getEtapaTexto()} por {$usuario->name}"
            );

            // Registrar interacción
            Interaccion::registrar(
                $cuenta->id,
                'aprobacion',
                'Enviado a ' . $cuenta->getEtapaTexto(),
                $request->comentario,
                $usuario->id
            );

            // Notificar al siguiente rol
            $this->notificarSiguienteRol($cuenta, $siguienteEtapa, $usuario);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Cuenta enviada a {$cuenta->getEtapaTexto()}",
                'cuenta' => $cuenta->fresh(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al enviar cuenta: ' . $e->getMessage());
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Rechazar cuenta
     */
    public function rechazar(Request $request, $id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        $usuario = Auth::user();

        // Verificar autorización
        if (!$cuenta->canUserApprove($usuario)) {
            return response()->json(['error' => 'No tienes permiso'], 403);
        }

        $request->validate([
            'motivo' => 'required|string|max:1000',
            'justificacion' => 'nullable|string|max:2000',
        ]);

        try {
            DB::beginTransaction();

            $estadoAnterior = $cuenta->estado_aprobacion;

            // Actualizar cuenta
            $cuenta->update([
                'estado_aprobacion' => 'rechazado',
                'motivo_rechazo' => $request->motivo,
                'justificacion_rechazo' => $request->justificacion,
                'fecha_rechazo' => now(),
                'estado_pago' => 'rejected',
                'etapa_aprobacion' => null,
                'fecha_ultima_modificacion' => now(),
                'modificado_por' => $usuario->id,
            ]);

            // Registrar en historial
            $cuenta->registrarHistorial(
                $usuario->id,
                'Rechazado',
                $estadoAnterior,
                'rechazado',
                "Motivo: {$request->motivo}"
            );

            // Registrar interacción
            Interaccion::registrar(
                $cuenta->id,
                'rechazo',
                'Cuenta Rechazada',
                $request->justificacion ?: $request->motivo,
                $usuario->id
            );

            // Notificar al contratista
            $this->notificarRechazo($cuenta, $usuario, $request->motivo);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cuenta rechazada correctamente',
                'cuenta' => $cuenta->fresh(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al rechazar cuenta: ' . $e->getMessage());
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Devolver a etapa anterior
     */
    public function devolverAnterior(Request $request, $id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        $usuario = Auth::user();

        // Solo ciertos roles pueden devolver
        $rolesConPermisoDevolver = ['ordenador_gasto', 'contratacion', 'alcalde', 'tesoreria', 'super_admin'];
        if (!in_array($usuario->role?->name, $rolesConPermisoDevolver)) {
            return response()->json(['error' => 'No tienes permiso para devolver'], 403);
        }

        $request->validate([
            'motivo' => 'required|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $etapaAnterior = match($cuenta->etapa_aprobacion) {
                'ordenador_gasto' => 'supervisor',
                'contratacion' => 'ordenador_gasto',
                'alcalde' => 'contratacion',
                'tesoreria' => 'alcalde',
                default => null,
            };

            if (!$etapaAnterior) {
                return response()->json(['error' => 'No hay etapa anterior'], 400);
            }

            $cuenta->update([
                'etapa_aprobacion' => $etapaAnterior,
                'estado_aprobacion' => 'en_revision',
                'motivo_devolucion' => $request->motivo,
                'fecha_ultima_modificacion' => now(),
                'modificado_por' => $usuario->id,
            ]);

            // Registrar en historial
            $cuenta->registrarHistorial(
                $usuario->id,
                'Devuelto a Etapa Anterior',
                'en_revision',
                'en_revision',
                "Devuelto a " . ($cuenta->getEtapaTexto()) . ": {$request->motivo}"
            );

            // Notificar
            Interaccion::registrar(
                $cuenta->id,
                'devolucion',
                'Devuelto a ' . $cuenta->getEtapaTexto(),
                $request->motivo,
                $usuario->id
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Cuenta devuelta a " . $cuenta->getEtapaTexto(),
                'cuenta' => $cuenta->fresh(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Devolver para corrección (solo Contratación)
     */
    public function devolverCorreccion(Request $request, $id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        $usuario = Auth::user();

        // Solo Contratación puede devolver para corrección
        if (!$usuario->hasRole('contratacion') && !$usuario->hasRole('super_admin')) {
            return response()->json(['error' => 'Solo Contratación puede devolver para corrección'], 403);
        }

        $request->validate([
            'observaciones' => 'required|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $cuenta->update([
                'estado_aprobacion' => 'en_correccion',
                'etapa_aprobacion' => 'contratista',
                'motivo_devolucion' => $request->observaciones,
                'fecha_ultima_modificacion' => now(),
                'modificado_por' => $usuario->id,
            ]);

            // Registrar en historial
            $cuenta->registrarHistorial(
                $usuario->id,
                'Devuelto para Corrección',
                'en_revision',
                'en_correccion',
                $request->observaciones
            );

            // Registrar interacción
            Interaccion::registrar(
                $cuenta->id,
                'devolucion',
                'Devuelto para Corrección',
                $request->observaciones,
                $usuario->id
            );

            // Notificar al contratista
            $this->notificarDevolucionCorreccion($cuenta, $usuario, $request->observaciones);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cuenta devuelta para corrección. El contratista puede editar y reenviar.',
                'cuenta' => $cuenta->fresh(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Agregar interacción sin cambiar estado
     */
    public function agregarInteraccion(Request $request, $id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        $usuario = Auth::user();

        // Verificar que puede comentar
        if (!$usuario->puedeRealizarAccion('comentar')) {
            return response()->json(['error' => 'No tienes permiso para comentar'], 403);
        }

        $request->validate([
            'asunto' => 'required|string|max:200',
            'detalle' => 'required|string|max:2000',
            'tipo' => 'nullable|in:nota_manual,recordatorio_pago,llamada,email_enviado,aprobacion,rechazo,devolucion,pago_registrado',
        ]);

        try {
            $interaccion = Interaccion::registrar(
                $cuenta->id,
                $request->tipo ?? 'nota_manual',
                $request->asunto,
                $request->detalle,
                $usuario->id
            );

            return response()->json([
                'success' => true,
                'message' => 'Interacción agregada',
                'interaccion' => $interaccion,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Obtener historial completo
     */
    public function obtenerHistorial($id)
    {
        $cuenta = CuentaCobro::findOrFail($id);
        $usuario = Auth::user();

        // Verificar acceso
        if ($usuario->hasRole('contratista') && $cuenta->user_id !== $usuario->id) {
            return response()->json(['error' => 'No tienes permiso'], 403);
        }

        $historial = $cuenta->getHistorialCompleto();

        return response()->json([
            'success' => true,
            'historial' => $historial,
        ]);
    }

    /**
     * Notificar al siguiente rol
     */
    private function notificarSiguienteRol($cuenta, $etapa, $usuarioAnterior)
    {
        $rolesNotificacion = [
            'supervisor' => 'Supervisor',
            'ordenador_gasto' => 'Ordenador del Gasto',
            'contratacion' => 'Contratación',
            'alcalde' => 'Alcalde',
            'tesoreria' => 'Tesorería',
        ];

        $usuarios = User::whereHas('role', fn($q) => $q->where('name', $etapa))->get();

        foreach ($usuarios as $usuario) {
            Notificacion::create([
                'user_id' => $usuario->id,
                'titulo' => "Nueva cuenta para validar #" . $cuenta->numero,
                'mensaje' => "Cuenta de cobro #" . $cuenta->numero . " ($ " . number_format($cuenta->valor_total, 2) . ") enviada por " . $usuarioAnterior->name,
                'tipo' => 'nueva_cuenta',
                'relacionado_id' => $cuenta->id,
                'relacionado_tipo' => 'CuentaCobro',
            ]);
        }
    }

    /**
     * Notificar rechazo
     */
    private function notificarRechazo($cuenta, $usuario, $motivo)
    {
        Notificacion::create([
            'user_id' => $cuenta->user_id,
            'titulo' => "Cuenta rechazada #" . $cuenta->numero,
            'mensaje' => "Motivo: " . substr($motivo, 0, 100),
            'tipo' => 'cuenta_rechazada',
            'relacionado_id' => $cuenta->id,
            'relacionado_tipo' => 'CuentaCobro',
        ]);
    }

    /**
     * Notificar devolución para corrección
     */
    private function notificarDevolucionCorreccion($cuenta, $usuario, $observaciones)
    {
        Notificacion::create([
            'user_id' => $cuenta->user_id,
            'titulo' => "Cuenta #" . $cuenta->numero . " devuelta para corrección",
            'mensaje' => "Por favor corrige los siguientes puntos: " . substr($observaciones, 0, 100),
            'tipo' => 'cuenta_devuelta',
            'relacionado_id' => $cuenta->id,
            'relacionado_tipo' => 'CuentaCobro',
        ]);
    }
}
