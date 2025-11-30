@extends('layouts.app')

@section('title', 'Detalle de Cuenta - Dewey Accounts')

@section('content')
<style>
    /* Wix-inspired Detail View Styles */
    :root {
        --wix-blue: #116dff;
        --wix-dark: #20303c;
        --wix-gray: #f4f4f4;
        --wix-text: #162d3d;
        --wix-border: #eef1f5;
        --wix-success: #10b981;
        --wix-warning: #f59e0b;
        --wix-danger: #ef4444;
    }

    .wix-container {
        max-width: 1200px;
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
        font-size: 28px;
        font-weight: 800;
        color: var(--wix-text);
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 12px;
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

    .wix-back-btn:hover {
        color: var(--wix-blue);
    }

    /* Main Grid */
    .wix-detail-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 32px;
    }

    /* Cards */
    .wix-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid var(--wix-border);
        padding: 32px;
        margin-bottom: 24px;
    }

    .wix-card-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--wix-text);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--wix-border);
    }

    .wix-card-title .material-symbols-rounded {
        color: var(--wix-blue);
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .info-item label {
        display: block;
        font-size: 12px;
        color: #8795a1;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .info-item div {
        font-size: 15px;
        color: var(--wix-text);
        font-weight: 500;
    }

    /* Summary Banner */
    .summary-banner {
        background: linear-gradient(135deg, var(--wix-dark) 0%, #2c3e50 100%);
        color: white;
        border-radius: 12px;
        padding: 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        box-shadow: 0 10px 30px rgba(32, 48, 60, 0.15);
    }

    .summary-info h2 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .summary-info p {
        opacity: 0.7;
        font-size: 14px;
    }

    .summary-total {
        text-align: right;
    }

    .summary-total label {
        display: block;
        font-size: 12px;
        opacity: 0.7;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .summary-total span {
        font-size: 36px;
        font-weight: 700;
        color: #4ade80; /* Bright green for money */
    }

    /* Status Badge */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 32px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #eef1f5;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 24px;
    }

    .timeline-dot {
        position: absolute;
        left: -32px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: white;
        border: 3px solid var(--wix-blue);
        z-index: 1;
    }

    .timeline-content {
        background: #f9fafb;
        border-radius: 8px;
        padding: 16px;
        border: 1px solid var(--wix-border);
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }

    .timeline-action {
        font-weight: 700;
        color: var(--wix-text);
    }

    .timeline-date {
        font-size: 12px;
        color: #8795a1;
    }

    /* Buttons */
    .wix-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        width: 100%;
        justify-content: center;
        margin-bottom: 12px;
    }

    .wix-btn-primary {
        background: var(--wix-blue);
        color: white;
    }
    .wix-btn-primary:hover { background: #0056d6; }

    .wix-btn-success {
        background: var(--wix-success);
        color: white;
    }
    .wix-btn-success:hover { background: #059669; }

    .wix-btn-danger {
        background: var(--wix-danger);
        color: white;
    }
    .wix-btn-danger:hover { background: #dc2626; }

    .wix-btn-secondary {
        background: white;
        border: 1px solid #d1d5db;
        color: var(--wix-text);
    }
    .wix-btn-secondary:hover { background: #f9fafb; }

    /* Items Table */
    .wix-items-table {
        width: 100%;
        border-collapse: collapse;
    }
    .wix-items-table th {
        text-align: left;
        padding: 12px;
        font-size: 12px;
        color: #8795a1;
        text-transform: uppercase;
        border-bottom: 1px solid var(--wix-border);
    }
    .wix-items-table td {
        padding: 16px 12px;
        border-bottom: 1px solid var(--wix-border);
        color: var(--wix-text);
    }
    .text-right { text-align: right; }

    @media (max-width: 900px) {
        .wix-detail-grid { grid-template-columns: 1fr; }
        .summary-banner { flex-direction: column; align-items: flex-start; gap: 20px; }
        .summary-total { text-align: left; }
    }
</style>

@php
    $authUser = auth()->user();
    $userRole = $authUser?->role?->name ?? 'guest';
    $isContratistaOwner = $cuenta->isOwner($authUser);
    $canApprove = $cuenta->canUserApprove($authUser);
    $canSendClient = $cuenta->canSendToClient($authUser);
@endphp

<div class="wix-container">
    <div class="wix-header">
        <div class="wix-title">
            <a href="{{ route('cuentas_cobro.index') }}" class="wix-back-btn">
                <span class="material-symbols-rounded">arrow_back</span>
                Volver
            </a>
            <h1>
                Cuenta de Cobro #{{ $cuenta->id }}
            </h1>
        </div>
        <div>
            @php
                $colors = [
                    'pendiente' => '#f59e0b',
                    'en_revision' => '#3b82f6',
                    'aprobado' => '#10b981',
                    'rechazado' => '#ef4444',
                    'pagado' => '#059669'
                ];
                $color = $colors[$cuenta->estado_aprobacion] ?? '#6b7c93';
            @endphp
            <span class="status-pill" style="background: {{ $color }}20; color: {{ $color }};">
                <span class="material-symbols-rounded" style="font-size: 18px;">
                    {{ $cuenta->estado_aprobacion === 'aprobado' ? 'check_circle' : 'pending' }}
                </span>
                {{ ucfirst(str_replace('_', ' ', $cuenta->estado_aprobacion)) }}
            </span>
        </div>
    </div>

    <div class="summary-banner">
        <div class="summary-info">
            <h2>{{ $cuenta->numero ?? 'Borrador' }}</h2>
            <p>Emitida el {{ \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d F, Y') }}</p>
        </div>
        <div class="summary-total">
            <label>Valor Total</label>
            <span>${{ number_format($cuenta->valor_total, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="wix-detail-grid">
        <!-- Left Column: Details -->
        <div class="detail-left">
            
            <!-- Beneficiary Info -->
            <div class="wix-card">
                <h3 class="wix-card-title">
                    <span class="material-symbols-rounded">person</span>
                    Información del Beneficiario
                </h3>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Nombre</label>
                        <div>{{ $cuenta->nombre_beneficiario }}</div>
                    </div>
                    <div class="info-item">
                        <label>Identificación</label>
                        <div>{{ $cuenta->tipo_identificacion }} {{ $cuenta->identificacion }}</div>
                    </div>
                    <div class="info-item">
                        <label>Tipo Cliente</label>
                        <div>{{ ucfirst($cuenta->tipo_cliente) }}</div>
                    </div>
                </div>
            </div>

            <!-- Detailed Sections (Legal Panels) -->
            @include('cuentas_cobro.partials.details-grid', ['visibleSections' => $visibleSections ?? []])

            <!-- Items -->
            @if($cuenta->items && $cuenta->items->count() > 0)
            <div class="wix-card">
                <h3 class="wix-card-title">
                    <span class="material-symbols-rounded">inventory_2</span>
                    Ítems
                </h3>
                <table class="wix-items-table">
                    <thead>
                        <tr>
                            <th>Descripción</th>
                            <th class="text-right">Cant.</th>
                            <th class="text-right">Unitario</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cuenta->items as $item)
                        <tr>
                            <td>
                                <div style="font-weight: 600;">{{ $item->item }}</div>
                                <div style="font-size: 13px; color: #8795a1;">{{ $item->detalle }}</div>
                            </td>
                            <td class="text-right">{{ $item->cantidad }}</td>
                            <td class="text-right">${{ number_format($item->precio_unitario, 0, ',', '.') }}</td>
                            <td class="text-right" style="font-weight: 600;">${{ number_format($item->cantidad * $item->precio_unitario, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <!-- Soportes -->
            <div class="wix-card">
                <h3 class="wix-card-title">
                    <span class="material-symbols-rounded">attach_file</span>
                    Soportes Adjuntos
                </h3>
                @if($cuenta->soportes && $cuenta->soportes->count() > 0)
                    <div style="display: grid; gap: 12px;">
                        @foreach($cuenta->soportes as $soporte)
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f9fafb; border-radius: 8px; border: 1px solid var(--wix-border);">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <span class="material-symbols-rounded" style="color: var(--wix-blue);">description</span>
                                    <a href="{{ Storage::url($soporte->path) }}" target="_blank" style="color: var(--wix-text); text-decoration: none; font-weight: 500;">
                                        {{ $soporte->nombre }}
                                    </a>
                                </div>
                                @if($isContratistaOwner && in_array($cuenta->estado_aprobacion, ['en_correccion','en_revision']))
                                    <form action="{{ route('cuentas_cobro.soportes.destroy', [$cuenta->id, $soporte->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar soporte?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer;">
                                            <span class="material-symbols-rounded">delete</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: #8795a1; font-style: italic;">No hay soportes adjuntos.</p>
                @endif

                @if($isContratistaOwner && in_array($cuenta->estado_aprobacion, ['en_correccion','en_revision']))
                    <div style="margin-top: 24px; padding-top: 24px; border-top: 1px dashed var(--wix-border);">
                        <form action="{{ route('cuentas_cobro.soportes.store', $cuenta->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label style="display: block; margin-bottom: 8px; font-weight: 600;">Subir nuevo soporte</label>
                            <div style="display: flex; gap: 12px;">
                                <input type="file" name="soportes[]" multiple required style="flex: 1; padding: 8px; border: 1px solid var(--wix-border); border-radius: 8px;">
                                <button type="submit" class="wix-btn-primary" style="width: auto; margin: 0;">Subir</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

        </div>

        <!-- Right Column: Actions & Timeline -->
        <div class="detail-right">
            
            <!-- Actions Card -->
            <div class="wix-card">
                <h3 class="wix-card-title">Acciones</h3>
                
                @if($isContratistaOwner && $cuenta->estado_aprobacion === 'en_correccion')
                    <a href="{{ route('cuentas_cobro.edit', $cuenta) }}" class="wix-btn wix-btn-secondary">
                        <span class="material-symbols-rounded">edit</span> Editar Cuenta
                    </a>
                    <form action="{{ route('cuentas_cobro.reenviar', $cuenta->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="wix-btn wix-btn-primary">
                            <span class="material-symbols-rounded">send</span> Reenviar a Revisión
                        </button>
                    </form>
                @endif

                @if($canApprove)
                    <button type="button" onclick="document.getElementById('approveModal').style.display='flex'" class="wix-btn wix-btn-success" style="margin-bottom: 12px;">
                        <span class="material-symbols-rounded">check_circle</span> Aprobar
                    </button>
                    <button onclick="document.getElementById('rejectModal').style.display='flex'" class="wix-btn wix-btn-danger">
                        <span class="material-symbols-rounded">cancel</span> Rechazar
                    </button>
                @endif

                <a href="{{ route('cuentas_cobro.pdf', $cuenta->id) }}" target="_blank" class="wix-btn wix-btn-secondary">
                    <span class="material-symbols-rounded">picture_as_pdf</span> Descargar PDF
                </a>
            </div>

            <!-- Timeline -->
            <div class="wix-card">
                <h3 class="wix-card-title">Historial</h3>
                <div class="timeline">
                    @forelse($cuenta->historial ?? [] as $evento)
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <span class="timeline-action">{{ ucfirst($evento->accion) }}</span>
                                    <span class="timeline-date">{{ $evento->created_at->format('d/m H:i') }}</span>
                                </div>
                                @if($evento->comentario)
                                    <div style="font-size: 13px; color: #6b7c93; margin-top: 4px;">
                                        "{{ $evento->comentario }}"
                                    </div>
                                @endif
                                <div style="font-size: 12px; color: #8795a1; margin-top: 8px;">
                                    Por: {{ $evento->user->name ?? 'Sistema' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p style="color: #8795a1; font-size: 13px;">No hay historial disponible.</p>
                    @endforelse
                </div>
            </div>

            <!-- Interacciones -->
            @include('cuentas_cobro.partials.interacciones')

        </div>
    </div>
</div>

<!-- Modals (Simplified for brevity, keeping functionality) -->
<div id="approveModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:32px; width:90%; max-width:400px; text-align:center; box-shadow: 0 20px 60px rgba(0,0,0,0.2);">
        <div style="width:60px; height:60px; background:#dcfce7; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; color:#16a34a;">
            <span class="material-symbols-rounded" style="font-size:32px;">check_circle</span>
        </div>
        <h3 style="margin-top:0; margin-bottom:8px; color:var(--wix-text); font-size:20px;">¿Aprobar cuenta?</h3>
        <p style="color:#6b7c93; margin-bottom:24px; font-size:15px;">La cuenta avanzará a la siguiente etapa del flujo.</p>
        
        <div style="display:flex; gap:12px; justify-content:center;">
            <button type="button" onclick="document.getElementById('approveModal').style.display='none'" class="wix-btn wix-btn-secondary" style="width:auto;">Cancelar</button>
            <form action="{{ route('cuentas_cobro.aprobar', $cuenta->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="wix-btn wix-btn-success" style="width:auto;">Confirmar Aprobación</button>
            </form>
        </div>
    </div>
</div>

<div id="rejectModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:32px; width:90%; max-width:500px;">
        <h3 style="margin-top:0; margin-bottom:16px;">Rechazar Cuenta</h3>
        <form action="{{ route('cuentas_cobro.rechazar', $cuenta->id) }}" method="POST">
            @csrf
            <textarea name="motivo_rechazo" rows="4" placeholder="Motivo del rechazo..." required style="width:100%; padding:12px; border:1px solid #eef1f5; border-radius:8px; margin-bottom:16px; font-family:inherit;"></textarea>
            <div style="display:flex; gap:12px; justify-content:flex-end;">
                <button type="button" onclick="document.getElementById('rejectModal').style.display='none'" class="wix-btn wix-btn-secondary" style="width:auto; margin:0;">Cancelar</button>
                <button type="submit" class="wix-btn wix-btn-danger" style="width:auto; margin:0;">Confirmar Rechazo</button>
            </div>
        </form>
    </div>
</div>

@endsection
