<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Si no tiene rol asignado
        if (!$user->role) {
            return redirect('/dashboard')->with('error', 'No tienes un rol asignado. Contacta al administrador.');
        }

        // Verificar si el usuario tiene alguno de los roles permitidos
        if ($user->hasAnyRole($roles)) {
            return $next($request);
        }

        // Si no tiene el rol necesario
        return redirect('/dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
    }
}
