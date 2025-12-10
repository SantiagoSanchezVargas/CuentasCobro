@extends('layouts.app')

@section('title', 'Reportes - Admin')

@section('content')
<style>
    /* Professional Enterprise Design System (Matching Auxiliar Role) */
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

    body {
        background-color: var(--bg-body);
        color: var(--text-main);
        font-family: 'Inter', sans-serif;
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: var(--secondary);
        letter-spacing: -0.025em;
        margin: 0;
    }

    .page-subtitle {
        font-size: 15px;
        color: var(--text-light);
        margin-top: 4px;
    }

    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 24px;
    }

    .report-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        padding: 32px;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .report-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary);
    }

    .report-icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
        font-size: 36px;
        color: white;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .gradient-green { background: linear-gradient(135deg, #10b981, #34d399); }
    .gradient-blue { background: linear-gradient(135deg, #116dff, #3b82f6); }
    .gradient-orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); }

    .report-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--secondary);
        margin-bottom: 12px;
    }

    .report-desc {
        font-size: 15px;
        color: var(--text-light);
        line-height: 1.5;
        margin-bottom: 24px;
        flex-grow: 1;
    }

    .btn-report {
        background: #eff6ff;
        color: var(--primary);
        border: none;
        padding: 12px 24px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-report:hover {
        background: var(--primary);
        color: white;
    }

    .btn-report.disabled {
        opacity: 0.6;
        cursor: not-allowed;
        background: #f1f5f9;
        color: #94a3b8;
    }

    .badge-coming-soon {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #f1f5f9;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 100px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="page-header">
        <div>
            <h1 class="page-title">Reportes del Sistema</h1>
            <p class="page-subtitle">Seleccione el tipo de reporte que desea consultar y analizar.</p>
        </div>
    </div>

    <div class="reports-grid">
        <!-- Financieros -->
        <div class="report-card">
            <div class="report-icon-wrapper gradient-green">
                <span class="material-symbols-rounded">payments</span>
            </div>
            <h3 class="report-title">Reportes Financieros</h3>
            <p class="report-desc">
                Consolidado detallado de cuentas de cobro, pagos realizados, pendientes y proyecciones financieras por periodo.
            </p>
            <a href="{{ route('reportes.index') }}" class="btn-report">
                Ver Reportes
                <span class="material-symbols-rounded" style="font-size: 18px;">arrow_forward</span>
            </a>
        </div>

        <!-- Usuarios -->
        <div class="report-card">
            <span class="badge-coming-soon">Próximamente</span>
            <div class="report-icon-wrapper gradient-blue">
                <span class="material-symbols-rounded">group_add</span>
            </div>
            <h3 class="report-title">Métricas de Usuarios</h3>
            <p class="report-desc">
                Análisis de crecimiento de usuarios, distribución por roles, actividad reciente y retención en la plataforma.
            </p>
            <button class="btn-report disabled">
                En Desarrollo
            </button>
        </div>

        <!-- Auditoría -->
        <div class="report-card">
            <span class="badge-coming-soon">Próximamente</span>
            <div class="report-icon-wrapper gradient-orange">
                <span class="material-symbols-rounded">history_edu</span>
            </div>
            <h3 class="report-title">Auditoría y Logs</h3>
            <p class="report-desc">
                Registro completo de acciones críticas, cambios en permisos y trazabilidad de operaciones en el sistema.
            </p>
            <button class="btn-report disabled">
                En Desarrollo
            </button>
        </div>
    </div>
</div>
@endsection
