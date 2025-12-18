@extends('layouts.app')

@section('title', 'Editar Tercero - Dewey Accounts')

@section('content')
<style>
    .edit-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 24px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a2e;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #6b7280;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .btn-back:hover {
        color: #00b5e2;
    }

    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .form-section {
        padding: 32px;
        border-bottom: 1px solid #f3f4f6;
    }

    .form-section:last-child {
        border-bottom: none;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 18px;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 24px;
    }

    .section-title .icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #00b5e2, #00d4ff);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-input, .form-select {
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.2s;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #00b5e2;
        box-shadow: 0 0 0 3px rgba(0, 181, 226, 0.1);
    }

    .form-input:disabled {
        background: #f9fafb;
        color: #6b7280;
    }

    .form-error {
        color: #dc2626;
        font-size: 13px;
        margin-top: 4px;
    }

    .type-switch {
        display: flex;
        gap: 16px;
    }

    .type-option {
        flex: 1;
        padding: 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .type-option:hover {
        border-color: #00b5e2;
    }

    .type-option.active {
        border-color: #00b5e2;
        background: #f0f9ff;
    }

    .type-option input {
        display: none;
    }

    .type-option .icon {
        font-size: 32px;
        margin-bottom: 8px;
        color: #00b5e2;
    }

    .type-option .label {
        font-weight: 600;
        color: #374151;
    }

    .form-actions {
        padding: 24px 32px;
        background: #f9fafb;
        display: flex;
        gap: 16px;
        justify-content: flex-end;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        text-decoration: none;
    }

    .btn-secondary {
        background: white;
        border: 1px solid #e5e7eb;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #f9fafb;
    }

    .btn-primary {
        background: #00b5e2;
        color: white;
    }

    .btn-primary:hover {
        background: #0097be;
        transform: translateY(-1px);
    }

    /* Responsabilidades checkboxes */
    .responsabilidades-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .responsabilidad-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px;
        background: #f9fafb;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .responsabilidad-item:hover {
        background: #f0f9ff;
    }

    .responsabilidad-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: #00b5e2;
    }

    .responsabilidad-item label {
        font-size: 13px;
        color: #374151;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        .form-grid, .form-grid-3 {
            grid-template-columns: 1fr;
        }
        .responsabilidades-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="edit-container">
    <div class="page-header">
        <h1 class="page-title">Editar Tercero</h1>
        <a href="{{ route('terceros.index') }}" class="btn-back">
            <span class="material-symbols-rounded">arrow_back</span>
            Volver al listado
        </a>
    </div>

    <form action="{{ route('terceros.update', $tercero->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-card">
            <!-- Tipo de Persona -->
            <div class="form-section">
                <div class="section-title">
                    <div class="icon">
                        <span class="material-symbols-rounded">badge</span>
                    </div>
                    Tipo de Persona
                </div>

                <div class="type-switch">
                    <label class="type-option {{ $tercero->tipo_persona === 'natural' ? 'active' : '' }}">
                        <input type="radio" name="tipo_persona" value="natural" {{ $tercero->tipo_persona === 'natural' ? 'checked' : '' }} onchange="toggleTipoPersona()">
                        <span class="material-symbols-rounded icon">person</span>
                        <div class="label">Persona Natural</div>
                    </label>
                    <label class="type-option {{ $tercero->tipo_persona === 'juridica' ? 'active' : '' }}">
                        <input type="radio" name="tipo_persona" value="juridica" {{ $tercero->tipo_persona === 'juridica' ? 'checked' : '' }} onchange="toggleTipoPersona()">
                        <span class="material-symbols-rounded icon">domain</span>
                        <div class="label">Persona Jurídica</div>
                    </label>
                </div>
            </div>

            <!-- Identificación -->
            <div class="form-section">
                <div class="section-title">
                    <div class="icon">
                        <span class="material-symbols-rounded">id_card</span>
                    </div>
                    Información de Identificación
                </div>

                <div class="form-grid-3">
                    <div class="form-group">
                        <label class="form-label">Tipo de Identificación</label>
                        <select name="tipo_identificacion" class="form-select" required>
                            <option value="CC" {{ $tercero->tipo_identificacion === 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                            <option value="NIT" {{ $tercero->tipo_identificacion === 'NIT' ? 'selected' : '' }}>NIT</option>
                            <option value="CE" {{ $tercero->tipo_identificacion === 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                            <option value="PA" {{ $tercero->tipo_identificacion === 'PA' ? 'selected' : '' }}>Pasaporte</option>
                            <option value="TI" {{ $tercero->tipo_identificacion === 'TI' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                        </select>
                        @error('tipo_identificacion')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Número de Identificación</label>
                        <input type="text" name="identificacion" class="form-input" value="{{ old('identificacion', $tercero->identificacion) }}" required>
                        @error('identificacion')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group" id="dvGroup" style="{{ $tercero->tipo_persona === 'juridica' ? '' : 'display:none' }}">
                        <label class="form-label">DV</label>
                        <input type="text" name="dv" class="form-input" value="{{ old('dv', $tercero->dv) }}" maxlength="1" style="width: 60px;">
                    </div>
                </div>

                <div class="form-grid" style="margin-top: 24px;">
                    <div class="form-group" id="nombreGroup" style="{{ $tercero->tipo_persona === 'natural' ? '' : 'display:none' }}">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre_completo" class="form-input" value="{{ old('nombre_completo', $tercero->nombre_completo) }}">
                        @error('nombre_completo')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group" id="razonGroup" style="{{ $tercero->tipo_persona === 'juridica' ? '' : 'display:none' }}">
                        <label class="form-label">Razón Social</label>
                        <input type="text" name="razon_social" class="form-input" value="{{ old('razon_social', $tercero->razon_social) }}">
                        @error('razon_social')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contacto -->
            <div class="form-section">
                <div class="section-title">
                    <div class="icon">
                        <span class="material-symbols-rounded">contact_page</span>
                    </div>
                    Información de Contacto
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email', $tercero->email) }}" placeholder="correo@ejemplo.com">
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-input" value="{{ old('telefono', $tercero->telefono) }}" placeholder="+57 300 123 4567">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-input" value="{{ old('direccion', $tercero->direccion) }}" placeholder="Calle, número, barrio...">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Departamento</label>
                        <select name="departamento" class="form-select" id="departamentoSelect">
                            <option value="">Seleccionar...</option>
                            @foreach($departamentos as $dep)
                                <option value="{{ $dep->nombre }}" {{ $tercero->departamento === $dep->nombre ? 'selected' : '' }}>{{ $dep->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Ciudad</label>
                        <input type="text" name="ciudad" class="form-input" value="{{ old('ciudad', $tercero->ciudad) }}" placeholder="Ciudad">
                    </div>
                </div>
            </div>

            <!-- Responsabilidades Fiscales -->
            <div class="form-section">
                <div class="section-title">
                    <div class="icon">
                        <span class="material-symbols-rounded">receipt_long</span>
                    </div>
                    Responsabilidades Fiscales
                </div>

                @php
                    $terceroResponsabilidades = $tercero->responsabilidad_fiscal ?? [];
                @endphp

                <div class="responsabilidades-grid">
                    @foreach($responsabilidadesFiscales as $resp)
                        <div class="responsabilidad-item">
                            <input type="checkbox" 
                                   name="responsabilidades_fiscales[]" 
                                   value="{{ $resp->codigo }}" 
                                   id="resp_{{ $resp->codigo }}"
                                   {{ in_array($resp->codigo, $terceroResponsabilidades) ? 'checked' : '' }}>
                            <label for="resp_{{ $resp->codigo }}">
                                <strong>{{ $resp->codigo }}</strong> - {{ $resp->nombre }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <a href="{{ route('terceros.index') }}" class="btn btn-secondary">
                    <span class="material-symbols-rounded">close</span>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <span class="material-symbols-rounded">save</span>
                    Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleTipoPersona() {
        const isJuridica = document.querySelector('input[name="tipo_persona"]:checked').value === 'juridica';
        
        document.getElementById('nombreGroup').style.display = isJuridica ? 'none' : '';
        document.getElementById('razonGroup').style.display = isJuridica ? '' : 'none';
        document.getElementById('dvGroup').style.display = isJuridica ? '' : 'none';

        // Update active state
        document.querySelectorAll('.type-option').forEach(opt => {
            opt.classList.remove('active');
        });
        document.querySelector('input[name="tipo_persona"]:checked').closest('.type-option').classList.add('active');
    }
</script>
@endsection
