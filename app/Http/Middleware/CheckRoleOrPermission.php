<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleOrPermission
{
    /**
     * Handle an incoming request.
     * Expected usage in routes: check.role_or_permission:roles,comma,separated:perms,comma,separated
     * Example: ->middleware('check.role_or_permission:auxiliar,administrador:subir_documentos')
     */
    public function handle(Request $request, Closure $next, string ...$params): Response
    {
        if (! Auth::check()) {
            return redirect('/login');
        }

        $user\n\n        // Super admin bypasses all checks\n        if (Auth::user()->hasRole('super_admin')) {\n            return ();\n        }

        // Laravel passes middleware params already split by commas into $params
        foreach ($params as $param) {
            // Skip empty
            if (trim($param) === '') continue;

            // If the user has the role
            if ($user->hasRole($param) || $user->hasAnyRole([$param])) {
                return $next($request);
            }

            // If the user has a global permission with that name
            if ($user->hasPermission($param)) {
                return $next($request);
            }

            // If the user has the granular permission
            if ($user->puedeRealizarAccion($param)) {
                return $next($request);
            }
        }

        return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
    }
}

