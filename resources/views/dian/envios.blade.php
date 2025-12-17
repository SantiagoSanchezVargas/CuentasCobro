@extends('layouts.app')

@section('title', 'Envíos DIAN')

@section('content')
<div class="page-container">
    <!-- Header -->
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: var(--apple-dark); margin-bottom: 4px;">
                <span class="material-symbols-rounded" style="vertical-align: middle; margin-right: 8px;">send</span>
                Envíos a la DIAN
            </h1>
            <p style="color: var(--apple-text-muted); font-size: 15px;">
                Seguimiento de documentos enviados a la DIAN
            </p>
        </div>
        <div style="display: flex; gap: 12px;">
            <button onclick="window.location.reload()" class="btn-apple btn-apple-secondary">
                <span class="material-symbols-rounded">refresh</span>
                Actualizar
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 20px; border-radius: 16px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span class="material-symbols-rounded" style="font-size: 32px; opacity: 0.9;">check_circle</span>
                <div>
                    <p style="font-size: 28px; font-weight: 700; margin: 0;">{{ $stats['aprobados'] ?? 0 }}</p>
                    <p style="font-size: 13px; opacity: 0.9; margin: 0;">Aprobados DIAN</p>
                </div>
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; padding: 20px; border-radius: 16px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span class="material-symbols-rounded" style="font-size: 32px; opacity: 0.9;">pending</span>
                <div>
                    <p style="font-size: 28px; font-weight: 700; margin: 0;">{{ $stats['pendientes'] ?? 0 }}</p>
                    <p style="font-size: 13px; opacity: 0.9; margin: 0;">Pendientes</p>
                </div>
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 20px; border-radius: 16px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span class="material-symbols-rounded" style="font-size: 32px; opacity: 0.9;">error</span>
                <div>
                    <p style="font-size: 28px; font-weight: 700; margin: 0;">{{ $stats['rechazados'] ?? 0 }}</p>
                    <p style="font-size: 13px; opacity: 0.9; margin: 0;">Rechazados</p>
                </div>
            </div>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; padding: 20px; border-radius: 16px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <span class="material-symbols-rounded" style="font-size: 32px; opacity: 0.9;">sync</span>
                <div>
                    <p style="font-size: 28px; font-weight: 700; margin: 0;">{{ $stats['en_proceso'] ?? 0 }}</p>
                    <p style="font-size: 13px; opacity: 0.9; margin: 0;">En Proceso</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div style="background: white; border-radius: 16px; padding: 20px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form method="GET" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--apple-text-muted); margin-bottom: 6px;">Estado DIAN</label>
                <select name="estado_dian" class="form-select" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <option value="">Todos</option>
                    <option value="sin_envio" {{ request('estado_dian') == 'sin_envio' ? 'selected' : '' }}>Sin Enviar</option>
                    <option value="enviado" {{ request('estado_dian') == 'enviado' ? 'selected' : '' }}>Enviado</option>
                    <option value="aprobado" {{ request('estado_dian') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                    <option value="rechazado" {{ request('estado_dian') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--apple-text-muted); margin-bottom: 6px;">Fecha Desde</label>
                <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="form-input" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--apple-text-muted); margin-bottom: 6px;">Fecha Hasta</label>
                <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="form-input" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
            </div>
            <div>
                <button type="submit" class="btn-apple">
                    <span class="material-symbols-rounded">search</span>
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc;">
                    <th style="padding: 14px 16px; text-align: left; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Cuenta</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">CUFE</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Beneficiario</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Valor</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Estado DIAN</th>
                    <th style="padding: 14px 16px; text-align: left; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Fecha Envío</th>
                    <th style="padding: 14px 16px; text-align: center; font-size: 13px; font-weight: 600; color: var(--apple-text-muted);">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cuentas ?? [] as $cuenta)
                <tr style="border-top: 1px solid #f1f5f9;">
                    <td style="padding: 14px 16px;">
                        <a href="{{ route('cuentas_cobro.show', $cuenta->id) }}" style="font-weight: 600; color: var(--apple-blue); text-decoration: none;">
                            {{ $cuenta->numero }}
                        </a>
                    </td>
                    <td style="padding: 14px 16px; font-family: monospace; font-size: 12px; color: #64748b;">
                        {{ $cuenta->cufe ?? '—' }}
                    </td>
                    <td style="padding: 14px 16px;">{{ $cuenta->nombre_beneficiario }}</td>
                    <td style="padding: 14px 16px; font-weight: 600;">${{ number_format($cuenta->valor_total, 0, ',', '.') }}</td>
                    <td style="padding: 14px 16px; text-align: center;">
                        @php
                            $estadoColors = [
                                'sin_envio' => 'background: #f1f5f9; color: #64748b;',
                                'enviado' => 'background: #fef3c7; color: #d97706;',
                                'aprobado' => 'background: #d1fae5; color: #059669;',
                                'rechazado' => 'background: #fee2e2; color: #dc2626;',
                            ];
                            $estadoLabels = [
                                'sin_envio' => 'Sin Enviar',
                                'enviado' => 'Enviado',
                                'aprobado' => 'Aprobado',
                                'rechazado' => 'Rechazado',
                            ];
                        @endphp
                        <span style="padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; {{ $estadoColors[$cuenta->estado_dian] ?? $estadoColors['sin_envio'] }}">
                            {{ $estadoLabels[$cuenta->estado_dian] ?? 'Sin Enviar' }}
                        </span>
                    </td>
                    <td style="padding: 14px 16px; font-size: 13px; color: #64748b;">
                        {{ $cuenta->fecha_envio_dian ? $cuenta->fecha_envio_dian->format('d/m/Y H:i') : '—' }}
                    </td>
                    <td style="padding: 14px 16px; text-align: center;">
                        <div style="display: flex; gap: 8px; justify-content: center;">
                            <a href="{{ route('cuentas_cobro.show', $cuenta->id) }}" class="btn-icon" title="Ver detalle" style="padding: 6px; border-radius: 8px; background: #f1f5f9;">
                                <span class="material-symbols-rounded" style="font-size: 18px;">visibility</span>
                            </a>
                            @if($cuenta->estado_dian == 'sin_envio')
                            <button onclick="enviarDian({{ $cuenta->id }})" class="btn-icon" title="Enviar a DIAN" style="padding: 6px; border-radius: 8px; background: #dbeafe; color: #2563eb; border: none; cursor: pointer;">
                                <span class="material-symbols-rounded" style="font-size: 18px;">send</span>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 48px; text-align: center; color: var(--apple-text-muted);">
                        <span class="material-symbols-rounded" style="font-size: 48px; opacity: 0.5; display: block; margin-bottom: 12px;">inbox</span>
                        No hay documentos para mostrar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($cuentas) && $cuentas->hasPages())
    <div style="margin-top: 24px;">
        {{ $cuentas->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
function enviarDian(cuentaId) {
    if (confirm('¿Desea enviar esta cuenta de cobro a la DIAN?')) {
        // TODO: Implementar envío real
        alert('Funcionalidad de envío DIAN en desarrollo');
    }
}
</script>
@endpush
@endsection
