@extends('layouts.app')

@section('title', 'Panel de Administración del Programa')

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-content">
            <h1>Panel de Administración</h1>
            <p class="subtitle">Control total del sistema y gestión de usuarios</p>
        </div>
        <div class="header-actions">
            <span class="date-badge">
                <i class="fas fa-calendar"></i>
                {{ now()->format('d M, Y') }}
            </span>
        </div>
    </header>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <!-- Total Usuarios -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-details">
                <h3>Total Usuarios</h3>
                <div class="stat-value">{{ $totalUsuarios }}</div>
                <div class="stat-meta">
                    <span class="trend up">
                        <i class="fas fa-user-check"></i>
                        {{ $usuariosConRol }}
                    </span>
                    <span class="period">Con Rol Asignado</span>
                </div>
            </div>
        </div>

        <!-- Solicitudes Pendientes -->
        <div class="stat-card warning">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-details">
                <h3>Solicitudes Pendientes</h3>
                <div class="stat-value">{{ $solicitudesPendientes }}</div>
                <div class="stat-meta">
                    <span class="period">De {{ $solicitudesTotal }} totales</span>
                </div>
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div class="stat-card success">
            <div class="stat-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="stat-details">
                <h3>Gestión</h3>
                <div class="stat-meta" style="margin-top: 0.5rem;">
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-600 hover:underline">Ver Usuarios</a>
                </div>
                <div class="stat-meta">
                    <a href="{{ route('admin.roles.index') }}" class="text-sm text-blue-600 hover:underline">Ver Roles</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Content Grid -->
    <div class="dashboard-content-grid">
        <!-- Recent Users -->
        <div class="content-section">
            <div class="section-header">
                <h2>Usuarios Recientes</h2>
                <a href="{{ route('admin.users.index') }}" class="action-link">Ver todos</a>
            </div>
            <div class="table-responsive">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuariosRecientes as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">{{ substr($user->name, 0, 1) }}</div>
                                    <div>
                                        <span class="user-name">{{ $user->name }}</span>
                                        <span class="user-email">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge {{ $user->role ? 'status-active' : 'status-pending' }}">
                                    {{ $user->role ? $user->role->name : 'Sin Rol' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No hay usuarios recientes</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="content-section">
            <div class="section-header">
                <h2>Estado de Solicitudes</h2>
            </div>
            <div class="chart-container">
                <canvas id="requestsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #0f172a;
        --secondary: #475569;
        --accent: #3b82f6;
        --success: #22c55e;
        --warning: #eab308;
        --danger: #ef4444;
        --background: #f8fafc;
        --surface: #ffffff;
        --border: #e2e8f0;
    }

    .dashboard-container {
        padding: 2rem;
        max-width: 1600px;
        margin: 0 auto;
        background-color: var(--background);
        min-height: calc(100vh - 64px);
    }

    /* Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
    }

    .header-content h1 {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }

    .subtitle {
        color: var(--secondary);
        font-size: 1rem;
    }

    .date-badge {
        background: var(--surface);
        padding: 0.75rem 1.25rem;
        border-radius: 9999px;
        border: 1px solid var(--border);
        color: var(--secondary);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card {
        background: var(--surface);
        padding: 1.5rem;
        border-radius: 1rem;
        border: 1px solid var(--border);
        display: flex;
        gap: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }

    .stat-icon {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 0.75rem;
        background: #f1f5f9;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .stat-card.warning .stat-icon {
        background: #fef9c3;
        color: var(--warning);
    }

    .stat-card.success .stat-icon {
        background: #dcfce7;
        color: var(--success);
    }

    .stat-details {
        flex: 1;
    }

    .stat-details h3 {
        color: var(--secondary);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
    }

    .trend {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-weight: 600;
    }

    .trend.up { color: var(--success); }

    .period {
        color: var(--secondary);
    }

    /* Content Grid */
    .dashboard-content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }

    .content-section {
        background: var(--surface);
        border-radius: 1rem;
        border: 1px solid var(--border);
        padding: 1.5rem;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .section-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary);
    }

    .action-link {
        color: var(--accent);
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
    }

    .action-link:hover {
        text-decoration: underline;
    }

    /* Table */
    .table-responsive {
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
    }

    .dashboard-table th {
        text-align: left;
        padding: 0.75rem 1rem;
        color: var(--secondary);
        font-weight: 500;
        font-size: 0.875rem;
        border-bottom: 1px solid var(--border);
    }

    .dashboard-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border);
        color: var(--primary);
    }

    .dashboard-table tr:last-child td {
        border-bottom: none;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-avatar {
        width: 2.5rem;
        height: 2.5rem;
        background: var(--accent);
        color: white;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
    }

    .user-name {
        display: block;
        font-weight: 500;
        color: var(--primary);
    }

    .user-email {
        display: block;
        font-size: 0.8rem;
        color: var(--secondary);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-pending {
        background: #f1f5f9;
        color: #475569;
    }

    .chart-container {
        height: 300px;
        width: 100%;
    }

    @media (max-width: 1024px) {
        .dashboard-content-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('requestsChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pendientes', 'Procesadas'],
                datasets: [{
                    data: [{{ $solicitudesPendientes }}, {{ $solicitudesTotal - $solicitudesPendientes }}],
                    backgroundColor: [
                        '#eab308',
                        '#3b82f6'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
@endsection
