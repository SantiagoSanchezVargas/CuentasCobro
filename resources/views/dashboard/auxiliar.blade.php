@extends('layouts.app')

@section('title', 'Dashboard Auxiliar - Dewey Accounts')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .main-content {
        background-color: var(--bg-body);
        padding: 40px;
        font-family: 'Inter', sans-serif;
    }

    /* Typography */
    h1, h2, h3, h4 {
        color: var(--secondary);
        letter-spacing: -0.025em;
    }

    /* Hero Section */
    .hero-section {
        background: white;
        border-radius: var(--radius-lg);
        padding: 32px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 600px;
        margin: 0 auto;
    }

    .hero-title {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 8px;
        color: var(--secondary);
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 16px;
        color: var(--text-light);
        margin-bottom: 24px;
        line-height: 1.6;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1px solid transparent;
        box-shadow: 0 4px 6px rgba(17, 109, 255, 0.2);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 12px rgba(17, 109, 255, 0.25);
        color: white;
    }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 48px;
    }

    @media (max-width: 1024px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Action Cards Row */
    .action-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    /* Action Cards */
    .action-card {
        background: var(--bg-card);
        border-radius: var(--radius-md);
        padding: 24px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }

    .card-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        transition: transform 0.3s ease;
    }
    
    .action-card:hover .card-icon-wrapper {
        transform: scale(1.1);
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--secondary);
    }

    .card-description {
        color: var(--text-light);
        font-size: 14px;
        margin-bottom: 16px;
        line-height: 1.5;
        flex-grow: 1;
    }

    .card-link {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
    }

    .card-link:hover {
        color: var(--primary-dark);
        gap: 10px; /* subtle animation */
    }

    /* Proyeccion Card */
    .proyeccion-card {
        background-color: #1e293b; /* Slate 800 */
        color: white;
        padding: 32px;
        border-radius: var(--radius-lg);
        margin-bottom: 24px;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }

    .proyeccion-card::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.05));
        pointer-events: none;
    }

    /* Chart Card */
    .chart-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 24px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        height: 100%;
        min-height: 300px;
        display: flex;
        flex-direction: column;
    }

    /* Recent Activity Table */
    .table-card {
        background: white;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
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
        padding: 20px 24px;
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

    .status-pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Support Button */
    .support-btn {
        position: fixed;
        bottom: 32px;
        left: 32px;
        z-index: 100;
        background: #25D366;
        color: white;
        border: none;
        border-radius: 50%;
        width: 64px;
        height: 64px;
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .support-btn:hover {
        transform: scale(1.1) rotate(10deg);
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.5);
    }

    .support-menu {
        display: none;
        position: fixed;
        bottom: 110px;
        left: 32px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 40px -5px rgba(0,0,0,0.15);
        width: 320px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        z-index: 99;
        animation: slideUp 0.3s ease-out;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Decorative Background Pattern */
    .bg-pattern {
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 40%;
        background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
        background-size: 20px 20px;
        opacity: 0.3;
        mask-image: linear-gradient(to left, black, transparent);
        -webkit-mask-image: linear-gradient(to left, black, transparent);
    }
</style>

<div class="hero-section">
    <div class="bg-pattern"></div>
    <div class="hero-content">
        <h1 class="hero-title">Hola, {{ Auth::user()->name }}</h1>
        <p class="hero-subtitle">Bienvenido a tu panel de control. Gestiona tus cuentas de cobro, revisa estados y mantén tu información al día.</p>
        <a href="{{ route('cuentas_cobro.create') }}" class="btn-primary">
            <span class="material-symbols-rounded">add_circle</span>
            Crear Nueva Cuenta
        </a>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Left Column: Stats & Actions -->
    <div>
        <!-- Proyección de Pagos Widget -->
        <div class="proyeccion-card">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
                <div style="background: rgba(255,255,255,0.1); padding: 8px; border-radius: 8px;">
                    <span class="material-symbols-rounded" style="color: #38bdf8;">account_balance_wallet</span>
                </div>
                <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: white;">Proyección de Pagos</h3>
            </div>
            <div style="font-size: 48px; font-weight: 800; margin-bottom: 12px; letter-spacing: -1px;">
                $ {{ number_format($proyeccionPagos ?? 0, 0, ',', '.') }}
            </div>
            <p style="color: #94a3b8; margin: 0; font-size: 15px; max-width: 80%;">
                Valor total en cuentas aprobadas pendientes de pago.
            </p>
        </div>

        <!-- Action Cards -->
        <div class="action-row">
            <!-- Card 1: Crear -->
            <div class="action-card">
                <div class="card-icon-wrapper" style="background: #eff6ff; color: var(--primary);">
                    <span class="material-symbols-rounded" style="font-size: 28px;">post_add</span>
                </div>
                <h3 class="card-title">Nueva Cuenta</h3>
                <p class="card-description">Inicia el proceso de cobro generando un nuevo documento.</p>
                <a href="{{ route('cuentas_cobro.create') }}" class="card-link">
                    Comenzar <span class="material-symbols-rounded" style="font-size: 18px;">arrow_forward</span>
                </a>
            </div>

            <!-- Card 2: Mis Cuentas -->
            <div class="action-card">
                <div class="card-icon-wrapper" style="background: #fdf2f8; color: #db2777;">
                    <span class="material-symbols-rounded" style="font-size: 28px;">folder_open</span>
                </div>
                <h3 class="card-title">Mis Documentos</h3>
                <p class="card-description">Accede al historial completo y verifica estados.</p>
                <a href="{{ route('cuentas_cobro.index') }}" class="card-link" style="color: #db2777;">
                    Ver historial <span class="material-symbols-rounded" style="font-size: 18px;">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 class="section-title" style="font-size: 20px; font-weight: 700; margin: 0;">Cuentas Recientes</h3>
                <a href="{{ route('cuentas_cobro.index') }}" style="color: var(--primary); text-decoration: none; font-size: 14px; font-weight: 600;">Ver todas</a>
            </div>
            <div class="table-card">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Referencia</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th style="text-align: right;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\CuentaCobro::where('user_id', Auth::id())->latest()->take(5)->get() as $cuenta)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: var(--secondary);">{{ $cuenta->numero ?? 'Borrador' }}</div>
                            </td>
                            <td style="color: var(--text-light);">
                                {{ $cuenta->created_at->format('d M, Y') }}
                            </td>
                            <td>
                                @php
                                    $colors = [
                                        'pendiente' => ['bg' => '#fff7ed', 'text' => '#c2410c'],
                                        'en_revision' => ['bg' => '#eff6ff', 'text' => '#1d4ed8'],
                                        'aprobado' => ['bg' => '#f0fdf4', 'text' => '#15803d'],
                                        'rechazado' => ['bg' => '#fef2f2', 'text' => '#b91c1c'],
                                        'pagado' => ['bg' => '#ecfdf5', 'text' => '#047857']
                                    ];
                                    $statusColor = $colors[$cuenta->estado_aprobacion] ?? ['bg' => '#f1f5f9', 'text' => '#64748b'];
                                @endphp
                                <span class="status-pill" style="background-color: {{ $statusColor['bg'] }}; color: {{ $statusColor['text'] }};">
                                    {{ ucfirst(str_replace('_', ' ', $cuenta->estado_aprobacion)) }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('cuentas_cobro.show', $cuenta->id) }}" style="color: var(--primary); text-decoration: none; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 4px;">
                                    Ver <span class="material-symbols-rounded" style="font-size: 16px;">chevron_right</span>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 40px; text-align: center; color: var(--text-light);">
                                No tienes cuentas de cobro recientes.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Charts -->
    <div>
        <div class="chart-card">
            <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 24px; color: var(--secondary);">Estado de Cuentas</h3>
            <div style="position: relative; height: 250px; width: 100%; display: flex; justify-content: center;">
                <canvas id="statusChart"></canvas>
            </div>
            <div style="margin-top: 24px; display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #f8fafc; border-radius: 8px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 10px; height: 10px; border-radius: 50%; background: #10b981;"></div>
                        <span style="font-size: 14px; color: var(--text-main); font-weight: 500;">Aprobadas</span>
                    </div>
                    <span style="font-weight: 700; color: var(--secondary);">{{ $cuentasAprobadas ?? 0 }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #f8fafc; border-radius: 8px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 10px; height: 10px; border-radius: 50%; background: #3b82f6;"></div>
                        <span style="font-size: 14px; color: var(--text-main); font-weight: 500;">En Revisión</span>
                    </div>
                    <span style="font-weight: 700; color: var(--secondary);">{{ $cuentasEnRevision ?? 0 }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; background: #f8fafc; border-radius: 8px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444;"></div>
                        <span style="font-size: 14px; color: var(--text-main); font-weight: 500;">Rechazadas</span>
                    </div>
                    <span style="font-weight: 700; color: var(--secondary);">{{ $cuentasRechazadas ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Support Widget -->
<button class="support-btn" onclick="toggleSupport()" title="Centro de Ayuda">
    <span class="material-symbols-rounded" style="font-size: 32px;">forum</span>
</button>

<div id="support-menu" class="support-menu">
    <div style="background: #1e293b; padding: 20px; color: white;">
        <h4 style="margin: 0; font-size: 16px; font-weight: 600;">Centro de Soporte</h4>
        <p style="margin: 4px 0 0; font-size: 13px; opacity: 0.8;">¿Necesitas ayuda con tus cuentas?</p>
    </div>
    <div style="padding: 20px;">
        <a href="https://wa.me/573172831316?text=Hola%20Soporte%2C%20necesito%20ayuda%20con%20mi%20cuenta%20de%20cobro." target="_blank" style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #f0fdf4; border-radius: 12px; text-decoration: none; color: #15803d; margin-bottom: 12px; transition: background 0.2s; border: 1px solid #dcfce7;">
            <span class="material-symbols-rounded">chat</span>
            <div>
                <div style="font-weight: 600; font-size: 14px;">WhatsApp Soporte</div>
                <div style="font-size: 12px; opacity: 0.9;">Chat directo con admin</div>
            </div>
        </a>
        
        <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #f1f5f9;">
            <p style="font-size: 12px; font-weight: 600; color: var(--text-light); margin-bottom: 8px; text-transform: uppercase;">Solicitudes Rápidas</p>
            <a href="https://wa.me/573172831316?text=Hola%20Admin%2C%20solicito%20permisos%20adicionales%20para..." target="_blank" style="display: block; padding: 8px 0; color: var(--text-main); text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                <span class="material-symbols-rounded" style="font-size: 18px; color: var(--primary);">lock_person</span>
                Solicitar Permisos
            </a>
            <a href="https://wa.me/573172831316?text=Hola%20Admin%2C%20tengo%20una%20duda%20sobre%20el%20estado%20de%20mi%20cuenta..." target="_blank" style="display: block; padding: 8px 0; color: var(--text-main); text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                <span class="material-symbols-rounded" style="font-size: 18px; color: var(--warning);">help</span>
                Consultar Estado
            </a>
        </div>
    </div>
</div>

<script>
    // Toggle Support Menu
    function toggleSupport() {
        const menu = document.getElementById('support-menu');
        if (menu.style.display === 'block') {
            menu.style.display = 'none';
        } else {
            menu.style.display = 'block';
        }
    }

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('support-menu');
        const btn = document.querySelector('.support-btn');
        if (menu.style.display === 'block' && !menu.contains(event.target) && !btn.contains(event.target)) {
            menu.style.display = 'none';
        }
    });

    // Initialize Chart
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Aprobadas', 'En Revisión', 'Rechazadas'],
                datasets: [{
                    data: [
                        {{ $cuentasAprobadas ?? 0 }}, 
                        {{ $cuentasEnRevision ?? 0 }}, 
                        {{ $cuentasRechazadas ?? 0 }}
                    ],
                    backgroundColor: [
                        '#10b981', // Success
                        '#3b82f6', // Blue
                        '#ef4444'  // Red
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true
                    }
                }
            }
        });
    });
</script>
@endsection
