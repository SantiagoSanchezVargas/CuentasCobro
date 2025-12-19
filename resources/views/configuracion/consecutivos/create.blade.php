@extends('layouts.app')

@section('title', 'Crear Consecutivo')

@section('content')
<style>
    .create-container {
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

    .info-box {
        grid-column: span 2;
        background: #e0f4ff;
        border-radius: 10px;
        padding: 14px 16px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .info-box .icon {
        color: #0369a1;
        font-size: 20px;
    }

    .info-box .content {
        font-size: 13px;
        color: #0c4a6e;
        line-height: 1.5;
    }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-group.full-width { grid-column: span 1; }
        .section-divider { grid-column: span 1; }
        .info-box { grid-column: span 1; flex-direction: column; }
    }
</style>

<div class="create-container">
    <div class="page-header">
        <h1>
            <span class="material-symbols-rounded icon">add_circle</span>
            Nuevo Consecutivo
        </h1>
        <p>Configure un nuevo rango de numeración para sus documentos fiscales.</p>
    </div>

    <div class="form-card">
        <div class="form-header">
            <h2>
                <span class="material-symbols-rounded">123</span>
                Datos del Consecutivo
            </h2>
        </div>

        <form action="{{ route('admin.consecutivos.store') }}" method="POST">
            @csrf
            
            <div class="form-body">
                <div class="form-grid">
                    <!-- Tipo de Documento -->
                    <div class="form-group full-width">
                        <label>
                            <span class="material-symbols-rounded icon">description</span>
                            Tipo de Documento <span class="required">*</span>
                        </label>
                        <select name="tipo_documento" class="form-select" required>
                            <option value="">Seleccione un tipo...</option>
                            <option value="Cuenta de Cobro">Cuenta de Cobro</option>
                            <option value="Documento Soporte">Documento Soporte</option>
                            <option value="Factura de Venta">Factura de Venta</option>
                        </select>
                    </div>

                    <!-- Prefijo -->
                    <div class="form-group">
                        <label>
                            <span class="material-symbols-rounded icon">tag</span>
                            Prefijo
                        </label>
                        <input type="text" name="prefijo" class="form-input" placeholder="Ej: CC, DS, FV" maxlength="10">
                        <span class="help-text">Opcional. Máximo 10 caracteres.</span>
                    </div>

                    <!-- Resolución DIAN -->
                    <div class="form-group">
                        <label>
                            <span class="material-symbols-rounded icon">verified</span>
                            Resolución DIAN
                        </label>
                        <input type="text" name="resolucion" class="form-input" placeholder="Número de resolución">
                        <span class="help-text">Si aplica para facturación electrónica.</span>
                    </div>

                    <div class="section-divider">
                        <div class="section-title">
                            <span class="material-symbols-rounded">format_list_numbered</span>
                            Rango de Numeración
                        </div>
                    </div>

                    <!-- Número Inicial -->
                    <div class="form-group">
                        <label>
                            <span class="material-symbols-rounded icon">first_page</span>
                            Número Inicial <span class="required">*</span>
                        </label>
                        <input type="number" name="numero_inicial" class="form-input" placeholder="1" min="1" required>
                    </div>

                    <!-- Número Final -->
                    <div class="form-group">
                        <label>
                            <span class="material-symbols-rounded icon">last_page</span>
                            Número Final <span class="required">*</span>
                        </label>
                        <input type="number" name="numero_final" class="form-input" placeholder="99999" min="1" required>
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
                        <input type="date" name="vigencia_inicio" class="form-input" required>
                    </div>

                    <!-- Vigencia Fin -->
                    <div class="form-group">
                        <label>
                            <span class="material-symbols-rounded icon">event_upcoming</span>
                            Vigencia Hasta <span class="required">*</span>
                        </label>
                        <input type="date" name="vigencia_fin" class="form-input" required>
                    </div>

                    <!-- Info Box -->
                    <div class="info-box">
                        <span class="material-symbols-rounded icon">info</span>
                        <div class="content">
                            <strong>Nota:</strong> El consecutivo se activará automáticamente al guardarse. 
                            El número actual iniciará en el número inicial configurado.
                        </div>
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
                    Guardar Consecutivo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
