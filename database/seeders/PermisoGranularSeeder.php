<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\PermisoGranular;
use Illuminate\Database\Seeder;

class PermisoGranularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Flujo: auxiliar → administrador → tesoreria
     */
    public function run(): void
    {
        // Obtener roles
        $roles = [
            'auxiliar' => Role::where('name', 'auxiliar')->first(),
            'administrador' => Role::where('name', 'administrador')->first(),
            'tesoreria' => Role::where('name', 'tesoreria')->first(),
            'admin_programa' => Role::where('name', 'admin_programa')->first(),
            'super_admin' => Role::where('name', 'super_admin')->first(),
        ];

        // ========================================
        // AUXILIAR (Primera etapa - Crea cuentas)
        // ========================================
        if ($roles['auxiliar']) {
            PermisoGranular::create([
                'role_id' => $roles['auxiliar']->id,
                'etapa_flujo' => 'auxiliar',
                'descripcion' => 'Permisos del Auxiliar - Creación y gestión inicial',
                'puede_crear' => true,
                'puede_leer' => true,
                'puede_editar' => true,
                'puede_subir_documentos' => true,
                'puede_descargar_documentos' => true,
                'puede_comentar' => true,
                'puede_archivar' => false,
                'campos_visibles' => json_encode(['numero', 'fecha_emision', 'nombre_beneficiario', 'valor_total', 'estado_aprobacion', 'created_at']),
                'campos_editables' => json_encode(['nombre_beneficiario', 'numero_cuenta_beneficiario', 'banco_beneficiario', 'observaciones']),
            ]);
        }

        // ========================================
        // ADMINISTRADOR (Segunda etapa - Aprobación)
        // ========================================
        if ($roles['administrador']) {
            PermisoGranular::create([
                'role_id' => $roles['administrador']->id,
                'etapa_flujo' => 'administrador',
                'descripcion' => 'Permisos del Administrador - Revisión y aprobación',
                'puede_crear' => true,
                'puede_leer' => true,
                'puede_editar' => true,
                'puede_aprobar' => true,
                'puede_rechazar' => true,
                'puede_devolver' => true,
                'puede_devolver_correccion' => true,
                'puede_comentar' => true,
                'puede_subir_documentos' => true,
                'puede_descargar_documentos' => true,
                'puede_enviar_cliente' => true,
                'puede_ver_todas_cuentas' => true,
                'puede_ver_reportes' => true,
                'puede_gestionar_contratos' => true,
                'puede_gestionar_usuarios' => false,
                'campos_visibles' => json_encode(['numero', 'fecha_emision', 'nombre_beneficiario', 'valor_total', 'departamento', 'municipio', 'items', 'documentos', 'estado_aprobacion', 'etapa_aprobacion', 'estado_pago', 'historial']),
            ]);
        }

        // ========================================
        // TESORERÍA (Tercera etapa - Pagos)
        // ========================================
        if ($roles['tesoreria']) {
            PermisoGranular::create([
                'role_id' => $roles['tesoreria']->id,
                'etapa_flujo' => 'tesoreria',
                'descripcion' => 'Permisos de Tesorería - Registro de pagos',
                'puede_leer' => true,
                'puede_registrar_pago' => true,
                'puede_comentar' => true,
                'puede_descargar_documentos' => true,
                'puede_devolver' => true,
                'puede_enviar_cliente' => true,
                'puede_ver_reportes' => true,
                'puede_ver_todas_cuentas' => true,
                'campos_visibles' => json_encode(['numero', 'fecha_emision', 'nombre_beneficiario', 'valor_total', 'numero_cuenta_beneficiario', 'banco_beneficiario', 'items', 'documentos', 'estado_aprobacion', 'estado_pago']),
                'campos_editables' => json_encode(['numero_cuenta_beneficiario', 'banco_beneficiario']),
            ]);
        }

        // ========================================
        // ADMIN PROGRAMA (Todos los permisos)
        // ========================================
        if ($roles['admin_programa']) {
            PermisoGranular::create([
                'role_id' => $roles['admin_programa']->id,
                'etapa_flujo' => null,
                'descripcion' => 'Permisos Totales del Admin del Programa',
                'puede_crear' => true,
                'puede_leer' => true,
                'puede_editar' => true,
                'puede_eliminar' => true,
                'puede_aprobar' => true,
                'puede_rechazar' => true,
                'puede_devolver' => true,
                'puede_devolver_correccion' => true,
                'puede_comentar' => true,
                'puede_subir_documentos' => true,
                'puede_descargar_documentos' => true,
                'puede_registrar_pago' => true,
                'puede_enviar_cliente' => true,
                'puede_archivar' => true,
                'puede_ver_todas_cuentas' => true,
                'puede_ver_reportes' => true,
                'puede_gestionar_usuarios' => true,
                'puede_gestionar_contratos' => true,
            ]);
        }

        // ========================================
        // SUPER ADMIN (Todos los permisos)
        // ========================================
        if ($roles['super_admin']) {
            PermisoGranular::create([
                'role_id' => $roles['super_admin']->id,
                'etapa_flujo' => null,
                'descripcion' => 'Permisos Totales del Super Admin',
                'puede_crear' => true,
                'puede_leer' => true,
                'puede_editar' => true,
                'puede_eliminar' => true,
                'puede_aprobar' => true,
                'puede_rechazar' => true,
                'puede_devolver' => true,
                'puede_devolver_correccion' => true,
                'puede_comentar' => true,
                'puede_subir_documentos' => true,
                'puede_descargar_documentos' => true,
                'puede_registrar_pago' => true,
                'puede_enviar_cliente' => true,
                'puede_archivar' => true,
                'puede_ver_todas_cuentas' => true,
                'puede_ver_reportes' => true,
                'puede_gestionar_usuarios' => true,
                'puede_gestionar_contratos' => true,
            ]);
        }

        $this->command->info('✅ Permisos granulares creados exitosamente');
    }
}
