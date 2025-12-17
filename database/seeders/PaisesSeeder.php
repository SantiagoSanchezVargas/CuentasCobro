<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaisesSeeder extends Seeder
{
    public function run(): void
    {
        $paises = [
            // Latinoamérica
            ['codigo_iso2' => 'CO', 'codigo_iso3' => 'COL', 'nombre' => 'Colombia', 'nombre_en' => 'Colombia', 'indicativo' => '+57', 'moneda' => 'COP'],
            ['codigo_iso2' => 'MX', 'codigo_iso3' => 'MEX', 'nombre' => 'México', 'nombre_en' => 'Mexico', 'indicativo' => '+52', 'moneda' => 'MXN'],
            ['codigo_iso2' => 'AR', 'codigo_iso3' => 'ARG', 'nombre' => 'Argentina', 'nombre_en' => 'Argentina', 'indicativo' => '+54', 'moneda' => 'ARS'],
            ['codigo_iso2' => 'BR', 'codigo_iso3' => 'BRA', 'nombre' => 'Brasil', 'nombre_en' => 'Brazil', 'indicativo' => '+55', 'moneda' => 'BRL'],
            ['codigo_iso2' => 'CL', 'codigo_iso3' => 'CHL', 'nombre' => 'Chile', 'nombre_en' => 'Chile', 'indicativo' => '+56', 'moneda' => 'CLP'],
            ['codigo_iso2' => 'PE', 'codigo_iso3' => 'PER', 'nombre' => 'Perú', 'nombre_en' => 'Peru', 'indicativo' => '+51', 'moneda' => 'PEN'],
            ['codigo_iso2' => 'EC', 'codigo_iso3' => 'ECU', 'nombre' => 'Ecuador', 'nombre_en' => 'Ecuador', 'indicativo' => '+593', 'moneda' => 'USD'],
            ['codigo_iso2' => 'VE', 'codigo_iso3' => 'VEN', 'nombre' => 'Venezuela', 'nombre_en' => 'Venezuela', 'indicativo' => '+58', 'moneda' => 'VES'],
            ['codigo_iso2' => 'BO', 'codigo_iso3' => 'BOL', 'nombre' => 'Bolivia', 'nombre_en' => 'Bolivia', 'indicativo' => '+591', 'moneda' => 'BOB'],
            ['codigo_iso2' => 'PY', 'codigo_iso3' => 'PRY', 'nombre' => 'Paraguay', 'nombre_en' => 'Paraguay', 'indicativo' => '+595', 'moneda' => 'PYG'],
            ['codigo_iso2' => 'UY', 'codigo_iso3' => 'URY', 'nombre' => 'Uruguay', 'nombre_en' => 'Uruguay', 'indicativo' => '+598', 'moneda' => 'UYU'],
            ['codigo_iso2' => 'PA', 'codigo_iso3' => 'PAN', 'nombre' => 'Panamá', 'nombre_en' => 'Panama', 'indicativo' => '+507', 'moneda' => 'PAB'],
            ['codigo_iso2' => 'CR', 'codigo_iso3' => 'CRI', 'nombre' => 'Costa Rica', 'nombre_en' => 'Costa Rica', 'indicativo' => '+506', 'moneda' => 'CRC'],
            ['codigo_iso2' => 'GT', 'codigo_iso3' => 'GTM', 'nombre' => 'Guatemala', 'nombre_en' => 'Guatemala', 'indicativo' => '+502', 'moneda' => 'GTQ'],
            ['codigo_iso2' => 'HN', 'codigo_iso3' => 'HND', 'nombre' => 'Honduras', 'nombre_en' => 'Honduras', 'indicativo' => '+504', 'moneda' => 'HNL'],
            ['codigo_iso2' => 'SV', 'codigo_iso3' => 'SLV', 'nombre' => 'El Salvador', 'nombre_en' => 'El Salvador', 'indicativo' => '+503', 'moneda' => 'USD'],
            ['codigo_iso2' => 'NI', 'codigo_iso3' => 'NIC', 'nombre' => 'Nicaragua', 'nombre_en' => 'Nicaragua', 'indicativo' => '+505', 'moneda' => 'NIO'],
            ['codigo_iso2' => 'DO', 'codigo_iso3' => 'DOM', 'nombre' => 'República Dominicana', 'nombre_en' => 'Dominican Republic', 'indicativo' => '+1809', 'moneda' => 'DOP'],
            ['codigo_iso2' => 'CU', 'codigo_iso3' => 'CUB', 'nombre' => 'Cuba', 'nombre_en' => 'Cuba', 'indicativo' => '+53', 'moneda' => 'CUP'],
            ['codigo_iso2' => 'PR', 'codigo_iso3' => 'PRI', 'nombre' => 'Puerto Rico', 'nombre_en' => 'Puerto Rico', 'indicativo' => '+1787', 'moneda' => 'USD'],
            
            // Norteamérica
            ['codigo_iso2' => 'US', 'codigo_iso3' => 'USA', 'nombre' => 'Estados Unidos', 'nombre_en' => 'United States', 'indicativo' => '+1', 'moneda' => 'USD'],
            ['codigo_iso2' => 'CA', 'codigo_iso3' => 'CAN', 'nombre' => 'Canadá', 'nombre_en' => 'Canada', 'indicativo' => '+1', 'moneda' => 'CAD'],
            
            // Europa
            ['codigo_iso2' => 'ES', 'codigo_iso3' => 'ESP', 'nombre' => 'España', 'nombre_en' => 'Spain', 'indicativo' => '+34', 'moneda' => 'EUR'],
            ['codigo_iso2' => 'FR', 'codigo_iso3' => 'FRA', 'nombre' => 'Francia', 'nombre_en' => 'France', 'indicativo' => '+33', 'moneda' => 'EUR'],
            ['codigo_iso2' => 'DE', 'codigo_iso3' => 'DEU', 'nombre' => 'Alemania', 'nombre_en' => 'Germany', 'indicativo' => '+49', 'moneda' => 'EUR'],
            ['codigo_iso2' => 'IT', 'codigo_iso3' => 'ITA', 'nombre' => 'Italia', 'nombre_en' => 'Italy', 'indicativo' => '+39', 'moneda' => 'EUR'],
            ['codigo_iso2' => 'GB', 'codigo_iso3' => 'GBR', 'nombre' => 'Reino Unido', 'nombre_en' => 'United Kingdom', 'indicativo' => '+44', 'moneda' => 'GBP'],
            ['codigo_iso2' => 'PT', 'codigo_iso3' => 'PRT', 'nombre' => 'Portugal', 'nombre_en' => 'Portugal', 'indicativo' => '+351', 'moneda' => 'EUR'],
            ['codigo_iso2' => 'NL', 'codigo_iso3' => 'NLD', 'nombre' => 'Países Bajos', 'nombre_en' => 'Netherlands', 'indicativo' => '+31', 'moneda' => 'EUR'],
            ['codigo_iso2' => 'BE', 'codigo_iso3' => 'BEL', 'nombre' => 'Bélgica', 'nombre_en' => 'Belgium', 'indicativo' => '+32', 'moneda' => 'EUR'],
            ['codigo_iso2' => 'CH', 'codigo_iso3' => 'CHE', 'nombre' => 'Suiza', 'nombre_en' => 'Switzerland', 'indicativo' => '+41', 'moneda' => 'CHF'],
            ['codigo_iso2' => 'AT', 'codigo_iso3' => 'AUT', 'nombre' => 'Austria', 'nombre_en' => 'Austria', 'indicativo' => '+43', 'moneda' => 'EUR'],
            
            // Asia
            ['codigo_iso2' => 'CN', 'codigo_iso3' => 'CHN', 'nombre' => 'China', 'nombre_en' => 'China', 'indicativo' => '+86', 'moneda' => 'CNY'],
            ['codigo_iso2' => 'JP', 'codigo_iso3' => 'JPN', 'nombre' => 'Japón', 'nombre_en' => 'Japan', 'indicativo' => '+81', 'moneda' => 'JPY'],
            ['codigo_iso2' => 'KR', 'codigo_iso3' => 'KOR', 'nombre' => 'Corea del Sur', 'nombre_en' => 'South Korea', 'indicativo' => '+82', 'moneda' => 'KRW'],
            ['codigo_iso2' => 'IN', 'codigo_iso3' => 'IND', 'nombre' => 'India', 'nombre_en' => 'India', 'indicativo' => '+91', 'moneda' => 'INR'],
            
            // Oceanía
            ['codigo_iso2' => 'AU', 'codigo_iso3' => 'AUS', 'nombre' => 'Australia', 'nombre_en' => 'Australia', 'indicativo' => '+61', 'moneda' => 'AUD'],
            ['codigo_iso2' => 'NZ', 'codigo_iso3' => 'NZL', 'nombre' => 'Nueva Zelanda', 'nombre_en' => 'New Zealand', 'indicativo' => '+64', 'moneda' => 'NZD'],
        ];

        foreach ($paises as $pais) {
            DB::table('paises')->insert(array_merge($pais, [
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
