<?php

namespace App\Http\Controllers;

use App\Models\CuentaCobro;
use App\Models\Soporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SoporteController extends Controller
{
    public function store(Request $request, $cuentaId)
    {
        $cuenta = CuentaCobro::findOrFail($cuentaId);
        $user = Auth::user();

        // Verificar si es el dueño de la cuenta
        $isOwner = $cuenta->user_id === $user->id;
        
        // Verificar permisos granulares mediante PermisoGranular
        // Esto es coherente con Documentos, que usa 'subir_documentos'
        // Support both granular permissions and global Permission entries
        $hasPermission = $user->hasPermission('subir_soportes') || $user->puedeRealizarAccion('subir_documentos');

        // Permitir si es dueño Y tiene permiso
        if (! $isOwner || ! $hasPermission) {
            return back()->with('error', 'No tienes permisos para adjuntar soportes.');
        }

        if (!in_array($cuenta->estado_aprobacion, ['en_correccion', 'en_revision'])) {
            return back()->with('error', 'La cuenta no está en estado válido para adjuntar soportes.');
        }

        $request->validate([
            'soportes.*' => 'required|file|max:10240', // 10MB por archivo
        ]);

        foreach ((array) $request->file('soportes', []) as $file) {
            $dir = 'soportes/'.$cuenta->id;
            $path = $file->store($dir, 'public');

            Soporte::create([
                'cuenta_cobro_id' => $cuenta->id,
                'user_id' => $user->id,
                'nombre' => $file->getClientOriginalName(),
                'path' => $path,
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
        }

        return back()->with('success', 'Soportes cargados correctamente.');
    }

    public function destroy($cuentaId, $soporteId)
    {
        $cuenta = CuentaCobro::findOrFail($cuentaId);
        $soporte = Soporte::where('cuenta_cobro_id', $cuenta->id)->findOrFail($soporteId);
        $user = Auth::user();

        $isOwner = $cuenta->user_id === $user->id;
        // Para eliminar, usamos el mismo permiso granular (o podrías definir otro)
        $hasPermission = $user->hasPermission('eliminar_soportes') || $user->puedeRealizarAccion('subir_documentos');

        if (! $isOwner || ! $hasPermission) {
            return back()->with('error', 'No tienes permisos para eliminar el soporte.');
        }

        if (!in_array($cuenta->estado_aprobacion, ['en_correccion', 'en_revision'])) {
            return back()->with('error', 'La cuenta no está en estado válido para eliminar soportes.');
        }

        // Eliminar archivo físico
        if ($soporte->path) {
            Storage::disk('public')->delete($soporte->path);
        }
        $soporte->delete();

        return back()->with('success', 'Soporte eliminado.');
    }
}
