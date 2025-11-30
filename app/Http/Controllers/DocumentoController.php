<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\CuentaCobro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentoController extends Controller
{
    /**
     * Mostrar documentos de una cuenta
     */
    public function index($cuentaCobroId)
    {
        $cuenta = CuentaCobro::findOrFail($cuentaCobroId);

        // Verificar autorización
        $this->autorizar('ver', $cuenta);

        $documentos = $cuenta->documentos()
            ->notArchived()
            ->visiblesParaUsuario(Auth::user())
            ->get();

        return view('documentos.index', compact('cuenta', 'documentos'));
    }

    /**
     * Mostrar formulario de carga
     */
    public function create($cuentaCobroId)
    {
        $cuenta = CuentaCobro::findOrFail($cuentaCobroId);

        // Verificar autorización
        if (!Auth::user()->puedeRealizarAccion('subir_documentos')) {
            abort(403, 'No tienes permiso para subir documentos');
        }

        $tiposDocumento = [
            'factura' => 'Factura',
            'contrato' => 'Contrato',
            'comprobante' => 'Comprobante de Pago',
            'otro' => 'Otro Documento',
        ];

        $categorias = [
            'soporte' => 'Soporte/Evidencia',
            'contrato' => 'Contrato',
            'comprobante_pago' => 'Comprobante de Pago',
            'anexo' => 'Anexo',
        ];

        return view('documentos.create', compact('cuenta', 'tiposDocumento', 'categorias'));
    }

    /**
     * Guardar documento
     */
    public function store(Request $request, $cuentaCobroId)
    {
        $cuenta = CuentaCobro::findOrFail($cuentaCobroId);

        $request->validate([
            'documento' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
            'tipo_documento' => 'required|in:factura,contrato,comprobante,otro',
            'categoria' => 'nullable|in:soporte,contrato,comprobante_pago,anexo',
            'descripcion' => 'nullable|string|max:500',
            'etiquetas' => 'nullable|string',
            'visibilidad' => 'required|in:private,internal,public',
        ]);

        // Verificar autorización
        if (!Auth::user()->puedeRealizarAccion('subir_documentos')) {
            return response()->json(['error' => 'No tienes permiso'], 403);
        }

        // Verificar límites de almacenamiento
        if ($request->file('documento')->getSize() > 10 * 1024 * 1024) {
            return response()->json(['error' => 'Archivo demasiado grande (máximo 10MB)'], 422);
        }

        try {
            $archivo = $request->file('documento');
            $nombreOriginal = $archivo->getClientOriginalName();
            $nombreAlmacenado = time() . '_' . str_slug($nombreOriginal) . '.' . $archivo->getClientOriginalExtension();

            // Crear directorio si no existe
            $ruta = 'documentos/cuentas_cobro/' . $cuenta->id;
            Storage::makeDirectory($ruta);

            // Guardar archivo
            $rutaArchivo = $archivo->storeAs($ruta, $nombreAlmacenado, 'public');

            // Crear registro de documento
            $documento = Documento::create([
                'cuenta_cobro_id' => $cuenta->id,
                'nombre_original' => $nombreOriginal,
                'nombre_almacenado' => $nombreAlmacenado,
                'tipo_documento' => $request->tipo_documento,
                'mime_type' => $archivo->getMimeType(),
                'tamaño_bytes' => $archivo->getSize(),
                'descripcion' => $request->descripcion,
                'categoria' => $request->categoria,
                'etiquetas' => $request->etiquetas ? json_encode(explode(',', $request->etiquetas)) : null,
                'user_id' => Auth::id(),
                'ruta_disco' => 'public',
                'ruta_archivo' => $rutaArchivo,
                'visibilidad' => $request->visibilidad,
                'roles_acceso' => json_encode(['supervisor', 'ordenador_gasto', 'contratacion', 'alcalde', 'tesoreria', 'super_admin']),
            ]);

            // Registrar en historial
            $cuenta->registrarHistorial(
                Auth::id(),
                'Documento Subido',
                $cuenta->estado_aprobacion,
                $cuenta->estado_aprobacion,
                "Documento: {$nombreOriginal} ({$documento->tipo_documento})"
            );

            return response()->json([
                'success' => true,
                'message' => 'Documento subido correctamente',
                'documento' => $documento,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al subir documento: ' . $e->getMessage());
            return response()->json(['error' => 'Error al subir el documento: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Descargar documento
     */
    public function descargar($documentoId)
    {
        $documento = Documento::findOrFail($documentoId);
        $usuario = Auth::user();

        // Verificar autorización
        if (!$documento->puedeDescargar($usuario)) {
            abort(403, 'No tienes permiso para descargar este documento');
        }

        // Verificar que el archivo existe
        if (!Storage::disk($documento->ruta_disco)->exists($documento->ruta_archivo)) {
            abort(404, 'El archivo no existe');
        }

        // Registrar descarga
        $documento->registrarDescarga();

        return Storage::disk($documento->ruta_disco)->download($documento->ruta_archivo, $documento->nombre_original);
    }

    /**
     * Ver documento en línea
     */
    public function ver($documentoId)
    {
        $documento = Documento::findOrFail($documentoId);
        $usuario = Auth::user();

        // Verificar autorización
        if (!$documento->puedeDescargar($usuario)) {
            abort(403, 'No tienes permiso para ver este documento');
        }

        // Registrar descarga
        $documento->registrarDescarga();

        $url = Storage::disk($documento->ruta_disco)->url($documento->ruta_archivo);

        return view('documentos.ver', compact('documento', 'url'));
    }

    /**
     * Eliminar documento
     */
    public function destroy($documentoId)
    {
        $documento = Documento::findOrFail($documentoId);
        $cuenta = $documento->cuentaCobro;

        // Verificar autorización
        $usuario = Auth::user();
        if ($usuario->id !== $documento->user_id && !$usuario->hasRole('super_admin')) {
            abort(403, 'No tienes permiso para eliminar este documento');
        }

        try {
            // Eliminar archivo del almacenamiento
            $documento->eliminarDelAlmacenamiento();

            // Registrar en historial
            $cuenta->registrarHistorial(
                Auth::id(),
                'Documento Eliminado',
                $cuenta->estado_aprobacion,
                $cuenta->estado_aprobacion,
                "Documento eliminado: {$documento->nombre_original}"
            );

            // Eliminar registro
            $documento->delete();

            return response()->json(['success' => true, 'message' => 'Documento eliminado']);
        } catch (\Exception $e) {
            \Log::error('Error al eliminar documento: ' . $e->getMessage());
            return response()->json(['error' => 'Error al eliminar el documento'], 500);
        }
    }

    /**
     * Crear nueva versión de documento
     */
    public function crearVersion(Request $request, $documentoId)
    {
        $documento = Documento::findOrFail($documentoId);

        $request->validate([
            'documento' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:10240',
            'descripcion' => 'nullable|string|max:500',
        ]);

        try {
            $archivo = $request->file('documento');
            $nombreAlmacenado = time() . '_v' . ($documento->version + 1) . '_' . str_slug($archivo->getClientOriginalName()) . '.' . $archivo->getClientOriginalExtension();

            // Guardar nueva versión
            $ruta = 'documentos/cuentas_cobro/' . $documento->cuenta_cobro_id;
            $rutaArchivo = $archivo->storeAs($ruta, $nombreAlmacenado, 'public');

            // Crear nueva versión
            $nuevaVersion = $documento->crearNuevaVersion($rutaArchivo, $request->descripcion);

            // Registrar en historial
            $documento->cuentaCobro->registrarHistorial(
                Auth::id(),
                'Documento Versionado',
                $documento->cuentaCobro->estado_aprobacion,
                $documento->cuentaCobro->estado_aprobacion,
                "Nueva versión del documento: {$documento->nombre_original} (v{$nuevaVersion->version})"
            );

            return response()->json([
                'success' => true,
                'message' => 'Nueva versión creada',
                'documento' => $nuevaVersion,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error al crear versión: ' . $e->getMessage());
            return response()->json(['error' => 'Error al crear versión'], 500);
        }
    }

    /**
     * Obtener historial de versiones
     */
    public function versiones($documentoId)
    {
        $documento = Documento::findOrFail($documentoId);
        $usuario = Auth::user();

        // Verificar autorización
        if (!$documento->puedeDescargar($usuario)) {
            abort(403, 'No tienes permiso');
        }

        // Obtener todas las versiones
        $versiones = Documento::where(function ($q) use ($documento) {
            $q->where('id', $documento->id)
              ->orWhere('documento_anterior_id', $documento->id);
        })
        ->orWhere(function ($q) use ($documento) {
            // También obtener versiones previas
            return $q->where('id', $documento->id);
        })
        ->orderByDesc('version')
        ->get();

        return view('documentos.versiones', compact('documento', 'versiones'));
    }

    /**
     * Archivar documento
     */
    public function archivar($documentoId)
    {
        $documento = Documento::findOrFail($documentoId);
        $usuario = Auth::user();

        // Verificar autorización
        if ($usuario->id !== $documento->user_id && !$usuario->hasRole('super_admin')) {
            abort(403, 'No tienes permiso');
        }

        $documento->archivar();

        return response()->json(['success' => true, 'message' => 'Documento archivado']);
    }

    /**
     * Desarchivar documento
     */
    public function desarchivizar($documentoId)
    {
        $documento = Documento::findOrFail($documentoId);
        $usuario = Auth::user();

        // Verificar autorización
        if ($usuario->id !== $documento->user_id && !$usuario->hasRole('super_admin')) {
            abort(403, 'No tienes permiso');
        }

        $documento->desarchivizar();

        return response()->json(['success' => true, 'message' => 'Documento desarchivado']);
    }

    /**
     * Autorizar acciones
     */
    private function autorizar($accion, $cuenta)
    {
        $usuario = Auth::user();

        if ($usuario->hasRole('super_admin')) {
            return true;
        }

        if ($usuario->hasRole('contratista') && $cuenta->user_id === $usuario->id) {
            return true;
        }

        if (in_array($usuario->role?->name, ['supervisor', 'ordenador_gasto', 'contratacion', 'alcalde', 'tesoreria'])) {
            return true;
        }

        abort(403, 'No tienes permiso para acceder a esta cuenta');
    }
}
