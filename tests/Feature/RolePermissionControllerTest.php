<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        if (!class_exists(\App\Models\User::class)) {
            $this->markTestSkipped('App\\Models\\User not available in this environment. Run `composer install` and `composer dump-autoload`.');
        }
    }

    public function test_store_accepts_ids_and_names_and_syncs_permissions()
    {
        // Create permissions
        $perm1 = Permission::create(['name' => 'perm_1']);
        $perm2 = Permission::create(['name' => 'perm_2']);

        // Ensure admin role exists
        $roleAdmin = Role::firstOrCreate(['name' => 'admin_programa']);
        $user = User::factory()->create(['role_id' => $roleAdmin->id]);

        // Acting as this user
        $this->actingAs($user);

        // Create role with permissions passed as IDs
        $response = $this->post(route('admin.roles.store'), [
            'name' => 'rol_test_ids',
            'description' => 'prueba',
            'permissions' => [$perm1->id]
        ]);

        $response->assertRedirect(route('admin.roles.index'));
        $this->assertDatabaseHas('role_permission', ['role_id' => Role::where('name', 'rol_test_ids')->first()->id, 'permission_id' => $perm1->id]);

        // Create role with permissions passed as names
        $response = $this->post(route('admin.roles.store'), [
            'name' => 'rol_test_names',
            'description' => 'prueba nombres',
            'permissions' => [$perm2->name]
        ]);

        $response->assertRedirect(route('admin.roles.index'));
        $this->assertDatabaseHas('role_permission', ['role_id' => Role::where('name', 'rol_test_names')->first()->id, 'permission_id' => $perm2->id]);
    }

    public function test_user_show_displays_role_permissions()
    {
        $perm = Permission::create(['name' => 'view_cuenta_cobro']);
        $role = Role::create(['name' => 'role_with_perm']);
        $role->permissions()->sync([$perm->id]);

        // Create target normal user and an administrator to access admin pages
        $targetUser = User::factory()->create(['role_id' => $role->id]);
        $adminRole = Role::firstOrCreate(['name' => 'admin_programa']);
        $admin = User::factory()->create(['role_id' => $adminRole->id]);
        $this->actingAs($admin);

        $response = $this->get(route('admin.users.show', $targetUser));
        $response->assertStatus(200);
        $response->assertSeeText('View cuenta cobro'); // shows `ucfirst` version
    }

    public function test_route_access_with_permission_or_role()
    {
        // Create permission and role
        $perm = Permission::create(['name' => 'view_cuenta_cobro']);
        $role = Role::create(['name' => 'rol_test_access']);
        $role->permissions()->sync([$perm->id]);

        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);

        $response = $this->get(route('cuentas_cobro.index'));
        $response->assertStatus(200);
    }

    public function test_cuenta_cobro_create_allows_any_role_with_permission()
    {
        $createPerm = Permission::create(['name' => 'create_cuenta_cobro']);
        $viewPerm = Permission::create(['name' => 'view_cuenta_cobro']);

        $role = Role::create(['name' => 'rol_test_creator']);
        $role->permissions()->sync([$createPerm->id, $viewPerm->id]);

        $user = User::factory()->create(['role_id' => $role->id]);
        $this->actingAs($user);

        $response = $this->get(route('cuentas_cobro.create'));
        $response->assertStatus(200);
    }
}
