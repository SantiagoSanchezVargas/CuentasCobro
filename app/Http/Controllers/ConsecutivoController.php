<?php

namespace App\Http\Controllers;

use App\Models\Consecutivo;
use Illuminate\Http\Request;

class ConsecutivoController extends Controller
{
    public function index()
    {
        $consecutivos = Consecutivo::all();
        return view('configuracion.consecutivos.index', compact('consecutivos'));
    }

    public function create()
    {
        return view('configuracion.consecutivos.create');
    }

    /**
     * Builder para crear múltiples rangos de consecutivos de forma rápida.
     */
    public function builder()
    {
        $consecutivos = Consecutivo::orderByDesc('created_at')->get();
        return view('configuracion.consecutivos.builder', compact('consecutivos'));
    }

    /**
     * Guardar múltiples consecutivos en un solo envío.
     */
    public function storeBulk(Request $request)
    {
        $request->validate([
            'rangos' => 'required|array|min:1',
            'rangos.*.tipo_documento' => 'required|string',
            'rangos.*.prefijo' => 'nullable|string|max:10',
            'rangos.*.numero_inicial' => 'required|integer',
            'rangos.*.numero_final' => 'required|integer|gt:rangos.*.numero_inicial',
            'rangos.*.vigencia_inicio' => 'required|date',
            'rangos.*.vigencia_fin' => 'required|date|after:rangos.*.vigencia_inicio',
        ]);

        foreach ($request->rangos as $rango) {
            Consecutivo::create([
                'tipo_documento' => $rango['tipo_documento'],
                'prefijo' => $rango['prefijo'] ?? null,
                'numero_inicial' => (int) $rango['numero_inicial'],
                'numero_final' => (int) $rango['numero_final'],
                'numero_actual' => ((int) $rango['numero_inicial']) - 1,
                'vigencia_inicio' => $rango['vigencia_inicio'],
                'vigencia_fin' => $rango['vigencia_fin'],
                'resolucion' => $rango['resolucion'] ?? null,
                'activo' => $rango['activo'] ?? true,
            ]);
        }

        return redirect()->route('consecutivos.index')->with('success', 'Rangos creados exitosamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_documento' => 'required|string',
            'numero_inicial' => 'required|integer',
            'numero_final' => 'required|integer|gt:numero_inicial',
            'vigencia_inicio' => 'required|date',
            'vigencia_fin' => 'required|date|after:vigencia_inicio',
        ]);

        $data = $request->all();
        $data['numero_actual'] = $request->numero_inicial - 1; // Start before the first number so the first increment gives the initial number

        Consecutivo::create($data);

        return redirect()->route('consecutivos.index')->with('success', 'Consecutivo creado correctamente.');
    }

    public function edit(Consecutivo $consecutivo)
    {
        return view('configuracion.consecutivos.edit', compact('consecutivo'));
    }

    public function update(Request $request, Consecutivo $consecutivo)
    {
        $request->validate([
            'tipo_documento' => 'required|string',
            'numero_final' => 'required|integer|gt:numero_inicial',
            'vigencia_fin' => 'required|date|after:vigencia_inicio',
        ]);

        $consecutivo->update($request->all());

        return redirect()->route('consecutivos.index')->with('success', 'Consecutivo actualizado correctamente.');
    }
}
