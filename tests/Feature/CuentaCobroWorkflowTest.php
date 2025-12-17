<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\CuentaCobro;
use App\Models\Permission;

class CuentaCobroWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private function minimalPayload(): array
    {
        return [
            'fecha_emision' => now()->toDateString(),
            'departamento' => 'Departamento X',
            'municipio' => 'Municipio Y',
            'tipo_identificacion' => 'CC',
            'tipo_cliente' => 'Natural',
            'nombre_beneficiario' => 'Beneficiario Demo',
            'fecha_prestacion_servicio' => now()->toDateString(),
            'items' => [
                ['item' => 'Servicio A', 'cantidad' => 1, 'precio_unitario' => 1000000],
            ],
            'concepto_cobro' => 'Pago por servicios profesionales',
        ];
    }

    public function test_auxiliar_can_access_create_and_store()
    {
        $role = Role::firstOrCreate(['name' => 'auxiliar']);

        $createPerm = Permission::firstOrCreate(['name' => 'create_cuenta_cobro']);
        $viewPerm = Permission::firstOrCreate(['name' => 'view_cuenta_cobro']);
        $role->permissions()->syncWithoutDetaching([$createPerm->id, $viewPerm->id]);

        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);

        $res = $this->get(route('cuentas_cobro.create'));
        $res->assertStatus(200);

        $payload = $this->minimalPayload();
        $store = $this->post(route('cuentas_cobro.store'), $payload);
        $store->assertRedirect(route('cuentas_cobro.index'));
        $this->assertDatabaseHas('cuentas_cobro', ['nombre_beneficiario' => 'Beneficiario Demo']);
    }

    public function test_non_auxiliar_cannot_access_create()
    {
        $role = Role::firstOrCreate(['name' => 'tesoreria']);
        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);

        $res = $this->get(route('cuentas_cobro.create'));
        $res->assertRedirect(route('cuentas_cobro.index'));
        $res->assertSessionHas('error');
    }

    public function test_administrator_can_approve_and_move_to_tesoreria()
    {
        // Create auxiliar and create a cuenta
        $auxRole = Role::firstOrCreate(['name' => 'auxiliar']);
        $createPerm = Permission::firstOrCreate(['name' => 'create_cuenta_cobro']);
        $viewPerm = Permission::firstOrCreate(['name' => 'view_cuenta_cobro']);
        $auxRole->permissions()->syncWithoutDetaching([$createPerm->id, $viewPerm->id]);
        $aux = User::factory()->create(['role_id' => $auxRole->id]);
        $this->actingAs($aux);
        $payload = $this->minimalPayload();
        $this->post(route('cuentas_cobro.store'), $payload);

        $cuenta = CuentaCobro::first();
        $this->assertNotNull($cuenta);

        // Administrator approves
        $adminRole = Role::firstOrCreate(['name' => 'administrador']);
        // Give granular approve permission for administrador
        \App\Models\PermisoGranular::create([
            'role_id' => $adminRole->id,
            'etapa_flujo' => 'administrador',
            'puede_aprobar' => true,
            'activo' => true,
        ]);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $this->actingAs($admin);

        $resp = $this->post(route('cuentas_cobro.aprobar', $cuenta->id));
        $resp->assertRedirect();
        $cuenta->refresh();
        $this->assertEquals('tesoreria', $cuenta->etapa_aprobacion);
    }

    public function test_tesoreria_can_final_approve()
    {
        // Create auxiliar and create a cuenta
        $auxRole = Role::firstOrCreate(['name' => 'auxiliar']);
        $createPerm = Permission::firstOrCreate(['name' => 'create_cuenta_cobro']);
        $viewPerm = Permission::firstOrCreate(['name' => 'view_cuenta_cobro']);
        $auxRole->permissions()->syncWithoutDetaching([$createPerm->id, $viewPerm->id]);
        $aux = User::factory()->create(['role_id' => $auxRole->id]);
        $this->actingAs($aux);
        $payload = $this->minimalPayload();
        $this->post(route('cuentas_cobro.store'), $payload);

        $cuenta = CuentaCobro::first();
        $this->assertNotNull($cuenta);

        // Move to tesoreria stage manually (simulate admin approval)
        $cuenta->update(['etapa_aprobacion' => 'tesoreria']);

        $tesRole = Role::firstOrCreate(['name' => 'tesoreria']);
        // Give granular approve permission for tesoreria
        \App\Models\PermisoGranular::create([
            'role_id' => $tesRole->id,
            'etapa_flujo' => 'tesoreria',
            'puede_aprobar' => true,
            'activo' => true,
        ]);
        $tes = User::factory()->create(['role_id' => $tesRole->id]);
        $this->actingAs($tes);

        $resp = $this->post(route('cuentas_cobro.aprobar', $cuenta->id));
        $resp->assertRedirect();
        $cuenta->refresh();
        $this->assertEquals('aprobado', $cuenta->estado_aprobacion);
    }

    public function test_admin_can_devolver_and_notify_auxiliar()
    {
        $auxRole = Role::firstOrCreate(['name' => 'auxiliar']);
        $createPerm = Permission::firstOrCreate(['name' => 'create_cuenta_cobro']);
        $viewPerm = Permission::firstOrCreate(['name' => 'view_cuenta_cobro']);
        $auxRole->permissions()->syncWithoutDetaching([$createPerm->id, $viewPerm->id]);
        $aux = User::factory()->create(['role_id' => $auxRole->id]);
        $this->actingAs($aux);
        $payload = $this->minimalPayload();
        $this->post(route('cuentas_cobro.store'), $payload);

        $cuenta = CuentaCobro::first();
        $this->assertNotNull($cuenta);

        $adminRole = Role::firstOrCreate(['name' => 'administrador']);
        $requestCorrections = Permission::firstOrCreate(['name' => 'request_corrections']);
        $adminRole->permissions()->syncWithoutDetaching([$requestCorrections->id]);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $this->actingAs($admin);

        $resp = $this->post(route('cuentas_cobro.devolver', $cuenta->id), ['motivo' => 'Falta info']);
        $resp->assertRedirect();
        $cuenta->refresh();
        $this->assertEquals('en_correccion', $cuenta->estado_aprobacion);
        $this->assertEquals('auxiliar', $cuenta->etapa_aprobacion);
        $this->assertDatabaseHas('notificaciones', ['user_id' => $cuenta->user_id, 'tipo' => 'cuenta_cobro', 'titulo' => 'Cuenta devuelta para corrección']);
    }

    public function test_admin_can_reject_and_notify_creator()
    {
        $auxRole = Role::firstOrCreate(['name' => 'auxiliar']);
        $createPerm = Permission::firstOrCreate(['name' => 'create_cuenta_cobro']);
        $viewPerm = Permission::firstOrCreate(['name' => 'view_cuenta_cobro']);
        $auxRole->permissions()->syncWithoutDetaching([$createPerm->id, $viewPerm->id]);
        $aux = User::factory()->create(['role_id' => $auxRole->id]);
        $this->actingAs($aux);
        $payload = $this->minimalPayload();
        $this->post(route('cuentas_cobro.store'), $payload);

        $cuenta = CuentaCobro::first();
        $this->assertNotNull($cuenta);

        $adminRole = Role::firstOrCreate(['name' => 'administrador']);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $this->actingAs($admin);

        $resp = $this->post(route('cuentas_cobro.rechazar', $cuenta->id), ['motivo_rechazo' => 'No cumple requisitos']);
        $resp->assertRedirect();
        $cuenta->refresh();
        $this->assertEquals('rechazado', $cuenta->estado_aprobacion);
        $this->assertDatabaseHas('notificaciones', ['user_id' => $cuenta->user_id, 'titulo' => 'Tu cuenta fue rechazada']);
    }

    public function test_tesoreria_can_register_and_notify_payment()
    {
        $auxRole = Role::firstOrCreate(['name' => 'auxiliar']);
        $createPerm = Permission::firstOrCreate(['name' => 'create_cuenta_cobro']);
        $viewPerm = Permission::firstOrCreate(['name' => 'view_cuenta_cobro']);
        $auxRole->permissions()->syncWithoutDetaching([$createPerm->id, $viewPerm->id]);
        $aux = User::factory()->create(['role_id' => $auxRole->id]);
        $this->actingAs($aux);
        $payload = $this->minimalPayload();
        $this->post(route('cuentas_cobro.store'), $payload);

        $cuenta = CuentaCobro::first();
        $this->assertNotNull($cuenta);

        // Move to tesoreria and mark approved
        $cuenta->update(['etapa_aprobacion' => 'tesoreria', 'estado_aprobacion' => 'aprobado']);

        $tesRole = Role::firstOrCreate(['name' => 'tesoreria']);
        // Give granular permission to register payments
        \App\Models\PermisoGranular::create([
            'role_id' => $tesRole->id,
            'etapa_flujo' => 'tesoreria',
            'puede_registrar_pago' => true,
            'activo' => true,
        ]);
        $tes = User::factory()->create(['role_id' => $tesRole->id]);
        $this->actingAs($tes);

        $resp = $this->post(route('cuentas_cobro.pagar', $cuenta->id), ['valor_pagado' => 1000000, 'medio_pago' => 'transferencia']);
        $resp->assertRedirect();
        $cuenta->refresh();
        $this->assertEquals('approved', $cuenta->estado_pago);
        $this->assertDatabaseHas('notificaciones', ['user_id' => $cuenta->user_id, 'titulo' => 'Pago realizado']);
    }

    public function test_tesoreria_can_reject_payment_and_notify()
    {
        $auxRole = Role::firstOrCreate(['name' => 'auxiliar']);
        $createPerm = Permission::firstOrCreate(['name' => 'create_cuenta_cobro']);
        $viewPerm = Permission::firstOrCreate(['name' => 'view_cuenta_cobro']);
        $auxRole->permissions()->syncWithoutDetaching([$createPerm->id, $viewPerm->id]);
        $aux = User::factory()->create(['role_id' => $auxRole->id]);
        $this->actingAs($aux);
        $payload = $this->minimalPayload();
        $this->post(route('cuentas_cobro.store'), $payload);

        $cuenta = CuentaCobro::first();
        $this->assertNotNull($cuenta);

        // Move to tesoreria and mark approved
        $cuenta->update(['etapa_aprobacion' => 'tesoreria', 'estado_aprobacion' => 'aprobado']);

        $tesRole = Role::firstOrCreate(['name' => 'tesoreria']);
        // Give granular permission to register/reject payments
        \App\Models\PermisoGranular::create([
            'role_id' => $tesRole->id,
            'etapa_flujo' => 'tesoreria',
            'puede_registrar_pago' => true,
            'activo' => true,
        ]);
        $tes = User::factory()->create(['role_id' => $tesRole->id]);
        $this->actingAs($tes);

        $resp = $this->post(route('cuentas_cobro.rechazar_pago', $cuenta->id), ['motivo' => 'Error en transacción']);
        $resp->assertRedirect();
        $cuenta->refresh();
        $this->assertEquals('rejected', $cuenta->estado_pago);
        $this->assertDatabaseHas('notificaciones', ['user_id' => $cuenta->user_id, 'titulo' => 'Pago rechazado']);
    }
}
