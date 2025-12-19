@extends('layouts.app')

@section('title', 'Movimientos General - Cuentas de Cobro')

@section('content')
<style>
    .movimientos-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 16px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title .icon {
        color: #00b5e2;
    }

    /* Stats Cards */
    .stats-row {
        display: flex;
        gap: 16px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .stat-card {
        flex: 1;
        min-width: 150px;
        background: white;
        border-radius: 10px;
        padding: 16px 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-card .icon-box {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stat-card .icon-box.blue { background: #e0f4ff; color: #00b5e2; }
    .stat-card .icon-box.green { background: #dcfce7; color: #22c55e; }
    .stat-card .icon-box.orange { background: #fef3c7; color: #f59e0b; }
    .stat-card .icon-box.purple { background: #ede9fe; color: #8b5cf6; }

    .stat-card .info h4 { font-size: 20px; font-weight: 700; color: #1a1a2e; margin: 0; }
    .stat-card .info p { font-size: 12px; color: #6b7280; margin: 0; }

    /* Filters */
    .filters-bar {
        background: white;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .filter-group label {
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
    }

    .filter-group input, .filter-group select {
        padding: 8px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 13px;
        min-width: 140px;
    }

    .filter-group input:focus, .filter-group select:focus {
        outline: none;
        border-color: #00b5e2;
    }

    .btn-filter {
        background: #00b5e2;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
    }

    .btn-filter:hover { background: #0097be; }

    .btn-export {
        background: #10b981;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        text-decoration: none;
    }

    .btn-export:hover { background: #059669; color: white; }

    /* Excel-like Table */
    .excel-wrapper {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .excel-scroll {
        overflow-x: auto;
    }

    .excel-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        min-width: 1000px;
    }

    .excel-table thead {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 100%);
        color: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .excel-table th {
        padding: 12px 10px;
        text-align: left;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
        border-right: 1px solid rgba(255,255,255,0.1);
    }

    .excel-table th:last-child { border-right: none; }

    .excel-table th.sortable {
        cursor: pointer;
        user-select: none;
    }

    .excel-table th.sortable:hover { background: rgba(255,255,255,0.1); }

    .excel-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.15s;
    }

    .excel-table tbody tr:hover { background: #f0f9ff; }
    .excel-table tbody tr:nth-child(even) { background: #fafafa; }
    .excel-table tbody tr:nth-child(even):hover { background: #f0f9ff; }

    .excel-table td {
        padding: 10px;
        border-right: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .excel-table td:last-child { border-right: none; }

    /* Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .badge.borrador { background: #e5e7eb; color: #374151; }
    .badge.enviado { background: #dbeafe; color: #1d4ed8; }
    .badge.aprobado { background: #d1fae5; color: #059669; }
    .badge.rechazado { background: #fee2e2; color: #dc2626; }
    .badge.pagado { background: #dcfce7; color: #166534; }
    .badge.pendiente { background: #fef3c7; color: #b45309; }

    .link-numero {
        color: #00b5e2;
        text-decoration: none;
        font-weight: 600;
    }

    .link-numero:hover { text-decoration: underline; }

    .text-muted { color: #9ca3af; font-size: 11px; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .font-mono { font-family: monospace; }
    .font-bold { font-weight: 700; }

    /* Pagination */
    .pagination-wrapper {
        padding: 16px;
        border-top: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pagination-info { color: #6b7280; font-size: 13px; }

    /* Empty state */
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
</style>

<div class="movimientos-container">
    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">
            <span class="material-symbols-rounded icon">table_chart</span>
            Movimientos General de Cuentas de Cobro
        </h1>
        <a href="{{ route('cuentas_cobro.movimientos.export', request()->query()) }}" class="btn-export">
            <span class="material-symbols-rounded">download</span>
            Exportar Excel
        </a>
    </div>

    <!-- Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="icon-box blue">
                <span class="material-symbols-rounded">receipt_long</span>
            </div>
            <div class="info">
                <h4>{{ number_format($stats['total_cuentas']) }}</h4>
                <p>Total Cuentas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-box green">
                <span class="material-symbols-rounded">payments</span>
            </div>
            <div class="info">
                <h4>${{ number_format($stats['monto_total'], 0, ',', '.') }}</h4>
                <p>Monto Total</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-box orange">
                <span class="material-symbols-rounded">pending</span>
            </div>
            <div class="info">
                <h4>{{ number_format($stats['pendientes']) }}</h4>
                <p>Pendientes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-box purple">
                <span class="material-symbols-rounded">check_circle</span>
            </div>
            <div class="info">
                <h4>{{ number_format($stats['pagadas']) }}</h4>
                <p>Pagadas</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" class="filters-bar">
        <div class="filter-group">
            <label>Buscar</label>
            <input type="text" name="search" placeholder="N°, Beneficiario..." value="{{ request('search') }}">
        </div>
        <div class="filter-group">
            <label>Estado</label>
            <select name="estado">
                <option value="">Todos</option>
                <option value="borrador" {{ request('estado') === 'borrador' ? 'selected' : '' }}>Borrador</option>
                <option value="enviado" {{ request('estado') === 'enviado' ? 'selected' : '' }}>Enviado</option>
                <option value="aprobado" {{ request('estado') === 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                <option value="rechazado" {{ request('estado') === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                <option value="pagado" {{ request('estado') === 'pagado' ? 'selected' : '' }}>Pagado</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Desde</label>
            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}">
        </div>
        <div class="filter-group">
            <label>Hasta</label>
            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}">
        </div>
        <button type="submit" class="btn-filter">
            <span class="material-symbols-rounded" style="font-size: 18px;">filter_list</span>
            Filtrar
        </button>
        @if(request()->hasAny(['search', 'estado', 'fecha_desde', 'fecha_hasta']))
            <a href="{{ route('cuentas_cobro.movimientos') }}" class="btn-filter" style="background: #6b7280;">
                <span class="material-symbols-rounded" style="font-size: 18px;">clear</span>
                Limpiar
            </a>
        @endif
    </form>

    <!-- Table -->
    <div class="excel-wrapper">
        <div class="excel-scroll">
            @if($cuentas->count() > 0)
            <table class="excel-table" id="movimientosTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th class="sortable">Consecutivo</th>
                        <th class="sortable">Fecha Emisión</th>
                        <th>Emitido Por</th>
                        <th>Beneficiario (A Quien)</th>
                        <th>Comprador (De Quien)</th>
                        <th>Concepto</th>
                        <th class="sortable text-right">Subtotal</th>
                        <th class="sortable text-right">IVA</th>
                        <th class="sortable text-right">Total</th>
                        <th class="text-center">Estado</th>
                        <th>Fecha Vencimiento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cuentas as $index => $cuenta)
                    <tr>
                        <td class="text-center text-muted">
                            {{ ($cuentas->currentPage() - 1) * $cuentas->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <a href="{{ route('cuentas_cobro.show', $cuenta->id) }}" class="link-numero">
                                {{ $cuenta->numero ?? 'Sin número' }}
                            </a>
                        </td>
                        <td>
                            {{ $cuenta->fecha_emision ? \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') : '-' }}
                            <br><span class="text-muted">{{ $cuenta->fecha_emision ? \Carbon\Carbon::parse($cuenta->fecha_emision)->format('H:i') : '' }}</span>
                        </td>
                        <td>
                            <strong>{{ $cuenta->user->name ?? 'N/A' }}</strong>
                            <br><span class="text-muted">{{ $cuenta->user->role->name ?? '' }}</span>
                        </td>
                        <td>
                            <strong>{{ $cuenta->nombre_beneficiario ?? '-' }}</strong>
                            <br><span class="text-muted font-mono">{{ $cuenta->tipo_identificacion_beneficiario ?? '' }} {{ $cuenta->identificacion_beneficiario ?? '' }}</span>
                        </td>
                        <td>
                            {{ $cuenta->nombre_comprador ?? '-' }}
                            <br><span class="text-muted font-mono">{{ $cuenta->identificacion_comprador ?? '' }}</span>
                        </td>
                        <td style="max-width: 200px;">
                            <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $cuenta->concepto_cobro }}">
                                {{ \Illuminate\Support\Str::limit($cuenta->concepto_cobro, 40) }}
                            </div>
                        </td>
                        <td class="text-right font-mono">
                            ${{ number_format($cuenta->subtotal ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="text-right font-mono">
                            ${{ number_format($cuenta->valor_iva ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="text-right font-mono font-bold">
                            ${{ number_format($cuenta->monto_total ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $cuenta->estado ?? 'borrador' }}">
                                {{ ucfirst($cuenta->estado ?? 'Borrador') }}
                            </span>
                        </td>
                        <td>
                            @if($cuenta->fecha_vencimiento)
                                @php
                                    $vencimiento = \Carbon\Carbon::parse($cuenta->fecha_vencimiento);
                                    $hoy = \Carbon\Carbon::today();
                                    $diasRestantes = $hoy->diffInDays($vencimiento, false);
                                @endphp
                                <span style="color: {{ $diasRestantes < 0 ? '#dc2626' : ($diasRestantes <= 7 ? '#f59e0b' : '#059669') }};">
                                    {{ $vencimiento->format('d/m/Y') }}
                                </span>
                                @if($diasRestantes < 0)
                                    <br><span class="text-muted" style="color: #dc2626;">Vencida</span>
                                @elseif($diasRestantes <= 7)
                                    <br><span class="text-muted" style="color: #f59e0b;">{{ $diasRestantes }} días</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <span class="material-symbols-rounded icon">search_off</span>
                <h3>No se encontraron cuentas de cobro</h3>
                <p>Ajusta los filtros o crea una nueva cuenta.</p>
            </div>
            @endif
        </div>

        @if($cuentas->count() > 0)
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Mostrando {{ $cuentas->firstItem() }} - {{ $cuentas->lastItem() }} de {{ $cuentas->total() }} registros
            </div>
            {{ $cuentas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
