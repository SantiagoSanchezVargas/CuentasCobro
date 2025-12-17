<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResponsabilidadesFiscalesSeeder extends Seeder
{
    public function run(): void
    {
        // Responsabilidades fiscales según DIAN Colombia 2025
        $responsabilidades = [
            ['codigo' => 'O-13', 'nombre' => 'Gran contribuyente', 'descripcion' => 'Persona calificada como gran contribuyente por la DIAN'],
            ['codigo' => 'O-15', 'nombre' => 'Autorretenedor', 'descripcion' => 'Persona autorizada para practicar autorretenciones'],
            ['codigo' => 'O-23', 'nombre' => 'Agente de retención IVA', 'descripcion' => 'Persona designada como agente de retención del IVA'],
            ['codigo' => 'O-47', 'nombre' => 'Régimen simple de tributación', 'descripcion' => 'Persona acogida al régimen simple de tributación - RST'],
            ['codigo' => 'R-99-PN', 'nombre' => 'No aplica - Otros', 'descripcion' => 'No responsable de IVA / No aplica ninguna responsabilidad especial'],
            ['codigo' => 'O-48', 'nombre' => 'Impuesto sobre las ventas - IVA', 'descripcion' => 'Responsable del impuesto sobre las ventas'],
            ['codigo' => 'O-49', 'nombre' => 'No responsable de IVA', 'descripcion' => 'No responsable del impuesto sobre las ventas'],
            ['codigo' => 'O-52', 'nombre' => 'Facturador electrónico', 'descripcion' => 'Obligado a facturar electrónicamente'],
            ['codigo' => 'O-53', 'nombre' => 'Documento soporte', 'descripcion' => 'Obligado a generar documento soporte en adquisiciones'],
        ];

        foreach ($responsabilidades as $resp) {
            DB::table('responsabilidades_fiscales')->insert(array_merge($resp, [
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
