@extends('layouts.app')

@section('title', 'Seguimiento General')

@section('content')
<div class="page-container">
    <!-- Header -->
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: var(--apple-dark); margin-bottom: 4px;">
                <span class="material-symbols-rounded" style="vertical-align: middle; margin-right: 8px;">timeline</span>
                Seguimiento de Cuentas de Cobro
            </h1>
            <p style="color: var(--apple-text-muted); font-size: 15px;">
                Vista general del estado de todas las cuentas en el flujo de aprobación
            </p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('cuentas_cobro.index') }}" class="btn-apple btn-apple-secondary">
                <span class="material-symbols-rounded">list</span>
                Ver Listado
            </a>
        </div>
    </div>

    <!-- Pipeline Visual -->
    <div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow-x: auto;">
        <h3 style="margin: 0 0 20px 0; font-size: 16px; font-weight: 600; color: var(--apple-text-muted);">Pipeline de Aprobación</h3>
        <div style="display: flex; gap: 16px; min-width: 600px;">
            @php
                $etapas = [
                    ['key' => 'auxiliar', 'label' => 'Auxiliar', 'icon' => 'support_agent', 'color' => '#6366f1'],
                    ['key' => 'administrador', 'label' => 'Administrador', 'icon' => 'admin_panel_settings', 'color' => '#8b5cf6'],
                    ['key' => 'tesoreria', 'label' => 'Tesorería', 'icon' => 'payments', 'color' => '#ec4899'],
                ];
            @endphp
            @foreach($etapas as $etapa)
            <div style="flex: 1; min-width: 160px;">
                <div style="background: {{ $etapa['color'] }}15; border: 2px solid {{ $etapa['color'] }}; border-radius: 12px; padding: 16px; text-align: center;">
                    <span class="material-symbols-rounded" style="font-size: 32px; color: {{ $etapa['color'] }}; display: block; margin-bottom: 8px;">{{ $etapa['icon'] }}</span>
                    <p style="font-weight: 600; font-size: 14px; margin: 0 0 4px 0;">{{ $etapa['label'] }}</p>
                    <p style="font-size: 28px; font-weight: 700; color: {{ $etapa['color'] }}; margin: 0;">
                        {{ $porEtapa[$etapa['key']] ?? 0 }}
                    </p>
                </div>
            </div>
            @if(!$loop->last)
            <div style="display: flex; align-items: center;">
                <span class="material-symbols-rounded" style="color: #d1d5db;">arrow_forward</span>
            </div>
            @endif
            @endforeach
        </div>
    </div>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 24px;">
        <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 20px; border-radius: 16px;">
            <p style="font-size: 13px; color: #92400e; margin: 0 0 4px 0; font-weight: 500;">Pendientes</p>
            <p style="font-size: 32px; font-weight: 700; color: #92400e; margin: 0;">{{ $stats['pendiente'] ?? 0 }}</p>
        </div>
        <div style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); padding: 20px; border-radius: 16px;">
            <p style="font-size: 13px; color: #1e40af; margin: 0 0 4px 0; font-weight: 500;">En Revisión</p>
            <p style="font-size: 32px; font-weight: 700; color: #1e40af; margin: 0;">{{ $stats['en_revision'] ?? 0 }}</p>
        </div>
        <div style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); padding: 20px; border-radius: 16px;">
            <p style="font-size: 13px; color: #065f46; margin: 0 0 4px 0; font-weight: 500;">Aprobadas</p>
            <p style="font-size: 32px; font-weight: 700; color: #065f46; margin: 0;">{{ $stats['aprobado'] ?? 0 }}</p>
        </div>
        <div style="background: linear-gradient(135deg, #fee2e2, #fecaca); padding: 20px; border-radius: 16px;">
            <p style="font-size: 13px; color: #991b1b; margin: 0 0 4px 0; font-weight: 500;">Rechazadas</p>
            <p style="font-size: 32px; font-weight: 700; color: #991b1b; margin: 0;">{{ $stats['rechazado'] ?? 0 }}</p>
        </div>
        <div style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe); padding: 20px; border-radius: 16px;">
            <p style="font-size: 13px; color: #3730a3; margin: 0 0 4px 0; font-weight: 500;">Pagadas</p>
            <p style="font-size: 32px; font-weight: 700; color: #3730a3; margin: 0;">{{ $stats['pagado'] ?? 0 }}</p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h3 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
            <span class="material-symbols-rounded">history</span>
            Actividad Reciente
        </h3>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @forelse($actividades ?? [] as $act)
            <div style="display: flex; align-items: flex-start; gap: 12px; padding: 12px; background: #f8fafc; border-radius: 10px;">
                <div style="width: 40px; height: 40px; background: #e0e7ff; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <span class="material-symbols-rounded" style="color: #4f46e5;">
                        @switch($act->tipo ?? 'info')
                            @case('aprobacion') check_circle @break
                            @case('rechazo') cancel @break
                            @case('creacion') add_circle @break
                            @case('pago') payments @break
                            @default info
                        @endswitch
                    </span>
                </div>
                <div style="flex: 1;">
                    <p style="margin: 0 0 2px 0; font-weight: 600; font-size: 14px;">{{ $act->descripcion ?? 'Actividad' }}</p>
                    <p style="margin: 0; font-size: 13px; color: #64748b;">
                        {{ $act->usuario ?? 'Sistema' }} · {{ $act->created_at ? $act->created_at->diffForHumans() : '' }}
                    </p>
                </div>
                @if($act->cuenta_cobro_id ?? false)
                <a href="{{ route('cuentas_cobro.show', $act->cuenta_cobro_id) }}" class="btn-apple btn-apple-secondary" style="padding: 6px 12px; font-size: 12px;">
                    Ver
                </a>
                @endif
            </div>
            @empty
            <div style="text-align: center; padding: 32px; color: var(--apple-text-muted);">
                <span class="material-symbols-rounded" style="font-size: 40px; opacity: 0.5; display: block; margin-bottom: 8px;">inbox</span>
                No hay actividad reciente
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
