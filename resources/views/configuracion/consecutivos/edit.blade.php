@extends('layouts.app')

@section('title', 'Editar Consecutivo')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Editar Consecutivo</h2>
        
        <form action="{{ route('consecutivos.update', $consecutivo) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento</label>
                    <select name="tipo_documento" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="Cuenta de Cobro" {{ $consecutivo->tipo_documento == 'Cuenta de Cobro' ? 'selected' : '' }}>Cuenta de Cobro</option>
                        <option value="Documento Soporte" {{ $consecutivo->tipo_documento == 'Documento Soporte' ? 'selected' : '' }}>Documento Soporte</option>
                        <option value="Factura de Venta" {{ $consecutivo->tipo_documento == 'Factura de Venta' ? 'selected' : '' }}>Factura de Venta</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prefijo</label>
                    <input type="text" name="prefijo" value="{{ $consecutivo->prefijo }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Resolución DIAN</label>
                    <input type="text" name="resolucion" value="{{ $consecutivo->resolucion }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número Inicial (No editable)</label>
                    <input type="number" value="{{ $consecutivo->numero_inicial }}" class="w-full rounded-lg border-gray-300 bg-gray-100" disabled>
                    <input type="hidden" name="numero_inicial" value="{{ $consecutivo->numero_inicial }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número Final</label>
                    <input type="number" name="numero_final" value="{{ $consecutivo->numero_final }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vigencia Desde</label>
                    <input type="date" name="vigencia_inicio" value="{{ $consecutivo->vigencia_inicio->format('Y-m-d') }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vigencia Hasta</label>
                    <input type="date" name="vigencia_fin" value="{{ $consecutivo->vigencia_fin->format('Y-m-d') }}" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div class="col-span-2">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="activo" value="1" {{ $consecutivo->activo ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="text-sm font-medium text-gray-700">Consecutivo Activo</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('consecutivos.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancelar</a>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Actualizar Consecutivo</button>
            </div>
        </form>
    </div>
</div>
@endsection
