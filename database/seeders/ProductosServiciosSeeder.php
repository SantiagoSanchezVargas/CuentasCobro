<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosServiciosSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            // Servicios profesionales
            ['codigo' => 'SRV-001', 'nombre' => 'Asesoría Contable', 'descripcion' => 'Servicios de asesoría y consultoría contable', 'tipo' => 'servicio', 'puc_codigo' => '5110', 'precio_unitario' => 500000, 'iva_porcentaje' => 19],
            ['codigo' => 'SRV-002', 'nombre' => 'Asesoría Tributaria', 'descripcion' => 'Servicios de asesoría y planeación tributaria', 'tipo' => 'servicio', 'puc_codigo' => '5110', 'precio_unitario' => 600000, 'iva_porcentaje' => 19],
            ['codigo' => 'SRV-003', 'nombre' => 'Asesoría Legal', 'descripcion' => 'Servicios de asesoría jurídica y legal', 'tipo' => 'servicio', 'puc_codigo' => '5110', 'precio_unitario' => 800000, 'iva_porcentaje' => 19],
            ['codigo' => 'SRV-004', 'nombre' => 'Consultoría Empresarial', 'descripcion' => 'Servicios de consultoría y estrategia empresarial', 'tipo' => 'servicio', 'puc_codigo' => '5110', 'precio_unitario' => 1000000, 'iva_porcentaje' => 19],
            ['codigo' => 'SRV-005', 'nombre' => 'Auditoría Externa', 'descripcion' => 'Servicios de auditoría externa y revisoría fiscal', 'tipo' => 'servicio', 'puc_codigo' => '5110', 'precio_unitario' => 2000000, 'iva_porcentaje' => 19],
            
            // Servicios tecnológicos
            ['codigo' => 'SRV-010', 'nombre' => 'Desarrollo de Software', 'descripcion' => 'Desarrollo de aplicaciones y sistemas a medida', 'tipo' => 'servicio', 'puc_codigo' => '5135', 'precio_unitario' => 1500000, 'iva_porcentaje' => 19],
            ['codigo' => 'SRV-011', 'nombre' => 'Soporte Técnico', 'descripcion' => 'Servicios de soporte técnico y mantenimiento', 'tipo' => 'servicio', 'puc_codigo' => '5145', 'precio_unitario' => 300000, 'iva_porcentaje' => 19],
            ['codigo' => 'SRV-012', 'nombre' => 'Diseño Web', 'descripcion' => 'Diseño y desarrollo de sitios web', 'tipo' => 'servicio', 'puc_codigo' => '5135', 'precio_unitario' => 800000, 'iva_porcentaje' => 19],
            ['codigo' => 'SRV-013', 'nombre' => 'Hosting y Dominio', 'descripcion' => 'Servicios de alojamiento web y dominios', 'tipo' => 'servicio', 'puc_codigo' => '5135', 'precio_unitario' => 150000, 'iva_porcentaje' => 19],
            
            // Servicios administrativos
            ['codigo' => 'SRV-020', 'nombre' => 'Trámites Notariales', 'descripcion' => 'Gestión de trámites ante notarías', 'tipo' => 'servicio', 'puc_codigo' => '5140', 'precio_unitario' => 200000, 'iva_porcentaje' => 0],
            ['codigo' => 'SRV-021', 'nombre' => 'Certificado de Tradición', 'descripcion' => 'Obtención de certificado de tradición y libertad', 'tipo' => 'servicio', 'puc_codigo' => '5140', 'precio_unitario' => 65700, 'iva_porcentaje' => 0],
            ['codigo' => 'SRV-022', 'nombre' => 'Registro Mercantil', 'descripcion' => 'Trámites de registro mercantil ante Cámara de Comercio', 'tipo' => 'servicio', 'puc_codigo' => '5140', 'precio_unitario' => 350000, 'iva_porcentaje' => 0],
            
            // Arrendamientos
            ['codigo' => 'SRV-030', 'nombre' => 'Arrendamiento Oficina', 'descripcion' => 'Canon de arrendamiento de espacio de oficina', 'tipo' => 'servicio', 'puc_codigo' => '5120', 'precio_unitario' => 2500000, 'iva_porcentaje' => 19],
            ['codigo' => 'SRV-031', 'nombre' => 'Arrendamiento Bodega', 'descripcion' => 'Canon de arrendamiento de bodega', 'tipo' => 'servicio', 'puc_codigo' => '5120', 'precio_unitario' => 3500000, 'iva_porcentaje' => 19],
            
            // Capacitación
            ['codigo' => 'SRV-040', 'nombre' => 'Capacitación Empresarial', 'descripcion' => 'Servicios de formación y capacitación', 'tipo' => 'servicio', 'puc_codigo' => '4160', 'precio_unitario' => 400000, 'iva_porcentaje' => 0],
            ['codigo' => 'SRV-041', 'nombre' => 'Taller Especializado', 'descripcion' => 'Talleres y seminarios especializados', 'tipo' => 'servicio', 'puc_codigo' => '4160', 'precio_unitario' => 250000, 'iva_porcentaje' => 0],
        ];

        foreach ($productos as $producto) {
            DB::table('productos_servicios')->insert(array_merge($producto, [
                'unidad_medida' => 'UND',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
