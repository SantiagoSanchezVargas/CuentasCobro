@extends('layouts.app')

@section('title', 'Planificador de Consecutivos')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Planificador de Consecutivos</h1>
            <p class="text-gray-500">Crea varios rangos de numeración en un solo paso (prefijo, rango, vigencia).</p>
        </div>
        <a href="{{ route('consecutivos.index') }}" class="text-blue-600 hover:underline">Volver al listado</a>
    </div>

    <form method="POST" action="{{ route('consecutivos.storeBulk') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6" id="bulkForm">
        @csrf
        <div class="space-y-4" id="rangosContainer">
            <template id="rangoTemplate">
                <div class="grid grid-cols-1 md:grid-cols-6 gap-3 items-end border border-gray-100 rounded-lg p-3 rango-row">
                    <div>
                        <label class="form-label">Tipo documento</label>
                        <input type="text" name="__NAME__[tipo_documento]" class="form-input" placeholder="Cuenta de Cobro" required>
                    </div>
                    <div>
                        <label class="form-label">Prefijo</label>
                        <input type="text" name="__NAME__[prefijo]" class="form-input" placeholder="CC" maxlength="10">
                    </div>
                    <div>
                        <label class="form-label">Número inicial</label>
                        <input type="number" name="__NAME__[numero_inicial]" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Número final</label>
                        <input type="number" name="__NAME__[numero_final]" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Vigencia inicio</label>
                        <input type="date" name="__NAME__[vigencia_inicio]" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Vigencia fin</label>
                        <input type="date" name="__NAME__[vigencia_fin]" class="form-input" required>
                    </div>
                </div>
            </template>
        </div>

        <div class="flex gap-3 mt-4">
            <button type="button" id="addRow" class="bg-slate-100 text-slate-800 px-3 py-2 rounded-lg hover:bg-slate-200">+ Agregar rango</button>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Guardar rangos</button>
        </div>
    </form>

    <div class="mt-10">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Consecutivos existentes</h2>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Prefijo</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Rango</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Vigencia</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($consecutivos as $c)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $c->tipo_documento }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $c->prefijo ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $c->numero_inicial }} - {{ $c->numero_final }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $c->vigencia_inicio->format('d/m/Y') }} - {{ $c->vigencia_fin->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $c->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $c->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    (function () {
        const container = document.getElementById('rangosContainer');
        const tpl = document.getElementById('rangoTemplate').innerHTML;
        const addBtn = document.getElementById('addRow');
        let counter = 0;

        function addRow(preset) {
            const name = `rangos[${counter}]`;
            const html = tpl.replace(/__NAME__/g, name);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html.trim();
            if (preset) {
                wrapper.querySelector(`[name="${name}[tipo_documento]"]`).value = preset.tipo_documento || '';
                wrapper.querySelector(`[name="${name}[prefijo]"]`).value = preset.prefijo || '';
                wrapper.querySelector(`[name="${name}[numero_inicial]"]`).value = preset.numero_inicial || '';
                wrapper.querySelector(`[name="${name}[numero_final]"]`).value = preset.numero_final || '';
                wrapper.querySelector(`[name="${name}[vigencia_inicio]"]`).value = preset.vigencia_inicio || '';
                wrapper.querySelector(`[name="${name}[vigencia_fin]"]`).value = preset.vigencia_fin || '';
            }
            container.appendChild(wrapper.firstElementChild);
            counter++;
        }

        addBtn.addEventListener('click', () => addRow());

        // Cargar una fila inicial con ejemplo
        addRow({ tipo_documento: 'Cuenta de Cobro', prefijo: 'CC', numero_inicial: 1000, numero_final: 30000, vigencia_inicio: '2025-01-01', vigencia_fin: '2025-02-28' });
    })();
</script>
@endsection
