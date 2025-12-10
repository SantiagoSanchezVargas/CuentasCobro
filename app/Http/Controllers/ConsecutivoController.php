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
