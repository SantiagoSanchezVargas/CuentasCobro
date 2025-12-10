@extends('layouts.app')

@section('title', 'Seguimiento de Aprobación')

@section('content')
<style>
    .timeline-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    .timeline-item {
        position: relative;
        padding-left: 40px;
        margin-bottom: 30px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: -30px;
        width: 2px;
        background: #e2e8f0;
    }
    .timeline-item:last-child::before {
        display: none;
    }
    .timeline-marker {
        position: absolute;
        left: -9px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fff;
        border: 4px solid #cbd5e1;
        z-index: 1;
    }
    .timeline-item.completed .timeline-marker {
        border-color: #10b981;
        background: #10b981;
    }
    .timeline-item.current .timeline-marker {
        border-color: #3b82f6;
        background: #fff;
    }
    .timeline-item.rejected .timeline-marker {
        border-color: #ef4444;
        background: #ef4444;
    }
    .timeline-content {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e2e8f0;
    }
    .timeline-date {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 4px;
    }
    .timeline-title {
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }
    .timeline-desc {
        font-size: 14px;
        color: #334155;
    }
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
        margin-top: 8px;
    }
    .status-approved { background: #d1fae5; color: #065f46; }
    .status-pending { background: #dbeafe; color: #1e40af; }
    .status-rejected { background: #fee2e2; color: #991b1b; }
</style>

<div class="timeline-container">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Seguimiento de Cuenta #{{ $cuenta->numero ?? $cuenta->id }}</h1>
        <a href="{{ route('cuentas_cobro.index') }}" class="text-blue-600 hover:underline">Volver</a>
    </div>

    <div class="timeline">
        <!-- Creación -->
        <div class="timeline-item completed">
            <div class="timeline-marker"></div>
            <div class="timeline-content">
                <div class="timeline-date">{{ $cuenta->created_at->format('d M Y, h:i A') }}</div>
                <h3 class="timeline-title">Cuenta Creada</h3>
                <p class="timeline-desc">Creada por: {{ $cuenta->user->name ?? 'Usuario' }} ({{ $cuenta->user->role->name ?? 'Rol' }})</p>
            </div>
        </div>

        <!-- Aprobación -->
        <div class="timeline-item {{ $cuenta->estado_aprobacion == 'aprobado' || $cuenta->estado_aprobacion == 'pagado' || $cuenta->estado_aprobacion == 'enviado_cliente' ? 'completed' : ($cuenta->estado_aprobacion == 'rechazado' ? 'rejected' : 'current') }}">
            <div class="timeline-marker"></div>
            <div class="timeline-content">
                <div class="timeline-date">{{ $cuenta->fecha_aprobacion ? $cuenta->fecha_aprobacion->format('d M Y') : 'Pendiente' }}</div>
                <h3 class="timeline-title">Aprobación</h3>
                @if($cuenta->estado_aprobacion == 'rechazado')
                    <p class="timeline-desc text-red-600">Rechazada. Motivo: {{ $cuenta->motivo_rechazo ?? 'No especificado' }}</p>
                @elseif($cuenta->estado_aprobacion == 'pendiente')
                    <p class="timeline-desc">En revisión por Administrador/Tesoreria</p>
                @else
                    <p class="timeline-desc">Aprobada exitosamente.</p>
                @endif
            </div>
        </div>

        <!-- Envío a DIAN (Simulado con estado enviado_cliente) -->
        <div class="timeline-item {{ $cuenta->estado_aprobacion == 'enviado_cliente' || $cuenta->estado_aprobacion == 'pagado' ? 'completed' : 'current' }}">
            <div class="timeline-marker"></div>
            <div class="timeline-content">
                <h3 class="timeline-title">Trámite DIAN</h3>
                @if($cuenta->estado_aprobacion == 'enviado_cliente' || $cuenta->estado_aprobacion == 'pagado')
                    <p class="timeline-desc">Documento enviado al usuario para facturación electrónica.</p>
                    <span class="status-badge status-approved">Enviado</span>
                @else
                    <p class="timeline-desc">Pendiente de envío.</p>
                @endif
            </div>
        </div>

        <!-- Pago -->
        <div class="timeline-item {{ $cuenta->estado_aprobacion == 'pagado' ? 'completed' : 'current' }}">
            <div class="timeline-marker"></div>
            <div class="timeline-content">
                <div class="timeline-date">{{ $cuenta->fecha_pago ? $cuenta->fecha_pago->format('d M Y') : 'Pendiente' }}</div>
                <h3 class="timeline-title">Pago Realizado</h3>
                @if($cuenta->estado_aprobacion == 'pagado')
                    <p class="timeline-desc">El pago ha sido procesado.</p>
                    <span class="status-badge status-approved">Pagado</span>
                @else
                    <p class="timeline-desc">Pendiente de pago.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
