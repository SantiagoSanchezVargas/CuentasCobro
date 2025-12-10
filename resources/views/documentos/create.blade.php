@extends('layouts.app')

@section('title', 'Subir Documento')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Subir Documento</h2>
            <a href="{{ route('documentos.index', $cuenta->id) }}" class="text-gray-500 hover:text-gray-700">
                <span class="material-symbols-rounded">close</span>
            </a>
        </div>

        <form action="{{ route('documentos.store', $cuenta->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento</label>
                <select name="tipo" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    <option value="factura">Factura / Cuenta de Cobro</option>
                    <option value="contrato">Contrato</option>
                    <option value="comprobante">Comprobante de Pago</option>
                    <option value="rut">RUT</option>
                    <option value="cedula">Cédula</option>
                    <option value="otro">Otro</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Archivo</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition cursor-pointer" onclick="document.getElementById('fileInput').click()">
                    <div class="space-y-1 text-center">
                        <span class="material-symbols-rounded text-gray-400 text-4xl">cloud_upload</span>
                        <div class="flex text-sm text-gray-600">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                <span>Selecciona un archivo</span>
                                <input id="fileInput" name="archivo" type="file" class="sr-only" onchange="document.getElementById('fileName').textContent = this.files[0].name">
                            </label>
                            <p class="pl-1">o arrastra y suelta</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF, PNG, JPG hasta 10MB</p>
                        <p id="fileName" class="text-sm font-semibold text-blue-600 mt-2"></p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Descripción (Opcional)</label>
                <textarea name="descripcion" rows="3" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Detalles adicionales sobre el documento..."></textarea>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('documentos.index', $cuenta->id) }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancelar</a>
                <button type="submit" class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 font-medium shadow-sm">Subir Archivo</button>
            </div>
        </form>
    </div>
</div>
@endsection
