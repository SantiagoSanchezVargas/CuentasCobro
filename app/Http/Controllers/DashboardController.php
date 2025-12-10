<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\CuentaCobro;
use App\Models\Contrato;
use Illuminate\Support\Facades\Mail;
use App\Mail\CuentaCobroNotification;
use App\Models\Notificacion;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        $roleName = $user->role ? $user->role->name : null;

        // Mapeo de roles a rutas específicas si el nombre no coincide exactamente
        $routeMapping = [
            'admin_programa' => 'admin.dashboard',
        ];

        if ($roleName) {
            // 1. Verificar mapeo manual
            if (isset($routeMapping[$roleName])) {
                return redirect()->route($routeMapping[$roleName]);
            }

            // 2. Lógica Dinámica: Redireccionar si existe una ruta específica para el rol
            // Convención: nombre_rol.dashboard (ej: auxiliar.dashboard, tesoreria.dashboard)
            if (\Illuminate\Support\Facades\Route::has($roleName . '.dashboard')) {
                return redirect()->route($roleName . '.dashboard');
            }
        }

        // Si es un rol nuevo o sin dashboard específico, mostrar la vista predeterminada
        return view('dashboard.default');
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

    public function adminPrograma()
    {
        // Usuarios
        $totalUsuarios = User::count();
        $usuariosConRol = User::whereNotNull('role_id')->count();
        
        // Solicitudes (Cuentas de Cobro)
        $solicitudesPendientes = CuentaCobro::where('estado_aprobacion', 'pendiente')->count();
        $solicitudesTotal = CuentaCobro::count();

        // Reportes de uso (Simulado con logins o actividad reciente si hubiera, por ahora cuentas recientes)
        $cuentasRecientes = CuentaCobro::latest()->take(5)->get();
        
        // Usuarios recientes
        $usuariosRecientes = User::latest()->take(5)->get();

        return view('dashboard.admin_programa', compact(
            'totalUsuarios',
            'usuariosConRol',
            'solicitudesPendientes',
            'solicitudesTotal',
            'cuentasRecientes',
            'usuariosRecientes'
        ));
    }

    public function administrador()
    {
        $totalUsers = User::count();
        $totalRoles = Role::count();
        $totalCuentas = CuentaCobro::count();
        $cuentasPendientes = CuentaCobro::where('estado_aprobacion', 'pendiente')->count();
        
        // Usuarios recientes
        $recentUsers = User::latest()->take(5)->get();

        return view('dashboard.administrador', compact(
            'totalUsers',
            'totalRoles',
            'totalCuentas',
            'cuentasPendientes',
            'recentUsers'
        ));
    }

    public function tesoreria()
    {
        // Cuentas aprobadas listas para pago
        $porPagar = CuentaCobro::where('estado_aprobacion', 'aprobado')->count();
        $valorPorPagar = CuentaCobro::where('estado_aprobacion', 'aprobado')->sum('valor_total');
        
        // Pagos realizados este mes
        $pagosMes = CuentaCobro::where('estado_aprobacion', 'pagado')
            ->whereMonth('fecha_pago', now()->month)
            ->count();
            
        $valorPagadoMes = CuentaCobro::where('estado_aprobacion', 'pagado')
            ->whereMonth('fecha_pago', now()->month)
            ->sum('valor_total');

        // Últimas cuentas aprobadas
        $cuentasPorPagar = CuentaCobro::where('estado_aprobacion', 'aprobado')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.tesoreria', compact(
            'porPagar',
            'valorPorPagar',
            'pagosMes',
            'valorPagadoMes',
            'cuentasPorPagar'
        ));
    }

    public function enviarCuentaCliente(Request $request, $id)
    {
        $request->validate(['email' => 'required|email']);
        $cuenta = CuentaCobro::findOrFail($id);
        
        // Enviar correo
        Mail::to($request->email)->send(new CuentaCobroNotification($cuenta, "Su cuenta de cobro ha sido aprobada y enviada para pago."));
        
        $cuenta->update(['estado_aprobacion' => 'enviado_cliente']);
        
        return back()->with('success', 'Cuenta enviada al cliente correctamente.');
    }

    public function enviarSugerencia(Request $request)
    {
        $request->validate(['mensaje' => 'required|string|max:1000']);
        
        // Buscar admins del programa
        $admins = User::whereHas('role', function($q) {
            $q->where('name', 'admin_programa');
        })->get();
        
        foreach($admins as $admin) {
            Notificacion::create([
                'user_id' => $admin->id,
                'cuenta_cobro_id' => null,
                'titulo' => 'Nueva Sugerencia',
                'mensaje' => 'Sugerencia de ' . Auth::user()->name . ': ' . $request->mensaje,
                'tipo' => 'info',
                'leida' => false
            ]);
        }
        
        return back()->with('success', 'Sugerencia enviada al administrador.');
    }
}
