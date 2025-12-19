@extends('layouts.app')

@section('title', 'Gestión de Pagos - Dewey Accounts')

@section('content')
<link rel="stylesheet" href="{{ asset('css/views/pagos.css') }}">

<div class="pagos-container">
    <!-- Header con Gradiente -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-icon">
                <span class="material-symbols-rounded">payments</span>
            </div>
            <div class="header-text">
                <h1>Gestión de Pagos</h1>
                <p>Administra y registra los pagos de cuentas de cobro aprobadas</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('cuentas_cobro.index') }}" class="btn-header">
                <span class="material-symbols-rounded">receipt_long</span>
                Ver Cuentas
            </a>
            <a href="{{ route('cuentas_cobro.exportar_pagos', ['format' => 'excel']) }}" class="btn-header primary">
                <span class="material-symbols-rounded">download</span>
                Exportar Excel
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="icon-box blue">
                <span class="material-symbols-rounded">account_balance_wallet</span>
            </div>
            <div class="info">
                <h4>${{ number_format($totalPagos ?? 0, 0, ',', '.') }}</h4>
                <p>Total en Pagos</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-box orange">
                <span class="material-symbols-rounded">schedule</span>
            </div>
            <div class="info">
                <h4>{{ $pagosPendientes ?? 0 }}</h4>
                <p>Pendientes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-box green">
                <span class="material-symbols-rounded">check_circle</span>
            </div>
            <div class="info">
                <h4>{{ $pagosAprobados ?? 0 }}</h4>
                <p>Pagadas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon-box red">
                <span class="material-symbols-rounded">cancel</span>
            </div>
            <div class="info">
                <h4>{{ $pagosRechazados ?? 0 }}</h4>
                <p>Rechazados</p>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-bar">
        <div class="filter-group">
            <label>Buscar</label>
            <input type="text" id="searchInput" class="form-control" placeholder="N°, beneficiario..." onkeyup="filterTable()">
        </div>
        <div class="filter-group">
            <label>Estado</label>
            <select id="statusFilter" class="form-control" onchange="filterTable()">
                <option value="">Todos</option>
                <option value="pending">Pendiente</option>
                <option value="approved_pending_pay">Aprobado (Por Pagar)</option>
                <option value="paid">Pagado</option>
                <option value="rejected">Rechazado</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Desde</label>
            <input type="date" id="dateFrom" class="form-control" onchange="filterTable()">
        </div>
        <div class="filter-group">
            <label>Hasta</label>
            <input type="date" id="dateTo" class="form-control" onchange="filterTable()">
        </div>
        <button class="btn-filter" onclick="filterTable()">
            <span class="material-symbols-rounded">filter_alt</span>
            Filtrar
        </button>
    </div>

    <!-- Tabla -->
    <div class="excel-wrapper">
        <div class="excel-scroll">
            @if(isset($cuentas) && $cuentas->count() > 0)
            <table class="excel-table" id="paymentsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Consecutivo</th>
                        <th>Fecha Emisión</th>
                        <th>Beneficiario</th>
                        <th>Concepto</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cuentas as $index => $cuenta)
                        @php
                            $estadoPago = $cuenta->estado_pago ?? 'pending';
                            $estadoAprobacion = $cuenta->estado_aprobacion;
                            
                            $displayStatus = 'pending';
                            $statusLabel = 'Pendiente';
                            $statusClass = 'badge-gray';

                            if ($estadoPago === 'approved') {
                                $displayStatus = 'paid';
                                $statusLabel = 'Pagado';
                                $statusClass = 'badge-green';
                            } elseif ($estadoPago === 'rejected') {
                                $displayStatus = 'payment_rejected';
                                $statusLabel = 'Rechazado';
                                $statusClass = 'badge-red';
                            } else {
                                switch ($estadoAprobacion) {
                                    case 'en_revision':
                                        $statusLabel = 'En Revisión';
                                        $statusClass = 'badge-blue';
                                        break;
                                    case 'aprobado':
                                        $displayStatus = 'approved_pending_pay';
                                        $statusLabel = 'Por Pagar';
                                        $statusClass = 'badge-amber';
                                        break;
                                    case 'rechazado':
                                        $displayStatus = 'rejected';
                                        $statusLabel = 'Rechazado';
                                        $statusClass = 'badge-red';
                                        break;
                                    case 'en_correccion':
                                        $statusLabel = 'En Corrección';
                                        $statusClass = 'badge-orange';
                                        break;
                                    default:
                                        $statusLabel = 'Borrador';
                                        $statusClass = 'badge-gray';
                                        break;
                                }
                            }
                        @endphp
                        <tr data-status="{{ $displayStatus }}">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><a href="{{ route('cuentas_cobro.show', $cuenta) }}" class="link-numero">{{ $cuenta->numero }}</a></td>
                            <td>{{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }}<br><span class="text-muted">{{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('H:i') }}</span></td>
                            <td><strong>{{ $cuenta->user->name ?? 'N/A' }}</strong></td>
                            <td>{{ Str::limit($cuenta->concepto ?? $cuenta->descripcion ?? '-', 30) }}</td>
                            <td class="text-right font-mono">${{ number_format($cuenta->subtotal ?? $cuenta->valor_total, 0, ',', '.') }}</td>
                            <td class="text-right font-mono">${{ number_format($cuenta->iva ?? 0, 0, ',', '.') }}</td>
                            <td class="text-right font-mono font-bold">${{ number_format($cuenta->valor_total, 0, ',', '.') }}</td>
                            <td><span class="badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('cuentas_cobro.show', $cuenta) }}" class="action-btn" title="Ver">
                                        <span class="material-symbols-rounded">visibility</span>
                                    </a>
                                    @if(($cuenta->estado_pago ?? 'pending') === 'pending' && ($cuenta->estado_aprobacion === 'aprobado') && ($cuenta->etapa_aprobacion === 'tesoreria'))
                                        <button onclick="openPagoModal({{ $cuenta->id }}, {{ (float)($cuenta->valor_total ?? 0) }})" class="action-btn success" title="Registrar Pago">
                                            <span class="material-symbols-rounded">paid</span>
                                        </button>
                                        <button onclick="openRejectPago({{ $cuenta->id }})" class="action-btn danger" title="Rechazar">
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
                <span class="material-symbols-rounded icon">payments</span>
                <h3>No hay pagos registrados</h3>
                <p>Las cuentas de cobro aparecerán aquí cuando sean creadas.</p>
            </div>
            @endif
        </div>
        @if(isset($cuentas) && $cuentas->count() > 0)
        <div class="pagination-wrapper">
            <span class="pagination-info">Mostrando 1 - {{ $cuentas->count() }} de {{ $cuentas->count() }} registros</span>
        </div>
        @endif
    </div>
</div>

<!-- Modal Registrar Pago -->
<div id="pagoModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h3><span class="material-symbols-rounded">paid</span> Registrar Pago</h3>
            <button type="button" class="modal-close" onclick="closePagoModal()">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form id="pagoForm" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Valor pagado</label>
                    <input type="number" name="valor_pagado" id="valor_pagado" step="0.01" required class="form-control" />
                </div>
                <div class="form-group">
                    <label>Medio de pago</label>
                    <select name="medio_pago" required class="form-control">
                        <option value="Transferencia">Transferencia</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Consignación">Consignación</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Referencia</label>
                    <input type="text" name="referencia_pago" placeholder="# de transacción" class="form-control" />
                </div>
                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea name="observacion_pago" rows="3" placeholder="Comentario opcional" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closePagoModal()">Cancelar</button>
                <button type="submit" class="btn-success">Confirmar Pago</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Rechazar Pago -->
<div id="rejectPagoModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header danger">
            <h3><span class="material-symbols-rounded">cancel</span> Rechazar Pago</h3>
            <button type="button" class="modal-close" onclick="closeRejectPago()">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form id="rejectPagoForm" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Motivo del rechazo</label>
                    <textarea name="motivo" rows="3" required class="form-control" placeholder="Explique el motivo..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeRejectPago()">Cancelar</button>
                <button type="submit" class="btn-danger">Rechazar Pago</button>
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
    document.getElementById('pagoModal').classList.add('active');
}

function closePagoModal(){
    document.getElementById('pagoModal').classList.remove('active');
}

function openRejectPago(id){
    const form = document.getElementById('rejectPagoForm');
    form.action = `{{ url('/cuentas_cobro') }}/${id}/rechazar-pago`;
    document.getElementById('rejectPagoModal').classList.add('active');
}

function closeRejectPago(){
    document.getElementById('rejectPagoModal').classList.remove('active');
}

document.getElementById('pagoModal').addEventListener('click', function(e){
    if(e.target === this) closePagoModal();
});

document.getElementById('rejectPagoModal').addEventListener('click', function(e){
    if(e.target === this) closeRejectPago();
});
</script>
@endsection
