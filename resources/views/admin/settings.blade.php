@extends('layouts.app')

@section('title', 'Configuración - Admin')

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

    .settings-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 32px;
        align-items: start;
    }

    .settings-sidebar {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        padding: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: var(--text-main);
        border-radius: var(--radius-md);
        transition: all 0.2s;
        font-weight: 500;
        font-size: 14px;
        text-decoration: none;
        margin-bottom: 4px;
    }

    .nav-link:hover {
        background: #f1f5f9;
        color: var(--primary);
    }

    .nav-link.active {
        background: var(--primary);
        color: white;
        box-shadow: 0 4px 6px -1px rgba(17, 109, 255, 0.2);
    }

    .nav-link .material-symbols-rounded {
        font-size: 20px;
    }

    .settings-card {
        background: var(--bg-card);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .card-header {
        padding: 24px;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-card);
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--secondary);
        margin: 0;
    }

    .card-body {
        padding: 32px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 14px;
        transition: all 0.2s;
        background: #f8fafc;
        color: var(--text-main);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
        box-shadow: 0 0 0 3px rgba(17, 109, 255, 0.1);
    }

    .form-control:disabled {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .form-text {
        font-size: 13px;
        color: var(--text-light);
        margin-top: 6px;
    }

    .toggle-switch {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px;
        background: #f8fafc;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
    }

    .toggle-label {
        font-weight: 500;
        color: var(--secondary);
    }

    .btn-save {
        background: var(--primary);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 100px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(17, 109, 255, 0.2);
    }

    .btn-save:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 8px -1px rgba(17, 109, 255, 0.3);
    }

    .btn-save:disabled {
        background: #e2e8f0;
        color: #94a3b8;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="page-header">
        <h1 class="page-title">Configuración del Sistema</h1>
        <p class="page-subtitle">Administra las preferencias generales y parámetros de la aplicación.</p>
    </div>

    <div class="settings-layout">
        <!-- Sidebar -->
        <div class="settings-sidebar">
            <nav class="nav flex-column">
                <a href="#" class="nav-link active">
                    <span class="material-symbols-rounded">tune</span>
                    General
                </a>
                <a href="#" class="nav-link">
                    <span class="material-symbols-rounded">notifications</span>
                    Notificaciones
                </a>
                <a href="#" class="nav-link">
                    <span class="material-symbols-rounded">security</span>
                    Seguridad
                </a>
                <a href="#" class="nav-link">
                    <span class="material-symbols-rounded">backup</span>
                    Copias de Seguridad
                </a>
            </nav>
        </div>

        <!-- Content -->
        <div class="settings-card">
            <div class="card-header">
                <h2 class="card-title">Ajustes Generales</h2>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="siteName" class="form-label">Nombre del Programa</label>
                        <input type="text" class="form-control" id="siteName" value="Gestión de Cuentas de Cobro" disabled>
                        <div class="form-text">Este nombre se muestra en la barra de título y correos. Contacte a soporte para cambiarlo.</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Modo de Operación</label>
                        <div class="toggle-switch">
                            <span class="toggle-label">Activar Modo Mantenimiento</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="maintenanceMode" style="width: 40px; height: 20px;">
                            </div>
                        </div>
                        <div class="form-text">Si se activa, solo los administradores podrán acceder al sistema.</div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="button" class="btn-save" disabled>Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
