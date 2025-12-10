@extends('layouts.app')

@section('title', 'Mis Cuentas de Cobro - Dewey Accounts')

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
    }

    .main-container {
        padding: 40px;
        max-width: 1400px;
        margin: 0 auto;
        font-family: 'Inter', sans-serif;
    }

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

    .page-title p {
        color: var(--text-light);
        font-size: 16px;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 6px rgba(17, 109, 255, 0.2);
        border: none;
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 12px rgba(17, 109, 255, 0.25);
        color: white;
    }

    .content-card {
        background: var(--bg-card);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        overflow: hidden;
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
        font-size: 15px;
        vertical-align: middle;
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .data-table tr:hover td {
        background: #f8fafc;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 13px;
        font-weight: 600;
    }

    .status-badge.pendiente { background: #fff7ed; color: #c2410c; }
    .status-badge.en_revision { background: #eff6ff; color: #1d4ed8; }
    .status-badge.aprobado { background: #f0fdf4; color: #15803d; }
    .status-badge.rechazado { background: #fef2f2; color: #b91c1c; }
    .status-badge.pagado { background: #ecfdf5; color: #047857; }
    .status-badge.en_correccion { background: #ffedd5; color: #9a3412; }
    .status-badge.enviado_cliente { background: #e0f2fe; color: #0369a1; }

    .action-btn {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: var(--text-light);
        transition: all 0.2s;
        text-decoration: none;
        background: transparent;
        border: 1px solid transparent;
    }

    .action-btn:hover {
        background: #f1f5f9;
        color: var(--primary);
        border-color: var(--border-color);
    }

    .action-btn.delete:hover {
        background: #fef2f2;
        color: var(--danger);
        border-color: #fecaca;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: #eff6ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        color: var(--primary);
    }

    .empty-state h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--secondary);
    }

    .empty-state p {
        color: var(--text-light);
        margin-bottom: 32px;
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
            <h1>Mis Cuentas de Cobro</h1>
            <p>Gestiona y realiza seguimiento a todos tus documentos.</p>
        </div>
        <a href="{{ route('cuentas_cobro.create') }}" class="btn-primary">
            <span class="material-symbols-rounded">add_circle</span>
            Nueva Cuenta
        </a>
    </div>

    <div class="content-card">
        @if($cuentas->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Referencia</th>
                        <th>Fecha Emisión</th>
                        <th>Valor Total</th>
                        <th>Estado</th>
                        <th>Ubicación</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cuentas as $cuenta)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: var(--secondary);">{{ $cuenta->numero ?? 'Borrador' }}</div>
                                <div style="font-size: 12px; color: var(--text-light);">ID: {{ $cuenta->id }}</div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d M, Y') }}</td>
                            <td style="font-weight: 600; color: var(--secondary);">${{ number_format($cuenta->valor_total, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $statusClass = $cuenta->estado_aprobacion;
                                    $statusLabel = ucfirst(str_replace('_', ' ', $cuenta->estado_aprobacion));
                                    
                                    if (($cuenta->estado_pago ?? 'pending') === 'approved') {
                                        $statusClass = 'pagado';
                                        $statusLabel = 'Pagado';
                                    } elseif ($cuenta->estado_aprobacion === 'en_revision') {
                                        $statusLabel = 'En Revisión';
                                    } elseif ($cuenta->estado_aprobacion === 'en_correccion') {
                                        $statusLabel = 'En Corrección';
                                    } elseif ($cuenta->estado_aprobacion === 'enviado_cliente') {
                                        $statusLabel = 'Enviado al Cliente';
                                    }
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td>{{ $cuenta->municipio }}, {{ $cuenta->departamento }}</td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 4px;">
                                    <a href="{{ route('cuentas_cobro.show', $cuenta) }}" class="action-btn" title="Ver detalles">
                                        <span class="material-symbols-rounded" style="font-size: 20px;">visibility</span>
                                    </a>
                                    <a href="{{ route('cuentas_cobro.edit', $cuenta) }}" class="action-btn" title="Editar">
                                        <span class="material-symbols-rounded" style="font-size: 20px;">edit</span>
                                    </a>
                                    <button type="button" onclick="openDeleteModal('{{ route('cuentas_cobro.destroy', $cuenta) }}')" class="action-btn delete" title="Eliminar">
                                        <span class="material-symbols-rounded" style="font-size: 20px;">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <span class="material-symbols-rounded" style="font-size: 40px;">receipt_long</span>
                </div>
                <h3>No tienes cuentas de cobro</h3>
                <p>Crea tu primera cuenta de cobro para comenzar a gestionar tus pagos.</p>
                <a href="{{ route('cuentas_cobro.create') }}" class="btn-primary">
                    Crear Primera Cuenta
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; backdrop-filter: blur(4px);">
    <div style="background:white; border-radius:16px; padding:32px; width:90%; max-width:400px; text-align:center; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
        <div style="width:60px; height:60px; background:#fee2e2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:#ef4444;">
            <span class="material-symbols-rounded" style="font-size:32px;">delete</span>
        </div>
        <h3 style="margin-top:0; margin-bottom:8px; color:var(--secondary); font-size:20px; font-weight: 700;">¿Eliminar cuenta?</h3>
        <p style="color:var(--text-light); margin-bottom:24px; font-size:15px; line-height: 1.5;">Esta acción no se puede deshacer y eliminará permanentemente la cuenta de cobro.</p>
        
        <div style="display:flex; gap:12px; justify-content:center;">
            <button type="button" onclick="closeDeleteModal()" class="btn-primary" style="background:white; color:var(--secondary); border:1px solid var(--border-color); width:auto; box-shadow: none;">Cancelar</button>
            <form id="deleteForm" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-primary" style="background:var(--danger); border:none; width:auto; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);">Eliminar</button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(url) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = url;
    modal.style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

// Close on click outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endsection
