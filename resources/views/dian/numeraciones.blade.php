@extends('layouts.app')

@section('title', 'Numeraciones DIAN')

@section('content')
<div class="page-container">
    <!-- Header -->
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: var(--apple-dark); margin-bottom: 4px;">
                <span class="material-symbols-rounded" style="vertical-align: middle; margin-right: 8px;">tag</span>
                Numeraciones Autorizadas DIAN
            </h1>
            <p style="color: var(--apple-text-muted); font-size: 15px;">
                Gestión de prefijos y rangos de numeración autorizados
            </p>
        </div>
        @if(auth()->user()->role->name === 'admin_programa')
        <div>
            <button onclick="openNuevaNumeracionModal()" class="btn-apple">
                <span class="material-symbols-rounded">add</span>
                Nueva Numeración
            </button>
        </div>
        @endif
    </div>

    <!-- Info Card -->
    <div style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: white; padding: 20px 24px; border-radius: 16px; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <span class="material-symbols-rounded" style="font-size: 40px; opacity: 0.9;">info</span>
            <div>
                <p style="font-weight: 600; font-size: 16px; margin: 0 0 4px 0;">Numeración de Facturación Electrónica</p>
                <p style="font-size: 14px; opacity: 0.9; margin: 0;">
                    Las numeraciones deben ser autorizadas por la DIAN antes de usarse. Cada rango tiene vigencia y debe asociarse a un tipo de documento.
                </p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc;">
                    <th style="padding: 14px 16px; text-align: left; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Prefijo</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Resolución</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Rango</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Actual</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Uso</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Autorizado</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Estado</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($numeraciones ?? [] as $num)
                @php
                    $total = $num->end_number - $num->start_number + 1;
                    $usado = $num->current_number - $num->start_number;
                    $porcentaje = $total > 0 ? round(($usado / $total) * 100) : 0;
                @endphp
                <tr style="border-top: 1px solid #f1f5f9;">
                    <td style="padding: 14px 16px; font-weight: 700; font-family: monospace; font-size: 15px;">{{ $num->prefix ?? 'SIN' }}</td>
                    <td style="padding: 14px 16px;">{{ $num->resolution_number ?? '—' }}</td>
                    <td style="padding: 14px 16px; text-align: center; font-family: monospace;">
                        {{ number_format($num->start_number, 0, '', '.') }} - {{ number_format($num->end_number, 0, '', '.') }}
                    </td>
                    <td style="padding: 14px 16px; text-align: center; font-weight: 600;">{{ number_format($num->current_number, 0, '', '.') }}</td>
                    <td style="padding: 14px 16px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="flex: 1; height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                                <div style="width: {{ $porcentaje }}%; height: 100%; background: {{ $porcentaje > 90 ? '#ef4444' : ($porcentaje > 70 ? '#f59e0b' : '#10b981') }};"></div>
                            </div>
                            <span style="font-size: 12px; font-weight: 600; color: {{ $porcentaje > 90 ? '#ef4444' : '#64748b' }};">{{ $porcentaje }}%</span>
                        </div>
                    </td>
                    <td style="padding: 14px 16px; font-size: 13px; color: #64748b;">
                        {{ $num->authorized_at ? \Carbon\Carbon::parse($num->authorized_at)->format('d/m/Y') : '—' }}
                    </td>
                    <td style="padding: 14px 16px; text-align: center;">
                        @if($num->active)
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #d1fae5; color: #059669;">Activo</span>
                        @else
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; background: #f1f5f9; color: #64748b;">Inactivo</span>
                        @endif
                    </td>
                    <td style="padding: 14px 16px; text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <button onclick="editarNumeracion({{ $num->id }})" class="btn-icon" title="Editar" style="padding: 6px; border-radius: 8px; background: #f1f5f9; border: none; cursor: pointer;">
                                <span class="material-symbols-rounded" style="font-size: 18px;">edit</span>
                            </button>
                            <button onclick="toggleNumeracion({{ $num->id }}, {{ $num->active ? 0 : 1 }})" class="btn-icon" title="{{ $num->active ? 'Desactivar' : 'Activar' }}" style="padding: 6px; border-radius: 8px; background: {{ $num->active ? '#fef3c7' : '#dbeafe' }}; border: none; cursor: pointer;">
                                <span class="material-symbols-rounded" style="font-size: 18px;">{{ $num->active ? 'pause' : 'play_arrow' }}</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 48px; text-align: center; color: var(--apple-text-muted);">
                        <span class="material-symbols-rounded" style="font-size: 48px; opacity: 0.5; display: block; margin-bottom: 12px;">numbers</span>
                        No hay numeraciones registradas
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Nueva Numeración -->
<div id="nuevaNumeracionModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 16px; width: 90%; max-width: 500px; padding: 0; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
        <div style="padding: 20px 24px; border-bottom: 1px solid #e2e8f0;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 700;">Nueva Numeración DIAN</h2>
        </div>
        <form action="{{ route('dian.numeraciones.store') }}" method="POST">
            @csrf
            <div style="padding: 24px; display: flex; flex-direction: column; gap: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Prefijo</label>
                    <input type="text" name="prefix" class="form-input" placeholder="Ej: DS, FE" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Número Inicial</label>
                        <input type="number" name="start_number" required class="form-input" placeholder="1" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Número Final</label>
                        <input type="number" name="end_number" required class="form-input" placeholder="1000" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    </div>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Número de Resolución</label>
                    <input type="text" name="resolution_number" class="form-input" placeholder="18760000001234" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Fecha Autorización</label>
                    <input type="date" name="authorized_at" class="form-input" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Notas</label>
                    <textarea name="notes" rows="2" class="form-input" placeholder="Notas adicionales..." style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0; resize: vertical;"></textarea>
                </div>
            </div>
            <div style="padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 12px; background: #f8fafc; border-radius: 0 0 16px 16px;">
                <button type="button" onclick="closeNuevaNumeracionModal()" class="btn-apple btn-apple-secondary">Cancelar</button>
                <button type="submit" class="btn-apple">Guardar</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openNuevaNumeracionModal() {
    document.getElementById('nuevaNumeracionModal').style.display = 'flex';
}
function closeNuevaNumeracionModal() {
    document.getElementById('nuevaNumeracionModal').style.display = 'none';
}
function editarNumeracion(id) {
    alert('Editar numeración #' + id + ' - Funcionalidad en desarrollo');
}
function toggleNumeracion(id, estado) {
    if (confirm('¿Desea ' + (estado ? 'activar' : 'desactivar') + ' esta numeración?')) {
        alert('Toggle numeración #' + id + ' - Funcionalidad en desarrollo');
    }
}
document.getElementById('nuevaNumeracionModal').addEventListener('click', function(e) {
    if (e.target === this) closeNuevaNumeracionModal();
});
</script>
@endpush
@endsection
