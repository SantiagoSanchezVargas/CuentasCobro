<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RoleSeeder::class);
    $this->call(UsersRolesSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(\Database\Seeders\SuperAdminSeeder::class);
        $this->call(DepartamentosMunicipiosSeeder::class);
        $this->call(ContratosDemoSeeder::class);
        
        // Catálogos para facturación electrónica
        $this->call(PucCatalogoSeeder::class);
        $this->call(PaisesSeeder::class);
        $this->call(ResponsabilidadesFiscalesSeeder::class);
        $this->call(ProductosServiciosSeeder::class);
        $this->call(CentrosCostoSeeder::class);

        // Crear un usuario de prueba si no existe
        if (class_exists('\App\\Models\\User')) {
            if (!User::where('email', 'test@example.com')->exists()) {
                User::factory()->create([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                ]);
            }
        } else {
            $exists = \Illuminate\Support\Facades\DB::table('users')->where('email', 'test@example.com')->exists();
            if (!$exists) {
                \Illuminate\Support\Facades\DB::table('users')->insert([
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => bcrypt('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        $this->call(CuentaCobroDemoSeeder::class);
    }
}
