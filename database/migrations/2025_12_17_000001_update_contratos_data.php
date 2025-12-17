<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Actualizar contratos con números realistas (columnas: numero, objeto, valor)
        DB::table('contratos')->where('id', 1)->update([
            'numero' => 'CTO-2025-0001',
            'objeto' => 'Prestación de servicios profesionales de asesoría contable y tributaria',
            'valor' => 15000000
        ]);
        
        DB::table('contratos')->where('id', 2)->update([
            'numero' => 'CTO-2025-0002',
            'objeto' => 'Desarrollo e implementación de software de gestión documental',
            'valor' => 35000000
        ]);
        
        DB::table('contratos')->where('id', 3)->update([
            'numero' => 'CTO-2025-0003',
            'objeto' => 'Servicios de consultoría en transformación digital',
            'valor' => 28000000
        ]);
        
        DB::table('contratos')->where('id', 4)->update([
            'numero' => 'CTO-2025-0004',
            'objeto' => 'Mantenimiento preventivo y correctivo de equipos de cómputo',
            'valor' => 12000000
        ]);
        
        DB::table('contratos')->where('id', 5)->update([
            'numero' => 'CTO-2025-0005',
            'objeto' => 'Capacitación y formación en herramientas ofimáticas',
            'valor' => 8500000
        ]);
    }

    public function down(): void
    {
        // No revertir
    }
};
