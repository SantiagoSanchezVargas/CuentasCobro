@extends('layouts.app')

@section('title', 'Editar Consecutivo')

@section('content')
<style>
    .edit-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 24px;
    }

    .page-header {
        margin-bottom: 24px;
    }

    .page-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .page-header h1 .icon {
        color: #00b5e2;
    }

    .page-header p {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #1e3a5f 0%, #2d4a6f 100%);
        padding: 20px 24px;
        color: white;
    }

    .form-header h2 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-body {
        padding: 24px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-group label .required {
        color: #ef4444;
    }

    .form-group label .icon {
        font-size: 16px;
        color: #6b7280;
    }

    .form-input, .form-select {
        padding: 12px 14px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s;
        background: #fafafa;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #00b5e2;
        background: white;
        box-shadow: 0 0 0 3px rgba(0, 181, 226, 0.1);
    }

    .form-input:disabled {
        background: #f1f5f9;
        color: #64748b;
        cursor: not-allowed;
    }

    .form-input::placeholder {
        color: #9ca3af;
    }

    .help-text {
        font-size: 11px;
        color: #6b7280;
        margin-top: 4px;
    }

    .section-divider {
        grid-column: span 2;
        border-top: 1px solid #e5e7eb;
        margin: 8px 0;
        padding-top: 16px;
    }

    .section-title {
        font-size: 14px;
        font-weight: 600;
        color: #1e3a5f;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
    }

    .form-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        background: #f8fafc;
        border-top: 1px solid #e5e7eb;
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        font-size: 14px;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
        color: #1f2937;
    }

    .btn-submit {
        background: linear-gradient(135deg, #00b5e2 0%, #0097be 100%);
        color: white;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        font-size: 14px;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #0097be 0%, #007a9a 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 181, 226, 0.3);
    }

    .status-card {
        grid-column: span 2;
        background: #f8fafc;
        border-radius: 12px;
        padding: 16px 20px;
        border: 2px solid #e2e8f0;
    }

    .status-card .status-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
    }

    .status-card .status-header h4 {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .toggle-switch {
        position: relative;
        width: 52px;
        height: 28px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: 0.3s;
        border-radius: 28px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .toggle-switch input:checked + .toggle-slider {
        background-color: #22c55e;
    }

    .toggle-switch input:checked + .toggle-slider:before {
        transform: translateX(24px);
    }

    .current-info {
        display: flex;
        align-items: center;
        gap: 16px;
        background: #e0f4ff;
        padding: 12px 16px;
        border-radius: 8px;
    }

    .current-info .label {
        font-size: 12px;
        color: #0369a1;
        font-weight: 500;
    }

    .current-info .value {
        font-family: monospace;
        font-size: 20px;
        font-weight: 700;
        color: #0c4a6e;
    }

    .progress-section {
        margin-top: 12px;
    }

    .progress-section .label {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 6px;
        display: flex;
        justify-content: space-between;
    }

    .progress-bar {
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar .fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.3s;
    }

    .progress-bar .fill.low { background: linear-gradient(90deg, #22c55e, #4ade80); }
    .progress-bar .fill.medium { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .progress-bar .fill.high { background: linear-gradient(90deg, #ef4444, #f87171); }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full-width { grid-column: span 1; }
        .section-divider { grid-column: span 1; }
        .status-card { grid-column: span 1; }
    }
</style>

<div class="edit-container">
    <div class="page-header">
        <h1>
            <span class="material-symbols-rounded icon">edit</span>
            Editar Consecutivo
        </h1>
        <p>Modifique la configuración del consecutivo.</p>
    </div>

    <div class="form-card">
        <div class="form-header">
            <h2>
                <span class="material-symbols-rounded">123</span>
                {{ $consecutivo->prefijo ? $consecutivo->prefijo . ' - ' : '' }}{{ $consecutivo->tipo_documento }}
            </h2>
        </div>

        <form action="{{ route('admin.consecutivos.update', $consecutivo) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-body">
                <div class="form-grid">
                    <!-- Status Card -->
                    @php
                        $totalRange = $consecutivo->numero_final - $consecutivo->numero_inicial;
                        $used = $consecutivo->numero_actual - $consecutivo->numero_inicial;
                        $usagePercent = $totalRange > 0 ? ($used / $totalRange) * 100 : 0;
                        $usageClass = $usagePercent < 60 ? 'low' : ($usagePercent < 85 ? 'medium' : 'high');
                    @endphp
                    <div class="status-card">
                        <div class="status-header">
                            <h4>
                                <span class="material-symbols-rounded">toggle_on</span>
                                Estado del Consecutivo
                            </h4>
                            <label class="toggle-switch">
                                <input type="checkbox" name="activo" value="1" {{ $consecutivo->activo ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                        <div class="current-info">
                            <div>
                                <div class="label">Número Actual</div>
                                <div class="value">{{ number_format($consecutivo->numero_actual) }}</div>
                            </div>
                            <div style="flex: 1;"></div>
                            <div>
                                <div class="label">Disponibles</div>
                                <div class="value">{{ number_format($consecutivo->numero_final - $consecutivo->numero_actual) }}</div>
                            </div>
                        </div>
                        <div class="progress-section">
                            <div class="label">
                                <span>Uso del rango</span>
                                <span style="font-weight: 600; color: {{ $usageClass === 'high' ? '#ef4444' : ($usageClass === 'medium' ? '#f59e0b' : '#22c55e') }};">
                                    {{ number_format($usagePercent, 1) }}%
                                </span>
                            </div>
                            <div class="progress-bar">
                                <div class="fill {{ $usageClass }}" style="width: {{ min($usagePercent, 100) }}%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Tipo de Documento -->
                    <div class="form-group full-width">
                        <label>
                            <span class="material-symbols-rounded icon">description</span>
                            Tipo de Documento <span class="required">*</span>
                        </label>
                        <select name="tipo_documento" class="form-select" required>
                            <option value="Cuenta de Cobro" {{ $consecutivo->tipo_documento == 'Cuenta de Cobro' ? 'selected' : '' }}>Cuenta de Cobro</option>
                            <option value="Documento Soporte" {{ $consecutivo->tipo_documento == 'Documento Soporte' ? 'selected' : '' }}>Documento Soporte</option>
                            <option value="Factura de Venta" {{ $consecutivo->tipo_documento == 'Factura de Venta' ? 'selected' : '' }}>Factura de Venta</option>
                        </select>
                    </div>

                    <!-- Prefijo -->
                    <div class="form-group">
                        <label>
                            <span class="material-symbols-rounded icon">tag</span>
                            Prefijo
                        </label>
                        <input type="text" name="prefijo" value="{{ $consecutivo->prefijo }}" class="form-input" placeholder="Ej: CC, DS, FV" maxlength="10">
                    </div>

                    <!-- Resolución DIAN -->
                    <div class="form-group">
                        <label>
                            <span class="material-symbols-rounded icon">verified</span>
                            Resolución DIAN
                        </label>
                        <input type="text" name="resolucion" value="{{ $consecutivo->resolucion }}" class="form-input" placeholder="Número de resolución">
                    </div>

                    <div class="section-divider">
                        <div class="section-title">
                            <span class="material-symbols-rounded">format_list_numbered</span>
                            Rango de Numeración
                        </div>
                    </div>

                    <!-- Número Inicial (No editable) -->
                    <div class="form-group">
                        <label>
                            <span class="material-symbols-rounded icon">first_page</span>
                            Número Inicial
                        </label>
                        <input type="number" value="{{ $consecutivo->numero_inicial }}" class="form-input" disabled>
                        <input type="hidden" name="numero_inicial" value="{{ $consecutivo->numero_inicial }}">
                        <span class="help-text">No se puede modificar una vez creado.</span>
                    </div>

                    <!-- Número Final -->
                    <div class="form-group">
                        <label>
                            <span class="material-symbols-rounded icon">last_page</span>
                            Número Final <span class="required">*</span>
                        </label>
                        <input type="number" name="numero_final" value="{{ $consecutivo->numero_final }}" class="form-input" min="{{ $consecutivo->numero_actual }}" required>
                        <span class="help-text">Debe ser mayor o igual al número actual.</span>
                    </div>

                    <div class="section-divider">
                        <div class="section-title">
                            <span class="material-symbols-rounded">date_range</span>
                            Período de Vigencia
                        </div>
                    </div>

                    <!-- Vigencia Inicio -->
                    <div class="form-group">
                        <label>
                            <span class="material-symbols-rounded icon">event</span>
                            Vigencia Desde <span class="required">*</span>
                        </label>
                        <input type="date" name="vigencia_inicio" value="{{ $consecutivo->vigencia_inicio->format('Y-m-d') }}" class="form-input" required>
                    </div>

                    <!-- Vigencia Fin -->
                    <div class="form-group">
                        <label>
                            <span class="material-symbols-rounded icon">event_upcoming</span>
                            Vigencia Hasta <span class="required">*</span>
                        </label>
                        <input type="date" name="vigencia_fin" value="{{ $consecutivo->vigencia_fin->format('Y-m-d') }}" class="form-input" required>
                    </div>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.consecutivos.index') }}" class="btn-cancel">
                    <span class="material-symbols-rounded" style="font-size: 18px;">arrow_back</span>
                    Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    <span class="material-symbols-rounded" style="font-size: 18px;">save</span>
                    Actualizar Consecutivo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
