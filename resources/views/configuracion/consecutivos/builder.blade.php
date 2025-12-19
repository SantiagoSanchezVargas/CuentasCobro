@extends('layouts.app')

@section('title', 'Planificador de Consecutivos')

@section('content')
<style>
    .builder-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 24px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-header .title-section h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 6px;
    }

    .page-header .title-section h1 .icon {
        color: #00b5e2;
    }

    .page-header .title-section p {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }

    .btn-back {
        background: #f3f4f6;
        color: #374151;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        font-size: 14px;
    }

    .btn-back:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    .builder-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .builder-header {
        background: linear-gradient(135deg, #00b5e2 0%, #0097be 100%);
        padding: 20px 24px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .builder-header h2 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .builder-body {
        padding: 24px;
    }

    .ranges-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .range-row {
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.2s;
    }

    .range-row:hover {
        border-color: #00b5e2;
        box-shadow: 0 4px 12px rgba(0, 181, 226, 0.1);
    }

    .range-row .row-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .range-row .row-header .number {
        background: #1e3a5f;
        color: white;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
    }

    .range-row .row-header .remove-btn {
        background: #fee2e2;
        color: #dc2626;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .range-row .row-header .remove-btn:hover {
        background: #dc2626;
        color: white;
    }

    .range-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }

    .range-grid .form-group.full-row {
        grid-column: span 3;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .form-group label {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-input {
        padding: 10px 12px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13px;
        transition: all 0.2s;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: #00b5e2;
        box-shadow: 0 0 0 3px rgba(0, 181, 226, 0.1);
    }

    .builder-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        background: #f8fafc;
        border-top: 1px solid #e5e7eb;
    }

    .btn-add {
        background: #f1f5f9;
        color: #475569;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        border: 2px dashed #cbd5e1;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        font-size: 14px;
    }

    .btn-add:hover {
        background: #e2e8f0;
        border-color: #94a3b8;
    }

    .btn-submit {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
        color: white;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        font-size: 14px;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }

    /* Existing Consecutivos Table */
    .existing-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .existing-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 100%);
        padding: 16px 24px;
        color: white;
    }

    .existing-header h3 {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .existing-table {
        width: 100%;
        border-collapse: collapse;
    }

    .existing-table thead {
        background: #f8fafc;
    }

    .existing-table th {
        padding: 12px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .existing-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
    }

    .existing-table tbody tr:hover {
        background: #f8fafc;
    }

    .existing-table td {
        padding: 14px 16px;
        font-size: 13px;
        color: #334155;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-badge.active {
        background: #dcfce7;
        color: #166534;
    }

    .status-badge.inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    @media (max-width: 768px) {
        .range-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .range-grid .form-group.full-row {
            grid-column: span 2;
        }
    }

    @media (max-width: 480px) {
        .range-grid {
            grid-template-columns: 1fr;
        }
        .range-grid .form-group.full-row {
            grid-column: span 1;
        }
    }
</style>

<div class="builder-container">
    <!-- Header -->
    <div class="page-header">
        <div class="title-section">
            <h1>
                <span class="material-symbols-rounded icon">tune</span>
                Planificador de Consecutivos
            </h1>
            <p>Crea varios rangos de numeración en un solo paso con prefijo, rango y vigencia.</p>
        </div>
        <a href="{{ route('admin.consecutivos.index') }}" class="btn-back">
            <span class="material-symbols-rounded" style="font-size: 18px;">arrow_back</span>
            Volver al Listado
        </a>
    </div>

    <!-- Builder Form -->
    <form method="POST" action="{{ route('admin.consecutivos.storeBulk') }}" id="bulkForm">
        @csrf
        <div class="builder-card">
            <div class="builder-header">
                <h2>
                    <span class="material-symbols-rounded">add_box</span>
                    Nuevos Rangos de Consecutivos
                </h2>
            </div>

            <div class="builder-body">
                <div class="ranges-container" id="rangosContainer">
                    <!-- Template (hidden) -->
                    <template id="rangoTemplate">
                        <div class="range-row">
                            <div class="row-header">
                                <span class="number">1</span>
                                <button type="button" class="remove-btn" onclick="removeRow(this)" title="Eliminar">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">close</span>
                                </button>
                            </div>
                            <div class="range-grid">
                                <div class="form-group">
                                    <label>Tipo Documento</label>
                                    <input type="text" name="__NAME__[tipo_documento]" class="form-input" placeholder="Cuenta de Cobro" required>
                                </div>
                                <div class="form-group">
                                    <label>Prefijo</label>
                                    <input type="text" name="__NAME__[prefijo]" class="form-input" placeholder="CC" maxlength="10">
                                </div>
                                <div class="form-group">
                                    <label>Resolución DIAN</label>
                                    <input type="text" name="__NAME__[resolucion]" class="form-input" placeholder="Opcional">
                                </div>
                                <div class="form-group">
                                    <label>Número Inicial</label>
                                    <input type="number" name="__NAME__[numero_inicial]" class="form-input" placeholder="1" required>
                                </div>
                                <div class="form-group">
                                    <label>Número Final</label>
                                    <input type="number" name="__NAME__[numero_final]" class="form-input" placeholder="99999" required>
                                </div>
                                <div class="form-group"></div>
                                <div class="form-group">
                                    <label>Vigencia Inicio</label>
                                    <input type="date" name="__NAME__[vigencia_inicio]" class="form-input" required>
                                </div>
                                <div class="form-group">
                                    <label>Vigencia Fin</label>
                                    <input type="date" name="__NAME__[vigencia_fin]" class="form-input" required>
                                </div>
                                <div class="form-group"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="builder-footer">
                <button type="button" id="addRow" class="btn-add">
                    <span class="material-symbols-rounded" style="font-size: 18px;">add</span>
                    Agregar Otro Rango
                </button>
                <button type="submit" class="btn-submit">
                    <span class="material-symbols-rounded" style="font-size: 18px;">save</span>
                    Guardar Todos los Rangos
                </button>
            </div>
        </div>
    </form>

    <!-- Existing Consecutivos -->
    <div class="existing-card">
        <div class="existing-header">
            <h3>
                <span class="material-symbols-rounded">list</span>
                Consecutivos Existentes
            </h3>
        </div>
        <table class="existing-table">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Prefijo</th>
                    <th>Rango</th>
                    <th>Vigencia</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consecutivos as $c)
                    <tr>
                        <td style="font-weight: 600;">{{ $c->tipo_documento }}</td>
                        <td>
                            @if($c->prefijo)
                                <span style="font-family: monospace; background: #f1f5f9; padding: 2px 8px; border-radius: 4px;">{{ $c->prefijo }}</span>
                            @else
                                <span style="color: #9ca3af;">—</span>
                            @endif
                        </td>
                        <td style="font-family: monospace;">{{ number_format($c->numero_inicial) }} — {{ number_format($c->numero_final) }}</td>
                        <td>{{ $c->vigencia_inicio->format('d/m/Y') }} — {{ $c->vigencia_fin->format('d/m/Y') }}</td>
                        <td>
                            <span class="status-badge {{ $c->activo ? 'active' : 'inactive' }}">
                                {{ $c->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #9ca3af; padding: 32px;">
                            No hay consecutivos configurados aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
        
        const row = wrapper.firstElementChild;
        row.querySelector('.number').textContent = counter + 1;
        
        if (preset) {
            const tipoInput = row.querySelector(`[name="${name}[tipo_documento]"]`);
            const prefijoInput = row.querySelector(`[name="${name}[prefijo]"]`);
            const inicialInput = row.querySelector(`[name="${name}[numero_inicial]"]`);
            const finalInput = row.querySelector(`[name="${name}[numero_final]"]`);
            const vigInicioInput = row.querySelector(`[name="${name}[vigencia_inicio]"]`);
            const vigFinInput = row.querySelector(`[name="${name}[vigencia_fin]"]`);
            
            if (tipoInput) tipoInput.value = preset.tipo_documento || '';
            if (prefijoInput) prefijoInput.value = preset.prefijo || '';
            if (inicialInput) inicialInput.value = preset.numero_inicial || '';
            if (finalInput) finalInput.value = preset.numero_final || '';
            if (vigInicioInput) vigInicioInput.value = preset.vigencia_inicio || '';
            if (vigFinInput) vigFinInput.value = preset.vigencia_fin || '';
        }
        
        container.appendChild(row);
        counter++;
        updateRowNumbers();
    }

    function updateRowNumbers() {
        const rows = container.querySelectorAll('.range-row');
        rows.forEach((row, index) => {
            const numberEl = row.querySelector('.number');
            if (numberEl) numberEl.textContent = index + 1;
        });
    }

    window.removeRow = function(btn) {
        const row = btn.closest('.range-row');
        if (container.querySelectorAll('.range-row').length > 1) {
            row.remove();
            updateRowNumbers();
        } else {
            alert('Debe tener al menos un rango.');
        }
    };

    addBtn.addEventListener('click', () => addRow());

    // Cargar una fila inicial con ejemplo
    const today = new Date();
    const nextYear = new Date(today.getFullYear() + 1, today.getMonth(), today.getDate());
    
    addRow({ 
        tipo_documento: 'Cuenta de Cobro', 
        prefijo: 'CC', 
        numero_inicial: 1, 
        numero_final: 99999, 
        vigencia_inicio: today.toISOString().split('T')[0], 
        vigencia_fin: nextYear.toISOString().split('T')[0] 
    });
})();
</script>
@endsection
