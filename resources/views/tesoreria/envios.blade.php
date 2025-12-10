@extends('layouts.app')

@section('title', 'Gestión de Envíos - Tesorería')

@section('content')
<style>
    :root {
        --primary: #116dff;
        --secondary: #0f172a;
        --success: #10b981;
        --warning: #f59e0b;
    }

    .envios-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--secondary);
    }

    .filters {
        background: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .envio-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 16px;
        transition: all 0.2s;
    }

    .envio-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.08);
        border-color: var(--primary);
    }

    .envio-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 12px;
    }

    .envio-info h3 {
        font-size: 16px;
        font-weight: 700;
        color: var(--secondary);
        margin-bottom: 4px;
    }

    .envio-meta {
        font-size: 13px;
        color: #64748b;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-success {
        background: #d1fae5;
        color: #065f46;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-failed {
        background: #fee2e2;
        color: #991b1b;
    }

    .envio-details {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #e2e8f0;
    }

    .detail-item {
        font-size: 13px;
    }

    .detail-label {
        color: #64748b;
        font-weight: 500;
        margin-bottom: 2px;
    }

    .detail-value {
        color: var(--secondary);
        font-weight: 600;
    }
</style>

<div class="envios-container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Historial de Envíos</h1>
            <p style="color: #64748b; margin-top: 4px;">Seguimiento de documentos enviados a la DIAN y usuarios</p>
        </div>
    </div>

    <div class="filters">
        <div class="flex gap-4">
            <select class="px-4 py-2 border rounded-lg">
                <option>Todos los estados</option>
                <option>Enviado exitosamente</option>
                <option>Pendiente</option>
                <option>Fallido</option>
            </select>
            <select class="px-4 py-2 border rounded-lg">
                <option>Todos los tipos</option>
                <option>Email</option>
                <option>DIAN</option>
            </select>
            <input type="date" class="px-4 py-2 border rounded-lg">
        </div>
    </div>

    @forelse($envios as $envio)
    <div class="envio-card">
        <div class="envio-header">
            <div class="envio-info">
                <h3>Cuenta #{{ $envio->cuentaCobro->numero ?? $envio->cuenta_cobro_id }}</h3>
                <p class="envio-meta">
                    Enviado el {{ $envio->fecha_envio->format('d M Y, h:i A') }} por {{ $envio->usuarioEnvia->name }}
                </p>
            </div>
            <span class="status-badge {{ $envio->enviado_exitosamente ? 'status-success' : 'status-failed' }}">
                {{ $envio->enviado_exitosamente ? 'Enviado' : 'Fallido' }}
            </span>
        </div>

        <div class="envio-details">
            <div class="detail-item">
                <div class="detail-label">Destinatario</div>
                <div class="detail-value">{{ $envio->destinatario_nombre }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Email</div>
                <div class="detail-value">{{ $envio->destinatario_email }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Tipo</div>
                <div class="detail-value">{{ ucfirst($envio->tipo_envio) }}</div>
            </div>
        </div>

        @if($envio->mensaje)
        <div class="mt-3 p-3 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-600">{{ $envio->mensaje }}</p>
        </div>
        @endif
    </div>
    @empty
    <div class="text-center py-12 bg-white rounded-xl border">
        <span class="material-symbols-rounded text-gray-300" style="font-size: 64px;">send</span>
        <p class="text-gray-500 mt-4">No hay envíos registrados todavía.</p>
    </div>
    @endforelse

    <div class="mt-6">
        {{ $envios->links() }}
    </div>
</div>
@endsection
