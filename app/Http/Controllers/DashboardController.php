<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\CuentaCobro;
use App\Models\Contrato;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        // Redireccionar según el rol
        if ($user->hasRole('auxiliar')) {
            return redirect()->route('auxiliar.dashboard');
        }
        if ($user->hasRole('administrador')) {
            return redirect()->route('administrador.dashboard');
        }
        if ($user->hasRole('tesoreria')) {
            return redirect()->route('tesoreria.dashboard');
        }
        if ($user->hasRole('admin_programa')) {
            return redirect()->route('admin.dashboard');
        }

        // Estadísticas de usuarios
        $totalUsers = User::count();
        $usersWithRoles = User::whereNotNull('role_id')->count();
        $usersWithoutRoles = User::whereNull('role_id')->count();
        $totalRoles = Role::count();
        
        // Estadísticas de cuentas de cobro y pagos
        $totalCuentas = CuentaCobro::count();
        $totalPagos = CuentaCobro::whereNotNull('contrato_id')->count();
        $totalTesoreria = CuentaCobro::whereHas('contrato')->count();
        $totalContratacion = Contrato::count();
        
        // Usuarios recientes (últimos 10)
        $recentUsers = User::with('role')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalUsers',
            'usersWithRoles',
            'usersWithoutRoles',
            'totalRoles',
            'totalCuentas',
            'totalPagos',
            'totalTesoreria',
            'totalContratacion',
            'recentUsers'
        ));
    }

    public function auxiliar()
    {
        $user = Auth::user();
        
        // Proyección de Pagos: Suma de valor_total de cuentas aprobadas pendientes de pago
        $proyeccionPagos = CuentaCobro::whereIn('estado_aprobacion', ['aprobado', 'enviado_cliente'])
            ->sum('valor_total');

        // Estados de las cuentas
        $estados = CuentaCobro::selectRaw('estado_aprobacion, count(*) as total')
            ->groupBy('estado_aprobacion')
            ->pluck('total', 'estado_aprobacion');

        $cuentasAprobadas = ($estados['aprobado'] ?? 0) + ($estados['enviado_cliente'] ?? 0) + ($estados['pagado'] ?? 0);
        $cuentasEnRevision = $estados['en_revision'] ?? 0;
        $cuentasRechazadas = $estados['rechazado'] ?? 0;

        return view('dashboard.auxiliar', compact(
            'proyeccionPagos',
            'cuentasAprobadas',
            'cuentasEnRevision',
            'cuentasRechazadas'
        ));
    }
}
