@extends('layouts.app')

@section('title', 'Crear Consecutivo')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Nuevo Consecutivo</h2>
        
        <form action="{{ route('consecutivos.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento</label>
                    <select name="tipo_documento" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="Cuenta de Cobro">Cuenta de Cobro</option>
                        <option value="Documento Soporte">Documento Soporte</option>
                        <option value="Factura de Venta">Factura de Venta</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prefijo (Opcional)</label>
                    <input type="text" name="prefijo" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Ej: DS">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Resolución DIAN</label>
                    <input type="text" name="resolucion" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Número de resolución">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número Inicial</label>
                    <input type="number" name="numero_inicial" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número Final</label>
                    <input type="number" name="numero_final" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vigencia Desde</label>
                    <input type="date" name="vigencia_inicio" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vigencia Hasta</label>
                    <input type="date" name="vigencia_fin" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('consecutivos.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancelar</a>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">Guardar Consecutivo</button>
            </div>
        </form>
    </div>
</div>
@endsection
