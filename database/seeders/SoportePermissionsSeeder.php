<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class SoportePermissionsSeeder extends Seeder
{
    public function run()
    {
        // Crear permiso para subir soportes
        $permisoSubir = Permission::firstOrCreate(
            ['name' => 'subir_soportes'],
            ['description' => 'Permite subir archivos de soporte a las cuentas de cobro']
        );

        // Crear permiso para eliminar soportes
        $permisoEliminar = Permission::firstOrCreate(
            ['name' => 'eliminar_soportes'],
            ['description' => 'Permite eliminar archivos de soporte de las cuentas de cobro']
        );

        // Roles que deben tener estos permisos
        // Contratista: debe poder subir y eliminar sus propios soportes
        // Administrador/Admin Programa: deben poder gestionar soportes si es necesario (o al menos tener el permiso en el sistema)
        // Auxiliar: Rol que crea las cuentas, también necesita subir soportes
        $roles = ['contratista', 'administrador', 'admin_programa', 'auxiliar'];

        foreach ($roles as $roleName) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                // Asignar subir_soportes
                if (!$role->permissions()->where('name', 'subir_soportes')->exists()) {
                    $role->permissions()->attach($permisoSubir);
                }
                
                // Asignar eliminar_soportes
                if (!$role->permissions()->where('name', 'eliminar_soportes')->exists()) {
                    $role->permissions()->attach($permisoEliminar);
                }
            }
        }
    }
}
