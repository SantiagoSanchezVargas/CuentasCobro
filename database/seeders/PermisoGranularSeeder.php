<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\PermisoGranular;
use Illuminate\Database\Seeder;

class PermisoGranularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener roles
        $roles = [
            'contratista' => Role::where('name', 'contratista')->first(),
            'supervisor' => Role::where('name', 'supervisor')->first(),
            'ordenador_gasto' => Role::where('name', 'ordenador_gasto')->first(),
            'contratacion' => Role::where('name', 'contratacion')->first(),
            'alcalde' => Role::where('name', 'alcalde')->first(),
            'tesoreria' => Role::where('name', 'tesoreria')->first(),
            'super_admin' => Role::where('name', 'super_admin')->first(),
        ];

        // ========================================
        // CONTRATISTA
        // ========================================
        PermisoGranular::create([
            'role_id' => $roles['contratista']->id,
            'etapa_flujo' => null,
            'descripcion' => 'Permisos del Contratista',
            'puede_crear' => true,
            'puede_leer' => true,
            'puede_editar' => true,
            'puede_subir_documentos' => true,
            'puede_descargar_documentos' => true,
            'puede_comentar' => true,
            'puede_archivar' => true,
            'campos_visibles' => json_encode(['numero', 'fecha_emision', 'nombre_beneficiario', 'valor_total', 'estado_aprobacion', 'created_at']),
            'campos_editables' => json_encode(['nombre_beneficiario', 'numero_cuenta_beneficiario', 'banco_beneficiario', 'observaciones']),
        ]);

        // ========================================
        // SUPERVISOR (Primera etapa)
        // ========================================
        PermisoGranular::create([
            'role_id' => $roles['supervisor']->id,
            'etapa_flujo' => 'supervisor',
            'descripcion' => 'Permisos del Supervisor en su etapa',
            'puede_leer' => true,
            'puede_aprobar' => true,
            'puede_rechazar' => true,
            'puede_comentar' => true,
            'puede_descargar_documentos' => true,
            'puede_ver_reportes' => true,
            'campos_visibles' => json_encode(['numero', 'fecha_emision', 'nombre_beneficiario', 'valor_total', 'departamento', 'municipio', 'items', 'documentos', 'estado_aprobacion']),
        ]);

        // ========================================
        // ORDENADOR DEL GASTO
        // ========================================
        PermisoGranular::create([
            'role_id' => $roles['ordenador_gasto']->id,
            'etapa_flujo' => 'ordenador_gasto',
            'descripcion' => 'Permisos del Ordenador del Gasto',
            'puede_leer' => true,
            'puede_aprobar' => true,
            'puede_rechazar' => true,
            'puede_devolver' => true,
            'puede_comentar' => true,
            'puede_descargar_documentos' => true,
            'puede_enviar_cliente' => true,
            'puede_ver_todas_cuentas' => true,
            'puede_ver_reportes' => true,
            'campos_visibles' => json_encode(['numero', 'fecha_emision', 'nombre_beneficiario', 'valor_total', 'departamento', 'municipio', 'items', 'documentos', 'estado_aprobacion', 'etapa_aprobacion', 'estado_pago']),
        ]);

        // ========================================
        // CONTRATACIÓN
        // ========================================
        PermisoGranular::create([
            'role_id' => $roles['contratacion']->id,
            'etapa_flujo' => 'contratacion',
            'descripcion' => 'Permisos de Contratación',
            'puede_leer' => true,
            'puede_aprobar' => true,
            'puede_rechazar' => true,
            'puede_devolver' => true,
            'puede_devolver_correccion' => true,
            'puede_comentar' => true,
            'puede_descargar_documentos' => true,
            'puede_gestionar_contratos' => true,
            'campos_visibles' => json_encode(['numero', 'fecha_emision', 'contrato_id', 'nombre_beneficiario', 'valor_total', 'items', 'documentos', 'estado_aprobacion']),
        ]);

        // ========================================
        // ALCALDE
        // ========================================
        PermisoGranular::create([
            'role_id' => $roles['alcalde']->id,
            'etapa_flujo' => 'alcalde',
            'descripcion' => 'Permisos del Alcalde (Aprobación Final)',
            'puede_leer' => true,
            'puede_aprobar' => true,
            'puede_rechazar' => true,
            'puede_devolver' => true,
            'puede_comentar' => true,
            'puede_descargar_documentos' => true,
            'puede_enviar_cliente' => true,
            'puede_ver_todas_cuentas' => true,
            'puede_ver_reportes' => true,
            'campos_visibles' => json_encode(['numero', 'fecha_emision', 'nombre_beneficiario', 'valor_total', 'valor_total', 'departamento', 'municipio', 'items', 'documentos', 'estado_aprobacion', 'etapa_aprobacion', 'estado_pago', 'historial']),
        ]);

        // ========================================
        // TESORERÍA
        // ========================================
        PermisoGranular::create([
            'role_id' => $roles['tesoreria']->id,
            'etapa_flujo' => 'tesoreria',
            'descripcion' => 'Permisos de Tesorería (Pagos)',
            'puede_leer' => true,
            'puede_registrar_pago' => true,
            'puede_comentar' => true,
            'puede_descargar_documentos' => true,
            'puede_devolver' => true,
            'puede_enviar_cliente' => true,
            'puede_ver_reportes' => true,
            'campos_visibles' => json_encode(['numero', 'fecha_emision', 'nombre_beneficiario', 'valor_total', 'numero_cuenta_beneficiario', 'banco_beneficiario', 'items', 'documentos', 'estado_aprobacion', 'estado_pago']),
            'campos_editables' => json_encode(['numero_cuenta_beneficiario', 'banco_beneficiario']),
        ]);

        // ========================================
        // SUPER ADMIN (Todos los permisos)
        // ========================================
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

        $this->command->info('✅ Permisos granulares creados exitosamente');
    }
}
