@extends('layouts.app')

@section('title', 'Panel de Tesorería')

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
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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

    .stat-meta {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: var(--text-light);
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 24px;
    }

    .content-card {
        background: var(--bg-card);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        padding: 24px;
    }

    .card-header {
        margin-bottom: 20px;
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--secondary);
    }

    /* Action List */
    .action-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .action-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #f8fafc;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid transparent;
    }

    .action-item:hover {
        background: white;
        border-color: var(--primary);
        box-shadow: var(--shadow-sm);
        transform: translateX(4px);
    }

    .action-icon {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        box-shadow: var(--shadow-sm);
    }

    .action-content h4 {
        color: var(--secondary);
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 2px;
    }

    .action-content p {
        color: var(--text-light);
        font-size: 13px;
    }

    /* Table */
    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table th {
        background: #f8fafc;
        padding: 12px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-light);
        text-transform: uppercase;
        border-bottom: 1px solid var(--border-color);
    }

    .custom-table td {
        padding: 12px 16px;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-main);
        font-size: 14px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 6px;
        background: var(--primary);
        color: white;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .btn-sm:hover { background: var(--primary-dark); }

    @media (max-width: 1024px) {
        .content-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="main-container">
    <!-- Header -->
    <div class="page-header">
        <div class="page-title">
            <h1>Panel de Tesorería</h1>
            <p class="page-subtitle">Gestión de pagos y recaudos</p>
        </div>
        <div style="background: white; padding: 8px 16px; border-radius: 99px; border: 1px solid var(--border-color); display: flex; align-items: center; gap: 8px; color: var(--text-light); font-weight: 500;">
            <span class="material-symbols-rounded">calendar_today</span>
            {{ now()->format('d M, Y') }}
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <!-- Por Pagar -->
        <div class="stat-card">
            <div class="stat-icon" style="background: #fffbeb; color: var(--warning);">
                <span class="material-symbols-rounded">pending_actions</span>
            </div>
            <div class="stat-value">{{ $porPagar }}</div>
            <div class="stat-label">Cuentas Por Pagar</div>
            <div class="stat-meta">
                <span>Total Pendiente</span>
                <span style="font-weight: 600; color: var(--secondary);">${{ number_format($valorPorPagar, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Pagos Realizados -->
        <div class="stat-card">
            <div class="stat-icon" style="background: #ecfdf5; color: var(--success);">
                <span class="material-symbols-rounded">check_circle</span>
            </div>
            <div class="stat-value">{{ $pagosMes }}</div>
            <div class="stat-label">Pagos Realizados (Mes)</div>
            <div class="stat-meta">
                <span>Total Pagado</span>
                <span style="font-weight: 600; color: var(--secondary);">${{ number_format($valorPagadoMes, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="content-grid">
        <!-- Quick Actions -->
        <div class="content-card">
            <div class="card-header">
                <h2 class="card-title">Acciones Rápidas</h2>
            </div>
            <div class="action-list">
                <a href="{{ route('cuentas_cobro.index') }}" class="action-item">
                    <div class="action-icon">
                        <span class="material-symbols-rounded">receipt_long</span>
                    </div>
                    <div class="action-content">
                        <h4>Todas las Cuentas</h4>
                        <p>Ver historial completo</p>
                    </div>
                </a>
                
                <a href="{{ route('cuentas_cobro.index', ['estado' => 'aprobada']) }}" class="action-item">
                    <div class="action-icon">
                        <span class="material-symbols-rounded">payments</span>
                    </div>
                    <div class="action-content">
                        <h4>Por Pagar</h4>
                        <p>Cuentas aprobadas</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Chart & Table -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Chart -->
            <div class="content-card">
                <div class="card-header">
                    <h2 class="card-title">Resumen Financiero</h2>
                </div>
                <div style="height: 250px; width: 100%;">
                    <canvas id="financialChart"></canvas>
                </div>
            </div>

            <!-- Table -->
            <div class="content-card">
                <div class="card-header">
                    <h2 class="card-title">Cuentas Aprobadas (Por Enviar)</h2>
                </div>
                <div style="overflow-x: auto;">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Cuenta</th>
                                <th>Contratista</th>
                                <th>Valor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cuentasPorPagar as $cuenta)
                            <tr>
                                <td>#{{ $cuenta->numero ?? $cuenta->id }}</td>
                                <td>{{ $cuenta->user->name ?? 'N/A' }}</td>
                                <td>${{ number_format($cuenta->valor_total, 0, ',', '.') }}</td>
                                <td>
                                    <button onclick="openEmailModal('{{ $cuenta->id }}', '{{ $cuenta->user->email ?? '' }}')" class="btn-sm">
                                        <span class="material-symbols-rounded" style="font-size: 16px;">send</span> Enviar a Usuario (DIAN)
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 24px; color: var(--text-light);">
                                    No hay cuentas pendientes de envío.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal -->
<div id="emailModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 24px; border-radius: 12px; width: 100%; max-width: 500px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <h2 style="font-size: 20px; font-weight: 700; color: var(--secondary);">Enviar Cuenta para Trámite DIAN</h2>
            <span onclick="closeEmailModal()" style="cursor: pointer; font-size: 24px;">&times;</span>
        </div>
        <form id="emailForm" method="POST">
            @csrf
            <p style="color: var(--text-light); margin-bottom: 16px; font-size: 14px;">Se enviará la cuenta de cobro aprobada al usuario para que proceda con la facturación electrónica (DIAN).</p>
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 14px; font-weight: 600; color: var(--secondary); margin-bottom: 8px;">Correo Electrónico</label>
                <input type="email" name="email" id="emailInput" required style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 8px;">
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeEmailModal()" style="padding: 10px 20px; border-radius: 8px; background: white; border: 1px solid var(--border-color); cursor: pointer;">Cancelar</button>
                <button type="submit" style="padding: 10px 20px; border-radius: 8px; background: var(--primary); color: white; border: none; cursor: pointer;">Enviar Correo</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function openEmailModal(id, email) {
        const form = document.getElementById('emailForm');
        form.action = `/dashboard/tesoreria/enviar/${id}`;
        document.getElementById('emailInput').value = email;
        document.getElementById('emailModal').style.display = 'flex';
    }

    function closeEmailModal() {
        document.getElementById('emailModal').style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('financialChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Por Pagar', 'Pagado'],
                datasets: [{
                    data: [{{ $valorPorPagar }}, {{ $valorPagadoMes }}],
                    backgroundColor: [
                        '#f59e0b',
                        '#10b981'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endsection
