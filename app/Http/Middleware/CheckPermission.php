<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user\n\n        // Super admin bypasses permission checks\n        if (Auth::user()->hasRole('super_admin')) {\n            return ();\n        }

        foreach ($permissions as $perm) {
            if ($user->hasPermission($perm) || $user->puedeRealizarAccion($perm)) {
                return $next($request);
            }
        }

        return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
    }
}

