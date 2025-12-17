<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'super_admin'], ['description' => 'Super Admin - tiene acceso total']);

        $email = 'superadmin@example.com';
        $name = 'Super Administrador';
        $password = 'SuperAdmin123!'; // Default seed password: change in production

        if (class_exists('\App\\Models\\User')) {
            $user = User::firstOrCreate([
                'email' => $email,
            ], [
                'name' => $name,
                'password' => Hash::make($password),
                'role_id' => $role->id,
            ]);
        } else {
            // Fallback to DB insert/update when User class isn't available
            $existing = \Illuminate\Support\Facades\DB::table('users')->where('email', $email)->first();
            if ($existing) {
                \Illuminate\Support\Facades\DB::table('users')->where('email', $email)->update([
                    'name' => $name,
                    'role_id' => $role->id,
                ]);
            } else {
                \Illuminate\Support\Facades\DB::table('users')->insert([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role_id' => $role->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info("Super admin created: {$email} / {$password}");
    }
}
