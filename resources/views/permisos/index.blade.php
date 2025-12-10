@extends('layouts.app')

@section('title', 'Matriz de Permisos')

@section('content')
<style>
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-300: #cbd5e1;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-600: #475569;
        --slate-700: #334155;
        --slate-800: #1e293b;
        --slate-900: #0f172a;
        --primary-blue: #116dff;
        --primary-hover: #0056d6;
        --purple-gradient: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
    }

    .page-header {
        background: var(--purple-gradient);
        border-radius: 24px;
        padding: 40px 32px;
        color: white;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 40px rgba(99, 102, 241, 0.2);
    }

    .header-content h1 {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .header-content p {
        font-size: 16px;
        opacity: 0.95;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 12px;
    }

    .btn-header {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        backdrop-filter: blur(8px);
        transition: all 0.2s;
    }

    .btn-header:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .role-section {
        background: white;
        border-radius: 18px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid var(--slate-200);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .role-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--slate-800);
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--slate-100);
    }

    .role-badge {
        font-size: 12px;
        padding: 4px 12px;
        border-radius: 20px;
        background: var(--slate-100);
        color: var(--slate-600);
        font-weight: 600;
        text-transform: uppercase;
    }

    .permissions-table-wrapper {
        overflow-x: auto;
    }

    .permissions-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .permissions-table th {
        text-align: left;
        padding: 12px;
        background: var(--slate-50);
        color: var(--slate-600);
        font-weight: 600;
        border-bottom: 2px solid var(--slate-200);
        white-space: nowrap;
    }

    .permissions-table td {
        padding: 12px;
        border-bottom: 1px solid var(--slate-100);
        color: var(--slate-700);
    }

    .check-icon {
        color: #10b981;
        font-weight: bold;
    }

    .cross-icon {
        color: var(--slate-300);
    }

    .btn-icon {
        padding: 6px;
        border-radius: 8px;
        border: none;
        background: transparent;
        cursor: pointer;
        color: var(--slate-500);
        transition: all 0.2s;
    }

    .btn-icon:hover {
        background: var(--slate-100);
        color: var(--primary-blue);
    }

    .empty-state {
        text-align: center;
        padding: 32px;
        color: var(--slate-400);
        font-style: italic;
    }
</style>

<div class="container">
    <div class="page-header">
        <div class="header-content">
            <h1>Matriz de Permisos Granulares</h1>
            <p>Gestión avanzada de capacidades por rol y etapa</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.roles.index') }}" class="btn-header">
                <span class="material-symbols-rounded">arrow_back</span>
                Volver a Roles
            </a>
            <a href="{{ route('admin.permisos.create') }}" class="btn-header" style="background: white; color: var(--primary-blue);">
                <span class="material-symbols-rounded">add</span>
                Nuevo Permiso
            </a>
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
