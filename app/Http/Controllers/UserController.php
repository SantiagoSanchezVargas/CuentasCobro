<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Mostrar listado de usuarios
    public function index()
    {
        $users = User::with('role')->get();
        return view('users.index', compact('users'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        // Registrar historial de cambio de rol (asignación inicial)
        \App\Models\RoleChangeHistory::create([
            'user_id' => $user->id,
            'previous_role_id' => null,
            'new_role_id' => $request->role_id,
            'changed_by' => Auth::id(),
            'changed_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado correctamente.');
    }

    // Mostrar detalle del usuario
    public function show(User $user)
    {
        $user->load(['role', 'roleChangeHistory.previousRole', 'roleChangeHistory.newRole', 'roleChangeHistory.changer']);
        return view('users.show', compact('user'));
    }

    // Mostrar formulario de edición
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // Actualizar usuario
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,{$user->id}",
            'role_id' => 'required|exists:roles,id',
        ]);

        $oldRoleId = $user->role_id;
        $newRoleId = $request->role_id;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $newRoleId,
        ]);

        if ($oldRoleId != $newRoleId) {
            \App\Models\RoleChangeHistory::create([
                'user_id' => $user->id,
                'previous_role_id' => $oldRoleId,
                'new_role_id' => $newRoleId,
                'changed_by' => Auth::id(),
                'changed_at' => now(),
            ]);
        }

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminar usuario
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
