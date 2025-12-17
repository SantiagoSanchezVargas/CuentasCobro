<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;

class AdminUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_user_and_assign_role()
    {
        $roleAdmin = Role::firstOrCreate(['name' => 'admin_programa']);

        $admin = User::factory()->create(['role_id' => $roleAdmin->id]);
        $this->actingAs($admin);

        $role = Role::firstOrCreate(['name' => 'tesoreria']);

        $response = $this->post(route('admin.users.store'), [
            'name' => 'Nuevo Usuario',
            'email' => 'nuevo@example.com',
            'password' => 'Secreto123!',
            'role_id' => $role->id,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['email' => 'nuevo@example.com', 'role_id' => $role->id]);
    }
}
