@extends('layouts.app')

@section('title', 'Nueva Cuenta de Cobro')

@section('content')
<style>
    /* Siigo Nube Inspired Design System */
    :root {
        --siigo-primary: #00b5e2;
        --siigo-primary-dark: #0097be;
        --siigo-secondary: #6c5ce7;
        --siigo-success: #00b894;
        --siigo-warning: #fdcb6e;
        --siigo-danger: #e74c3c;
        --siigo-dark: #2d3436;
        --siigo-gray-100: #f8f9fa;
        --siigo-gray-200: #e9ecef;
        --siigo-gray-300: #dfe6e9;
        --siigo-gray-400: #b2bec3;
        --siigo-gray-500: #636e72;
        --siigo-shadow: 0 2px 12px rgba(0,0,0,0.08);
        --siigo-radius: 8px;
    }

    .siigo-page {
        background: var(--siigo-gray-100);
        min-height: 100vh;
        padding: 24px;
    }

    /* Top Navigation Bar */
    .siigo-topbar {
        background: white;
        border-radius: var(--siigo-radius);
        box-shadow: var(--siigo-shadow);
        padding: 16px 24px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .siigo-topbar-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .siigo-back-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--siigo-gray-500);
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .siigo-back-btn:hover {
        background: var(--siigo-gray-100);
        color: var(--siigo-primary);
    }

    .siigo-doc-type {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .siigo-doc-type select {
        border: 2px solid var(--siigo-primary);
        border-radius: 6px;
        padding: 8px 16px;
        font-weight: 600;
        color: var(--siigo-primary);
        background: white;
        cursor: pointer;
    }

    .siigo-doc-number {
        background: var(--siigo-gray-100);
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 700;
        color: var(--siigo-dark);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .siigo-doc-number .icon {
        color: var(--siigo-primary);
    }

    .siigo-topbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .siigo-status-badge {
        background: linear-gradient(135deg, var(--siigo-warning), #f39c12);
        color: #5a4010;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Main Layout */
    .siigo-main-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
    }

    @media (max-width: 1200px) {
        .siigo-main-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Cards */
    .siigo-card {
        background: white;
        border-radius: var(--siigo-radius);
        box-shadow: var(--siigo-shadow);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .siigo-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--siigo-gray-200);
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        user-select: none;
        transition: background 0.2s;
    }

    .siigo-card-header:hover {
        background: var(--siigo-gray-100);
    }

    .siigo-card-header h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--siigo-dark);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .siigo-card-header h3 .icon {
        color: var(--siigo-primary);
        font-size: 20px;
    }

    .siigo-card-header .chevron {
        color: var(--siigo-gray-400);
        transition: transform 0.3s;
    }

    .siigo-card-header.collapsed .chevron {
        transform: rotate(-90deg);
    }

    .siigo-card-body {
        padding: 20px;
        transition: all 0.3s ease;
    }

    .siigo-card-body.collapsed {
        display: none;
    }

    /* Form Elements */
    .siigo-form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .siigo-form-grid.cols-3 {
        grid-template-columns: repeat(3, 1fr);
    }

    .siigo-form-grid.cols-4 {
        grid-template-columns: repeat(4, 1fr);
    }

    .siigo-form-group {
        margin-bottom: 0;
    }

    .siigo-form-group.full-width {
        grid-column: 1 / -1;
    }

    .siigo-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--siigo-gray-500);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .siigo-label .required {
        color: var(--siigo-danger);
    }

    .siigo-input {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--siigo-gray-300);
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.2s;
        background: white;
    }

    .siigo-input:focus {
        border-color: var(--siigo-primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 181, 226, 0.1);
    }

    .siigo-input:disabled, .siigo-input[readonly] {
        background: var(--siigo-gray-100);
        color: var(--siigo-gray-500);
    }

    .siigo-input-group {
        position: relative;
    }

    .siigo-input-group .siigo-input {
        padding-left: 40px;
    }

    .siigo-input-group .input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--siigo-gray-400);
        font-size: 20px;
    }

    .siigo-input-group .input-action {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: var(--siigo-primary);
        color: white;
        border: none;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Search Dropdown */
    .siigo-search-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid var(--siigo-gray-300);
        border-radius: 6px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        max-height: 300px;
        overflow-y: auto;
        z-index: 100;
        display: none;
    }

    .siigo-search-dropdown.active {
        display: block;
    }

    .siigo-search-item {
        padding: 12px 16px;
        cursor: pointer;
        border-bottom: 1px solid var(--siigo-gray-200);
        transition: background 0.2s;
    }

    .siigo-search-item:hover {
        background: var(--siigo-gray-100);
    }

    .siigo-search-item:last-child {
        border-bottom: none;
    }

    .siigo-search-item .name {
        font-weight: 600;
        color: var(--siigo-dark);
    }

    .siigo-search-item .meta {
        font-size: 12px;
        color: var(--siigo-gray-500);
        margin-top: 2px;
    }

    /* Items Table */
    .siigo-items-table {
        width: 100%;
        border-collapse: collapse;
    }

    .siigo-items-table thead {
        background: linear-gradient(135deg, var(--siigo-gray-100), var(--siigo-gray-200));
    }

    .siigo-items-table th {
        padding: 12px 10px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: var(--siigo-gray-500);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .siigo-items-table td {
        padding: 10px;
        border-bottom: 1px solid var(--siigo-gray-200);
        vertical-align: middle;
    }

    .siigo-items-table tbody tr {
        transition: background 0.2s;
    }

    .siigo-items-table tbody tr:hover {
        background: var(--siigo-gray-100);
    }

    .siigo-items-table .item-input {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid transparent;
        border-radius: 4px;
        font-size: 13px;
        transition: all 0.2s;
        background: transparent;
    }

    .siigo-items-table .item-input:hover {
        border-color: var(--siigo-gray-300);
        background: white;
    }

    .siigo-items-table .item-input:focus {
        border-color: var(--siigo-primary);
        background: white;
        outline: none;
    }

    .siigo-items-table .row-total {
        font-weight: 700;
        color: var(--siigo-dark);
        text-align: right;
        padding-right: 16px;
    }

    .siigo-items-table .delete-btn {
        background: none;
        border: none;
        color: var(--siigo-gray-400);
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .siigo-items-table .delete-btn:hover {
        background: #fee2e2;
        color: var(--siigo-danger);
    }

    /* Add Item Row */
    .siigo-add-item {
        padding: 16px 20px;
        border-top: 1px dashed var(--siigo-gray-300);
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .siigo-add-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--siigo-primary);
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.2s;
        border: none;
        background: none;
    }

    .siigo-add-btn:hover {
        background: rgba(0, 181, 226, 0.1);
    }

    /* Summary Panel */
    .siigo-summary {
        position: sticky;
        top: 24px;
    }

    .siigo-summary-card {
        background: white;
        border-radius: var(--siigo-radius);
        box-shadow: var(--siigo-shadow);
        overflow: hidden;
    }

    .siigo-summary-header {
        background: linear-gradient(135deg, var(--siigo-dark), #34495e);
        color: white;
        padding: 20px;
    }

    .siigo-summary-header h3 {
        font-size: 14px;
        font-weight: 600;
        opacity: 0.8;
        margin-bottom: 8px;
    }

    .siigo-summary-header .total {
        font-size: 32px;
        font-weight: 800;
    }

    .siigo-summary-body {
        padding: 20px;
    }

    .siigo-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        font-size: 14px;
    }

    .siigo-summary-row.divider {
        border-top: 1px solid var(--siigo-gray-200);
        margin-top: 8px;
        padding-top: 16px;
    }

    .siigo-summary-row .label {
        color: var(--siigo-gray-500);
    }

    .siigo-summary-row .value {
        font-weight: 600;
        color: var(--siigo-dark);
    }

    .siigo-summary-row.total-row {
        background: var(--siigo-gray-100);
        margin: 0 -20px;
        padding: 16px 20px;
        font-size: 16px;
    }

    .siigo-summary-row.total-row .value {
        color: var(--siigo-primary);
        font-weight: 800;
        font-size: 20px;
    }

    /* Action Buttons */
    .siigo-actions {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .siigo-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }

    .siigo-btn-primary {
        background: linear-gradient(135deg, var(--siigo-success), #00a080);
        color: white;
    }

    .siigo-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 184, 148, 0.3);
    }

    .siigo-btn-secondary {
        background: var(--siigo-gray-100);
        color: var(--siigo-gray-500);
        border: 1px solid var(--siigo-gray-300);
    }

    .siigo-btn-secondary:hover {
        background: var(--siigo-gray-200);
    }

    .siigo-btn-outline {
        background: transparent;
        color: var(--siigo-primary);
        border: 2px solid var(--siigo-primary);
    }

    .siigo-btn-outline:hover {
        background: rgba(0, 181, 226, 0.1);
    }

    /* Quick Info Cards */
    .siigo-info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 16px;
    }

    .siigo-info-card {
        background: var(--siigo-gray-100);
        border-radius: 8px;
        padding: 12px;
        text-align: center;
    }

    .siigo-info-card .value {
        font-size: 20px;
        font-weight: 800;
        color: var(--siigo-dark);
    }

    .siigo-info-card .label {
        font-size: 11px;
        color: var(--siigo-gray-500);
        text-transform: uppercase;
    }

    /* Tax Selector */
    .siigo-tax-select {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .siigo-tax-chip {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        background: var(--siigo-gray-100);
        border: 1px solid var(--siigo-gray-300);
        border-radius: 20px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .siigo-tax-chip:hover {
        border-color: var(--siigo-primary);
    }

    .siigo-tax-chip.active {
        background: rgba(0, 181, 226, 0.1);
        border-color: var(--siigo-primary);
        color: var(--siigo-primary);
    }

    /* Progress Steps */
    .siigo-progress {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }

    .siigo-progress-step {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--siigo-gray-400);
    }

    .siigo-progress-step.active {
        color: var(--siigo-primary);
        font-weight: 600;
    }

    .siigo-progress-step.completed {
        color: var(--siigo-success);
    }

    .siigo-progress-step .step-num {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--siigo-gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 11px;
    }

    .siigo-progress-step.active .step-num {
        background: var(--siigo-primary);
        color: white;
    }

    .siigo-progress-step.completed .step-num {
        background: var(--siigo-success);
        color: white;
    }

    .siigo-progress-line {
        flex: 1;
        height: 2px;
        background: var(--siigo-gray-200);
    }

    .siigo-progress-line.completed {
        background: var(--siigo-success);
    }

    /* Modal Styles */
    .siigo-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
    }

    .siigo-modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .siigo-modal {
        background: white;
        border-radius: 12px;
        width: 100%;
        max-width: 700px;
        max-height: 90vh;
        overflow: hidden;
        transform: scale(0.9);
        transition: transform 0.3s;
    }

    .siigo-modal-overlay.active .siigo-modal {
        transform: scale(1);
    }

    .siigo-modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--siigo-gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .siigo-modal-header h2 {
        font-size: 18px;
        font-weight: 700;
        color: var(--siigo-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .siigo-modal-header h2 .icon {
        color: var(--siigo-primary);
    }

    .siigo-modal-close {
        background: none;
        border: none;
        color: var(--siigo-gray-400);
        cursor: pointer;
        padding: 8px;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .siigo-modal-close:hover {
        background: var(--siigo-gray-100);
        color: var(--siigo-dark);
    }

    .siigo-modal-body {
        padding: 24px;
        overflow-y: auto;
        max-height: calc(90vh - 140px);
    }

    .siigo-modal-footer {
        padding: 16px 24px;
        border-top: 1px solid var(--siigo-gray-200);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .siigo-form-grid {
            grid-template-columns: 1fr;
        }
        .siigo-form-grid.cols-3,
        .siigo-form-grid.cols-4 {
            grid-template-columns: 1fr;
        }
        .siigo-topbar {
            flex-direction: column;
            gap: 16px;
        }
        .siigo-info-grid {
            grid-template-columns: 1fr;
        }
        .siigo-modal {
            margin: 20px;
            max-width: calc(100% - 40px);
        }
    }
</style>

<div class="siigo-page">
    <form action="{{ route('cuentas_cobro.store') }}" method="POST" id="cuentaCobroForm" enctype="multipart/form-data">
        @csrf
        
        <!-- Top Bar -->
        <div class="siigo-topbar">
            <div class="siigo-topbar-left">
                <a href="{{ route('cuentas_cobro.index') }}" class="siigo-back-btn">
                    <span class="material-symbols-rounded">arrow_back</span>
                    Volver
                </a>
                <div class="siigo-doc-type">
                    <select name="tipo_documento" class="siigo-input" style="width: auto;">
                        <option value="Cuenta de Cobro">Cuenta de Cobro</option>
                    </select>
                </div>
                <div class="siigo-doc-number">
                    <span class="material-symbols-rounded icon">tag</span>
                    <span>Nº</span>
                    <strong id="docNumber">{{ $siguienteNumero ?? 'Auto' }}</strong>
                    <input type="hidden" name="numero" value="{{ $siguienteNumero ?? '' }}">
                </div>
            </div>
            <div class="siigo-topbar-right">
                <div class="siigo-status-badge">
                    <span class="material-symbols-rounded" style="font-size: 16px;">edit_note</span>
                    Borrador
                </div>
                <div style="display: flex; align-items: center; gap: 8px; color: var(--siigo-gray-500); font-size: 13px;">
                    <span class="material-symbols-rounded" style="font-size: 18px;">calendar_today</span>
                    <input type="date" name="fecha_emision" value="{{ date('Y-m-d') }}" class="siigo-input" style="width: auto; padding: 6px 10px;">
                </div>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="siigo-progress">
            <div class="siigo-progress-step active" id="step1">
                <span class="step-num">1</span>
                <span>Tercero</span>
            </div>
            <div class="siigo-progress-line" id="line1"></div>
            <div class="siigo-progress-step" id="step2">
                <span class="step-num">2</span>
                <span>Contrato</span>
            </div>
            <div class="siigo-progress-line" id="line2"></div>
            <div class="siigo-progress-step" id="step3">
                <span class="step-num">3</span>
                <span>Ítems</span>
            </div>
            <div class="siigo-progress-line" id="line3"></div>
            <div class="siigo-progress-step" id="step4">
                <span class="step-num">4</span>
                <span>Revisión</span>
            </div>
        </div>

        <div class="siigo-main-grid">
            <!-- Left Column - Main Content -->
            <div class="siigo-main-content">
                
                <!-- Tercero / Beneficiario -->
                <div class="siigo-card" id="cardTercero">
                    <div class="siigo-card-header" onclick="toggleCard('cardTercero')">
                        <h3>
                            <span class="material-symbols-rounded icon">person</span>
                            Tercero / Beneficiario
                        </h3>
                        <span class="material-symbols-rounded chevron">expand_more</span>
                    </div>
                    <div class="siigo-card-body">
                        <div class="siigo-form-grid">
                            <div class="siigo-form-group full-width">
                                <label class="siigo-label">Buscar Tercero <span class="required">*</span></label>
                                <div class="siigo-input-group" style="position: relative;">
                                    <span class="material-symbols-rounded input-icon">search</span>
                                    <input type="text" id="searchTercero" class="siigo-input" placeholder="Buscar por nombre, cédula o NIT..." autocomplete="off">
                                    <button type="button" class="input-action" onclick="openNewTerceroModal()">
                                        <span class="material-symbols-rounded" style="font-size: 14px;">add</span>
                                        Nuevo
                                    </button>
                                    <div class="siigo-search-dropdown" id="terceroDropdown">
                                        <!-- Results populated by JS -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="terceroDetails" style="display: none; margin-top: 20px; padding: 16px; background: var(--siigo-gray-100); border-radius: 8px;">
                            <div class="siigo-form-grid cols-3">
                                <div class="siigo-form-group">
                                    <label class="siigo-label">Nombre Completo</label>
                                    <input type="text" name="nombre_beneficiario" id="nombreBeneficiario" class="siigo-input" required>
                                </div>
                                <div class="siigo-form-group">
                                    <label class="siigo-label">Tipo Identificación</label>
                                    <select name="tipo_identificacion" id="tipoIdentificacion" class="siigo-input">
                                        <option value="CC">Cédula de Ciudadanía</option>
                                        <option value="NIT">NIT</option>
                                        <option value="CE">Cédula de Extranjería</option>
                                        <option value="PA">Pasaporte</option>
                                    </select>
                                </div>
                                <div class="siigo-form-group">
                                    <label class="siigo-label">Número Identificación</label>
                                    <input type="text" name="identificacion" id="identificacion" class="siigo-input" required>
                                </div>
                                <div class="siigo-form-group">
                                    <label class="siigo-label">Teléfono</label>
                                    <input type="text" name="telefono" id="telefono" class="siigo-input">
                                </div>
                                <div class="siigo-form-group">
                                    <label class="siigo-label">Email</label>
                                    <input type="email" name="email" id="email" class="siigo-input">
                                </div>
                                <div class="siigo-form-group">
                                    <label class="siigo-label">Dirección</label>
                                    <input type="text" name="direccion" id="direccion" class="siigo-input">
                                </div>
                            </div>
                            <input type="hidden" name="tercero_id" id="terceroId">
                            <input type="hidden" name="tipo_cliente" id="tipoCliente" value="Persona Natural">
                        </div>
                    </div>
                </div>

                <!-- Contrato Asociado -->
                <div class="siigo-card" id="cardContrato">
                    <div class="siigo-card-header" onclick="toggleCard('cardContrato')">
                        <h3>
                            <span class="material-symbols-rounded icon">description</span>
                            Contrato Asociado
                        </h3>
                        <span class="material-symbols-rounded chevron">expand_more</span>
                    </div>
                    <div class="siigo-card-body">
                        <div class="siigo-form-grid cols-3">
                            <div class="siigo-form-group">
                                <label class="siigo-label">Número de Contrato</label>
                                <select name="contrato_id" id="contratoSelect" class="siigo-input">
                                    <option value="">Sin contrato asociado</option>
                                    @if(isset($contratos))
                                        @foreach($contratos as $contrato)
                                        <option value="{{ $contrato->id }}" 
                                                data-objeto="{{ $contrato->objeto }}"
                                                data-valor="{{ $contrato->valor }}">
                                            {{ $contrato->numero }} - {{ Str::limit($contrato->objeto, 40) }}
                                        </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="siigo-form-group">
                                <label class="siigo-label">Departamento</label>
                                <select name="departamento" id="departamentoSelect" class="siigo-input">
                                    <option value="">Seleccionar...</option>
                                    @if(isset($departamentos))
                                        @foreach($departamentos as $dep)
                                        <option value="{{ $dep->nombre }}">{{ $dep->nombre }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="siigo-form-group">
                                <label class="siigo-label">Municipio</label>
                                <select name="municipio" id="municipioSelect" class="siigo-input">
                                    <option value="">Seleccionar...</option>
                                </select>
                            </div>
                        </div>
                        <div id="contratoInfo" style="display: none; margin-top: 16px; padding: 12px; background: #e8f5e9; border-radius: 6px; border-left: 4px solid var(--siigo-success);">
                            <p style="margin: 0; font-size: 13px; color: var(--siigo-dark);">
                                <strong>Objeto:</strong> <span id="contratoObjeto"></span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Ítems / Servicios -->
                <div class="siigo-card" id="cardItems">
                    <div class="siigo-card-header" onclick="toggleCard('cardItems')">
                        <h3>
                            <span class="material-symbols-rounded icon">receipt_long</span>
                            Detalle de Servicios / Productos
                        </h3>
                        <span class="material-symbols-rounded chevron">expand_more</span>
                    </div>
                    <div class="siigo-card-body" style="padding: 0;">
                        <table class="siigo-items-table">
                            <thead>
                                <tr>
                                    <th style="width: 4%">#</th>
                                    <th style="width: 12%">Código PUC</th>
                                    <th style="width: 20%">Servicio / Producto</th>
                                    <th style="width: 16%">Descripción</th>
                                    <th style="width: 10%">Centro Costo</th>
                                    <th style="width: 6%">Cant.</th>
                                    <th style="width: 12%">Valor Unit.</th>
                                    <th style="width: 8%">Impuesto</th>
                                    <th style="width: 10%">Total</th>
                                    <th style="width: 4%"></th>
                                </tr>
                            </thead>
                            <tbody id="itemsTableBody">
                                <!-- Rows added by JS -->
                            </tbody>
                        </table>
                        <div class="siigo-add-item">
                            <button type="button" class="siigo-add-btn" onclick="addItemRow()">
                                <span class="material-symbols-rounded">add_circle</span>
                                Agregar línea
                            </button>
                            <button type="button" class="siigo-add-btn" onclick="openCatalogoModal()">
                                <span class="material-symbols-rounded">inventory_2</span>
                                Desde catálogo
                            </button>
                            <button type="button" class="siigo-add-btn" onclick="openPucModal()">
                                <span class="material-symbols-rounded">account_tree</span>
                                Buscar PUC
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Observaciones y Archivos -->
                <div class="siigo-card" id="cardNotes">
                    <div class="siigo-card-header" onclick="toggleCard('cardNotes')">
                        <h3>
                            <span class="material-symbols-rounded icon">note_alt</span>
                            Observaciones y Adjuntos
                        </h3>
                        <span class="material-symbols-rounded chevron">expand_more</span>
                    </div>
                    <div class="siigo-card-body">
                        <div class="siigo-form-grid">
                            <div class="siigo-form-group full-width">
                                <label class="siigo-label">Concepto / Observaciones</label>
                                <textarea name="concepto_cobro" class="siigo-input" rows="3" placeholder="Describe el concepto del cobro o agrega notas adicionales..."></textarea>
                            </div>
                            <div class="siigo-form-group">
                                <label class="siigo-label">Adjuntar Soporte (Opcional)</label>
                                <input type="file" name="soporte" class="siigo-input" accept=".pdf,.jpg,.png,.doc,.docx">
                                <small style="color: var(--siigo-gray-500); font-size: 11px;">PDF, imágenes o documentos. Máx 5MB</small>
                            </div>
                            <div class="siigo-form-group">
                                <label class="siigo-label">Fecha de Vencimiento</label>
                                <input type="date" name="fecha_vencimiento" class="siigo-input" value="{{ date('Y-m-d', strtotime('+30 days')) }}">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column - Summary -->
            <div class="siigo-summary">
                <div class="siigo-summary-card">
                    <div class="siigo-summary-header">
                        <h3>Total a Cobrar</h3>
                        <div class="total" id="summaryTotal">$0</div>
                    </div>
                    <div class="siigo-summary-body">
                        <div class="siigo-info-grid">
                            <div class="siigo-info-card">
                                <div class="value" id="infoItems">0</div>
                                <div class="label">Ítems</div>
                            </div>
                            <div class="siigo-info-card">
                                <div class="value" id="infoQty">0</div>
                                <div class="label">Cantidad</div>
                            </div>
                            <div class="siigo-info-card">
                                <div class="value" id="infoTax">0%</div>
                                <div class="label">IVA Prom.</div>
                            </div>
                        </div>

                        <div class="siigo-summary-row">
                            <span class="label">Subtotal</span>
                            <span class="value" id="summarySubtotal">$0</span>
                        </div>
                        <div class="siigo-summary-row">
                            <span class="label">Descuentos</span>
                            <span class="value" id="summaryDescuentos">- $0</span>
                        </div>
                        <div class="siigo-summary-row">
                            <span class="label">IVA (19%)</span>
                            <span class="value" id="summaryIva">$0</span>
                        </div>
                        <div class="siigo-summary-row">
                            <span class="label">Retenciones</span>
                            <span class="value" id="summaryRetenciones">- $0</span>
                        </div>
                        <div class="siigo-summary-row divider total-row">
                            <span class="label">Total Neto</span>
                            <span class="value" id="summaryNeto">$0</span>
                        </div>
                    </div>
                    <div class="siigo-actions">
                        <button type="submit" name="action" value="save" class="siigo-btn siigo-btn-primary">
                            <span class="material-symbols-rounded">save</span>
                            Guardar Cuenta
                        </button>
                        <button type="submit" name="action" value="save_and_send" class="siigo-btn siigo-btn-outline">
                            <span class="material-symbols-rounded">send</span>
                            Guardar y Enviar
                        </button>
                        <button type="button" class="siigo-btn siigo-btn-secondary" onclick="previewDocument()">
                            <span class="material-symbols-rounded">visibility</span>
                            Vista Previa
                        </button>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="siigo-card" style="margin-top: 16px;">
                    <div class="siigo-card-body" style="padding: 16px;">
                        <h4 style="font-size: 13px; font-weight: 700; color: var(--siigo-dark); margin-bottom: 12px;">Acciones Rápidas</h4>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <a href="#" class="siigo-back-btn" style="justify-content: flex-start;">
                                <span class="material-symbols-rounded">content_copy</span>
                                Duplicar cuenta anterior
                            </a>
                            <a href="#" class="siigo-back-btn" style="justify-content: flex-start;">
                                <span class="material-symbols-rounded">history</span>
                                Ver historial del tercero
                            </a>
                            <a href="#" class="siigo-back-btn" style="justify-content: flex-start;">
                                <span class="material-symbols-rounded">calculate</span>
                                Calculadora de impuestos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden fields for controller compatibility -->
        <input type="hidden" name="subtotal" id="inputSubtotal" value="0">
        <input type="hidden" name="iva_valor" id="inputIva" value="0">
        <input type="hidden" name="valor_total" id="inputTotal" value="0">
    </form>

    <!-- Modal Nuevo Tercero -->
    <div class="siigo-modal-overlay" id="modalTercero">
        <div class="siigo-modal">
            <div class="siigo-modal-header">
                <h2>
                    <span class="material-symbols-rounded icon">person_add</span>
                    Crear Nuevo Tercero
                </h2>
                <button type="button" class="siigo-modal-close" onclick="closeNewTerceroModal()">
                    <span class="material-symbols-rounded">close</span>
                </button>
            </div>
            <div class="siigo-modal-body">
                <form id="formNuevoTercero">
                    <div class="siigo-form-grid cols-2" style="gap: 16px;">
                        <div class="siigo-form-group full-width">
                            <label class="siigo-label">Tipo de Persona <span class="required">*</span></label>
                            <div style="display: flex; gap: 16px;">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="radio" name="modal_tipo_persona" value="natural" checked>
                                    <span>Persona Natural</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <input type="radio" name="modal_tipo_persona" value="juridica">
                                    <span>Persona Jurídica</span>
                                </label>
                            </div>
                        </div>
                        <div class="siigo-form-group">
                            <label class="siigo-label">Tipo de Identificación <span class="required">*</span></label>
                            <select id="modal_tipo_id" class="siigo-input" required>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="NIT">NIT</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="PA">Pasaporte</option>
                                <option value="TI">Tarjeta de Identidad</option>
                            </select>
                        </div>
                        <div class="siigo-form-group">
                            <label class="siigo-label">Número de Identificación <span class="required">*</span></label>
                            <div style="display: flex; gap: 8px;">
                                <input type="text" id="modal_identificacion" class="siigo-input" placeholder="Ej: 1234567890" required style="flex: 1;">
                                <input type="text" id="modal_dv" class="siigo-input" placeholder="DV" style="width: 60px; display: none;">
                            </div>
                        </div>
                        <div class="siigo-form-group" id="divNombreCompleto">
                            <label class="siigo-label">Nombre Completo <span class="required">*</span></label>
                            <input type="text" id="modal_nombre" class="siigo-input" placeholder="Ej: Juan Pérez García" required>
                        </div>
                        <div class="siigo-form-group" id="divRazonSocial" style="display: none;">
                            <label class="siigo-label">Razón Social <span class="required">*</span></label>
                            <input type="text" id="modal_razon_social" class="siigo-input" placeholder="Ej: Empresa S.A.S.">
                        </div>
                        <div class="siigo-form-group">
                            <label class="siigo-label">Teléfono</label>
                            <div style="display: flex; gap: 8px;">
                                <select id="modal_codigo_pais" class="siigo-input" style="width: 140px;">
                                    @foreach($paises as $pais)
                                    <option value="{{ $pais->indicativo }}" {{ $pais->codigo_iso2 === 'CO' ? 'selected' : '' }}>
                                        {{ $pais->codigo_iso2 }} {{ $pais->indicativo }}
                                    </option>
                                    @endforeach
                                </select>
                                <input type="text" id="modal_telefono" class="siigo-input" placeholder="Ej: 3001234567" style="flex: 1;">
                            </div>
                        </div>
                        <div class="siigo-form-group">
                            <label class="siigo-label">Email</label>
                            <input type="email" id="modal_email" class="siigo-input" placeholder="Ej: correo@ejemplo.com">
                        </div>
                        <div class="siigo-form-group full-width">
                            <label class="siigo-label">Responsabilidades Fiscales</label>
                            <div id="responsabilidadesFiscalesContainer" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; max-height: 150px; overflow-y: auto; border: 1px solid var(--siigo-gray-200); border-radius: 8px; padding: 12px;">
                                @foreach($responsabilidadesFiscales as $resp)
                                <label style="display: flex; align-items: flex-start; gap: 8px; cursor: pointer; font-size: 12px;">
                                    <input type="checkbox" name="modal_responsabilidades[]" value="{{ $resp->codigo }}">
                                    <span><strong>{{ $resp->codigo }}</strong>: {{ Str::limit($resp->nombre, 40) }}</span>
                                </label>
                                @endforeach
                            </div>
                            <small style="color: var(--siigo-gray-500); font-size: 11px;">Según Resolución DIAN - Ley 2024/2025</small>
                        </div>
                        <div class="siigo-form-group">
                            <label class="siigo-label">Departamento</label>
                            <select id="modal_departamento" class="siigo-input">
                                <option value="">Seleccionar...</option>
                                @foreach($departamentos as $dep)
                                <option value="{{ $dep->nombre }}" data-id="{{ $dep->id }}">{{ $dep->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="siigo-form-group">
                            <label class="siigo-label">Ciudad/Municipio</label>
                            <select id="modal_ciudad" class="siigo-input">
                                <option value="">Seleccionar departamento primero</option>
                            </select>
                        </div>
                        <div class="siigo-form-group full-width">
                            <label class="siigo-label">Dirección</label>
                            <input type="text" id="modal_direccion" class="siigo-input" placeholder="Ej: Calle 123 # 45-67">
                        </div>
                    </div>
                </form>
            </div>
            <div class="siigo-modal-footer">
                <button type="button" class="siigo-btn siigo-btn-secondary" onclick="closeNewTerceroModal()">
                    Cancelar
                </button>
                <button type="button" class="siigo-btn siigo-btn-primary" onclick="saveNewTercero()">
                    <span class="material-symbols-rounded">save</span>
                    Guardar Tercero
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Catálogo de Productos -->
    <div class="siigo-modal-overlay" id="modalCatalogo">
        <div class="siigo-modal" style="max-width: 800px;">
            <div class="siigo-modal-header">
                <h2>
                    <span class="material-symbols-rounded icon">inventory_2</span>
                    Catálogo de Productos y Servicios
                </h2>
                <button type="button" class="siigo-modal-close" onclick="closeCatalogoModal()">
                    <span class="material-symbols-rounded">close</span>
                </button>
            </div>
            <div class="siigo-modal-body">
                <div class="siigo-form-group" style="margin-bottom: 16px;">
                    <div class="siigo-input-group">
                        <input type="text" id="searchCatalogo" class="siigo-input" placeholder="Buscar por código, nombre o descripción...">
                        <span class="siigo-input-icon">
                            <span class="material-symbols-rounded">search</span>
                        </span>
                    </div>
                </div>
                <div id="catalogoList" style="max-height: 400px; overflow-y: auto;">
                    <table class="siigo-items-table" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>PUC</th>
                                <th>Precio</th>
                                <th>IVA</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="catalogoTableBody">
                            @foreach($productos as $prod)
                            <tr class="catalogo-item" data-codigo="{{ $prod->codigo }}" data-nombre="{{ $prod->nombre }}" 
                                data-descripcion="{{ $prod->descripcion }}" data-puc="{{ $prod->puc_codigo }}" 
                                data-precio="{{ $prod->precio_unitario }}" data-iva="{{ $prod->iva_porcentaje }}">
                                <td><strong>{{ $prod->codigo }}</strong></td>
                                <td>{{ $prod->nombre }}</td>
                                <td><span style="font-family: monospace; font-size: 11px;">{{ $prod->puc_codigo }}</span></td>
                                <td>{{ number_format($prod->precio_unitario, 0, ',', '.') }}</td>
                                <td>{{ $prod->iva_porcentaje }}%</td>
                                <td>
                                    <button type="button" class="siigo-btn siigo-btn-primary" style="padding: 4px 8px; font-size: 11px;" 
                                            onclick="selectProducto(this.closest('tr'))">
                                        <span class="material-symbols-rounded" style="font-size: 14px;">add</span>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="siigo-modal-footer">
                <button type="button" class="siigo-btn siigo-btn-secondary" onclick="closeCatalogoModal()">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal PUC -->
    <div class="siigo-modal-overlay" id="modalPuc">
        <div class="siigo-modal" style="max-width: 700px;">
            <div class="siigo-modal-header">
                <h2>
                    <span class="material-symbols-rounded icon">account_tree</span>
                    Plan Único de Cuentas (PUC)
                </h2>
                <button type="button" class="siigo-modal-close" onclick="closePucModal()">
                    <span class="material-symbols-rounded">close</span>
                </button>
            </div>
            <div class="siigo-modal-body">
                <div class="siigo-form-group" style="margin-bottom: 16px;">
                    <div class="siigo-input-group">
                        <input type="text" id="searchPuc" class="siigo-input" placeholder="Buscar por código o nombre de cuenta...">
                        <span class="siigo-input-icon">
                            <span class="material-symbols-rounded">search</span>
                        </span>
                    </div>
                </div>
                <div id="pucList" style="max-height: 400px; overflow-y: auto;">
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        @foreach($pucCatalogo as $puc)
                        <div class="puc-item" data-codigo="{{ $puc->codigo }}" data-nombre="{{ $puc->nombre }}" 
                             style="padding: 10px; border: 1px solid var(--siigo-gray-200); border-radius: 6px; cursor: pointer; transition: all 0.2s;"
                             onclick="selectPuc(this)" onmouseover="this.style.background='var(--siigo-gray-100)'" onmouseout="this.style.background='white'">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <span style="font-family: monospace; font-weight: 700; color: var(--siigo-primary);">{{ $puc->codigo }}</span>
                                    <span style="margin-left: 12px;">{{ $puc->nombre }}</span>
                                </div>
                                <span class="material-symbols-rounded" style="color: var(--siigo-gray-400); font-size: 18px;">chevron_right</span>
                            </div>
                            @if($puc->clase)
                            <div style="font-size: 11px; color: var(--siigo-gray-500); margin-top: 4px;">Clase: {{ $puc->clase }} | Naturaleza: {{ $puc->naturaleza }}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="siigo-modal-footer">
                <small style="flex: 1; color: var(--siigo-gray-500);">Haga clic en una cuenta para aplicarla a la fila seleccionada</small>
                <button type="button" class="siigo-btn siigo-btn-secondary" onclick="closePucModal()">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // State
    let itemRowCount = 0;
    let terceros = @json($terceros ?? []);
    let selectedItemRow = null; // Para PUC selection
    
    // Catálogos desde el servidor
    const productosData = @json($productos);
    const pucData = @json($pucCatalogo);
    const centrosCostoData = @json($centrosCosto);
    
    // Departamentos y municipios desde el servidor
    const departamentosData = @json($departamentos->map(function($dep) {
        return [
            'id' => $dep->id,
            'nombre' => $dep->nombre,
            'municipios' => $dep->municipios->pluck('nombre')->toArray()
        ];
    }));

    // Toggle Card Collapse
    function toggleCard(cardId) {
        const card = document.getElementById(cardId);
        const header = card.querySelector('.siigo-card-header');
        const body = card.querySelector('.siigo-card-body');
        
        header.classList.toggle('collapsed');
        body.classList.toggle('collapsed');
    }

    // Cargar municipios por departamento
    function loadMunicipios(departamentoNombre, selectId = 'municipioSelect') {
        const select = document.getElementById(selectId);
        select.innerHTML = '<option value="">Seleccionar...</option>';
        
        const dep = departamentosData.find(d => d.nombre === departamentoNombre);
        if (dep && dep.municipios) {
            dep.municipios.forEach(mun => {
                const option = document.createElement('option');
                option.value = mun;
                option.textContent = mun;
                select.appendChild(option);
            });
        }
    }

    // Event listener para departamento principal
    document.getElementById('departamentoSelect')?.addEventListener('change', function() {
        loadMunicipios(this.value, 'municipioSelect');
    });

    // Event listener para departamento del modal
    document.getElementById('modal_departamento')?.addEventListener('change', function() {
        loadMunicipios(this.value, 'modal_ciudad');
    });

    // Add Item Row
    function addItemRow(data = null) {
        itemRowCount++;
        const tbody = document.getElementById('itemsTableBody');
        const tr = document.createElement('tr');
        tr.id = `itemRow${itemRowCount}`;
        
        // Generar opciones de centros de costo
        let centrosCostoOptions = '<option value="">-</option>';
        centrosCostoData.forEach(cc => {
            centrosCostoOptions += `<option value="${cc.codigo}">${cc.codigo} - ${cc.nombre}</option>`;
        });
        
        tr.innerHTML = `
            <td style="text-align: center; color: var(--siigo-gray-400); font-weight: 600;">${itemRowCount}</td>
            <td>
                <div class="puc-selector" style="position: relative;">
                    <input type="text" name="items[${itemRowCount}][puc_codigo]" class="item-input item-puc" 
                           placeholder="Buscar PUC..." value="${data?.puc_codigo || ''}" 
                           onfocus="showPucDropdown(this)" oninput="filterPucDropdown(this)">
                    <input type="hidden" name="items[${itemRowCount}][puc_nombre]" class="item-puc-nombre" value="${data?.puc_nombre || ''}">
                </div>
            </td>
            <td>
                <input type="text" name="items[${itemRowCount}][item]" class="item-input item-name" 
                       placeholder="Nombre del servicio" value="${data?.item || ''}" required>
            </td>
            <td>
                <input type="text" name="items[${itemRowCount}][descripcion]" class="item-input" 
                       placeholder="Detalles..." value="${data?.descripcion || ''}">
            </td>
            <td>
                <select name="items[${itemRowCount}][centro_costo]" class="item-input item-cc" style="font-size: 11px;">
                    ${centrosCostoOptions}
                </select>
            </td>
            <td>
                <input type="number" name="items[${itemRowCount}][cantidad]" class="item-input item-qty" 
                       value="${data?.cantidad || 1}" min="1" onchange="calculateTotals()">
            </td>
            <td>
                <input type="number" name="items[${itemRowCount}][precio_unitario]" class="item-input item-price" 
                       value="${data?.precio || 0}" min="0" step="100" onchange="calculateTotals()">
            </td>
            <td>
                <select name="items[${itemRowCount}][impuesto]" class="item-input item-tax" onchange="calculateTotals()">
                    <option value="0">0%</option>
                    <option value="5">5%</option>
                    <option value="19" ${!data || data?.iva == 19 ? 'selected' : (data?.iva == 5 ? '' : (data?.iva == 0 ? '' : ''))}>19%</option>
                </select>
            </td>
            <td class="row-total" id="rowTotal${itemRowCount}">$0</td>
            <td style="text-align: center;">
                <button type="button" class="delete-btn" onclick="removeItemRow(${itemRowCount})">
                    <span class="material-symbols-rounded">delete</span>
                </button>
            </td>
        `;
        
        tbody.appendChild(tr);
        updateProgress();
        calculateTotals();
    }

    function removeItemRow(rowId) {
        const row = document.getElementById(`itemRow${rowId}`);
        if (row) {
            row.remove();
            calculateTotals();
            updateProgress();
        }
    }

    // ==================== CATÁLOGO DE PRODUCTOS ====================
    function openCatalogoModal() {
        document.getElementById('modalCatalogo').classList.add('active');
        document.getElementById('searchCatalogo').focus();
    }

    function closeCatalogoModal() {
        document.getElementById('modalCatalogo').classList.remove('active');
        document.getElementById('searchCatalogo').value = '';
        filterCatalogoTable('');
    }

    function filterCatalogoTable(query) {
        const rows = document.querySelectorAll('#catalogoTableBody .catalogo-item');
        const q = query.toLowerCase();
        rows.forEach(row => {
            const codigo = row.dataset.codigo?.toLowerCase() || '';
            const nombre = row.dataset.nombre?.toLowerCase() || '';
            const descripcion = row.dataset.descripcion?.toLowerCase() || '';
            const puc = row.dataset.puc?.toLowerCase() || '';
            const visible = codigo.includes(q) || nombre.includes(q) || descripcion.includes(q) || puc.includes(q);
            row.style.display = visible ? '' : 'none';
        });
    }

    document.getElementById('searchCatalogo')?.addEventListener('input', function() {
        filterCatalogoTable(this.value);
    });

    function selectProducto(row) {
        const data = {
            item: row.dataset.nombre,
            descripcion: row.dataset.descripcion,
            puc_codigo: row.dataset.puc,
            precio: parseFloat(row.dataset.precio) || 0,
            iva: parseInt(row.dataset.iva) || 19
        };
        addItemRow(data);
        closeCatalogoModal();
    }

    // ==================== PUC ====================
    function openPucModal() {
        document.getElementById('modalPuc').classList.add('active');
        document.getElementById('searchPuc').focus();
    }

    function closePucModal() {
        document.getElementById('modalPuc').classList.remove('active');
        document.getElementById('searchPuc').value = '';
        filterPucList('');
        selectedItemRow = null;
    }

    function filterPucList(query) {
        const items = document.querySelectorAll('#pucList .puc-item');
        const q = query.toLowerCase();
        items.forEach(item => {
            const codigo = item.dataset.codigo?.toLowerCase() || '';
            const nombre = item.dataset.nombre?.toLowerCase() || '';
            const visible = codigo.includes(q) || nombre.includes(q);
            item.style.display = visible ? '' : 'none';
        });
    }

    document.getElementById('searchPuc')?.addEventListener('input', function() {
        filterPucList(this.value);
    });

    function selectPuc(item) {
        const codigo = item.dataset.codigo;
        const nombre = item.dataset.nombre;
        
        if (selectedItemRow) {
            // Aplicar a fila específica
            const pucInput = selectedItemRow.querySelector('.item-puc');
            const pucNombreInput = selectedItemRow.querySelector('.item-puc-nombre');
            if (pucInput) pucInput.value = codigo;
            if (pucNombreInput) pucNombreInput.value = nombre;
        } else {
            // Aplicar a la última fila o crear una nueva
            const lastRow = document.querySelector('#itemsTableBody tr:last-child');
            if (lastRow) {
                const pucInput = lastRow.querySelector('.item-puc');
                const pucNombreInput = lastRow.querySelector('.item-puc-nombre');
                if (pucInput) pucInput.value = codigo;
                if (pucNombreInput) pucNombreInput.value = nombre;
            }
        }
        closePucModal();
    }

    // Búsqueda rápida en línea para PUC
    function showPucDropdown(input) {
        // Registrar la fila seleccionada para el modal PUC
        selectedItemRow = input.closest('tr');
    }

    function filterPucDropdown(input) {
        // Búsqueda inline simplificada - solo abre modal si escribe más de 2 caracteres
        if (input.value.length >= 2) {
            const found = pucData.find(p => p.codigo.startsWith(input.value) || p.nombre.toLowerCase().includes(input.value.toLowerCase()));
            if (found) {
                input.title = `${found.codigo} - ${found.nombre}`;
            }
        }
    }

    // Calculate Totals
    function calculateTotals() {
        let subtotal = 0;
        let totalIva = 0;
        let totalQty = 0;
        let itemCount = 0;
        let taxSum = 0;

        document.querySelectorAll('#itemsTableBody tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.item-qty')?.value) || 0;
            const price = parseFloat(row.querySelector('.item-price')?.value) || 0;
            const taxRate = parseFloat(row.querySelector('.item-tax')?.value) || 0;
            
            const lineSubtotal = qty * price;
            const lineTax = lineSubtotal * (taxRate / 100);
            const lineTotal = lineSubtotal + lineTax;

            const rowTotalEl = row.querySelector('.row-total');
            if (rowTotalEl) {
                rowTotalEl.textContent = formatCurrency(lineTotal);
            }

            subtotal += lineSubtotal;
            totalIva += lineTax;
            totalQty += qty;
            itemCount++;
            taxSum += taxRate;
        });

        const total = subtotal + totalIva;
        const avgTax = itemCount > 0 ? Math.round(taxSum / itemCount) : 0;

        // Update displays
        document.getElementById('summarySubtotal').textContent = formatCurrency(subtotal);
        document.getElementById('summaryIva').textContent = formatCurrency(totalIva);
        document.getElementById('summaryNeto').textContent = formatCurrency(total);
        document.getElementById('summaryTotal').textContent = formatCurrency(total);

        document.getElementById('infoItems').textContent = itemCount;
        document.getElementById('infoQty').textContent = totalQty;
        document.getElementById('infoTax').textContent = avgTax + '%';

        // Hidden inputs
        document.getElementById('inputSubtotal').value = subtotal;
        document.getElementById('inputIva').value = totalIva;
        document.getElementById('inputTotal').value = total;
    }

    function formatCurrency(value) {
        return new Intl.NumberFormat('es-CO', { 
            style: 'currency', 
            currency: 'COP',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(value);
    }

    // Tercero Search
    const searchInput = document.getElementById('searchTercero');
    const dropdown = document.getElementById('terceroDropdown');

    searchInput?.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        if (query.length < 2) {
            dropdown.classList.remove('active');
            return;
        }

        const filtered = terceros.filter(t => 
            t.nombre?.toLowerCase().includes(query) || 
            t.identificacion?.includes(query)
        );

        if (filtered.length > 0) {
            dropdown.innerHTML = filtered.slice(0, 5).map(t => `
                <div class="siigo-search-item" onclick='selectTercero(${JSON.stringify(t)})'>
                    <div class="name">${t.nombre}</div>
                    <div class="meta">${t.tipo_identificacion || 'CC'}: ${t.identificacion} • ${t.email || 'Sin email'}</div>
                </div>
            `).join('');
            dropdown.classList.add('active');
        } else {
            dropdown.innerHTML = `
                <div class="siigo-search-item" onclick="openNewTerceroModal()">
                    <div class="name" style="color: var(--siigo-primary);">
                        <span class="material-symbols-rounded" style="font-size: 16px; vertical-align: text-bottom;">add</span>
                        Crear nuevo tercero
                    </div>
                    <div class="meta">No se encontraron resultados para "${query}"</div>
                </div>
            `;
            dropdown.classList.add('active');
        }
    });

    function selectTercero(tercero) {
        document.getElementById('terceroId').value = tercero.id || '';
        document.getElementById('nombreBeneficiario').value = tercero.nombre || '';
        document.getElementById('tipoIdentificacion').value = tercero.tipo_identificacion || 'CC';
        document.getElementById('identificacion').value = tercero.identificacion || '';
        document.getElementById('telefono').value = tercero.telefono || '';
        document.getElementById('email').value = tercero.email || '';
        document.getElementById('direccion').value = tercero.direccion || '';
        document.getElementById('tipoCliente').value = tercero.tipo || 'Persona Natural';

        document.getElementById('terceroDetails').style.display = 'block';
        document.getElementById('searchTercero').value = tercero.nombre;
        dropdown.classList.remove('active');
        
        updateProgress();
    }

    // Modal Tercero Functions
    function openNewTerceroModal() {
        document.getElementById('modalTercero').classList.add('active');
        dropdown?.classList.remove('active');
    }

    function closeNewTerceroModal() {
        document.getElementById('modalTercero').classList.remove('active');
        document.getElementById('formNuevoTercero').reset();
    }

    // Cambiar tipo de persona en modal
    document.querySelectorAll('input[name="modal_tipo_persona"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const isJuridica = this.value === 'juridica';
            document.getElementById('divNombreCompleto').style.display = isJuridica ? 'none' : 'block';
            document.getElementById('divRazonSocial').style.display = isJuridica ? 'block' : 'none';
            document.getElementById('modal_dv').style.display = isJuridica ? 'block' : 'none';
            
            if (isJuridica) {
                document.getElementById('modal_tipo_id').value = 'NIT';
            }
        });
    });

    // Guardar nuevo tercero
    async function saveNewTercero() {
        const tipoPersonaRaw = document.querySelector('input[name="modal_tipo_persona"]:checked').value;
        const tipoPersona = tipoPersonaRaw.toLowerCase(); // Convertir a minúsculas para el backend
        const tipoId = document.getElementById('modal_tipo_id').value;
        const identificacion = document.getElementById('modal_identificacion').value;
        const dv = document.getElementById('modal_dv').value;
        const nombreCompleto = document.getElementById('modal_nombre').value;
        const razonSocial = document.getElementById('modal_razon_social').value;
        const codigoPais = document.getElementById('modal_codigo_pais').value;
        const telefono = document.getElementById('modal_telefono').value;
        const telefonoCompleto = telefono ? `${codigoPais} ${telefono}` : null;
        const email = document.getElementById('modal_email').value;
        const departamento = document.getElementById('modal_departamento').value;
        const ciudad = document.getElementById('modal_ciudad').value;
        const direccion = document.getElementById('modal_direccion').value;
        
        // Obtener responsabilidades fiscales seleccionadas
        const responsabilidades = [];
        document.querySelectorAll('input[name="modal_responsabilidades[]"]:checked').forEach(cb => {
            responsabilidades.push(cb.value);
        });

        // Validación
        if (!identificacion) {
            alert('Por favor ingrese el número de identificación');
            return;
        }
        if (tipoPersona === 'natural' && !nombreCompleto) {
            alert('Por favor ingrese el nombre completo');
            return;
        }
        if (tipoPersona === 'juridica' && !razonSocial) {
            alert('Por favor ingrese la razón social');
            return;
        }

        try {
            const response = await fetch('{{ route("terceros.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    tipo_persona: tipoPersona,
                    tipo_identificacion: tipoId,
                    identificacion: identificacion,
                    dv: dv || null,
                    nombre_completo: tipoPersona === 'natural' ? nombreCompleto : null,
                    razon_social: tipoPersona === 'juridica' ? razonSocial : null,
                    codigo_pais: codigoPais || '+57',
                    telefono: telefonoCompleto,
                    email: email || null,
                    departamento: departamento || null,
                    ciudad: ciudad || null,
                    direccion: direccion || null,
                    responsabilidades_fiscales: responsabilidades
                })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                // Obtener el nombre para mostrar
                const nombreMostrar = tipoPersona === 'natural' ? nombreCompleto : razonSocial;
                
                // Agregar a la lista local
                const nuevoTercero = {
                    id: data.tercero.id,
                    nombre: nombreMostrar,
                    tipo_identificacion: tipoId,
                    identificacion: identificacion,
                    telefono: telefono,
                    email: email,
                    direccion: direccion,
                    tipo: tipoPersona === 'natural' ? 'Persona Natural' : 'Persona Jurídica'
                };
                terceros.push(nuevoTercero);
                
                // Seleccionar automáticamente
                selectTercero(nuevoTercero);
                closeNewTerceroModal();
                
                alert('Tercero creado exitosamente');
            } else {
                // Mostrar errores de validación
                let errorMsg = 'Error al crear tercero:\n';
                if (data.errors) {
                    Object.values(data.errors).forEach(errs => {
                        errs.forEach(e => errorMsg += '- ' + e + '\n');
                    });
                } else {
                    errorMsg += data.message || 'Error desconocido';
                }
                alert(errorMsg);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error de conexión al guardar el tercero');
        }
    }

    // Contrato Selection
    document.getElementById('contratoSelect')?.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const infoDiv = document.getElementById('contratoInfo');
        
        if (this.value) {
            document.getElementById('contratoObjeto').textContent = selected.dataset.objeto || '';
            infoDiv.style.display = 'block';
        } else {
            infoDiv.style.display = 'none';
        }
        updateProgress();
    });

    // Progress Steps
    function updateProgress() {
        const hasTercero = document.getElementById('nombreBeneficiario')?.value;
        const hasContrato = document.getElementById('contratoSelect')?.value;
        const hasItems = document.querySelectorAll('#itemsTableBody tr').length > 0;

        // Step 1 - Tercero
        const step1 = document.getElementById('step1');
        const line1 = document.getElementById('line1');
        if (hasTercero) {
            step1.classList.remove('active');
            step1.classList.add('completed');
            line1.classList.add('completed');
        } else {
            step1.classList.add('active');
            step1.classList.remove('completed');
            line1.classList.remove('completed');
        }

        // Step 2 - Contrato
        const step2 = document.getElementById('step2');
        const line2 = document.getElementById('line2');
        if (hasContrato) {
            step2.classList.remove('active');
            step2.classList.add('completed');
            line2.classList.add('completed');
        } else if (hasTercero) {
            step2.classList.add('active');
            step2.classList.remove('completed');
            line2.classList.remove('completed');
        }

        // Step 3 - Items
        const step3 = document.getElementById('step3');
        const line3 = document.getElementById('line3');
        if (hasItems) {
            step3.classList.remove('active');
            step3.classList.add('completed');
            line3.classList.add('completed');
        } else if (hasTercero) {
            step3.classList.add('active');
            step3.classList.remove('completed');
            line3.classList.remove('completed');
        }

        // Step 4 - Review
        const step4 = document.getElementById('step4');
        if (hasTercero && hasItems) {
            step4.classList.add('active');
        }
    }

    // Preview Document
    function previewDocument() {
        alert('Vista previa próximamente');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.siigo-input-group')) {
            dropdown?.classList.remove('active');
        }
    });

    // Close modal on overlay click
    document.getElementById('modalTercero')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeNewTerceroModal();
        }
    });

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        addItemRow(); // Add first row
        updateProgress();
    });
</script>
@endsection
