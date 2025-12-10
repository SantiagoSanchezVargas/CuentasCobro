@extends('layouts.app')

@section('title', 'Dashboard - Dewey Accounts')

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
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .main-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px;
        font-family: 'Inter', sans-serif;
    }

    /* Header */
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

    .page-subtitle {
        color: var(--text-light);
        font-size: 16px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: var(--bg-card);
        border-radius: var(--radius-md);
        padding: 24px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
        text-decoration: none;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }
    .stat-icon span { font-size: 24px; }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: var(--secondary);
        margin-bottom: 4px;
        line-height: 1;
    }

    .stat-label {
        font-size: 13px;
        color: var(--text-light);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Section Headers */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        margin-top: 40px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--secondary);
    }

    /* Table */
    .table-container {
        background: var(--bg-card);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
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
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border-color);
    }

    .custom-table td {
        padding: 16px 24px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-main);
        font-size: 14px;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .avatar {
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

    .badge {
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-primary { background: #eff6ff; color: var(--primary); }
    .badge-success { background: #ecfdf5; color: var(--success); }
    .badge-warning { background: #fffbeb; color: var(--warning); }
    .badge-danger { background: #fef2f2; color: var(--danger); }
    .badge-gray { background: #f1f5f9; color: var(--text-light); }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }
    .btn-primary:hover { background: var(--primary-dark); }

    .btn-secondary {
        background: white;
        border-color: var(--border-color);
        color: var(--text-main);
    }
    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }
</style>

<div class="main-container">
    <!-- Hero Section -->
    <div class="page-header">
        <div class="page-title">
            <h1>¡Hola, {{ Auth::user()->name }}! 👋</h1>
            <p class="page-subtitle">Gestiona tus cuentas de cobro de manera eficiente y profesional</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('cuentas_cobro.create') }}" class="btn btn-primary">
                <span class="material-symbols-rounded">add_circle</span> Nueva Cuenta
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <a href="{{ route('admin.users.index') }}" class="stat-card">
            <div class="stat-icon" style="background: #eff6ff; color: var(--primary);">
                <span class="material-symbols-rounded">group</span>
            </div>
            <div class="stat-value">{{ $totalUsers ?? 0 }}</div>
            <div class="stat-label">Usuarios Activos</div>
        </a>

        <a href="{{ route('cuentas_cobro.index') }}" class="stat-card">
            <div class="stat-icon" style="background: #ecfdf5; color: var(--success);">
                <span class="material-symbols-rounded">receipt_long</span>
            </div>
            <div class="stat-value">{{ $totalCuentas ?? 0 }}</div>
            <div class="stat-label">Cuentas de Cobro</div>
        </a>

        <a href="{{ route('cuentas_cobro.pagos') }}" class="stat-card">
            <div class="stat-icon" style="background: #fffbeb; color: var(--warning);">
                <span class="material-symbols-rounded">payments</span>
            </div>
            <div class="stat-value">{{ $totalPagos ?? 0 }}</div>
            <div class="stat-label">Pagos Procesados</div>
        </a>

        <div class="stat-card">
            <div class="stat-icon" style="background: #fef2f2; color: var(--danger);">
                <span class="material-symbols-rounded">admin_panel_settings</span>
            </div>
            <div class="stat-value">{{ $totalRoles ?? 0 }}</div>
            <div class="stat-label">Roles Disponibles</div>
        </div>
    </div>

    <!-- Recent Users Section -->
    <div class="section-header">
        <h2 class="section-title">Actividad Reciente</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            Ver Todos <span class="material-symbols-rounded">arrow_forward</span>
        </a>
    </div>

    <div class="table-container">
        @if(isset($recentUsers) && $recentUsers->count() > 0)
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Fecha Registro</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $recentUser)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="avatar">{{ strtoupper(substr($recentUser->name, 0, 1)) }}</div>
                                <div>
                                    <div style="font-weight: 600;">{{ $recentUser->name }}</div>
                                    <div style="font-size: 12px; color: var(--text-light);">ID: #{{ $recentUser->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $recentUser->email }}</td>
                        <td>
                            @if($recentUser->role)
                                <span class="badge badge-primary">
                                    {{ ucfirst($recentUser->role->name) }}
                                </span>
                            @else
                                <span class="badge badge-gray">Sin rol</span>
                            @endif
                        </td>
                        <td>{{ $recentUser->created_at->diffForHumans() }}</td>
                        <td>
                            <span class="badge badge-success">Activo</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="padding: 40px; text-align: center; color: var(--text-light);">
                <span class="material-symbols-rounded" style="font-size: 48px; opacity: 0.5;">group_off</span>
                <p>No hay usuarios recientes</p>
            </div>
        @endif
    </div>
</div>
@endsection
