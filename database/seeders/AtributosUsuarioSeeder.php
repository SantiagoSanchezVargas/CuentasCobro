<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AtributoUsuario;
use Illuminate\Database\Seeder;

class AtributosUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios
        $usuarios = User::with('role')->get();

        foreach ($usuarios as $usuario) {
            // Verificar si ya existe registro de atributos
            if ($usuario->atributos) {
                continue;
            }

            // Crear atributos según el rol
            $atributos = [
                'user_id' => $usuario->id,
                'nombre_completo' => explode(' ', $usuario->name)[0] ?? $usuario->name,
                'apellidos' => implode(' ', array_slice(explode(' ', $usuario->name), 1)) ?? 'Usuario',
                'notificaciones_email' => true,
                'idioma_preferido' => 'es',
                'puede_delegar' => false,
                'dias_para_aprobar' => 5,
            ];

            // Personalizar según rol
            $rolName = $usuario->role?->name;

            match ($rolName) {
                'contratista' => [
                    'atributos' => array_merge($atributos, [
                        'departamento' => 'Proveedores Externos',
                        'puesto' => 'Proveedor / Contratista',
                        'nivel_jerarquico' => '5',
                        'puede_delegar' => false,
                        'limite_cuentas_simultaneas' => 10,
                    ]),
                ],
                'supervisor' => [
                    'atributos' => array_merge($atributos, [
                        'departamento' => 'Supervisión',
                        'puesto' => 'Supervisor de Cuentas',
                        'nivel_jerarquico' => '4',
                        'puede_delegar' => true,
                        'limite_aprobacion_valor' => 50000000, // $50M
                        'dias_para_aprobar' => 3,
                    ]),
                ],
                'ordenador_gasto' => [
                    'atributos' => array_merge($atributos, [
                        'departamento' => 'Tesorería',
                        'puesto' => 'Ordenador del Gasto',
                        'nivel_jerarquico' => '2',
                        'puede_delegar' => true,
                        'limite_aprobacion_valor' => 200000000, // $200M
                        'dias_para_aprobar' => 2,
                    ]),
                ],
                'contratacion' => [
                    'atributos' => array_merge($atributos, [
                        'departamento' => 'Contratación',
                        'puesto' => 'Profesional en Contratación',
                        'nivel_jerarquico' => '3',
                        'puede_delegar' => true,
                        'limite_aprobacion_valor' => 100000000, // $100M
                        'dias_para_aprobar' => 3,
                    ]),
                ],
                'alcalde' => [
                    'atributos' => array_merge($atributos, [
                        'departamento' => 'Despacho del Alcalde',
                        'puesto' => 'Alcalde / Director',
                        'nivel_jerarquico' => '1',
                        'puede_delegar' => true,
                        'dias_para_aprobar' => 2,
                    ]),
                ],
                'tesoreria' => [
                    'atributos' => array_merge($atributos, [
                        'departamento' => 'Tesorería',
                        'puesto' => 'Tesorero / Cajero',
                        'nivel_jerarquico' => '3',
                        'puede_delegar' => false,
                        'limite_cuentas_simultaneas' => 50,
                    ]),
                ],
                'super_admin' => [
                    'atributos' => array_merge($atributos, [
                        'departamento' => 'Tecnología',
                        'puesto' => 'Administrador del Sistema',
                        'nivel_jerarquico' => '0',
                        'puede_delegar' => false,
                    ]),
                ],
                default => ['atributos' => $atributos],
            };

            // Usar el valor correcto
            $atributosFinales = match ($rolName) {
                'contratista' => array_merge($atributos, [
                    'departamento' => 'Proveedores Externos',
                    'puesto' => 'Proveedor / Contratista',
                    'nivel_jerarquico' => '5',
                    'limite_cuentas_simultaneas' => 10,
                ]),
                'supervisor' => array_merge($atributos, [
                    'departamento' => 'Supervisión',
                    'puesto' => 'Supervisor de Cuentas',
                    'nivel_jerarquico' => '4',
                    'puede_delegar' => true,
                    'limite_aprobacion_valor' => 50000000,
                    'dias_para_aprobar' => 3,
                ]),
                'ordenador_gasto' => array_merge($atributos, [
                    'departamento' => 'Tesorería',
                    'puesto' => 'Ordenador del Gasto',
                    'nivel_jerarquico' => '2',
                    'puede_delegar' => true,
                    'limite_aprobacion_valor' => 200000000,
                    'dias_para_aprobar' => 2,
                ]),
                'contratacion' => array_merge($atributos, [
                    'departamento' => 'Contratación',
                    'puesto' => 'Profesional en Contratación',
                    'nivel_jerarquico' => '3',
                    'puede_delegar' => true,
                    'limite_aprobacion_valor' => 100000000,
                    'dias_para_aprobar' => 3,
                ]),
                'alcalde' => array_merge($atributos, [
                    'departamento' => 'Despacho del Alcalde',
                    'puesto' => 'Alcalde / Director',
                    'nivel_jerarquico' => '1',
                    'puede_delegar' => true,
                    'dias_para_aprobar' => 2,
                ]),
                'tesoreria' => array_merge($atributos, [
                    'departamento' => 'Tesorería',
                    'puesto' => 'Tesorero / Cajero',
                    'nivel_jerarquico' => '3',
                    'puede_delegar' => false,
                    'limite_cuentas_simultaneas' => 50,
                ]),
                'super_admin' => array_merge($atributos, [
                    'departamento' => 'Tecnología',
                    'puesto' => 'Administrador del Sistema',
                    'nivel_jerarquico' => '0',
                    'puede_delegar' => false,
                ]),
                default => $atributos,
            };

            AtributoUsuario::create($atributosFinales);
        }

        $this->command->info('✅ Atributos de usuario creados exitosamente');
    }
}
