<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentrosCostoSeeder extends Seeder
{
    public function run(): void
    {
        $centros = [
            ['codigo' => '1-1', 'nombre' => 'Bogotá', 'descripcion' => 'Centro de costo principal - Bogotá D.C.'],
            ['codigo' => '22-1', 'nombre' => 'Colombia Telecomunicaciones', 'descripcion' => 'Proyecto telecomunicaciones'],
            ['codigo' => '23-1', 'nombre' => 'Proyecto 93445', 'descripcion' => 'Proyecto especial 93445'],
            ['codigo' => '24-1', 'nombre' => 'Notaría 73', 'descripcion' => 'Gestiones Notaría 73'],
            ['codigo' => '25-1', 'nombre' => 'Administración General', 'descripcion' => 'Gastos administrativos generales'],
            ['codigo' => '26-1', 'nombre' => 'Ventas y Marketing', 'descripcion' => 'Área comercial y marketing'],
            ['codigo' => '27-1', 'nombre' => 'Operaciones', 'descripcion' => 'Área de operaciones'],
            ['codigo' => '28-1', 'nombre' => 'Tecnología', 'descripcion' => 'Departamento de TI'],
            ['codigo' => '29-1', 'nombre' => 'Recursos Humanos', 'descripcion' => 'Área de talento humano'],
            ['codigo' => '30-1', 'nombre' => 'Contabilidad y Finanzas', 'descripcion' => 'Área financiera'],
        ];

        foreach ($centros as $centro) {
            DB::table('centros_costo')->insert(array_merge($centro, [
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
