@extends('layouts.app')

@section('title', 'Configuración de Consecutivos')

@section('content')
<style>
    .consecutivos-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 24px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header h1 .icon {
        color: #00b5e2;
    }

    .header-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-primary {
        background: linear-gradient(135deg, #00b5e2 0%, #0097be 100%);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0097be 0%, #007a9a 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 181, 226, 0.3);
        color: white;
    }

    .btn-secondary {
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

    .btn-secondary:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-card .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stat-card .icon-box.blue { background: #e0f4ff; color: #00b5e2; }
    .stat-card .icon-box.green { background: #dcfce7; color: #22c55e; }
    .stat-card .icon-box.orange { background: #fef3c7; color: #f59e0b; }
    .stat-card .icon-box.red { background: #fee2e2; color: #ef4444; }

    .stat-card .info h4 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .stat-card .info p {
        font-size: 12px;
        color: #6b7280;
        margin: 0;
    }

    .table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .table-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 100%);
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-header h3 {
        color: white;
        font-size: 16px;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .consecutivos-table {
        width: 100%;
        border-collapse: collapse;
    }

    .consecutivos-table thead {
        background: #f8fafc;
    }

    .consecutivos-table th {
        padding: 14px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
    }

    .consecutivos-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }

    .consecutivos-table tbody tr:hover {
        background: #f8fafc;
    }

    .consecutivos-table td {
        padding: 16px;
        font-size: 14px;
        color: #334155;
        vertical-align: middle;
    }

    .tipo-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        background: #e0f4ff;
        color: #0369a1;
    }

    .tipo-badge.cuenta { background: #e0f4ff; color: #0369a1; }
    .tipo-badge.documento { background: #f3e8ff; color: #7c3aed; }
    .tipo-badge.factura { background: #dcfce7; color: #166534; }

    .prefijo-tag {
        font-family: 'Consolas', 'Monaco', monospace;
        background: #f1f5f9;
        padding: 4px 10px;
        border-radius: 4px;
        font-weight: 600;
        color: #475569;
    }

    .rango-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .rango-info .range {
        font-family: monospace;
        font-weight: 600;
        color: #1e3a5f;
    }

    .rango-info .current {
        font-size: 11px;
        color: #6b7280;
    }

    .current-number {
        font-family: monospace;
        font-size: 16px;
        font-weight: 700;
        color: #00b5e2;
    }

    .vigencia-info {
        font-size: 12px;
        color: #64748b;
    }

    .vigencia-info .dates {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 12px;
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

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        color: #64748b;
        transition: all 0.15s;
    }

    .action-btn:hover {
        background: #e2e8f0;
        color: #1e3a5f;
    }

    .action-btn.edit:hover { color: #00b5e2; }

    .empty-state {
        text-align: center;
        padding: 60px 24px;
        color: #6b7280;
    }

    .empty-state .icon {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 16px;
    }

    .empty-state h3 {
        font-size: 18px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .progress-bar {
        height: 6px;
        background: #e2e8f0;
        border-radius: 3px;
        overflow: hidden;
        margin-top: 6px;
    }

    .progress-bar .fill {
        height: 100%;
        border-radius: 3px;
        transition: width 0.3s;
    }

    .progress-bar .fill.low { background: #22c55e; }
    .progress-bar .fill.medium { background: #f59e0b; }
    .progress-bar .fill.high { background: #ef4444; }

    @media (max-width: 768px) {
        .consecutivos-container { padding: 16px; }
        .page-header { flex-direction: column; align-items: flex-start; }
        .header-actions { width: 100%; }
        .header-actions a { flex: 1; justify-content: center; }
    }
</style>

<div class="consecutivos-container">
    <!-- Header -->
    <div class="page-header">
        <h1>
            <span class="material-symbols-rounded icon">123</span>
            Consecutivos de Facturación
        </h1>
        <div class="header-actions">
            <a href="{{ route('admin.consecutivos.builder') }}" class="btn-secondary">
                <span class="material-symbols-rounded" style="font-size: 18px;">tune</span>
                Planificador Rangos
            </a>
            <a href="{{ route('admin.consecutivos.create') }}" class="btn-primary">
                <span class="material-symbols-rounded" style="font-size: 18px;">add</span>
                Nuevo Consecutivo
            </a>
        </div>
    </div>

    <!-- Stats -->
    @php
        $totalConsecutivos = $consecutivos->count();
        $activos = $consecutivos->where('activo', true)->count();
        $inactivos = $totalConsecutivos - $activos;
        $vencidosProximos = $consecutivos->filter(function($c) {
            return $c->vigencia_fin <= now()->addDays(30) && $c->activo;
        })->count();
    @endphp

    <div class="stats-row">
        <div class="stat-card">
            <div class="icon-box blue">
                <span class="material-symbols-rounded">123</span>
            </div>
            <div class="info">
                <h4>{{ $totalConsecutivos }}</h4>
                <p>Total Consecutivos</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-box green">
                <span class="material-symbols-rounded">check_circle</span>
            </div>
            <div class="info">
                <h4>{{ $activos }}</h4>
                <p>Activos</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-box red">
                <span class="material-symbols-rounded">cancel</span>
            </div>
            <div class="info">
                <h4>{{ $inactivos }}</h4>
                <p>Inactivos</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-box orange">
                <span class="material-symbols-rounded">schedule</span>
            </div>
            <div class="info">
                <h4>{{ $vencidosProximos }}</h4>
                <p>Próximos a Vencer</p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="table-container">
        <div class="table-header">
            <h3>
                <span class="material-symbols-rounded">format_list_numbered</span>
                Listado de Consecutivos
            </h3>
        </div>

        @if($consecutivos->count() > 0)
        <table class="consecutivos-table">
            <thead>
                <tr>
                    <th>Tipo de Documento</th>
                    <th>Prefijo</th>
                    <th>Rango</th>
                    <th>Actual</th>
                    <th>Uso</th>
                    <th>Vigencia</th>
                    <th>Estado</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consecutivos as $consecutivo)
                @php
                    $totalRange = $consecutivo->numero_final - $consecutivo->numero_inicial;
                    $used = $consecutivo->numero_actual - $consecutivo->numero_inicial;
                    $usagePercent = $totalRange > 0 ? ($used / $totalRange) * 100 : 0;
                    $usageClass = $usagePercent < 60 ? 'low' : ($usagePercent < 85 ? 'medium' : 'high');
                    
                    $tipoClass = 'cuenta';
                    if (str_contains(strtolower($consecutivo->tipo_documento), 'soporte')) $tipoClass = 'documento';
                    if (str_contains(strtolower($consecutivo->tipo_documento), 'factura')) $tipoClass = 'factura';
                @endphp
                <tr>
                    <td>
                        <span class="tipo-badge {{ $tipoClass }}">
                            <span class="material-symbols-rounded" style="font-size: 16px;">
                                @if($tipoClass === 'cuenta')receipt_long
                                @elseif($tipoClass === 'documento')description
                                @else receipt @endif
                            </span>
                            {{ $consecutivo->tipo_documento }}
                        </span>
                    </td>
                    <td>
                        @if($consecutivo->prefijo)
                            <span class="prefijo-tag">{{ $consecutivo->prefijo }}</span>
                        @else
                            <span style="color: #9ca3af;">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="rango-info">
                            <span class="range">{{ number_format($consecutivo->numero_inicial) }} → {{ number_format($consecutivo->numero_final) }}</span>
                            <span class="current">{{ number_format($totalRange + 1) }} números disponibles</span>
                        </div>
                    </td>
                    <td>
                        <span class="current-number">{{ number_format($consecutivo->numero_actual) }}</span>
                    </td>
                    <td style="min-width: 120px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 12px; font-weight: 600; color: {{ $usageClass === 'high' ? '#ef4444' : ($usageClass === 'medium' ? '#f59e0b' : '#22c55e') }};">
                                {{ number_format($usagePercent, 0) }}%
                            </span>
                        </div>
                        <div class="progress-bar">
                            <div class="fill {{ $usageClass }}" style="width: {{ min($usagePercent, 100) }}%;"></div>
                        </div>
                    </td>
                    <td>
                        <div class="vigencia-info">
                            <div class="dates">
                                <span class="material-symbols-rounded" style="font-size: 14px;">event</span>
                                {{ $consecutivo->vigencia_inicio->format('d/m/Y') }} — {{ $consecutivo->vigencia_fin->format('d/m/Y') }}
                            </div>
                            @if($consecutivo->vigencia_fin < now())
                                <span style="color: #ef4444; font-weight: 600;">Vencido</span>
                            @elseif($consecutivo->vigencia_fin <= now()->addDays(30))
                                <span style="color: #f59e0b; font-weight: 600;">Vence pronto</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="status-badge {{ $consecutivo->activo ? 'active' : 'inactive' }}">
                            <span class="material-symbols-rounded" style="font-size: 14px;">
                                {{ $consecutivo->activo ? 'check_circle' : 'cancel' }}
                            </span>
                            {{ $consecutivo->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.consecutivos.edit', $consecutivo) }}" class="action-btn edit" title="Editar">
                            <span class="material-symbols-rounded">edit</span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <span class="material-symbols-rounded icon">123</span>
            <h3>No hay consecutivos configurados</h3>
            <p>Crea tu primer consecutivo para empezar a generar números de documentos.</p>
            <a href="{{ route('admin.consecutivos.create') }}" class="btn-primary" style="margin-top: 16px;">
                <span class="material-symbols-rounded" style="font-size: 18px;">add</span>
                Crear Consecutivo
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
