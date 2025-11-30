@extends('layouts.app')

@section('title', 'Mis Aprobaciones - Dewey Accounts')

@section('content')
<style>
    :root {
        --wix-blue: #116dff;
        --wix-dark: #20303c;
        --wix-gray: #f4f4f4;
        --wix-text: #162d3d;
        --wix-border: #eef1f5;
        --wix-success: #10b981;
        --wix-danger: #ef4444;
    }

    .wix-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* Header */
    .wix-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .wix-title h1 {
        font-family: 'Inter', sans-serif;
        font-size: 32px;
        font-weight: 800;
        color: var(--wix-text);
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .wix-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #6b7c93;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: color 0.2s;
    }
    .wix-back-btn:hover { color: var(--wix-blue); }

    /* Stage Banner */
    .stage-banner {
        background: white;
        border: 1px solid var(--wix-border);
        border-left: 4px solid var(--wix-blue);
        border-radius: 8px;
        padding: 16px 24px;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }

    .stage-banner.warning {
        border-left-color: #f59e0b;
        background: #fffbeb;
    }

    /* Approval Cards */
    .approval-card {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--wix-border);
        padding: 24px;
        margin-bottom: 20px;
        transition: all 0.2s;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
    }

    .approval-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        transform: translateY(-2px);
        border-color: #dbeafe;
    }

    .card-info h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--wix-text);
        margin-bottom: 4px;
    }

    .card-meta {
        font-size: 14px;
        color: #6b7c93;
        display: flex;
        gap: 16px;
        align-items: center;
    }

    .card-amount {
        text-align: right;
    }

    .amount-label {
        font-size: 12px;
        color: #8795a1;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .amount-value {
        font-size: 20px;
        font-weight: 700;
        color: var(--wix-text);
    }

    /* Buttons */
    .wix-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .wix-btn-primary { background: var(--wix-blue); color: white; }
    .wix-btn-primary:hover { background: #0056d6; }

    .wix-btn-success { background: var(--wix-success); color: white; }
    .wix-btn-success:hover { background: #059669; }

    .wix-btn-danger { background: var(--wix-danger); color: white; }
    .wix-btn-danger:hover { background: #dc2626; }

    .wix-btn-secondary { background: white; border: 1px solid #d1d5db; color: var(--wix-text); }
    .wix-btn-secondary:hover { background: #f9fafb; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        border: 1px dashed var(--wix-border);
    }
    .empty-icon {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 16px;
    }

    @media (max-width: 768px) {
        .approval-card { flex-direction: column; align-items: flex-start; }
        .card-amount { text-align: left; margin-top: 12px; margin-bottom: 12px; }
        .actions { width: 100%; display: flex; gap: 8px; }
        .wix-btn { flex: 1; justify-content: center; }
    }
</style>

<div class="wix-container">
    <div class="wix-header">
        <div class="wix-title">
            <h1>Mis Aprobaciones</h1>
        </div>
        <a href="{{ route('dashboard') }}" class="wix-back-btn">
            <span class="material-symbols-rounded">arrow_back</span>
            Volver al Dashboard
        </a>
    </div>

    @if($etapa)
        <div class="stage-banner">
            <span class="material-symbols-rounded" style="color: var(--wix-blue);">info</span>
            <div>
                <strong style="color: var(--wix-text);">Etapa actual asignada:</strong> 
                {{ ucfirst(str_replace('_',' ', $etapa)) }}
            </div>
        </div>
    @else
        <div class="stage-banner warning">
            <span class="material-symbols-rounded" style="color: #f59e0b;">warning</span>
            <div>
                <strong style="color: #92400e;">Sin etapa asignada:</strong> 
                Tu rol ({{ auth()->user()->role->name ?? 'N/A' }}) no tiene permisos de aprobación configurados.
            </div>
        </div>
    @endif

    <div class="approvals-list">
        @forelse($cuentas as $cuenta)
            <div class="approval-card">
                <div class="card-info">
                    <h3>Cuenta #{{ $cuenta->numero }}</h3>
                    <div class="card-meta">
                        <span><span class="material-symbols-rounded" style="font-size: 16px; vertical-align: text-bottom;">calendar_today</span> {{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d/m/Y') }}</span>
                        <span><span class="material-symbols-rounded" style="font-size: 16px; vertical-align: text-bottom;">person</span> {{ $cuenta->nombre_beneficiario }}</span>
                    </div>
                </div>
                
                <div class="card-amount">
                    <div class="amount-label">Valor Total</div>
                    <div class="amount-value">${{ number_format($cuenta->valor_total, 0, ',', '.') }}</div>
                </div>

                <div class="actions" style="display: flex; gap: 8px;">
                    <a href="{{ route('cuentas_cobro.show', $cuenta->id) }}" class="wix-btn wix-btn-secondary">
                        Ver Detalle
                    </a>
                    
                    @if($cuenta->canUserApprove(auth()->user()))
                        <button type="button" onclick="openApproveModal('{{ route('cuentas_cobro.aprobar', $cuenta->id) }}')" class="wix-btn wix-btn-success">
                            <span class="material-symbols-rounded">check</span> Aprobar
                        </button>
                        <button type="button" onclick="openRejectModal({{ $cuenta->id }})" class="wix-btn wix-btn-danger">
                            <span class="material-symbols-rounded">close</span> Rechazar
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <span class="material-symbols-rounded empty-icon">task_alt</span>
                <h3 style="color: var(--wix-text); margin-bottom: 8px;">¡Todo al día!</h3>
                <p style="color: #6b7c93;">No tienes cuentas pendientes por aprobar en este momento.</p>
            </div>
        @endforelse
    </div>

    <div style="margin-top: 32px;">
        {{ $cuentas->links() }}
    </div>
</div>

<!-- Modal Aprobación -->
<div id="approveModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:32px; width:90%; max-width:400px; text-align:center; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
        <div style="width:60px; height:60px; background:#dcfce7; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:#16a34a;">
            <span class="material-symbols-rounded" style="font-size:32px;">check_circle</span>
        </div>
        <h3 style="margin-top:0; margin-bottom:8px; color:var(--wix-text); font-size:20px;">¿Aprobar cuenta?</h3>
        <p style="color:#6b7c93; margin-bottom:24px; font-size:15px;">La cuenta avanzará a la siguiente etapa del flujo.</p>
        
        <div style="display:flex; gap:12px; justify-content:center;">
            <button type="button" onclick="closeApproveModal()" class="wix-btn wix-btn-secondary" style="width:auto;">Cancelar</button>
            <form id="approveForm" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="wix-btn wix-btn-success" style="width:auto;">Confirmar Aprobación</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Rechazo -->
<div id="rejectModal" style="display:none; position: fixed; inset:0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 32px; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
        <h3 style="margin-top:0; margin-bottom: 16px; color: var(--wix-text);">Rechazar Cuenta</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--wix-text);">Motivo de rechazo</label>
                <textarea name="motivo_rechazo" rows="4" required style="width:100%; padding:12px; border:1px solid var(--wix-border); border-radius:8px; font-family: inherit;"></textarea>
            </div>
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <button type="button" onclick="closeRejectModal()" class="wix-btn wix-btn-secondary" style="width: auto; margin: 0;">Cancelar</button>
                <button type="submit" class="wix-btn wix-btn-danger" style="width: auto; margin: 0;">Confirmar Rechazo</button>
            </div>
        </form>
    </div>
</div>

<script>
function openApproveModal(url){
    const form = document.getElementById('approveForm');
    form.action = url;
    document.getElementById('approveModal').style.display = 'flex';
}
function closeApproveModal(){
    document.getElementById('approveModal').style.display = 'none';
}
document.getElementById('approveModal').addEventListener('click', function(e){
    if(e.target === this) closeApproveModal();
});

function openRejectModal(id){
    const form = document.getElementById('rejectForm');
    form.action = `{{ url('/cuentas_cobro') }}/${id}/rechazar`;
    document.getElementById('rejectModal').style.display = 'flex';
}
function closeRejectModal(){
    document.getElementById('rejectModal').style.display = 'none';
}
document.getElementById('rejectModal').addEventListener('click', function(e){
    if(e.target === this) closeRejectModal();
});
</script>
@endsection
