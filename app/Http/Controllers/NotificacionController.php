<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    /**
     * Mostrar bandeja de notificaciones del usuario actual.
     */
    public function index()
    {
        $notificaciones = Notificacion::where('user_id', Auth::id())
            ->with('cuentaCobro')
            ->orderByDesc('created_at')
            ->paginate(20);

        $noLeidas = Notificacion::where('user_id', Auth::id())->noLeidas()->count();

        return view('notificaciones.index', compact('notificaciones', 'noLeidas'));
    }

    /**
     * Marcar una notificación como leída.
     */
    public function marcarLeida($id)
    {
        $notificacion = Notificacion::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notificacion->marcarComoLeida();

        return back()->with('success', 'Notificación marcada como leída.');
    }

    /**
     * Marcar todas las notificaciones del usuario como leídas.
     */
    public function marcarTodasLeidas()
    {
        Notificacion::where('user_id', Auth::id())
            ->noLeidas()
            ->update([
                'leida' => true,
                'fecha_leida' => now(),
            ]);

        return back()->with('success', 'Todas las notificaciones fueron marcadas como leídas.');
    }

    /**
     * Marcar como leída y redirigir al recurso relacionado.
     */
    public function visitar($id)
    {
        $notificacion = Notificacion::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$notificacion->leida) {
            $notificacion->marcarComoLeida();
        }

        // Redirigir según el tipo de notificación o recurso asociado
        if ($notificacion->cuenta_cobro_id) {
            return redirect()->route('cuentas_cobro.show', $notificacion->cuenta_cobro_id);
        }

        // Si no hay recurso específico, volver atrás
        return back();
    }
}
