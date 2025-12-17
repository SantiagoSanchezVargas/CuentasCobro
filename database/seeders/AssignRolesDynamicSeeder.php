<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roles;

class AssignRolesDynamicSeeder extends Seeder
{
    public function run(): void
    {
        // Definir roles por usuario (email => rol)
        $assignments = [
            'santisanchez21456@gmail.com' => 'alcalde',
            'daniel00250@hotmail.com' => 'supervisor',
            'dabenitez@gmail.com' => 'contratista',
            'storres@gmail.com' => 'ordenador_gasto',
            'jcalderon@gmail.com'=>'tesoreria',
        ];

        foreach ($assignments as $email => $roleName) {
            $role = Roles::where('name', $roleName)->first();

            if (!$role) {
                $this->command->warn("⚠️ Rol no encontrado: {$roleName}");
                continue;
            }

            if (class_exists('\App\\Models\\User')) {
                $user = User::where('email', $email)->first();
                if ($user) {
                    $user->role_id = $role->id;
                    $user->save();
                    $this->command->info("✅ Rol '{$roleName}' asignado a: {$email}");
                } else {
                    $this->command->warn("⚠️ Usuario no encontrado: {$email}");
                }
            } else {
                $existing = \Illuminate\Support\Facades\DB::table('users')->where('email', $email)->first();
                if ($existing) {
                    \Illuminate\Support\Facades\DB::table('users')->where('email', $email)->update(['role_id' => $role->id]);
                    $this->command->info("✅ Rol '{$roleName}' asignado a: {$email} (via DB)");
                } else {
                    $this->command->warn("⚠️ Usuario no encontrado: {$email}");
                }
            }
        }
    }
}
