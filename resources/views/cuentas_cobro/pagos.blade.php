@extends('layouts.app')

@section('title', 'Gestión de Pagos - Dewey Accounts')

@section('content')
<style>
    /* Professional Enterprise Design System */
    :root {
        --primary: #116dff;
        --primary-dark: #0056d6;
        --secondary: #0f172a; /* Slate 900 */
        --text-main: #334155; /* Slate 700 */
        --text-light: #64748b; /* Slate 500 */
        --bg-body: #f8fafc; /* Slate 50 */
        --bg-card: #ffffff;
        --border-color: #e2e8f0; /* Slate 200 */
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --radius-md: 12px;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px;
        font-family: 'Inter', sans-serif;
    }

    /* Header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .page-title h1 {
        font-size: 32px;
        font-weight: 800;
        color: var(--secondary);
        margin-bottom: 8px;
        letter-spacing: -0.025em;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: var(--bg-card);
        border-radius: var(--radius-md);
        padding: 24px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    .stat-icon span { font-size: 24px; }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: var(--secondary);
        margin-bottom: 4px;
        line-height: 1;
    }

    .stat-label {
        font-size: 13px;
        color: var(--text-light);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Filters */
    .filters-bar {
        background: var(--bg-card);
        padding: 24px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        margin-bottom: 24px;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        align-items: flex-end;
        box-shadow: var(--shadow-sm);
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        color: var(--text-main);
        transition: all 0.2s;
        background-color: #fff;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(17, 109, 255, 0.1);
    }

    /* Table */
    .table-card {
        background: var(--bg-card);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background: #f8fafc;
        padding: 16px 24px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-light);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--border-color);
    }

    .data-table td {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-main);
        font-size: 14px;
        vertical-align: middle;
    }

    .data-table tr:last-child td { border-bottom: none; }
    .data-table tr:hover td { background: #f8fafc; }

    /* Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }
    
    .btn-primary {
        background: var(--primary);
        color: white;
        box-shadow: 0 2px 4px rgba(17, 109, 255, 0.2);
    }
    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }
    
    .btn-secondary {
        background: white;
        border: 1px solid var(--border-color);
        color: var(--text-main);
    }
    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    .btn-success { background: var(--success); color: white; }
    .btn-danger { background: var(--danger); color: white; }

    .action-icon-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        background: transparent;
        color: var(--text-light);
    }
    .action-icon-btn:hover { background: #f1f5f9; color: var(--primary); }

    .action-icon-btn.approve { color: var(--success); }
    .action-icon-btn.approve:hover { background: #dcfce7; }

    .action-icon-btn.reject { color: var(--danger); }
    .action-icon-btn.reject:hover { background: #fee2e2; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-icon {
        font-size: 64px;
        color: #e2e8f0;
        margin-bottom: 16px;
    }
    
    @media (max-width: 768px) {
        .main-container { padding: 20px; }
        .page-header { flex-direction: column; align-items: flex-start; gap: 16px; }
        .data-table { display: block; overflow-x: auto; }
    }
</style>

<div class="main-container">
    <div class="page-header">
        <div class="page-title">
            <h1>Gestión de Pagos</h1>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('cuentas_cobro.index') }}" class="btn btn-secondary">
                <span class="material-symbols-rounded">receipt_long</span> Ver Cuentas
            </a>
            <a href="{{ route('cuentas_cobro.exportar_pagos') }}" class="btn btn-primary">
                <span class="material-symbols-rounded">download</span> Exportar
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #e0f2fe; color: #0284c7;">
                <span class="material-symbols-rounded">payments</span>
            </div>
            <div class="stat-value">${{ number_format($totalPagos ?? 0, 0, ',', '.') }}</div>
            <div class="stat-label">Total en Pagos</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fff7ed; color: #ea580c;">
                <span class="material-symbols-rounded">schedule</span>
            </div>
            <div class="stat-value">{{ $pagosPendientes ?? 0 }}</div>
            <div class="stat-label">Pagos Pendientes</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #f0fdf4; color: #16a34a;">
                <span class="material-symbols-rounded">check_circle</span>
            </div>
            <div class="stat-value">{{ $pagosAprobados ?? 0 }}</div>
            <div class="stat-label">Pagos Aprobados</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef2f2; color: #dc2626;">
                <span class="material-symbols-rounded">cancel</span>
            </div>
            <div class="stat-value">{{ $pagosRechazados ?? 0 }}</div>
            <div class="stat-label">Pagos Rechazados</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-bar">
        <div class="filter-group">
            <label>Estado</label>
            <select id="statusFilter" class="form-control" onchange="filterTable()">
                <option value="">Todos los estados</option>
                <option value="pending">Pendiente</option>
                <option value="sent_to_client">Enviado al Cliente</option>
                <option value="approved">Aprobado</option>
                <option value="rejected">Rechazado</option>
                <option value="processing">En Proceso</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Fecha Desde</label>
            <input type="date" id="dateFrom" class="form-control" onchange="filterTable()">
        </div>
        <div class="filter-group">
            <label>Fecha Hasta</label>
            <input type="date" id="dateTo" class="form-control" onchange="filterTable()">
        </div>
        <div class="filter-group" style="flex: 2;">
            <label>Buscar</label>
            <input type="text" id="searchInput" class="form-control" placeholder="Número de cuenta, contratista..." onkeyup="filterTable()">
        </div>
    </div>

    <!-- Table -->
    <div class="table-card">
        @if(isset($cuentas) && $cuentas->count() > 0)
            <table class="data-table" id="paymentsTable">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Contratista</th>
                        <th>Fecha Emisión</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Fecha Pago</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cuentas as $cuenta)
                        @php
                            $estadoPago = $cuenta->estado_pago ?? 'pending';
                            $estadoAprobacion = $cuenta->estado_aprobacion;
                            
                            // Determine display status
                            $displayStatus = $estadoPago;
                            if ($estadoPago === 'pending' && $estadoAprobacion === 'enviado_cliente') {
                                $displayStatus = 'sent_to_client';
                            }

                            $colors = [
                                'pending' => ['bg' => '#fff7ed', 'text' => '#c2410c'],
                                'approved' => ['bg' => '#f0fdf4', 'text' => '#15803d'],
                                'rejected' => ['bg' => '#fef2f2', 'text' => '#b91c1c'],
                                'processing' => ['bg' => '#eff6ff', 'text' => '#1d4ed8'],
                                'sent_to_client' => ['bg' => '#e0e7ff', 'text' => '#4338ca']
                            ];
                            $style = $colors[$displayStatus] ?? ['bg' => '#f1f5f9', 'text' => '#64748b'];
                            $textos = [
                                'pending' => 'Pendiente',
                                'approved' => 'Aprobado',
                                'rejected' => 'Rechazado',
                                'processing' => 'En Proceso',
                                'sent_to_client' => 'Enviado al Cliente'
                            ];
                        @endphp
                        <tr data-status="{{ $displayStatus }}">
                            <td><strong style="color: var(--secondary);">{{ $cuenta->numero }}</strong></td>
                            <td>{{ $cuenta->user->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }}</td>
                            <td style="font-weight: 600; color: var(--secondary);">${{ number_format($cuenta->valor_total, 0, ',', '.') }}</td>
                            <td>
                                <span class="status-badge" style="background: {{ $style['bg'] }}; color: {{ $style['text'] }};">
                                    {{ $textos[$displayStatus] ?? 'Desconocido' }}
                                </span>
                            </td>
                            <td>{{ $cuenta->fecha_pago ? \Carbon\Carbon::parse($cuenta->fecha_pago)->format('d/m/Y') : '-' }}</td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 4px;">
                                    <a href="{{ route('cuentas_cobro.show', $cuenta) }}" class="action-icon-btn" title="Ver detalles">
                                        <span class="material-symbols-rounded">visibility</span>
                                    </a>
                                    @if(($cuenta->estado_pago ?? 'pending') === 'pending' && ($cuenta->estado_aprobacion === 'aprobado') && ($cuenta->etapa_aprobacion === 'tesoreria'))
                                        <button onclick="openPagoModal({{ $cuenta->id }}, {{ (float)($cuenta->valor_total ?? 0) }})" class="action-icon-btn approve" title="Registrar pago">
                                            <span class="material-symbols-rounded">paid</span>
                                        </button>
                                        <button onclick="openRejectPago({{ $cuenta->id }})" class="action-icon-btn reject" title="Rechazar pago">
                                            <span class="material-symbols-rounded">close</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <span class="material-symbols-rounded empty-icon">payments</span>
                <h3 style="color: var(--secondary); margin-bottom: 8px;">No hay pagos registrados</h3>
                <p style="color: var(--text-light);">Las cuentas de cobro aparecerán aquí cuando sean creadas.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal Registrar Pago -->
<div id="pagoModal" style="display:none; position: fixed; inset:0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: white; border-radius: 16px; padding: 32px; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
        <h3 style="margin-top:0; margin-bottom: 20px; color: var(--secondary); font-weight: 700;">Registrar Pago</h3>
        <form id="pagoForm" method="POST">
            @csrf
            <div style="display: grid; gap: 16px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; color: var(--text-main); font-size: 13px;">Valor pagado</label>
                    <input type="number" name="valor_pagado" id="valor_pagado" step="0.01" required class="form-control" />
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; color: var(--text-main); font-size: 13px;">Medio de pago</label>
                    <select name="medio_pago" required class="form-control">
                        <option value="Transferencia">Transferencia</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Consignación">Consignación</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; color: var(--text-main); font-size: 13px;">Referencia</label>
                    <input type="text" name="referencia_pago" placeholder="# de transacción" class="form-control" />
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; color: var(--text-main); font-size: 13px;">Observaciones</label>
                    <textarea name="observacion_pago" rows="3" placeholder="Comentario opcional" class="form-control" style="font-family: inherit;"></textarea>
                </div>
            </div>
            <div style="display:flex; gap:12px; justify-content:flex-end; margin-top: 24px;">
                <button type="button" class="btn btn-secondary" onclick="closePagoModal()">Cancelar</button>
                <button type="submit" class="btn btn-success">Confirmar Pago</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Rechazar Pago -->
<div id="rejectPagoModal" style="display:none; position: fixed; inset:0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: white; border-radius: 16px; padding: 32px; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
        <h3 style="margin-top:0; margin-bottom: 20px; color: var(--secondary); font-weight: 700;">Rechazar Pago</h3>
        <form id="rejectPagoForm" method="POST">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 6px; color: var(--text-main); font-size: 13px;">Motivo</label>
                <textarea name="motivo" rows="3" required class="form-control" style="font-family: inherit;"></textarea>
            </div>
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeRejectPago()">Cancelar</button>
                <button type="submit" class="btn btn-danger">Rechazar Pago</button>
            </div>
        </form>
    </div>
</div>

<script>
function filterTable() {
    const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
    const searchInput = document.getElementById('searchInput').value.toUpperCase();
    const table = document.getElementById('paymentsTable');
    
    if (!table) return;
    
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const status = row.getAttribute('data-status');
        const cells = row.getElementsByTagName('td');
        let showRow = true;

        if (statusFilter && status !== statusFilter) {
            showRow = false;
        }

        if (searchInput && showRow) {
            let found = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j].textContent.toUpperCase().indexOf(searchInput) > -1) {
                    found = true;
                    break;
                }
            }
            if (!found) showRow = false;
        }

        row.style.display = showRow ? '' : 'none';
    }
}

function openPagoModal(id, valor){
  const form = document.getElementById('pagoForm');
  form.action = `{{ url('/cuentas_cobro') }}/${id}/pagar`;
  document.getElementById('valor_pagado').value = valor.toFixed(2);
  document.getElementById('pagoModal').style.display = 'flex';
}
function closePagoModal(){
  document.getElementById('pagoModal').style.display = 'none';
}
document.getElementById('pagoModal').addEventListener('click', function(e){
    if(e.target === this) closePagoModal();
});

function openRejectPago(id){
    const form = document.getElementById('rejectPagoForm');
    form.action = `{{ url('/cuentas_cobro') }}/${id}/rechazar-pago`;
    document.getElementById('rejectPagoModal').style.display = 'flex';
}
function closeRejectPago(){
    document.getElementById('rejectPagoModal').style.display = 'none';
}
document.getElementById('rejectPagoModal').addEventListener('click', function(e){
    if(e.target === this) closeRejectPago();
});

</script>
@endsection
