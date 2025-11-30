<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 🔹 Definir los permisos
        $permissions = [
            // Cuentas de cobro
            'create_cuenta_cobro',
            'view_own_cuenta_cobro',
            'edit_own_cuenta_cobro',
            'upload_documents',
            'view_contract_info',
            'view_cuenta_cobro',
            'review_cuenta_cobro',
            'approve_cuenta_cobro',
            'reject_cuenta_cobro',
            'add_comments',
            'request_corrections',
            'view_all_cuenta_cobro',
            'final_approval',
            'override_decisions',
            'view_reports',

            // Administración del sistema
            'manage_users',
            'system_admin',

            // Pagos
            'authorize_payment',
            'process_payment',
            'payment_confirmation',
            'financial_reports',

            // Contratación
            'manage_contracts',
            'manage_contractors',
        ];

        // 🔹 Crear permisos si no existen
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // 🔹 Definir roles y sus permisos
        $rolesData = [
            'auxiliar' => [
                'permissions' => [
                    'create_cuenta_cobro',
                    'view_own_cuenta_cobro',
                    'edit_own_cuenta_cobro',
                    'upload_documents',
                    'view_contract_info'
                ],
                'description' => 'Auxiliar - Crea y gestiona sus cuentas de cobro'
            ],
            'administrador' => [
                'permissions' => [
                    'view_cuenta_cobro',
                    'review_cuenta_cobro',
                    'approve_cuenta_cobro',
                    'reject_cuenta_cobro',
                    'add_comments',
                    'request_corrections',
                    'manage_contracts',
                    'view_reports'
                ],
                'description' => 'Administrador - Aprueba cuentas y gestiona contratos'
            ],
            'tesoreria' => [
                'permissions' => [
                    'view_cuenta_cobro',
                    'process_payment',
                    'payment_confirmation',
                    'financial_reports'
                ],
                'description' => 'Tesorería - Realiza y confirma pagos'
            ],
            'admin_programa' => [
                'permissions' => [
                    'system_admin',
                    'manage_users',
                    'override_decisions',
                    'view_all_cuenta_cobro',
                    'view_reports',
                    'manage_contracts'
                ],
                'description' => 'Admin del Programa - Control total del sistema'
            ]
        ];

        // 🔹 Crear roles y asignar permisos
        foreach ($rolesData as $roleName => $data) {
            $role = Role::firstOrCreate(
                ['name' => $roleName],
                ['description' => $data['description']]
            );

            $role->permissions()->sync(
                Permission::whereIn('name', $data['permissions'])->pluck('id')->toArray()
            );
        }

        $this->command->info('Roles y permisos actualizados exitosamente.');
    }
}
