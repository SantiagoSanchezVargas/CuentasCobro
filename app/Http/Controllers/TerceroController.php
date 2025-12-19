<?php

namespace App\Http\Controllers;

use App\Models\Tercero;
use Illuminate\Http\Request;

class TerceroController extends Controller
{
    /**
     * Display a listing of terceros.
     */
    public function index(Request $request)
    {
        $query = Tercero::query();

        // Filtros de búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('identificacion', 'like', "%{$search}%")
                  ->orWhere('nombre_completo', 'like', "%{$search}%")
                  ->orWhere('razon_social', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipo_persona')) {
            $query->where('tipo_persona', $request->tipo_persona);
        }

        $terceros = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('terceros.index', compact('terceros'));
    }

    /**
     * Search terceros for AJAX autocomplete.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $terceros = Tercero::where('identificacion', 'like', "%{$query}%")
            ->orWhere('nombre_completo', 'like', "%{$query}%")
            ->orWhere('razon_social', 'like', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json($terceros->map(function ($tercero) {
            $nombre = $tercero->tipo_persona === 'juridica' 
                ? $tercero->razon_social 
                : $tercero->nombre_completo;
            return [
                'id' => $tercero->id,
                'value' => $nombre,
                'text' => $tercero->identificacion . ' - ' . $nombre,
                'data' => $tercero
            ];
        }));
    }

    /**
     * Store a newly created tercero.
     */
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
            'pais' => 'nullable',
            'pais_codigo' => 'nullable',
            'ciudad' => 'nullable',
            'departamento' => 'nullable',
            'responsabilidades_fiscales' => 'nullable|array',
        ]);

        if (isset($validated['responsabilidades_fiscales'])) {
            $validated['responsabilidad_fiscal'] = $validated['responsabilidades_fiscales'];
            unset($validated['responsabilidades_fiscales']);
        }
        if (isset($validated['pais_codigo'])) {
            $validated['codigo_pais'] = $validated['pais_codigo'];
            unset($validated['pais_codigo']); // Quitamos el nombre que NO existe en la DB
        }
        $tercero = Tercero::create($validated);

        return response()->json([
            'success' => true,
            'tercero' => $tercero,
            'message' => 'Tercero creado correctamente'
        ]);
    }

    /**
     * Show the form for editing a tercero.
     */
    public function edit($id)
    {
        $tercero = Tercero::findOrFail($id);
        
        // Cargar catálogos
        $paises = \Illuminate\Support\Facades\DB::table('paises')->where('activo', true)->orderBy('nombre')->get();
        $responsabilidadesFiscales = \Illuminate\Support\Facades\DB::table('responsabilidades_fiscales')->where('activo', true)->get();
        $departamentos = \App\Models\Departamento::with('municipios')->orderBy('nombre')->get();

        return view('terceros.edit', compact('tercero', 'paises', 'responsabilidadesFiscales', 'departamentos'));
    }

    /**
     * Update a tercero.
     */
    public function update(Request $request, $id)
    {
        $tercero = Tercero::findOrFail($id);

        $validated = $request->validate([
            'tipo_persona' => 'required|in:natural,juridica',
            'tipo_identificacion' => 'required',
            'identificacion' => 'required|unique:terceros,identificacion,' . $id,
            'dv' => 'nullable',
            'nombre_completo' => 'required_if:tipo_persona,natural',
            'razon_social' => 'required_if:tipo_persona,juridica',
            'email' => 'nullable|email',
            'telefono' => 'nullable',
            'codigo_pais' => 'nullable',
            'direccion' => 'nullable',
            'pais' => 'nullable',
            'pais_codigo' => 'nullable',
            'ciudad' => 'nullable',
            'departamento' => 'nullable',
            'responsabilidades_fiscales' => 'nullable|array',
        ]);

         if (isset($validated['responsabilidades_fiscales'])) {
            $validated['responsabilidad_fiscal'] = $validated['responsabilidades_fiscales'];
            unset($validated['responsabilidades_fiscales']);
        }
        if (isset($validated['pais_codigo'])) {
            $validated['codigo_pais'] = $validated['pais_codigo'];
            unset($validated['pais_codigo']); // Quitamos el nombre que NO existe en la DB
        }

        $tercero->update($validated);

        return redirect()->route('terceros.index')->with('success', 'Tercero actualizado correctamente');
    }

    /**
     * Delete a tercero.
     */
    public function destroy($id)
    {
        $tercero = Tercero::findOrFail($id);
        
        // Verificar si tiene cuentas de cobro asociadas
        $tieneCuentas = \App\Models\CuentaCobro::where('identificacion', $tercero->identificacion)->exists();
        
        if ($tieneCuentas) {
            return redirect()->route('terceros.index')->with('error', 'No se puede eliminar el tercero porque tiene cuentas de cobro asociadas.');
        }

        $tercero->delete();

        return redirect()->route('terceros.index')->with('success', 'Tercero eliminado correctamente');
    }

    /**
     * Update tercero inline via AJAX.
     */
    public function updateInline(Request $request, $id)
    {
        $tercero = Tercero::findOrFail($id);

        $field = $request->input('field');
        $value = $request->input('value');

        $allowedFields = ['nombre_completo', 'razon_social', 'email', 'telefono', 'direccion', 'ciudad', 'departamento'];

        if (!in_array($field, $allowedFields)) {
            return response()->json(['success' => false, 'message' => 'Campo no permitido'], 400);
        }

        // Validación básica
        if ($field === 'email' && $value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['success' => false, 'message' => 'Email inválido'], 422);
        }

        $tercero->update([$field => $value]);

        return response()->json([
            'success' => true,
            'message' => 'Actualizado correctamente',
            'tercero' => $tercero->fresh()
        ]);
    }
}
