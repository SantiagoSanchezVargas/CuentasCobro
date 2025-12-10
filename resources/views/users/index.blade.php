@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

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
        --radius-lg: 16px;
        --radius-md: 12px;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    body {
        background-color: var(--bg-body);
        color: var(--text-main);
        font-family: 'Inter', sans-serif;
    }

    /* Header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--secondary);
        letter-spacing: -0.025em;
        margin: 0;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid transparent;
        box-shadow: var(--shadow-sm);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
        color: white;
    }

    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: var(--bg-card);
        padding: 24px;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 28px;
        color: white;
    }

    .stat-content h4 {
        font-size: 24px;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
        color: var(--secondary);
    }

    .stat-content p {
        font-size: 14px;
        color: var(--text-light);
        margin: 4px 0 0 0;
        font-weight: 500;
    }

    /* Gradients */
    .bg-gradient-blue { background: linear-gradient(135deg, #116dff, #3b82f6); }
    .bg-gradient-green { background: linear-gradient(135deg, #10b981, #34d399); }
    .bg-gradient-orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .table-header-section {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        background: #f8fafc;
    }

    .table-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--secondary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-box {
        position: relative;
        width: 300px;
    }

    .search-box input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
        background: white;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(17, 109, 255, 0.1);
    }

    .search-box .material-symbols-rounded {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
        font-size: 20px;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table th {
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

    .custom-table td {
        padding: 16px 24px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-main);
        font-size: 14px;
        vertical-align: middle;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .custom-table tr:hover td {
        background-color: #f8fafc;
    }

    /* User Avatar */
    .user-avatar-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar-small {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }

    /* Badges */
    .badge-role {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.025em;
    }

    .badge-primary { background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; } /* Blue */
    .badge-secondary { background: #f8fafc; color: #475569; border: 1px solid #e2e8f0; } /* Slate */
    .badge-success { background: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; } /* Green */
    .badge-danger { background: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2; } /* Red */
    .badge-warning { background: #fffbeb; color: #b45309; border: 1px solid #fef3c7; } /* Amber */
    .badge-info { background: #f0f9ff; color: #0369a1; border: 1px solid #e0f2fe; } /* Sky */
    .badge-indigo { background: #eef2ff; color: #4338ca; border: 1px solid #e0e7ff; } /* Indigo */
    .badge-purple { background: #faf5ff; color: #7e22ce; border: 1px solid #f3e8ff; } /* Purple */
    .badge-pink { background: #fdf2f8; color: #be185d; border: 1px solid #fce7f3; } /* Pink */
    .badge-teal { background: #f0fdfa; color: #0f766e; border: 1px solid #ccfbf1; } /* Teal */

    /* Actions */
    .table-actions {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .btn-icon {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1px solid transparent;
        transition: all 0.2s ease;
        background: transparent;
        color: var(--text-light);
    }

    .btn-icon:hover {
        background: #f1f5f9;
        color: var(--primary);
        transform: translateY(-1px);
    }

    .btn-icon-view:hover { background: #eff6ff; color: #1d4ed8; border-color: #dbeafe; }
    .btn-icon-edit:hover { background: #fff7ed; color: #c2410c; border-color: #ffedd5; }
    .btn-icon-delete:hover { background: #fef2f2; color: #b91c1c; border-color: #fee2e2; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 64px 24px;
    }

    .empty-icon {
        font-size: 64px;
        color: var(--text-light);
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--secondary);
        margin-bottom: 8px;
    }

    .empty-text {
        color: var(--text-light);
        margin-bottom: 24px;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">Gestión de Usuarios</h1>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">
            <span class="material-symbols-rounded">person_add</span>
            Nuevo Usuario
        </a>
    </div>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon bg-gradient-blue">
                <span class="material-symbols-rounded">group</span>
            </div>
            <div class="stat-content">
                <h4>{{ $users->count() }}</h4>
                <p>Total Usuarios</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-gradient-green">
                <span class="material-symbols-rounded">verified_user</span>
            </div>
            <div class="stat-content">
                <h4>{{ $users->whereNotNull('role_id')->count() }}</h4>
                <p>Con Rol Asignado</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-gradient-orange">
                <span class="material-symbols-rounded">person_off</span>
            </div>
            <div class="stat-content">
                <h4>{{ $users->whereNull('role_id')->count() }}</h4>
                <p>Sin Rol</p>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="table-card">
        <div class="table-header-section">
            <h3 class="table-title">
                <span class="material-symbols-rounded">list</span>
                Lista de Usuarios
            </h3>
            <div class="search-box">
                <span class="material-symbols-rounded">search</span>
                <input type="text" id="searchInput" placeholder="Buscar por nombre o email..." onkeyup="searchTable()">
            </div>
        </div>

        <div class="table-responsive">
            @if($users->count() > 0)
                <table class="custom-table" id="usersTable">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Fecha Registro</th>
                            <th style="text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="user-avatar-cell">
                                        <div class="user-avatar-small">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                        <span class="fw-semibold">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="text-muted">{{ $user->email }}</td>
                                <td>
                                    @if($user->role)
                                        @php
                                            $roleColor = match(strtolower($user->role->name)) {
                                                'super administrador' => 'danger',
                                                'administrador' => 'primary',
                                                'admin programa' => 'indigo',
                                                'auxiliar' => 'info',
                                                'tesoreria' => 'pink',
                                                'contratista' => 'success',
                                                'ordenador de gasto' => 'warning',
                                                'alcalde' => 'teal',
                                                'supervisor' => 'purple',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge-role badge-{{ $roleColor }}">
                                            {{ $user->role->name }}
                                        </span>
                                    @else
                                        <span class="badge-role badge-secondary">Sin rol</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('admin.users.show', $user) }}" class="btn-icon btn-icon-view" title="Ver detalles">
                                            <span class="material-symbols-rounded">visibility</span>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn-icon btn-icon-edit" title="Editar usuario">
                                            <span class="material-symbols-rounded">edit</span>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este usuario?')" class="btn-icon btn-icon-delete" title="Eliminar usuario">
                                                <span class="material-symbols-rounded">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <span class="material-symbols-rounded empty-icon">group_off</span>
                    <h2 class="empty-title">No hay usuarios registrados</h2>
                    <p class="empty-text">Comienza agregando tu primer usuario al sistema</p>
                    <a href="{{ route('admin.users.create') }}" class="btn-primary">
                        <span class="material-symbols-rounded">person_add</span>
                        Crear Primer Usuario
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function searchTable() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toUpperCase();
    const table = document.getElementById('usersTable');
    if (!table) return;
    
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName('td');
        let found = false;
        
        for (let j = 0; j < td.length; j++) {
            if (td[j]) {
                const txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        
        tr[i].style.display = found ? '' : 'none';
    }
}
</script>

@endsection
