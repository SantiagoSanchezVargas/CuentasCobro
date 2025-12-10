@extends('layouts.app')

@section('title', 'Reportes y Análisis')

@section('content')
<style>
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-300: #cbd5e1;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-600: #475569;
        --slate-700: #334155;
        --slate-800: #1e293b;
        --slate-900: #0f172a;
        --primary-blue: #116dff;
        --primary-hover: #0056d6;
        --success-green: #10b981;
        --warning-orange: #f59e0b;
        --danger-red: #ef4444;
        --purple-gradient: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
        --blue-gradient: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        --green-gradient: linear-gradient(135deg, #10b981 0%, #059669 100%);
        --orange-gradient: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .page-header {
        background: var(--purple-gradient);
        border-radius: 24px;
        padding: 40px 32px;
        color: white;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 40px rgba(99, 102, 241, 0.2);
    }

    .header-content h1 {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .header-content p {
        font-size: 16px;
        opacity: 0.95;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 12px;
    }

    .btn-header {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        backdrop-filter: blur(8px);
        transition: all 0.2s;
    }

    .btn-header:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: white;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid var(--slate-200);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-blue);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
    }

    .stat-label {
        font-size: 14px;
        font-weight: 600;
        color: var(--slate-500);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: var(--slate-900);
        margin-bottom: 4px;
    }

    .stat-trend {
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .trend-up { color: var(--success-green); }
    .trend-neutral { color: var(--slate-500); }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 32px;
    }

    .card {
        background: white;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid var(--slate-200);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--slate-100);
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--slate-800);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title .material-symbols-rounded {
        color: var(--primary-blue);
    }

    /* Progress Bars for States */
    .state-item {
        margin-bottom: 20px;
    }

    .state-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: var(--slate-700);
    }

    .progress-bg {
        height: 8px;
        background: var(--slate-100);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 1s ease;
    }

    /* Department Table */
    .dept-table {
        width: 100%;
        border-collapse: collapse;
    }

    .dept-table th {
        text-align: left;
        padding: 12px;
        font-size: 12px;
        font-weight: 600;
        color: var(--slate-500);
        text-transform: uppercase;
        border-bottom: 2px solid var(--slate-100);
    }

    .dept-table td {
        padding: 16px 12px;
        border-bottom: 1px solid var(--slate-50);
        color: var(--slate-700);
        font-size: 14px;
    }

    .dept-table tr:last-child td {
        border-bottom: none;
    }

    .dept-name {
        font-weight: 600;
        color: var(--slate-800);
    }

    .btn-sm {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        background: var(--slate-50);
        color: var(--primary-blue);
        transition: all 0.2s;
    }

    .btn-sm:hover {
        background: var(--primary-blue);
        color: white;
    }

    /* Aging Grid */
    .aging-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .aging-card {
        background: var(--slate-50);
        border-radius: 12px;
        padding: 16px;
        text-align: center;
        border: 1px solid var(--slate-200);
    }

    .aging-value {
        font-size: 24px;
        font-weight: 700;
        color: var(--slate-800);
        display: block;
        margin-bottom: 4px;
    }

    .aging-label {
        font-size: 12px;
        color: var(--slate-500);
        font-weight: 600;
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
        .aging-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="container">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <h1>Reportes y Análisis</h1>
            <p>Visión general del estado financiero y operativo</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('reportes.exportar', 'general') }}" class="btn-header">
                <span class="material-symbols-rounded">download</span>
                Exportar General
            </a>
            <a href="{{ route('cuentas_cobro.exportar_pagos', ['format' => 'csv']) }}" class="btn-header" style="background: white; color: var(--primary-blue);">
                <span class="material-symbols-rounded">description</span>
                Pagos CSV
            </a>
            <a href="{{ route('cuentas_cobro.exportar_pagos', ['format' => 'excel']) }}" class="btn-header" style="background: white; color: var(--primary-blue);">
                <span class="material-symbols-rounded">table_view</span>
                Pagos Excel
            </a>
        </div>
    </div>

    <!-- Key Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #eff6ff; color: #3b82f6;">
                <span class="material-symbols-rounded">receipt_long</span>
            </div>
            <div class="stat-label">Total Cuentas</div>
            <div class="stat-value">{{ number_format($totalCuentas) }}</div>
            <div class="stat-trend trend-neutral">Registradas en el sistema</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #f0fdf4; color: #10b981;">
                <span class="material-symbols-rounded">attach_money</span>
            </div>
            <div class="stat-label">Valor Total</div>
            <div class="stat-value">${{ number_format($totalValor, 0) }}</div>
            <div class="stat-trend trend-neutral">Monto acumulado histórico</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #fff7ed; color: #f59e0b;">
                <span class="material-symbols-rounded">pending_actions</span>
            </div>
            <div class="stat-label">Pendiente Pago</div>
            <div class="stat-value">${{ number_format($totalPendiente, 0) }}</div>
            <div class="stat-trend trend-neutral">Por cobrar/procesar</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #f5f3ff; color: #8b5cf6;">
                <span class="material-symbols-rounded">calendar_today</span>
            </div>
            <div class="stat-label">Pagado Este Mes</div>
            <div class="stat-value">${{ number_format($pagadasEsteMes, 0) }}</div>
            <div class="stat-trend trend-up">
                <span class="material-symbols-rounded" style="font-size: 16px;">trending_up</span>
                Gestión reciente
            </div>
        </div>
    </div>

    <div class="content-grid">
        <!-- Left Column: Departments & Recent -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Departments Table -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="material-symbols-rounded">map</span>
                        Distribución por Departamento
                    </div>
                </div>
                
                @if($porDepartamento->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="dept-table">
                            <thead>
                                <tr>
                                    <th>Departamento</th>
                                    <th>Cantidad</th>
                                    <th>Valor Total</th>
                                    <th style="text-align: right;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($porDepartamento as $dept)
                                    <tr>
                                        <td class="dept-name">{{ $dept->departamento }}</td>
                                        <td>
                                            <span style="background: var(--slate-100); padding: 4px 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                {{ $dept->total }}
                                            </span>
                                        </td>
                                        <td style="font-family: monospace; font-size: 14px;">${{ number_format($dept->valor, 0) }}</td>
                                        <td style="text-align: right;">
                                            <a href="{{ route('reportes.departamento', $dept->departamento) }}" class="btn-sm">Ver Detalles</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 40px; color: var(--slate-400);">
                        No hay datos disponibles por departamento
                    </div>
                @endif
            </div>

            <!-- Aging Analysis -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <span class="material-symbols-rounded">history</span>
                        Antigüedad de Cuentas (Enviadas al Cliente)
                    </div>
                </div>
                <div class="aging-grid">
                    <div class="aging-card">
                        <span class="aging-value" style="color: #10b981;">{{ $aging['0_30'] ?? 0 }}</span>
                        <span class="aging-label">0-30 Días</span>
                    </div>
                    <div class="aging-card">
                        <span class="aging-value" style="color: #f59e0b;">{{ $aging['31_60'] ?? 0 }}</span>
                        <span class="aging-label">31-60 Días</span>
                    </div>
                    <div class="aging-card">
                        <span class="aging-value" style="color: #f97316;">{{ $aging['61_90'] ?? 0 }}</span>
                        <span class="aging-label">61-90 Días</span>
                    </div>
                    <div class="aging-card">
                        <span class="aging-value" style="color: #ef4444;">{{ $aging['90_plus'] ?? 0 }}</span>
                        <span class="aging-label">90+ Días</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Status Distribution -->
        <div>
            <div class="card" style="height: 100%;">
                <div class="card-header">
                    <div class="card-title">
                        <span class="material-symbols-rounded">pie_chart</span>
                        Estado de Cuentas
                    </div>
                </div>

                @if($porEstado->count() > 0)
                    @php
                        $maxVal = $porEstado->max('total');
                    @endphp
                    
                    @foreach($porEstado as $estado)
                        @php
                            $percent = ($estado->total / $totalCuentas) * 100;
                            $color = match($estado->estado_aprobacion) {
                                'pagado' => '#10b981',
                                'aprobado' => '#3b82f6',
                                'rechazado' => '#ef4444',
                                'en_revision' => '#f59e0b',
                                default => '#64748b'
                            };
                            $label = ucfirst(str_replace('_', ' ', $estado->estado_aprobacion));
                        @endphp
                        <div class="state-item">
                            <div class="state-header">
                                <span>{{ $label }}</span>
                                <span>{{ $estado->total }} ({{ round($percent) }}%)</span>
                            </div>
                            <div class="progress-bg">
                                <div class="progress-fill" style="width: {{ $percent }}%; background: {{ $color }};"></div>
                            </div>
                            <div style="font-size: 12px; color: var(--slate-500); margin-top: 4px; text-align: right;">
                                ${{ number_format($estado->valor, 0) }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 40px; color: var(--slate-400);">
                        No hay datos de estados
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
