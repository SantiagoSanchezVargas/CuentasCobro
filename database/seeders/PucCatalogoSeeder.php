<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; 

class PucCatalogoSeeder extends Seeder
{
    public function run(): void
    {
       Schema::disableForeignKeyConstraints(); 
        DB::table('puc_catalogo')->truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Quitamos la línea que tenías aquí repetida de truncate

        $path = database_path('data/puc_codes.php');
        if (!file_exists($path)) {
            // Fallback to hardcoded basic list if file doesn't exist
            $this->command->warn("File not found: $path. Using basic fallback list.");
            $this->seedBasicList();
            return;
        }

        $puc = require $path;
        
        $this->command->info('Seeding PUC codes... found ' . count($puc) . ' entries.');

        $chunks = array_chunk($puc, 500);
        
        foreach ($chunks as $chunk) {
            $dataToInsert = [];
            foreach ($chunk as $cuenta) {
                $dataToInsert[] = array_merge($cuenta, [
                    'activo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('puc_catalogo')->insert($dataToInsert);
        }
    }

    private function seedBasicList()
    {
        $puc = [
            // Clase 1 - Activos
            ['codigo' => '1', 'nombre' => 'ACTIVO', 'naturaleza' => 'Débito', 'clase' => 'Activo', 'grupo' => null],
            ['codigo' => '11', 'nombre' => 'DISPONIBLE', 'naturaleza' => 'Débito', 'clase' => 'Activo', 'grupo' => 'Disponible'],
            ['codigo' => '1105', 'nombre' => 'CAJA', 'naturaleza' => 'Débito', 'clase' => 'Activo', 'grupo' => 'Disponible'],
            ['codigo' => '1110', 'nombre' => 'BANCOS', 'naturaleza' => 'Débito', 'clase' => 'Activo', 'grupo' => 'Disponible'],
            ['codigo' => '13', 'nombre' => 'DEUDORES', 'naturaleza' => 'Débito', 'clase' => 'Activo', 'grupo' => 'Deudores'],
            ['codigo' => '1305', 'nombre' => 'CLIENTES', 'naturaleza' => 'Débito', 'clase' => 'Activo', 'grupo' => 'Deudores'],
            ['codigo' => '1330', 'nombre' => 'ANTICIPOS Y AVANCES', 'naturaleza' => 'Débito', 'clase' => 'Activo', 'grupo' => 'Deudores'],
            
            // Clase 2 - Pasivos
            ['codigo' => '2', 'nombre' => 'PASIVO', 'naturaleza' => 'Crédito', 'clase' => 'Pasivo', 'grupo' => null],
            ['codigo' => '21', 'nombre' => 'OBLIGACIONES FINANCIERAS', 'naturaleza' => 'Crédito', 'clase' => 'Pasivo', 'grupo' => 'Obligaciones Financieras'],
            ['codigo' => '22', 'nombre' => 'PROVEEDORES', 'naturaleza' => 'Crédito', 'clase' => 'Pasivo', 'grupo' => 'Proveedores'],
            ['codigo' => '2205', 'nombre' => 'NACIONALES', 'naturaleza' => 'Crédito', 'clase' => 'Pasivo', 'grupo' => 'Proveedores'],
            ['codigo' => '23', 'nombre' => 'CUENTAS POR PAGAR', 'naturaleza' => 'Crédito', 'clase' => 'Pasivo', 'grupo' => 'Cuentas por Pagar'],
            ['codigo' => '2335', 'nombre' => 'COSTOS Y GASTOS POR PAGAR', 'naturaleza' => 'Crédito', 'clase' => 'Pasivo', 'grupo' => 'Cuentas por Pagar'],
            ['codigo' => '2365', 'nombre' => 'RETENCIÓN EN LA FUENTE', 'naturaleza' => 'Crédito', 'clase' => 'Pasivo', 'grupo' => 'Cuentas por Pagar'],
            ['codigo' => '2368', 'nombre' => 'IMPUESTO DE INDUSTRIA Y COMERCIO RETENIDO', 'naturaleza' => 'Crédito', 'clase' => 'Pasivo', 'grupo' => 'Cuentas por Pagar'],
            ['codigo' => '24', 'nombre' => 'IMPUESTOS, GRAVÁMENES Y TASAS', 'naturaleza' => 'Crédito', 'clase' => 'Pasivo', 'grupo' => 'Impuestos'],
            ['codigo' => '2408', 'nombre' => 'IMPUESTO SOBRE LAS VENTAS POR PAGAR', 'naturaleza' => 'Crédito', 'clase' => 'Pasivo', 'grupo' => 'Impuestos'],
            
            // Clase 3 - Patrimonio
            ['codigo' => '3', 'nombre' => 'PATRIMONIO', 'naturaleza' => 'Crédito', 'clase' => 'Patrimonio', 'grupo' => null],
            ['codigo' => '31', 'nombre' => 'CAPITAL SOCIAL', 'naturaleza' => 'Crédito', 'clase' => 'Patrimonio', 'grupo' => 'Capital'],
            
            // Clase 4 - Ingresos
            ['codigo' => '4', 'nombre' => 'INGRESOS', 'naturaleza' => 'Crédito', 'clase' => 'Ingresos', 'grupo' => null],
            ['codigo' => '41', 'nombre' => 'OPERACIONALES', 'naturaleza' => 'Crédito', 'clase' => 'Ingresos', 'grupo' => 'Operacionales'],
            ['codigo' => '4135', 'nombre' => 'COMERCIO AL POR MAYOR Y AL POR MENOR', 'naturaleza' => 'Crédito', 'clase' => 'Ingresos', 'grupo' => 'Operacionales'],
            ['codigo' => '4140', 'nombre' => 'HOTELES Y RESTAURANTES', 'naturaleza' => 'Crédito', 'clase' => 'Ingresos', 'grupo' => 'Operacionales'],
            ['codigo' => '4145', 'nombre' => 'TRANSPORTE, ALMACENAMIENTO Y COMUNICACIONES', 'naturaleza' => 'Crédito', 'clase' => 'Ingresos', 'grupo' => 'Operacionales'],
            ['codigo' => '4155', 'nombre' => 'ACTIVIDADES INMOBILIARIAS, EMPRESARIALES Y DE ALQUILER', 'naturaleza' => 'Crédito', 'clase' => 'Ingresos', 'grupo' => 'Operacionales'],
            ['codigo' => '4160', 'nombre' => 'ENSEÑANZA', 'naturaleza' => 'Crédito', 'clase' => 'Ingresos', 'grupo' => 'Operacionales'],
            ['codigo' => '4165', 'nombre' => 'SERVICIOS SOCIALES Y DE SALUD', 'naturaleza' => 'Crédito', 'clase' => 'Ingresos', 'grupo' => 'Operacionales'],
            ['codigo' => '4170', 'nombre' => 'OTRAS ACTIVIDADES DE SERVICIOS COMUNITARIOS', 'naturaleza' => 'Crédito', 'clase' => 'Ingresos', 'grupo' => 'Operacionales'],
            ['codigo' => '4175', 'nombre' => 'DEVOLUCIONES, REBAJAS Y DESCUENTOS EN VENTAS (DB)', 'naturaleza' => 'Débito', 'clase' => 'Ingresos', 'grupo' => 'Operacionales'],
            
            // Clase 5 - Gastos
            ['codigo' => '5', 'nombre' => 'GASTOS', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => null],
            ['codigo' => '51', 'nombre' => 'OPERACIONALES DE ADMINISTRACIÓN', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '5105', 'nombre' => 'GASTOS DE PERSONAL', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '5110', 'nombre' => 'HONORARIOS', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '5115', 'nombre' => 'IMPUESTOS', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '5120', 'nombre' => 'ARRENDAMIENTOS', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '5125', 'nombre' => 'CONTRIBUCIONES Y AFILIACIONES', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '5130', 'nombre' => 'SEGUROS', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '5135', 'nombre' => 'SERVICIOS', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '5140', 'nombre' => 'GASTOS LEGALES', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '5145', 'nombre' => 'MANTENIMIENTO Y REPARACIONES', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '5150', 'nombre' => 'ADECUACIÓN E INSTALACIÓN', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '5155', 'nombre' => 'GASTOS DE VIAJE', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '5195', 'nombre' => 'DIVERSOS', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Administración'],
            ['codigo' => '52', 'nombre' => 'OPERACIONALES DE VENTAS', 'naturaleza' => 'Débito', 'clase' => 'Gastos', 'grupo' => 'Operacionales Ventas'],
            
            // Clase 6 - Costos de ventas
            ['codigo' => '6', 'nombre' => 'COSTOS DE VENTAS', 'naturaleza' => 'Débito', 'clase' => 'Costos', 'grupo' => null],
            ['codigo' => '61', 'nombre' => 'COSTO DE VENTAS Y DE PRESTACIÓN DE SERVICIOS', 'naturaleza' => 'Débito', 'clase' => 'Costos', 'grupo' => 'Costo de Ventas'],
        ];

        foreach ($puc as $cuenta) {
            DB::table('puc_catalogo')->insert(array_merge($cuenta, [
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
