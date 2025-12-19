@extends('layouts.app')

@section('title', 'Matriz de Permisos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/views/permisos.css') }}">
@endpush

@section('content')
<div class="container">
    <!-- Header con gradiente oscuro -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-icon">
                <span class="material-symbols-rounded">admin_panel_settings</span>
            </div>
            <div class="header-text">
                <h1>Matriz de Permisos Granulares</h1>
                <p>Gestión avanzada de capacidades por rol y etapa del flujo</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.roles.index') }}" class="btn-header">
                <span class="material-symbols-rounded">arrow_back</span>
                Volver a Roles
            </a>
            <a href="{{ route('admin.permisos.create') }}" class="btn-header primary">
                <span class="material-symbols-rounded">add</span>
                Nuevo Permiso
            </a>
        </div>
    </div>

    <!-- Info Banner - Etapas del Flujo -->
    <div class="info-banner" style="background: linear-gradient(135deg, rgba(0, 181, 226, 0.08), rgba(0, 151, 190, 0.05)); border: 1px solid rgba(0, 181, 226, 0.2); border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
        <span class="material-symbols-rounded" style="color: #00b5e2; font-size: 24px;">info</span>
        <div>
            <strong style="color: #0097be;">Flujo de Aprobación:</strong>
            <span style="color: #475569;"> Auxiliar → Administrador → Tesorería (Pago)</span>
        </div>
    </div>

    @foreach($roles as $role)
        <div class="role-section">
            <div class="role-title">
                <span class="material-symbols-rounded" style="color: var(--primary-blue);">
                    @switch($role->name)
                        @case('super_admin') admin_panel_settings @break
                        @case('admin_programa') manage_accounts @break
                        @case('administrador') admin_panel_settings @break
                        @case('tesoreria') account_balance @break
                        @case('auxiliar') support_agent @break
                        @default badge
                    @endswitch
                </span>
                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                <span class="role-badge">{{ $permisosPorRol[$role->name]->count() }} Configuraciones</span>
            </div>

            @if($permisosPorRol[$role->name]->count() > 0)
                <div class="permissions-table-wrapper">
                    <table class="permissions-table">
                        <thead>
                            <tr>
                                <th>Etapa / Contexto</th>
                                <th text-align="center">Crear</th>
                                <th text-align="center">Leer</th>
                                <th text-align="center">Editar</th>
                                <th text-align="center">Eliminar</th>
                                <th text-align="center">Aprobar</th>
                                <th text-align="center">Rechazar</th>
                                <th text-align="center">Pagos</th>
                                <th text-align="center">Docs</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permisosPorRol[$role->name] as $permiso)
                                <tr>
                                    <td>
                                        <strong>{{ $permiso->etapa_flujo ? ucfirst(str_replace('_', ' ', $permiso->etapa_flujo)) : 'General / Global' }}</strong>
                                        @if($permiso->descripcion)
                                            <div style="font-size: 12px; color: var(--slate-500);">{{ $permiso->descripcion }}</div>
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="material-symbols-rounded {{ $permiso->puede_crear ? 'check-icon' : 'cross-icon' }}">
                                            {{ $permiso->puede_crear ? 'check_circle' : 'cancel' }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="material-symbols-rounded {{ $permiso->puede_leer ? 'check-icon' : 'cross-icon' }}">
                                            {{ $permiso->puede_leer ? 'check_circle' : 'cancel' }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="material-symbols-rounded {{ $permiso->puede_editar ? 'check-icon' : 'cross-icon' }}">
                                            {{ $permiso->puede_editar ? 'check_circle' : 'cancel' }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="material-symbols-rounded {{ $permiso->puede_eliminar ? 'check-icon' : 'cross-icon' }}">
                                            {{ $permiso->puede_eliminar ? 'check_circle' : 'cancel' }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="material-symbols-rounded {{ $permiso->puede_aprobar ? 'check-icon' : 'cross-icon' }}">
                                            {{ $permiso->puede_aprobar ? 'check_circle' : 'cancel' }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="material-symbols-rounded {{ $permiso->puede_rechazar ? 'check-icon' : 'cross-icon' }}">
                                            {{ $permiso->puede_rechazar ? 'check_circle' : 'cancel' }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="material-symbols-rounded {{ $permiso->puede_registrar_pago ? 'check-icon' : 'cross-icon' }}">
                                            {{ $permiso->puede_registrar_pago ? 'check_circle' : 'cancel' }}
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="material-symbols-rounded {{ ($permiso->puede_subir_documentos || $permiso->puede_descargar_documentos) ? 'check-icon' : 'cross-icon' }}">
                                            {{ ($permiso->puede_subir_documentos || $permiso->puede_descargar_documentos) ? 'check_circle' : 'cancel' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 4px;">
                                            <a href="{{ route('admin.permisos.edit', $permiso->id) }}" class="btn-icon" title="Editar">
                                                <span class="material-symbols-rounded">edit</span>
                                            </a>
                                            <form action="{{ route('admin.permisos.destroy', $permiso->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta configuración?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon" style="color: #ef4444;" title="Eliminar">
                                                    <span class="material-symbols-rounded">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <span class="material-symbols-rounded" style="font-size: 48px; opacity: 0.5; margin-bottom: 16px;">rule_settings</span>
                    <p>No hay permisos granulares configurados para este rol.</p>
                    <button onclick="aplicarPlantilla({{ $role->id }})" class="btn-header" style="background: var(--primary-blue); color: white; margin: 16px auto; display: inline-flex;">
                        Aplicar Plantilla Recomendada
                    </button>
                </div>
            @endif
        </div>
    @endforeach
</div>

<script>
    function aplicarPlantilla(roleId) {
        // Implementar lógica para llamar a la API de plantillas
        // Por ahora redirigir a crear
        window.location.href = "{{ route('admin.permisos.create') }}?role_id=" + roleId;
    }
</script>
@endsection
