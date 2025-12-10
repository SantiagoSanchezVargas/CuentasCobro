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

        $user = User::firstOrCreate([
            'email' => $email,
        ], [
            'name' => $name,
            'password' => Hash::make($password),
            'role_id' => $role->id,
        ]);

        $this->command->info("Super admin created: {$email} / {$password}");
    }
}
