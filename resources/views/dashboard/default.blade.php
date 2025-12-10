@extends('layouts.app')

@section('title', 'Panel Principal')

@section('content')
<style>
    :root {
        --primary: #116dff;
        --secondary: #0f172a;
        --text-main: #334155;
        --text-light: #64748b;
        --bg-card: #ffffff;
        --border-color: #e2e8f0;
        --radius-md: 12px;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        font-family: 'Inter', sans-serif;
    }

    .welcome-banner {
        background: linear-gradient(135deg, var(--primary) 0%, #0056d6 100%);
        border-radius: var(--radius-md);
        padding: 32px;
        color: white;
        margin-bottom: 40px;
        box-shadow: 0 10px 25px -5px rgba(17, 109, 255, 0.3);
    }

    .welcome-title {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .welcome-subtitle {
        opacity: 0.9;
        font-size: 16px;
    }

    .modules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }

    .module-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 24px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .module-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.1);
        border-color: var(--primary);
    }

    .module-icon {
        width: 48px;
        height: 48px;
        background: #eff6ff;
        color: var(--primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }

    .module-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--secondary);
        margin-bottom: 8px;
    }

    .module-desc {
        font-size: 14px;
        color: var(--text-light);
        line-height: 1.5;
    }
</style>

<div class="main-container">
    <div class="welcome-banner">
        <h1 class="welcome-title">Bienvenido, {{ Auth::user()->name }}</h1>
        <p class="welcome-subtitle">Panel de Control - Rol: {{ Auth::user()->role ? Auth::user()->role->name : 'Sin Rol' }}</p>
    </div>

    <h2 style="font-size: 20px; font-weight: 700; color: var(--secondary); margin-bottom: 24px;">Módulos Disponibles</h2>

    <div class="modules-grid">
        <!-- Módulos Generales -->
        <a href="{{ route('cuentas_cobro.index') }}" class="module-card">
            <div class="module-icon">
                <span class="material-symbols-rounded">receipt_long</span>
            </div>
            <h3 class="module-title">Cuentas de Cobro</h3>
            <p class="module-desc">Gestiona y visualiza tus cuentas de cobro.</p>
        </a>

        <a href="{{ route('notificaciones.index') }}" class="module-card">
            <div class="module-icon">
                <span class="material-symbols-rounded">notifications</span>
            </div>
            <h3 class="module-title">Notificaciones</h3>
            <p class="module-desc">Revisa tus alertas y mensajes del sistema.</p>
        </a>

        <!-- Módulos Dinámicos según Permisos (Ejemplo) -->
        @if(Auth::user()->can('ver_reportes') || Auth::user()->hasRole('administrador') || Auth::user()->hasRole('tesoreria'))
        <a href="{{ route('reportes.index') }}" class="module-card">
            <div class="module-icon">
                <span class="material-symbols-rounded">bar_chart</span>
            </div>
            <h3 class="module-title">Reportes</h3>
            <p class="module-desc">Visualiza estadísticas y métricas financieras.</p>
        </a>
        @endif

        @if(Auth::user()->hasRole('administrador') || Auth::user()->hasRole('admin_programa'))
        <a href="{{ route('admin.users.index') }}" class="module-card">
            <div class="module-icon">
                <span class="material-symbols-rounded">group</span>
            </div>
            <h3 class="module-title">Usuarios</h3>
            <p class="module-desc">Administra usuarios y roles del sistema.</p>
        </a>
        @endif
    </div>
</div>
@endsection
