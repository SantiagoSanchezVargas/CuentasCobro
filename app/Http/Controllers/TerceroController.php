<?php

namespace App\Http\Controllers;

use App\Models\Tercero;
use Illuminate\Http\Request;

class TerceroController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        $terceros = Tercero::where('identificacion', 'like', "%{$query}%")
            ->orWhere('nombre_completo', 'like', "%{$query}%")
            ->orWhere('razon_social', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json($terceros->map(function ($tercero) {
            return [
                'id' => $tercero->id,
                'text' => $tercero->identificacion . ' - ' . $tercero->nombre,
                'data' => $tercero
            ];
        }));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_persona' => 'required|in:natural,juridica',
            'tipo_identificacion' => 'required',
            'identificacion' => 'required|unique:terceros,identificacion',
            'dv' => 'nullable',
            'nombre_completo' => 'required_if:tipo_persona,natural',
            'razon_social' => 'required_if:tipo_persona,juridica',
            'email' => 'nullable|email',
            'telefono' => 'nullable',
            'codigo_pais' => 'nullable',
            'direccion' => 'nullable',
            'ciudad' => 'nullable',
            'departamento' => 'nullable',
            'responsabilidades_fiscales' => 'nullable|array',
        ]);

        // Convertir responsabilidades_fiscales a responsabilidad_fiscal para el modelo
        if (isset($validated['responsabilidades_fiscales'])) {
            $validated['responsabilidad_fiscal'] = $validated['responsabilidades_fiscales'];
            unset($validated['responsabilidades_fiscales']);
        }

        $tercero = Tercero::create($validated);

        return response()->json([
            'success' => true,
            'tercero' => $tercero,
            'message' => 'Tercero creado correctamente'
        ]);
    }
}
