@extends('layouts.app')

@section('title', 'Nueva Cuenta - Dewey Accounts')

@section('content')
<style>
    /* Wix-inspired Design System (Matching Show View) */
    :root {
        --wix-blue: #116dff;
        --wix-dark: #20303c;
        --wix-gray: #f4f4f4;
        --wix-text: #162d3d;
        --wix-border: #eef1f5;
        --wix-success: #10b981;
    }

    .wix-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    /* Header */
    .wix-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .wix-title h1 {
        font-family: 'Inter', sans-serif;
        font-size: 28px;
        font-weight: 800;
        color: var(--wix-text);
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .wix-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #6b7c93;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: color 0.2s;
    }

    .wix-back-btn:hover {
        color: var(--wix-blue);
    }

    /* Summary Banner (Adapted for Create) */
    .summary-banner {
        background: linear-gradient(135deg, var(--wix-dark) 0%, #2c3e50 100%);
        color: white;
        border-radius: 12px;
        padding: 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
        box-shadow: 0 10px 30px rgba(32, 48, 60, 0.15);
    }

    .summary-info h2 {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .summary-info p {
        opacity: 0.7;
        font-size: 14px;
    }

    /* Card Style */
    .wix-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid var(--wix-border);
        overflow: hidden; /* Contains the form partial */
    }

    /* Override Form Partial Styles to match Card */
    .form-body {
        padding: 32px !important;
    }
    
    .section-title {
        font-size: 18px !important;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--wix-border);
        margin-bottom: 24px !important;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .summary-banner { flex-direction: column; align-items: flex-start; gap: 20px; }
    }
</style>

<div class="wix-container">
    <div class="wix-header">
        <div class="wix-title">
            <a href="{{ route('cuentas_cobro.index') }}" class="wix-back-btn">
                <span class="material-symbols-rounded">arrow_back</span>
                Volver
            </a>
            <h1>
                Nueva Cuenta de Cobro
            </h1>
        </div>
    </div>

    <div class="summary-banner">
        <div class="summary-info">
            <h2>Crear Nueva Cuenta</h2>
            <p>Completa la información para generar tu documento de cobro.</p>
        </div>
        <div style="background: rgba(255,255,255,0.1); padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600;">
            <span class="material-symbols-rounded" style="vertical-align: bottom; font-size: 18px; margin-right: 4px;">edit_document</span>
            Borrador
        </div>
    </div>

        <div class="wix-card">
        <form action="{{ route('cuentas_cobro.store') }}" method="POST" id="cuentaCobroForm" enctype="multipart/form-data">
            @csrf
            @include('cuentas_cobro.partials.form_improved', ['btnText' => 'Crear Cuenta', 'cuenta' => null])
        </form>
    </div>
</div>
@endsection
