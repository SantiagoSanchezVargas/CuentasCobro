<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class RolController extends Controller
{
    /**
     * Mostrar todos los roles
     */
    public function index()
    {
        $roles = Role::with('users')->get();
        return view('roles.index', compact('roles'));
    }

    /**
     * Mostrar formulario para crear un nuevo rol
     */
    public function create()
    {
        $availablePermissions = Permission::all();
        return view('roles.create', compact('availablePermissions'));
    }

    /**
     * Guardar un nuevo rol en la base de datos
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description ?? null,
        ]);

        // Asignar permisos: convertir nombres a IDs
        if ($request->has('permissions')) {
            // Accept both numeric IDs and permission names
            $permissionValues = $request->permissions ?? [];
            $permissionIds = Permission::whereIn('id', $permissionValues)
                ->orWhereIn('name', $permissionValues)
                ->pluck('id')
                ->toArray();
            $role->permissions()->sync($permissionIds);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente con sus permisos.');
    }

    /**
     * Mostrar formulario para editar un rol existente
     */
    public function edit(Role $role)
    {
        $availablePermissions = Permission::all();
        return view('roles.edit', compact('role', 'availablePermissions'));
    }

    /**
     * Actualizar un rol existente
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description ?? null,
        ]);

        // Sincronizar permisos: esto actualiza correctamente la tabla pivot
        if ($request->has('permissions')) {
            $permissionValues = $request->permissions ?? [];
            $permissionIds = Permission::whereIn('id', $permissionValues)
                ->orWhereIn('name', $permissionValues)
                ->pluck('id')
                ->toArray();
            $role->permissions()->sync($permissionIds);
        } else {
            // Si no hay permisos seleccionados, remover todos
            $role->permissions()->sync([]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rol y permisos actualizados correctamente.');
    }

    /**
     * Eliminar un rol
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado correctamente.');
    }

    /**
     * Mostrar un rol (opcional, si lo usas)
     */
    public function show(Role $role)
    {
        $users = $role->users()->paginate(10);
        return view('roles.show', compact('role', 'users'));
    }

    /**
     * Asignar un rol a un usuario (AJAX)
     */
    public function assignRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);
        $user->role()->associate($role);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Rol asignado correctamente.']);
    }

    /**
     * Remover rol de un usuario (AJAX)
     */
    public function removeRole(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->role()->dissociate();
        $user->save();

        return response()->json(['success' => true, 'message' => 'Rol removido correctamente.']);
    }

    /**
     * Obtener usuarios sin rol (AJAX)
     */
    public function getUsersWithoutRole()
    {
        $users = User::whereNull('role_id')->get();
        return response()->json($users);
    }
}
