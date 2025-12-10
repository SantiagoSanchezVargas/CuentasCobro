<?php

namespace App\Http\Controllers;

use App\Models\PermisoGranular;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermisoController extends Controller
{
    /**
     * Mostrar matriz de permisos
     */
    public function index()
    {
        // Solo Super Admin o Admin Programa puede gestionar permisos
        if (!Auth::user()->hasAnyRole(['super_admin', 'admin_programa'])) {
            abort(403, 'Solo Super Admin puede acceder a la gestión de permisos');
        }

        $roles = Role::all();
        $permisos = PermisoGranular::with('role')->get();

        // Agrupar por rol
        $permisosPorRol = [];
        foreach ($roles as $role) {
            $permisosPorRol[$role->name] = PermisoGranular::where('role_id', $role->id)
                ->activos()
                ->get();
        }

        return view('permisos.index', compact('roles', 'permisos', 'permisosPorRol'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        if (!Auth::user()->hasAnyRole(['super_admin', 'admin_programa'])) {
            abort(403);
        }

        $roles = Role::all();
        $etapasFluj = ['supervisor', 'ordenador_gasto', 'contratacion', 'alcalde', 'tesoreria'];
        $estados = ['en_revision', 'aprobado', 'rechazado', 'en_correccion'];

        return view('permisos.create', compact('roles', 'etapasFluj', 'estados'));
    }

    /**
     * Guardar nuevo permiso
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasAnyRole(['super_admin', 'admin_programa'])) {
            abort(403);
        }

        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'puede_crear' => 'boolean',
            'puede_leer' => 'boolean',
            'puede_editar' => 'boolean',
            'puede_eliminar' => 'boolean',
            'puede_aprobar' => 'boolean',
            'puede_rechazar' => 'boolean',
            'puede_devolver' => 'boolean',
            'puede_devolver_correccion' => 'boolean',
            'puede_comentar' => 'boolean',
            'puede_subir_documentos' => 'boolean',
            'puede_descargar_documentos' => 'boolean',
            'puede_registrar_pago' => 'boolean',
            'puede_enviar_cliente' => 'boolean',
            'puede_archivar' => 'boolean',
            'puede_ver_todas_cuentas' => 'boolean',
            'puede_ver_reportes' => 'boolean',
            'puede_gestionar_usuarios' => 'boolean',
            'puede_gestionar_contratos' => 'boolean',
            'etapa_flujo' => 'nullable|string',
            'descripcion' => 'nullable|string|max:500',
        ]);

        $permiso = PermisoGranular::create([
            'role_id' => $request->role_id,
            'etapa_flujo' => $request->etapa_flujo,
            'puede_crear' => (bool)$request->puede_crear,
            'puede_leer' => (bool)$request->puede_leer,
            'puede_editar' => (bool)$request->puede_editar,
            'puede_eliminar' => (bool)$request->puede_eliminar,
            'puede_aprobar' => (bool)$request->puede_aprobar,
            'puede_rechazar' => (bool)$request->puede_rechazar,
            'puede_devolver' => (bool)$request->puede_devolver,
            'puede_devolver_correccion' => (bool)$request->puede_devolver_correccion,
            'puede_comentar' => (bool)$request->puede_comentar,
            'puede_subir_documentos' => (bool)$request->puede_subir_documentos,
            'puede_descargar_documentos' => (bool)$request->puede_descargar_documentos,
            'puede_registrar_pago' => (bool)$request->puede_registrar_pago,
            'puede_enviar_cliente' => (bool)$request->puede_enviar_cliente,
            'puede_archivar' => (bool)$request->puede_archivar,
            'puede_ver_todas_cuentas' => (bool)$request->puede_ver_todas_cuentas,
            'puede_ver_reportes' => (bool)$request->puede_ver_reportes,
            'puede_gestionar_usuarios' => (bool)$request->puede_gestionar_usuarios,
            'puede_gestionar_contratos' => (bool)$request->puede_gestionar_contratos,
            'campos_visibles' => $request->campos_visibles ? json_encode($request->campos_visibles) : null,
            'campos_editables' => $request->campos_editables ? json_encode($request->campos_editables) : null,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('permisos.index')
            ->with('success', 'Permiso granular creado correctamente');
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        if (!Auth::user()->hasAnyRole(['super_admin', 'admin_programa'])) {
            abort(403);
        }

        $permiso = PermisoGranular::findOrFail($id);
        $roles = Role::all();
        $etapasFluj = ['supervisor', 'ordenador_gasto', 'contratacion', 'alcalde', 'tesoreria'];

        return view('permisos.edit', compact('permiso', 'roles', 'etapasFluj'));
    }

    /**
     * Actualizar permiso
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasAnyRole(['super_admin', 'admin_programa'])) {
            abort(403);
        }

        $permiso = PermisoGranular::findOrFail($id);

        $request->validate([
            'puede_crear' => 'boolean',
            'puede_leer' => 'boolean',
            'puede_editar' => 'boolean',
            'puede_eliminar' => 'boolean',
            'puede_aprobar' => 'boolean',
            'puede_rechazar' => 'boolean',
            'puede_devolver' => 'boolean',
            'puede_devolver_correccion' => 'boolean',
            'puede_comentar' => 'boolean',
            'puede_subir_documentos' => 'boolean',
            'puede_descargar_documentos' => 'boolean',
            'puede_registrar_pago' => 'boolean',
            'puede_enviar_cliente' => 'boolean',
            'puede_archivar' => 'boolean',
            'puede_ver_todas_cuentas' => 'boolean',
            'puede_ver_reportes' => 'boolean',
            'puede_gestionar_usuarios' => 'boolean',
            'puede_gestionar_contratos' => 'boolean',
        ]);

        $permiso->update([
            'puede_crear' => (bool)$request->puede_crear,
            'puede_leer' => (bool)$request->puede_leer,
            'puede_editar' => (bool)$request->puede_editar,
            'puede_eliminar' => (bool)$request->puede_eliminar,
            'puede_aprobar' => (bool)$request->puede_aprobar,
            'puede_rechazar' => (bool)$request->puede_rechazar,
            'puede_devolver' => (bool)$request->puede_devolver,
            'puede_devolver_correccion' => (bool)$request->puede_devolver_correccion,
            'puede_comentar' => (bool)$request->puede_comentar,
            'puede_subir_documentos' => (bool)$request->puede_subir_documentos,
            'puede_descargar_documentos' => (bool)$request->puede_descargar_documentos,
            'puede_registrar_pago' => (bool)$request->puede_registrar_pago,
            'puede_enviar_cliente' => (bool)$request->puede_enviar_cliente,
            'puede_archivar' => (bool)$request->puede_archivar,
            'puede_ver_todas_cuentas' => (bool)$request->puede_ver_todas_cuentas,
            'puede_ver_reportes' => (bool)$request->puede_ver_reportes,
            'puede_gestionar_usuarios' => (bool)$request->puede_gestionar_usuarios,
            'puede_gestionar_contratos' => (bool)$request->puede_gestionar_contratos,
        ]);

        return redirect()->route('permisos.index')
            ->with('success', 'Permisos actualizados correctamente');
    }

    /**
     * Eliminar permiso
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasAnyRole(['super_admin', 'admin_programa'])) {
            abort(403);
        }

        $permiso = PermisoGranular::findOrFail($id);
        $permiso->delete();

        return redirect()->route('permisos.index')
            ->with('success', 'Permiso eliminado');
    }

    /**
     * Obtener matriz de permisos en JSON (para AJAX)
     */
    public function matrizJson()
    {
        // El middleware ya se encarga de la autorización
        
        $roles = Role::all();
        $matriz = [];

        foreach ($roles as $role) {
            $permisos = PermisoGranular::where('role_id', $role->id)
                ->activos()
                ->get()
                ->map(fn($p) => $p->getResumenPermisos())
                ->toArray();

            $matriz[$role->name] = $permisos;
        }

        return response()->json($matriz);
    }

    /**
     * Aplicar plantilla de permisos predefinida
     */
    public function aplicarPlantilla(Request $request, $roleId)
    {
        if (!Auth::user()->hasAnyRole(['super_admin', 'admin_programa'])) {
            abort(403);
        }

        $role = Role::findOrFail($roleId);
        $plantilla = $request->plantilla;

        // Plantillas predefinidas
        $plantillas = [
            'contratista' => [
                'puede_crear' => true,
                'puede_leer' => true,
                'puede_editar' => true,
                'puede_subir_documentos' => true,
                'puede_descargar_documentos' => true,
                'puede_archivar' => true,
            ],
            'supervisor' => [
                'puede_leer' => true,
                'puede_aprobar' => true,
                'puede_rechazar' => true,
                'puede_comentar' => true,
                'puede_descargar_documentos' => true,
                'puede_ver_reportes' => true,
            ],
            'ordenador_gasto' => [
                'puede_leer' => true,
                'puede_aprobar' => true,
                'puede_rechazar' => true,
                'puede_devolver' => true,
                'puede_comentar' => true,
                'puede_descargar_documentos' => true,
                'puede_enviar_cliente' => true,
                'puede_ver_todas_cuentas' => true,
                'puede_ver_reportes' => true,
            ],
            'contratacion' => [
                'puede_leer' => true,
                'puede_aprobar' => true,
                'puede_rechazar' => true,
                'puede_devolver' => true,
                'puede_devolver_correccion' => true,
                'puede_comentar' => true,
                'puede_descargar_documentos' => true,
                'puede_gestionar_contratos' => true,
            ],
            'alcalde' => [
                'puede_leer' => true,
                'puede_aprobar' => true,
                'puede_rechazar' => true,
                'puede_devolver' => true,
                'puede_comentar' => true,
                'puede_descargar_documentos' => true,
                'puede_enviar_cliente' => true,
                'puede_ver_todas_cuentas' => true,
                'puede_ver_reportes' => true,
            ],
            'tesoreria' => [
                'puede_leer' => true,
                'puede_comentar' => true,
                'puede_descargar_documentos' => true,
                'puede_registrar_pago' => true,
                'puede_devolver' => true,
                'puede_enviar_cliente' => true,
                'puede_ver_reportes' => true,
            ],
        ];

        if (!isset($plantillas[$plantilla])) {
            return response()->json(['error' => 'Plantilla no existe'], 400);
        }

        // Crear o actualizar permisos
        PermisoGranular::updateOrCreate(
            ['role_id' => $role->id],
            array_merge(['role_id' => $role->id], $plantillas[$plantilla])
        );

        return response()->json(['success' => true, 'message' => 'Plantilla aplicada']);
    }
}
