<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PermisoGranular;
use Illuminate\Http\Request;

class DiagnosticsController extends Controller
{
    public function userPermissions(User $user)
    {
        $role = $user->role;
        $globalPerms = $role ? $role->permissions : collect([]);
        $granular = $role ? PermisoGranular::byRol($role)->activos()->get() : collect([]);

        return view('admin.diagnostics.user_permissions', compact('user', 'role', 'globalPerms', 'granular'));
    }
}
