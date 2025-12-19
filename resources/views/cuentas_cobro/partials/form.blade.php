<style>
    /* Wix-inspired Form Styles */
    :root {
        --wix-blue: #116dff;
        --wix-dark: #20303c;
        --wix-gray: #f4f4f4;
        --wix-text: #162d3d;
        --wix-border: #eef1f5;
        --wix-input-bg: #ffffff;
        --wix-focus-shadow: rgba(17, 109, 255, 0.15);
    }

    .form-body {
        padding: 40px;
    }

    .form-section {
        margin-bottom: 40px;
        padding-bottom: 40px;
        border-bottom: 1px solid var(--wix-border);
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 20px;
        font-weight: 700;
        color: var(--wix-text);
        margin-bottom: 24px;
    }

    .section-title .material-symbols-rounded {
        color: var(--wix-blue);
        font-size: 24px;
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
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: var(--wix-text);
        margin-bottom: 8px;
    }

    .form-label .material-symbols-rounded {
        font-size: 18px;
        color: #8795a1;
    }

    .form-label .optional-tag {
        font-size: 12px;
        font-weight: 500;
        color: #8795a1;
        background: #f0f2f5;
        padding: 2px 8px;
        border-radius: 12px;
    }

    .form-input-wrapper {
        position: relative;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 12px 16px 12px 44px; /* Left padding for icon */
        font-size: 15px;
        border: 1px solid #cfd4da;
        border-radius: 8px; /* Sharper corners */
        outline: none;
        transition: all 0.2s ease;
        background: var(--wix-input-bg);
        color: var(--wix-text);
        font-family: 'Inter', sans-serif;
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
        line-height: 1.5;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: var(--wix-blue);
        box-shadow: 0 0 0 4px var(--wix-focus-shadow);
    }

    .form-input.is-invalid,
    .form-select.is-invalid,
    .form-textarea.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .form-input[readonly] {
        background: #f9fafb;
        cursor: not-allowed;
        color: #6b7c93;
    }

    .form-icon {
        position: absolute;
        left: 14px;
        top: 13px;
        color: #9ca3af;
        font-size: 20px;
        pointer-events: none;
        transition: color 0.2s ease;
    }

    .form-input:focus ~ .form-icon,
    .form-select:focus ~ .form-icon,
    .form-textarea:focus ~ .form-icon {
        color: var(--wix-blue);
    }

    .form-error {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 6px;
        color: #ef4444;
        font-size: 13px;
    }

    /* Optional Sections (Details/Summary) */
    details.optional-section {
        border: 1px solid var(--wix-border);
        border-radius: 8px;
        background: #fcfcfd;
        margin-bottom: 24px;
    }

    details.optional-section summary {
        list-style: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        transition: background 0.2s;
    }

    details.optional-section summary:hover {
        background: #f9fafb;
    }

    details.optional-section summary::-webkit-details-marker {
        display: none;
    }

    details.optional-section .section-title {
        margin-bottom: 0;
        font-size: 16px;
    }

    .badge-optional {
        font-size: 12px;
        font-weight: 600;
        color: #6b7c93;
        background: #eef1f5;
        padding: 4px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .optional-content {
        padding: 24px;
        border-top: 1px solid var(--wix-border);
        background: white;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    /* Items Section */
    .items-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .items-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .item-row {
        background: #f9fafb;
        border: 1px solid var(--wix-border);
        border-radius: 8px;
        padding: 20px;
        display: grid;
        grid-template-columns: 2fr 2fr 1fr 1.5fr auto;
        gap: 16px;
        align-items: start;
        transition: all 0.2s ease;
    }

    .item-row:hover {
        border-color: #d1d5db;
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .item-row .form-input {
        background: white;
    }

    .btn-remove-item {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border: 1px solid #fee2e2;
        border-radius: 8px;
        background: #fef2f2;
        color: #ef4444;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 28px; /* Align with inputs */
    }

    .btn-remove-item:hover {
        background: #fee2e2;
        border-color: #fecaca;
    }

    .btn-add-item {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid var(--wix-blue);
        background: white;
        color: var(--wix-blue);
        margin-top: 24px;
    }

    .btn-add-item:hover {
        background: #f0f7ff;
    }

    /* Total Display */
    .total-display {
        background: var(--wix-dark);
        border-radius: 12px;
        padding: 32px;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        margin-top: 40px;
    }

    .total-display-label {
        font-size: 14px;
        opacity: 0.7;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .total-display-value {
        font-size: 42px;
        font-weight: 700;
        letter-spacing: -1px;
    }

    .totals-breakdown {
        width: 100%;
        max-width: 400px;
        margin-top: 24px;
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 24px;
    }

    .totals-breakdown .row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        font-size: 14px;
        color: rgba(255,255,255,0.8);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        margin-top: 40px;
        padding-top: 32px;
        border-top: 1px solid var(--wix-border);
    }

    .btn-cancel,
    .btn-submit {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 14px 32px;
        border-radius: 30px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        text-decoration: none;
    }

    .btn-cancel {
        background: white;
        border: 1px solid #d1d5db;
        color: var(--wix-text);
    }

    .btn-cancel:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }

    .btn-submit {
        background: var(--wix-blue);
        color: white;
        box-shadow: 0 4px 14px rgba(17, 109, 255, 0.3);
    }

    .btn-submit:hover {
        background: #0056d6;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(17, 109, 255, 0.4);
    }

    @media (max-width: 1024px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .item-row {
            grid-template-columns: 1fr;
        }
        .btn-remove-item {
            margin-top: 0;
        }
    }

    @media (max-width: 768px) {
        .form-body {
            padding: 24px;
        }
        .form-grid-3 {
            grid-template-columns: 1fr;
        }
        .form-actions {
            flex-direction: column;
        }
        .btn-cancel,
        .btn-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="form-body">
    @php
        $tipoDocumentoOpciones = [
            'CC' => 'Cédula de Ciudadanía',
            'CE' => 'Cédula de Extranjería',
            'NIT' => 'NIT',
            'PA' => 'Pasaporte',
        ];
        $formatDateTimeInput = function ($value) {
            if (empty($value)) {
                return '';
            }
            try {
                return \Illuminate\Support\Carbon::parse($value)->format('Y-m-d\\TH:i');
            } catch (\Throwable $th) {
                return $value;
            }
        };
        $departamentoSeleccionado = old('departamento', $cuenta->departamento ?? '');
        $municipioSeleccionado = old('municipio', $cuenta->municipio ?? '');
        $municipiosDisponibles = [];
        if ($departamentoSeleccionado && isset($departamentos) && isset($departamentos[$departamentoSeleccionado])) {
            $municipiosDisponibles = $departamentos[$departamentoSeleccionado];
        }
        $hasFieldValue = function (string $field) use ($cuenta) {
            $oldValue = old($field);
            if (is_array($oldValue)) {
                foreach ($oldValue as $value) {
                    if ($value !== null && $value !== '') {
                        return true;
                    }
                }
            } elseif ($oldValue !== null && $oldValue !== '') {
                return true;
            }
            if (isset($cuenta)) {
                $value = data_get($cuenta, $field);
                if ($value !== null && $value !== '') {
                    return true;
                }
            }
            return false;
        };
        $shouldOpenSection = function (array $fields) use ($hasFieldValue, $errors) {
            foreach ($fields as $field) {
                if ($hasFieldValue($field) || $errors->has($field)) {
                    return true;
                }
            }
            return false;
        };
        $existingSoportes = isset($cuenta) ? ($cuenta->soportes ?? collect()) : collect();
        $canManageAttachments = isset($cuenta) && auth()->check() && $cuenta->isOwner(auth()->user()) && in_array($cuenta->estado_aprobacion, ['en_revision', 'en_correccion']);
        $supportErrors = $errors->get('soportes.*');
    @endphp
    {{-- Sección: Datos del Vendedor (Beneficiario) --}}
    <details class="form-section optional-section" open>
        <summary>
            <span class="section-title">
                <span class="material-symbols-rounded">person</span>
                Datos del Vendedor (Beneficiario)
            </span>
        </summary>
        <div class="optional-content">
        <div class="form-grid">
            <!-- Search/Select Component -->
            <div class="form-group full-width" id="beneficiario-search-container">
                <label class="form-label">Buscar Vendedor</label>
                <div class="form-input-wrapper" style="display:flex; gap:8px;">
                    <input type="text" id="search_beneficiario" class="form-input" placeholder="Buscar por nombre o identificación..." onkeyup="handleTerceroSearch(this.value, 'beneficiario')">
                    <span class="material-symbols-rounded form-icon">search</span>
                    <button type="button" onclick="openTerceroModal('beneficiario')" class="btn-add-item" style="margin:0; padding:0 12px; border-radius:8px;" title="Crear Nuevo">
                        <span class="material-symbols-rounded">add</span>
                    </button>
                </div>
                <div id="beneficiario-results" class="search-results" style="display:none; position:absolute; z-index:1000; background:white; border:1px solid #ddd; width:100%; max-height:200px; overflow-y:auto;"></div>
            </div>

            <!-- Selected Info Card (Initially Hidden) -->
            <div class="form-group full-width" id="beneficiario-selected-card" style="display:none;">
                <div style="background:#f8f9fa; padding:15px; border-radius:8px; border:1px solid #e9ecef; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <strong id="beneficiario-display-name" style="display:block; font-size:1.1em; color:#2c3e50;"></strong>
                        <span id="beneficiario-display-id" style="color:#6c757d; font-size:0.9em;"></span>
                    </div>
                    <button type="button" onclick="clearTerceroSelection('beneficiario')" style="background:none; border:none; color:#dc3545; cursor:pointer;">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>
            </div>

            <!-- Hidden Fields for Form Submission -->
            <input type="hidden" name="tipo_identificacion" id="tipo_identificacion" value="{{ old('tipo_identificacion', $cuenta->tipo_identificacion ?? '') }}">
            <input type="hidden" name="identificacion" id="identificacion" value="{{ old('identificacion', $cuenta->identificacion ?? '') }}">
            <input type="hidden" name="nombre_beneficiario" id="nombre_beneficiario" value="{{ old('nombre_beneficiario', $cuenta->nombre_beneficiario ?? '') }}">
            <input type="hidden" name="tipo_cliente" id="tipo_cliente" value="{{ old('tipo_cliente', $cuenta->tipo_cliente ?? '') }}">
        </div>
        </div>
    </details>

    {{-- Sección: Datos del Comprador (Deudor) --}}
    <details class="form-section optional-section" open>
        <summary>
            <span class="section-title">
                <span class="material-symbols-rounded">domain</span>
                Datos del Comprador (Deudor)
            </span>
        </summary>
        <div class="optional-content">
        <div class="form-grid">
            <!-- Search/Select Component -->
            <div class="form-group full-width" id="deudor-search-container">
                <label class="form-label">Buscar Comprador</label>
                <div class="form-input-wrapper" style="display:flex; gap:8px;">
                    <input type="text" id="search_deudor" class="form-input" placeholder="Buscar por nombre o identificación..." onkeyup="handleTerceroSearch(this.value, 'deudor')">
                    <span class="material-symbols-rounded form-icon">search</span>
                    <button type="button" onclick="openTerceroModal('deudor')" class="btn-add-item" style="margin:0; padding:0 12px; border-radius:8px;" title="Crear Nuevo">
                        <span class="material-symbols-rounded">add</span>
                    </button>
                </div>
                <div id="deudor-results" class="search-results" style="display:none; position:absolute; z-index:1000; background:white; border:1px solid #ddd; width:100%; max-height:200px; overflow-y:auto;"></div>
            </div>

            <!-- Selected Info Card (Initially Hidden) -->
            <div class="form-group full-width" id="deudor-selected-card" style="display:none;">
                <div style="background:#f8f9fa; padding:15px; border-radius:8px; border:1px solid #e9ecef; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <strong id="deudor-display-name" style="display:block; font-size:1.1em; color:#2c3e50;"></strong>
                        <span id="deudor-display-id" style="color:#6c757d; font-size:0.9em;"></span>
                        <br>
                        <span id="deudor-display-email" style="color:#6c757d; font-size:0.85em;"></span>
                    </div>
                    <button type="button" onclick="clearTerceroSelection('deudor')" style="background:none; border:none; color:#dc3545; cursor:pointer;">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>
            </div>

            <!-- Hidden Fields for Form Submission -->
            <input type="hidden" name="nombre_deudor" id="nombre_deudor" value="{{ old('nombre_deudor', $cuenta->nombre_deudor ?? '') }}">
            <input type="hidden" name="tipo_documento_deudor" id="tipo_documento_deudor" value="{{ old('tipo_documento_deudor', $cuenta->tipo_documento_deudor ?? '') }}">
            <input type="hidden" name="numero_documento_deudor" id="numero_documento_deudor" value="{{ old('numero_documento_deudor', $cuenta->numero_documento_deudor ?? '') }}">
            <input type="hidden" name="email_deudor" id="email_deudor" value="{{ old('email_deudor', $cuenta->email_deudor ?? '') }}">
            <input type="hidden" name="telefono_deudor" id="telefono_deudor" value="{{ old('telefono_deudor', $cuenta->telefono_deudor ?? '') }}">
        </div>
        </div>
    </details>

    {{-- Sección: Datos de la Cuenta --}}
    <div class="form-section">
        <h2 class="section-title">
            <span class="material-symbols-rounded">description</span>
            Datos de la Cuenta de Cobro
        </h2>

        <div class="form-grid">
            <div class="form-group">
                <label for="numero" class="form-label">
                    <span class="material-symbols-rounded">numbers</span>
                    Número de Cuenta
                </label>
                <div class="form-input-wrapper">
                    @if(isset($cuenta) && $cuenta->exists)
                        <input 
                            type="text" 
                            id="numero" 
                            name="numero" 
                            value="{{ old('numero', $cuenta->numero) }}" 
                            class="form-input" 
                            readonly
                            style="background-color: #f3f4f6;"
                        >
                    @else
                        <input 
                            type="text" 
                            class="form-input" 
                            value="Generado automáticamente al guardar" 
                            readonly
                            style="background-color: #f3f4f6; color: #6b7280; font-style: italic;"
                        >
                    @endif
                    <span class="material-symbols-rounded form-icon">confirmation_number</span>
                </div>
                @error('numero')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="fecha_emision" class="form-label">
                    <span class="material-symbols-rounded">event</span>
                    Fecha de Emisión
                </label>
                <div class="form-input-wrapper">
                    <input 
                        type="date" 
                        id="fecha_emision" 
                        name="fecha_emision" 
                        value="{{ old('fecha_emision', $cuenta->fecha_emision ?? '') }}" 
                        class="form-input @error('fecha_emision') is-invalid @enderror" 
                        required
                    >
                    <span class="material-symbols-rounded form-icon">calendar_today</span>
                </div>
                @error('fecha_emision')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>


        </div>
    </div>



    {{-- Sección: Ítems --}}
    <div class="form-section">
        <div class="items-header">
            <h2 class="section-title" style="margin-bottom: 0; border-bottom: none;">
                <span class="material-symbols-rounded">inventory_2</span>
                Ítems de la Cuenta de Cobro
            </h2>
        </div>

        <div id="items-container" class="items-container">
            @php
                $itemsOld = old('items', $cuenta->items ?? []);
                $itemsOld = is_array($itemsOld) ? $itemsOld : $itemsOld->toArray();
            @endphp
            @forelse($itemsOld as $i => $item)
                <div class="item-row">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">label</span>
                            Nombre del Ítem
                        </label>
                        <div class="form-input-wrapper">
                            <input type="text" name="items[{{ $i }}][item]" value="{{ $item['item'] ?? '' }}" placeholder="Ej: Desarrollo de software" class="form-input" required>
                            <span class="material-symbols-rounded form-icon">shopping_cart</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">info</span>
                            Detalle
                        </label>
                        <div class="form-input-wrapper">
                            <input type="text" name="items[{{ $i }}][detalle]" value="{{ $item['detalle'] ?? '' }}" placeholder="Detalle adicional" class="form-input">
                            <span class="material-symbols-rounded form-icon">description</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">production_quantity_limits</span>
                            Cantidad
                        </label>
                        <div class="form-input-wrapper">
                            <input type="number" name="items[{{ $i }}][cantidad]" value="{{ $item['cantidad'] ?? 1 }}" placeholder="1" class="form-input" min="1" required>
                            <span class="material-symbols-rounded form-icon">add_circle</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">payments</span>
                            Precio Unitario
                        </label>
                        <div class="form-input-wrapper">
                            <input type="number" name="items[{{ $i }}][precio_unitario]" value="{{ $item['precio_unitario'] ?? 0 }}" placeholder="0.00" class="form-input" step="0.01" required>
                            <span class="material-symbols-rounded form-icon">attach_money</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">percent</span>
                            IVA (%)
                        </label>
                        <div class="form-input-wrapper">
                            <input type="number" name="items[{{ $i }}][iva]" value="{{ $item['iva'] ?? 19 }}" placeholder="19" class="form-input" step="0.01" min="0" max="100">
                            <span class="material-symbols-rounded form-icon">percent</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">price_check</span>
                            Retefuente (%)
                        </label>
                        <div class="form-input-wrapper">
                            <input type="number" name="items[{{ $i }}][retefuente]" value="{{ $item['retefuente'] ?? 0 }}" placeholder="0" class="form-input" step="0.01" min="0" max="100">
                            <span class="material-symbols-rounded form-icon">remove</span>
                        </div>
                    </div>

                    <button type="button" class="btn-remove-item">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>
            @empty
                <div class="item-row">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">label</span>
                            Nombre del Ítem
                        </label>
                        <div class="form-input-wrapper">
                            <input type="text" name="items[0][item]" placeholder="Ej: Desarrollo de software" class="form-input" required>
                            <span class="material-symbols-rounded form-icon">shopping_cart</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">info</span>
                            Detalle
                        </label>
                        <div class="form-input-wrapper">
                            <input type="text" name="items[0][detalle]" placeholder="Detalle adicional" class="form-input">
                            <span class="material-symbols-rounded form-icon">description</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">production_quantity_limits</span>
                            Cantidad
                        </label>
                        <div class="form-input-wrapper">
                            <input type="number" name="items[0][cantidad]" placeholder="1" class="form-input" min="1" value="1" required>
                            <span class="material-symbols-rounded form-icon">add_circle</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">payments</span>
                            Precio Unitario
                        </label>
                        <div class="form-input-wrapper">
                            <input type="number" name="items[0][precio_unitario]" placeholder="0.00" class="form-input" step="0.01" required>
                            <span class="material-symbols-rounded form-icon">attach_money</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">percent</span>
                            IVA (%)
                        </label>
                        <div class="form-input-wrapper">
                            <input type="number" name="items[0][iva]" value="19" placeholder="19" class="form-input" step="0.01" min="0" max="100">
                            <span class="material-symbols-rounded form-icon">percent</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="material-symbols-rounded">price_check</span>
                            Retefuente (%)
                        </label>
                        <div class="form-input-wrapper">
                            <input type="number" name="items[0][retefuente]" value="0" placeholder="0" class="form-input" step="0.01" min="0" max="100">
                            <span class="material-symbols-rounded form-icon">remove</span>
                        </div>
                    </div>

                    <button type="button" class="btn-remove-item">
                        <span class="material-symbols-rounded">close</span>
                    </button>
                </div>
            @endforelse
        </div>

        <button type="button" class="btn-add-item" id="add-item">
            <span class="material-symbols-rounded">add</span>
            Agregar Ítem
        </button>
    </div>

    {{-- Sección: Datos del Acreedor --}}
    @php
        $openAcreedor = $shouldOpenSection([
            'nombre_acreedor','tipo_documento_acreedor','numero_documento_acreedor',
            'ciudad_expedicion_acreedor','direccion_acreedor','telefono_acreedor','email_acreedor'
        ]);
    @endphp
    <details class="form-section optional-section" {{ $openAcreedor ? 'open' : '' }}>
        <summary>
            <span class="section-title">
                <span class="material-symbols-rounded">account_balance</span>
                Datos del Acreedor
            </span>
            <span class="badge-optional">
                <span class="material-symbols-rounded" style="font-size:1rem;">info</span>
                Opcional
            </span>
        </summary>
        <div class="optional-content">
        <div class="form-grid">
            <div class="form-group">
                <label for="nombre_acreedor" class="form-label">
                    <span class="material-symbols-rounded">badge</span>
                    Nombre del Acreedor
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="nombre_acreedor"
                        name="nombre_acreedor"
                        class="form-input @error('nombre_acreedor') is-invalid @enderror"
                        value="{{ old('nombre_acreedor', $cuenta->nombre_acreedor ?? '') }}"
                        placeholder="Persona o entidad acreedora"
                    >
                    <span class="material-symbols-rounded form-icon">person</span>
                </div>
                @error('nombre_acreedor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tipo_documento_acreedor" class="form-label">
                    <span class="material-symbols-rounded">how_to_reg</span>
                    Tipo de Documento
                </label>
                <div class="form-input-wrapper">
                    <select
                        id="tipo_documento_acreedor"
                        name="tipo_documento_acreedor"
                        class="form-select @error('tipo_documento_acreedor') is-invalid @enderror"
                    >
                        <option value="">Seleccione...</option>
                        @foreach($tipoDocumentoOpciones as $value => $label)
                            <option value="{{ $value }}" {{ old('tipo_documento_acreedor', $cuenta->tipo_documento_acreedor ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-rounded form-icon">id_card</span>
                </div>
                @error('tipo_documento_acreedor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="numero_documento_acreedor" class="form-label">
                    <span class="material-symbols-rounded">fingerprint</span>
                    Número de Documento
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="numero_documento_acreedor"
                        name="numero_documento_acreedor"
                        class="form-input @error('numero_documento_acreedor') is-invalid @enderror"
                        value="{{ old('numero_documento_acreedor', $cuenta->numero_documento_acreedor ?? '') }}"
                        placeholder="123456789"
                    >
                    <span class="material-symbols-rounded form-icon">tag</span>
                </div>
                @error('numero_documento_acreedor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="ciudad_expedicion_acreedor" class="form-label">
                    <span class="material-symbols-rounded">location_city</span>
                    Ciudad de Expedición
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="ciudad_expedicion_acreedor"
                        name="ciudad_expedicion_acreedor"
                        class="form-input @error('ciudad_expedicion_acreedor') is-invalid @enderror"
                        value="{{ old('ciudad_expedicion_acreedor', $cuenta->ciudad_expedicion_acreedor ?? '') }}"
                        placeholder="Ciudad donde se expidió el documento"
                    >
                    <span class="material-symbols-rounded form-icon">location_city</span>
                </div>
                @error('ciudad_expedicion_acreedor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="direccion_acreedor" class="form-label">
                    <span class="material-symbols-rounded">home_pin</span>
                    Dirección
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="direccion_acreedor"
                        name="direccion_acreedor"
                        class="form-input @error('direccion_acreedor') is-invalid @enderror"
                        value="{{ old('direccion_acreedor', $cuenta->direccion_acreedor ?? '') }}"
                        placeholder="Dirección de contacto"
                    >
                    <span class="material-symbols-rounded form-icon">home</span>
                </div>
                @error('direccion_acreedor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="telefono_acreedor" class="form-label">
                    <span class="material-symbols-rounded">call</span>
                    Teléfono
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="telefono_acreedor"
                        name="telefono_acreedor"
                        class="form-input @error('telefono_acreedor') is-invalid @enderror"
                        value="{{ old('telefono_acreedor', $cuenta->telefono_acreedor ?? '') }}"
                        placeholder="Teléfono de contacto"
                    >
                    <span class="material-symbols-rounded form-icon">call</span>
                </div>
                @error('telefono_acreedor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email_acreedor" class="form-label">
                    <span class="material-symbols-rounded">mail</span>
                    Correo Electrónico
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="email"
                        id="email_acreedor"
                        name="email_acreedor"
                        class="form-input @error('email_acreedor') is-invalid @enderror"
                        value="{{ old('email_acreedor', $cuenta->email_acreedor ?? '') }}"
                        placeholder="correo@dominio.com"
                    >
                    <span class="material-symbols-rounded form-icon">alternate_email</span>
                </div>
                @error('email_acreedor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        </div>
    </details>

    {{-- Sección: Datos del Deudor --}}
    @php
        $openDeudor = $shouldOpenSection([
            'nombre_deudor','tipo_documento_deudor','numero_documento_deudor',
            'ciudad_expedicion_deudor','direccion_deudor','telefono_deudor','email_deudor'
        ]);
    @endphp
    <details class="form-section optional-section" {{ $openDeudor ? 'open' : '' }}>
        <summary>
            <span class="section-title">
                <span class="material-symbols-rounded">groups</span>
                Datos del Deudor
            </span>
            <span class="badge-optional">
                <span class="material-symbols-rounded" style="font-size:1rem;">info</span>
                Opcional
            </span>
        </summary>
        <div class="optional-content">
        <div class="form-grid">
            <div class="form-group">
                <label for="nombre_deudor" class="form-label">
                    <span class="material-symbols-rounded">person</span>
                    Nombre del Deudor
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="nombre_deudor"
                        name="nombre_deudor"
                        class="form-input @error('nombre_deudor') is-invalid @enderror"
                        value="{{ old('nombre_deudor', $cuenta->nombre_deudor ?? '') }}"
                        placeholder="Persona o entidad deudora"
                    >
                    <span class="material-symbols-rounded form-icon">groups</span>
                </div>
                @error('nombre_deudor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tipo_documento_deudor" class="form-label">
                    <span class="material-symbols-rounded">how_to_reg</span>
                    Tipo de Documento
                </label>
                <div class="form-input-wrapper">
                    <select
                        id="tipo_documento_deudor"
                        name="tipo_documento_deudor"
                        class="form-select @error('tipo_documento_deudor') is-invalid @enderror"
                    >
                        <option value="">Seleccione...</option>
                        @foreach($tipoDocumentoOpciones as $value => $label)
                            <option value="{{ $value }}" {{ old('tipo_documento_deudor', $cuenta->tipo_documento_deudor ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <span class="material-symbols-rounded form-icon">id_card</span>
                </div>
                @error('tipo_documento_deudor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="numero_documento_deudor" class="form-label">
                    <span class="material-symbols-rounded">fingerprint</span>
                    Número de Documento
                </label>
                <div class="form-input-wrapper" style="display:flex; gap:8px;">
                    <input
                        type="text"
                        id="numero_documento_deudor"
                        name="numero_documento_deudor"
                        class="form-input @error('numero_documento_deudor') is-invalid @enderror"
                        value="{{ old('numero_documento_deudor', $cuenta->numero_documento_deudor ?? '') }}"
                        placeholder="Número del documento"
                    >
                    <span class="material-symbols-rounded form-icon">tag</span>
                </div>
                @error('numero_documento_deudor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="ciudad_expedicion_deudor" class="form-label">
                    <span class="material-symbols-rounded">location_city</span>
                    Ciudad de Expedición
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="ciudad_expedicion_deudor"
                        name="ciudad_expedicion_deudor"
                        class="form-input @error('ciudad_expedicion_deudor') is-invalid @enderror"
                        value="{{ old('ciudad_expedicion_deudor', $cuenta->ciudad_expedicion_deudor ?? '') }}"
                        placeholder="Ciudad del documento"
                    >
                    <span class="material-symbols-rounded form-icon">location_city</span>
                </div>
                @error('ciudad_expedicion_deudor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="direccion_deudor" class="form-label">
                    <span class="material-symbols-rounded">home</span>
                    Dirección
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="direccion_deudor"
                        name="direccion_deudor"
                        class="form-input @error('direccion_deudor') is-invalid @enderror"
                        value="{{ old('direccion_deudor', $cuenta->direccion_deudor ?? '') }}"
                        placeholder="Dirección de notificación"
                    >
                    <span class="material-symbols-rounded form-icon">home_pin</span>
                </div>
                @error('direccion_deudor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="telefono_deudor" class="form-label">
                    <span class="material-symbols-rounded">call</span>
                    Teléfono
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="telefono_deudor"
                        name="telefono_deudor"
                        class="form-input @error('telefono_deudor') is-invalid @enderror"
                        value="{{ old('telefono_deudor', $cuenta->telefono_deudor ?? '') }}"
                        placeholder="Teléfono del deudor"
                    >
                    <span class="material-symbols-rounded form-icon">call</span>
                </div>
                @error('telefono_deudor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email_deudor" class="form-label">
                    <span class="material-symbols-rounded">mail</span>
                    Correo Electrónico
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="email"
                        id="email_deudor"
                        name="email_deudor"
                        class="form-input @error('email_deudor') is-invalid @enderror"
                        value="{{ old('email_deudor', $cuenta->email_deudor ?? '') }}"
                        placeholder="correo@dominio.com"
                    >
                    <span class="material-symbols-rounded form-icon">alternate_email</span>
                </div>
                @error('email_deudor')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        </div>
    </details>

    {{-- Sección: Detalle del Servicio --}}
    <div class="form-section">
        <h2 class="section-title">
            <span class="material-symbols-rounded">work</span>
            Detalle del Servicio
        </h2>
        <div class="form-grid">
            <div class="form-group full-width">
                <label for="concepto_cobro" class="form-label">
                    <span class="material-symbols-rounded">sticky_note_2</span>
                    Concepto del Cobro
                </label>
                <div class="form-input-wrapper">
                    <textarea
                        id="concepto_cobro"
                        name="concepto_cobro"
                        class="form-textarea @error('concepto_cobro') is-invalid @enderror"
                        placeholder="Describa brevemente el concepto"
                        required
                    >{{ old('concepto_cobro', $cuenta->concepto_cobro ?? '') }}</textarea>
                    <span class="material-symbols-rounded form-icon">topic</span>
                </div>
                @error('concepto_cobro')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="descripcion_servicio" class="form-label">
                    <span class="material-symbols-rounded">description</span>
                    Descripción del Servicio <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <textarea
                        id="descripcion_servicio"
                        name="descripcion_servicio"
                        class="form-textarea @error('descripcion_servicio') is-invalid @enderror"
                        placeholder="Detalle las actividades realizadas"
                    >{{ old('descripcion_servicio', $cuenta->descripcion_servicio ?? '') }}</textarea>
                    <span class="material-symbols-rounded form-icon">notes</span>
                </div>
                @error('descripcion_servicio')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group full-width">
                <div class="form-grid-3">
                    <div class="form-group">
                        <label for="fecha_prestacion_servicio" class="form-label">
                            <span class="material-symbols-rounded">event</span>
                            Fecha prestación
                        </label>
                        <div class="form-input-wrapper">
                            <input
                                type="date"
                                id="fecha_prestacion_servicio"
                                name="fecha_prestacion_servicio"
                                class="form-input @error('fecha_prestacion_servicio') is-invalid @enderror"
                                value="{{ old('fecha_prestacion_servicio', $cuenta->fecha_prestacion_servicio ?? '') }}"
                                required
                            >
                            <span class="material-symbols-rounded form-icon">event</span>
                        </div>
                        @error('fecha_prestacion_servicio')
                            <div class="form-error">
                                <span class="material-symbols-rounded">error</span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_inicio_servicio" class="form-label">
                            <span class="material-symbols-rounded">play_arrow</span>
                            Fecha inicio <span class="optional-tag">(opcional)</span>
                        </label>
                        <div class="form-input-wrapper">
                            <input
                                type="date"
                                id="fecha_inicio_servicio"
                                name="fecha_inicio_servicio"
                                class="form-input @error('fecha_inicio_servicio') is-invalid @enderror"
                                value="{{ old('fecha_inicio_servicio', $cuenta->fecha_inicio_servicio ?? '') }}"
                            >
                            <span class="material-symbols-rounded form-icon">schedule</span>
                        </div>
                        @error('fecha_inicio_servicio')
                            <div class="form-error">
                                <span class="material-symbols-rounded">error</span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fecha_fin_servicio" class="form-label">
                            <span class="material-symbols-rounded">stop</span>
                            Fecha fin <span class="optional-tag">(opcional)</span>
                        </label>
                        <div class="form-input-wrapper">
                            <input
                                type="date"
                                id="fecha_fin_servicio"
                                name="fecha_fin_servicio"
                                class="form-input @error('fecha_fin_servicio') is-invalid @enderror"
                                value="{{ old('fecha_fin_servicio', $cuenta->fecha_fin_servicio ?? '') }}"
                            >
                            <span class="material-symbols-rounded form-icon">event_busy</span>
                        </div>
                        @error('fecha_fin_servicio')
                            <div class="form-error">
                                <span class="material-symbols-rounded">error</span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group full-width">
                <label for="lugar_prestacion_servicio" class="form-label">
                    <span class="material-symbols-rounded">map</span>
                    Lugar de prestación <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="lugar_prestacion_servicio"
                        name="lugar_prestacion_servicio"
                        class="form-input @error('lugar_prestacion_servicio') is-invalid @enderror"
                        value="{{ old('lugar_prestacion_servicio', $cuenta->lugar_prestacion_servicio ?? '') }}"
                        placeholder="Ciudad o dirección donde se prestó"
                    >
                    <span class="material-symbols-rounded form-icon">pin_drop</span>
                </div>
                @error('lugar_prestacion_servicio')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    {{-- Sección: Información Contractual --}}
    @php
        $openContract = $shouldOpenSection([
            'numero_contrato_referencia','fecha_contrato','tipo_contrato','objeto_contrato'
        ]);
    @endphp
    <details class="form-section optional-section" {{ $openContract ? 'open' : '' }}>
        <summary>
            <span class="section-title">
                <span class="material-symbols-rounded">gavel</span>
                Información Contractual
            </span>
            <span class="badge-optional">
                <span class="material-symbols-rounded" style="font-size:1rem;">info</span>
                Opcional
            </span>
        </summary>
        <div class="optional-content">
        <div class="form-grid">
            <div class="form-group">
                <label for="numero_contrato_referencia" class="form-label">
                    <span class="material-symbols-rounded">receipt_long</span>
                    Número de contrato <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="numero_contrato_referencia"
                        name="numero_contrato_referencia"
                        class="form-input @error('numero_contrato_referencia') is-invalid @enderror"
                        value="{{ old('numero_contrato_referencia', $cuenta->numero_contrato_referencia ?? '') }}"
                        placeholder="Contrato o acto administrativo"
                    >
                    <span class="material-symbols-rounded form-icon">receipt_long</span>
                </div>
                @error('numero_contrato_referencia')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="fecha_contrato" class="form-label">
                    <span class="material-symbols-rounded">event_available</span>
                    Fecha de contrato <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="date"
                        id="fecha_contrato"
                        name="fecha_contrato"
                        class="form-input @error('fecha_contrato') is-invalid @enderror"
                        value="{{ old('fecha_contrato', $cuenta->fecha_contrato ?? '') }}"
                    >
                    <span class="material-symbols-rounded form-icon">event_available</span>
                </div>
                @error('fecha_contrato')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tipo_contrato" class="form-label">
                    <span class="material-symbols-rounded">category</span>
                    Tipo de contrato <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="tipo_contrato"
                        name="tipo_contrato"
                        class="form-input @error('tipo_contrato') is-invalid @enderror"
                        value="{{ old('tipo_contrato', $cuenta->tipo_contrato ?? '') }}"
                        placeholder="Prestación de servicios, obra, etc."
                    >
                    <span class="material-symbols-rounded form-icon">category</span>
                </div>
                @error('tipo_contrato')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="objeto_contrato" class="form-label">
                    <span class="material-symbols-rounded">list_alt</span>
                    Objeto contractual <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <textarea
                        id="objeto_contrato"
                        name="objeto_contrato"
                        class="form-textarea @error('objeto_contrato') is-invalid @enderror"
                        placeholder="Resuma el objeto del contrato"
                    >{{ old('objeto_contrato', $cuenta->objeto_contrato ?? '') }}</textarea>
                    <span class="material-symbols-rounded form-icon">inventory_2</span>
                </div>
                @error('objeto_contrato')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        </div>
    </details>

    {{-- Sección: Consecutivo y Soportes --}}
    @php
        $openConsecutivo = $shouldOpenSection([
            'prefijo_cuenta','serie_cuenta','consecutivo_cuenta','ciudad_expedicion_cuenta',
            'numero_documento_soporte','fecha_documento_soporte','documento_soporte_url','requiere_validacion_previa'
        ]);
    @endphp
    <details class="form-section optional-section" {{ $openConsecutivo ? 'open' : '' }}>
        <summary>
            <span class="section-title">
                <span class="material-symbols-rounded">qr_code_2</span>
                Consecutivo y Soportes
            </span>
            <span class="badge-optional">
                <span class="material-symbols-rounded" style="font-size:1rem;">info</span>
                Opcional
            </span>
        </summary>
        <div class="optional-content">
        <div class="form-grid">
            <div class="form-group">
                <label for="prefijo_cuenta" class="form-label">
                    <span class="material-symbols-rounded">sell</span>
                    Prefijo <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="prefijo_cuenta"
                        name="prefijo_cuenta"
                        class="form-input @error('prefijo_cuenta') is-invalid @enderror"
                        value="{{ old('prefijo_cuenta', $cuenta->prefijo_cuenta ?? '') }}"
                        placeholder="CC"
                    >
                    <span class="material-symbols-rounded form-icon">sell</span>
                </div>
                @error('prefijo_cuenta')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="serie_cuenta" class="form-label">
                    <span class="material-symbols-rounded">sell</span>
                    Serie <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="serie_cuenta"
                        name="serie_cuenta"
                        class="form-input @error('serie_cuenta') is-invalid @enderror"
                        value="{{ old('serie_cuenta', $cuenta->serie_cuenta ?? '') }}"
                        placeholder="2024"
                    >
                    <span class="material-symbols-rounded form-icon">sell</span>
                </div>
                @error('serie_cuenta')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="consecutivo_cuenta" class="form-label">
                    <span class="material-symbols-rounded">push_pin</span>
                    Consecutivo <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="number"
                        id="consecutivo_cuenta"
                        name="consecutivo_cuenta"
                        class="form-input @error('consecutivo_cuenta') is-invalid @enderror"
                        value="{{ old('consecutivo_cuenta', $cuenta->consecutivo_cuenta ?? '') }}"
                        min="0"
                    >
                    <span class="material-symbols-rounded form-icon">123</span>
                </div>
                @error('consecutivo_cuenta')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="ciudad_expedicion_cuenta" class="form-label">
                    <span class="material-symbols-rounded">travel_explore</span>
                    Ciudad de expedición
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="ciudad_expedicion_cuenta"
                        name="ciudad_expedicion_cuenta"
                        class="form-input @error('ciudad_expedicion_cuenta') is-invalid @enderror"
                        value="{{ old('ciudad_expedicion_cuenta', $cuenta->ciudad_expedicion_cuenta ?? '') }}"
                        placeholder="Ciudad donde se expide la cuenta"
                    >
                    <span class="material-symbols-rounded form-icon">location_on</span>
                </div>
                @error('ciudad_expedicion_cuenta')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="numero_documento_soporte" class="form-label">
                    <span class="material-symbols-rounded">bookmark</span>
                    Número documento soporte <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="numero_documento_soporte"
                        name="numero_documento_soporte"
                        class="form-input @error('numero_documento_soporte') is-invalid @enderror"
                        value="{{ old('numero_documento_soporte', $cuenta->numero_documento_soporte ?? '') }}"
                        placeholder="Número del documento anexo"
                    >
                    <span class="material-symbols-rounded form-icon">bookmark</span>
                </div>
                @error('numero_documento_soporte')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="fecha_documento_soporte" class="form-label">
                    <span class="material-symbols-rounded">event_note</span>
                    Fecha documento soporte <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="date"
                        id="fecha_documento_soporte"
                        name="fecha_documento_soporte"
                        class="form-input @error('fecha_documento_soporte') is-invalid @enderror"
                        value="{{ old('fecha_documento_soporte', $cuenta->fecha_documento_soporte ?? '') }}"
                    >
                    <span class="material-symbols-rounded form-icon">event_note</span>
                </div>
                @error('fecha_documento_soporte')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="documento_soporte_url" class="form-label">
                    <span class="material-symbols-rounded">attach_file</span>
                    URL del soporte <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="url"
                        id="documento_soporte_url"
                        name="documento_soporte_url"
                        class="form-input @error('documento_soporte_url') is-invalid @enderror"
                        value="{{ old('documento_soporte_url', $cuenta->documento_soporte_url ?? '') }}"
                        placeholder="https://..."
                    >
                    <span class="material-symbols-rounded form-icon">link</span>
                </div>
                @error('documento_soporte_url')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group toggle-group">
                <label class="form-label">
                    <span class="material-symbols-rounded">rule</span>
                    ¿Requiere validación previa?
                </label>
                <input type="hidden" name="requiere_validacion_previa" value="0">
                <label class="toggle-field">
                    <input
                        type="checkbox"
                        name="requiere_validacion_previa"
                        value="1"
                        {{ old('requiere_validacion_previa', $cuenta->requiere_validacion_previa ?? false) ? 'checked' : '' }}
                    >
                    <span>Marque si requiere visto bueno antes del pago</span>
                </label>
            </div>
        </div>
        </div>
    </details>

    {{-- Sección: Condiciones de Pago --}}
    @php
        $openCondiciones = $shouldOpenSection([
            'fecha_hora_emision','dias_plazo_pago','fecha_vencimiento_real','dias_gracia',
            'fecha_vencimiento_con_gracia','forma_pago_acordada','interes_mora_porcentaje',
            'valor_pendiente_pago','condiciones_pago','penalidades_retraso',
            'cobra_intereses_mora','recordatorio_habilitado'
        ]);
    @endphp
    <details class="form-section optional-section" {{ $openCondiciones ? 'open' : '' }}>
        <summary>
            <span class="section-title">
                <span class="material-symbols-rounded">payments</span>
                Condiciones de Pago
            </span>
            <span class="badge-optional">
                <span class="material-symbols-rounded" style="font-size:1rem;">info</span>
                Opcional
            </span>
        </summary>
        <div class="optional-content">
        <div class="form-grid">
            <div class="form-group">
                <label for="fecha_hora_emision" class="form-label">
                    <span class="material-symbols-rounded">schedule</span>
                    Fecha y hora de emisión
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="datetime-local"
                        id="fecha_hora_emision"
                        name="fecha_hora_emision"
                        class="form-input @error('fecha_hora_emision') is-invalid @enderror"
                        value="{{ old('fecha_hora_emision', isset($cuenta->fecha_hora_emision) ? $formatDateTimeInput($cuenta->fecha_hora_emision) : '') }}"
                    >
                    <span class="material-symbols-rounded form-icon">schedule</span>
                </div>
                @error('fecha_hora_emision')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="dias_plazo_pago" class="form-label">
                    <span class="material-symbols-rounded">hourglass_top</span>
                    Plazo pactado (días)
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="number"
                        id="dias_plazo_pago"
                        name="dias_plazo_pago"
                        class="form-input @error('dias_plazo_pago') is-invalid @enderror"
                        value="{{ old('dias_plazo_pago', $cuenta->dias_plazo_pago ?? '') }}"
                        min="0"
                    >
                    <span class="material-symbols-rounded form-icon">hourglass_empty</span>
                </div>
                @error('dias_plazo_pago')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="fecha_vencimiento_real" class="form-label">
                    <span class="material-symbols-rounded">event_busy</span>
                    Fecha de vencimiento
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="date"
                        id="fecha_vencimiento_real"
                        name="fecha_vencimiento_real"
                        class="form-input @error('fecha_vencimiento_real') is-invalid @enderror"
                        value="{{ old('fecha_vencimiento_real', $cuenta->fecha_vencimiento_real ?? '') }}"
                    >
                    <span class="material-symbols-rounded form-icon">calendar_month</span>
                </div>
                @error('fecha_vencimiento_real')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="dias_gracia" class="form-label">
                    <span class="material-symbols-rounded">hourglass_bottom</span>
                    Días de gracia <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="number"
                        id="dias_gracia"
                        name="dias_gracia"
                        class="form-input @error('dias_gracia') is-invalid @enderror"
                        value="{{ old('dias_gracia', $cuenta->dias_gracia ?? '') }}"
                        min="0"
                    >
                    <span class="material-symbols-rounded form-icon">hourglass_disabled</span>
                </div>
                @error('dias_gracia')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="fecha_vencimiento_con_gracia" class="form-label">
                    <span class="material-symbols-rounded">update</span>
                    Vence con gracia <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="date"
                        id="fecha_vencimiento_con_gracia"
                        name="fecha_vencimiento_con_gracia"
                        class="form-input @error('fecha_vencimiento_con_gracia') is-invalid @enderror"
                        value="{{ old('fecha_vencimiento_con_gracia', $cuenta->fecha_vencimiento_con_gracia ?? '') }}"
                    >
                    <span class="material-symbols-rounded form-icon">event_repeat</span>
                </div>
                @error('fecha_vencimiento_con_gracia')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="forma_pago_acordada" class="form-label">
                    <span class="material-symbols-rounded">credit_card</span>
                    Forma de pago acordada <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="forma_pago_acordada"
                        name="forma_pago_acordada"
                        class="form-input @error('forma_pago_acordada') is-invalid @enderror"
                        value="{{ old('forma_pago_acordada', $cuenta->forma_pago_acordada ?? '') }}"
                        placeholder="Transferencia, cheque, etc."
                    >
                    <span class="material-symbols-rounded form-icon">payments</span>
                </div>
                @error('forma_pago_acordada')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="interes_mora_porcentaje" class="form-label">
                    <span class="material-symbols-rounded">percent</span>
                    Interés de mora (%) <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        id="interes_mora_porcentaje"
                        name="interes_mora_porcentaje"
                        class="form-input @error('interes_mora_porcentaje') is-invalid @enderror"
                        value="{{ old('interes_mora_porcentaje', $cuenta->interes_mora_porcentaje ?? '') }}"
                    >
                    <span class="material-symbols-rounded form-icon">trending_up</span>
                </div>
                @error('interes_mora_porcentaje')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="valor_pendiente_pago" class="form-label">
                    <span class="material-symbols-rounded">request_quote</span>
                    Valor pendiente por pagar <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        id="valor_pendiente_pago"
                        name="valor_pendiente_pago"
                        class="form-input @error('valor_pendiente_pago') is-invalid @enderror"
                        value="{{ old('valor_pendiente_pago', $cuenta->valor_pendiente_pago ?? '') }}"
                    >
                    <span class="material-symbols-rounded form-icon">attach_money</span>
                </div>
                @error('valor_pendiente_pago')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group full-width" style="margin-top: 1.5rem;">
                <label for="condiciones_pago" class="form-label">
                    <span class="material-symbols-rounded">rule</span>
                    Condiciones adicionales <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <textarea
                        id="condiciones_pago"
                        name="condiciones_pago"
                        class="form-textarea @error('condiciones_pago') is-invalid @enderror"
                        placeholder="Cláusulas o condiciones especiales de pago"
                    >{{ old('condiciones_pago', $cuenta->condiciones_pago ?? '') }}</textarea>
                    <span class="material-symbols-rounded form-icon">rule</span>
                </div>
                @error('condiciones_pago')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="penalidades_retraso" class="form-label">
                    <span class="material-symbols-rounded">gpp_maybe</span>
                    Penalidades por retraso <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <textarea
                        id="penalidades_retraso"
                        name="penalidades_retraso"
                        class="form-textarea @error('penalidades_retraso') is-invalid @enderror"
                        placeholder="Describa multas o recargos"
                    >{{ old('penalidades_retraso', $cuenta->penalidades_retraso ?? '') }}</textarea>
                    <span class="material-symbols-rounded form-icon">warning</span>
                </div>
                @error('penalidades_retraso')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group toggle-group">
                <label class="form-label">
                    <span class="material-symbols-rounded">percent</span>
                    ¿Cobra intereses de mora?
                </label>
                <input type="hidden" name="cobra_intereses_mora" value="0">
                <label class="toggle-field">
                    <input
                        type="checkbox"
                        name="cobra_intereses_mora"
                        value="1"
                        {{ old('cobra_intereses_mora', $cuenta->cobra_intereses_mora ?? false) ? 'checked' : '' }}
                    >
                    <span>Aplicar interés moratorio</span>
                </label>
            </div>

            <div class="form-group toggle-group">
                <label class="form-label">
                    <span class="material-symbols-rounded">notifications_active</span>
                    Recordatorios automáticos
                </label>
                <input type="hidden" name="recordatorio_habilitado" value="0">
                <label class="toggle-field">
                    <input
                        type="checkbox"
                        name="recordatorio_habilitado"
                        value="1"
                        {{ old('recordatorio_habilitado', $cuenta->recordatorio_habilitado ?? false) ? 'checked' : '' }}
                    >
                    <span>Enviar recordatorios antes del vencimiento</span>
                </label>
            </div>
        </div>
        </div>
    </details>

    {{-- Sección: Estado Legal y Judicial --}}
    @php
        $openLegal = $shouldOpenSection([
            'estado_cobro_judicial','numero_proceso_judicial','fecha_inicio_proceso',
            'juzgado','radicado_judicial','tiene_merito_ejecutivo','deuda_reconocida_deudor',
            'evidencias_obligacion','testigos'
        ]);
    @endphp
    <details class="form-section optional-section" {{ $openLegal ? 'open' : '' }}>
        <summary>
            <span class="section-title">
                <span class="material-symbols-rounded">gavel</span>
                Estado Legal y Judicial
            </span>
            <span class="badge-optional">
                <span class="material-symbols-rounded" style="font-size:1rem;">info</span>
                Opcional
            </span>
        </summary>
        <div class="optional-content">
        <div class="form-grid">
            <div class="form-group">
                <label for="estado_cobro_judicial" class="form-label">
                    <span class="material-symbols-rounded">balance</span>
                    Estado del proceso <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="estado_cobro_judicial"
                        name="estado_cobro_judicial"
                        class="form-input @error('estado_cobro_judicial') is-invalid @enderror"
                        value="{{ old('estado_cobro_judicial', $cuenta->estado_cobro_judicial ?? '') }}"
                        placeholder="Sin proceso, en demanda, etc."
                    >
                    <span class="material-symbols-rounded form-icon">balance</span>
                </div>
                @error('estado_cobro_judicial')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="numero_proceso_judicial" class="form-label">
                    <span class="material-symbols-rounded">tag</span>
                    Número de proceso <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="numero_proceso_judicial"
                        name="numero_proceso_judicial"
                        class="form-input @error('numero_proceso_judicial') is-invalid @enderror"
                        value="{{ old('numero_proceso_judicial', $cuenta->numero_proceso_judicial ?? '') }}"
                        placeholder="Número o radicado interno"
                    >
                    <span class="material-symbols-rounded form-icon">push_pin</span>
                </div>
                @error('numero_proceso_judicial')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="fecha_inicio_proceso" class="form-label">
                    <span class="material-symbols-rounded">calendar_month</span>
                    Fecha inicio proceso <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="date"
                        id="fecha_inicio_proceso"
                        name="fecha_inicio_proceso"
                        class="form-input @error('fecha_inicio_proceso') is-invalid @enderror"
                        value="{{ old('fecha_inicio_proceso', $cuenta->fecha_inicio_proceso ?? '') }}"
                    >
                    <span class="material-symbols-rounded form-icon">event</span>
                </div>
                @error('fecha_inicio_proceso')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="juzgado" class="form-label">
                    <span class="material-symbols-rounded">account_balance</span>
                    Juzgado <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        id="juzgado"
                        name="juzgado"
                        class="form-input @error('juzgado') is-invalid @enderror"
                        value="{{ old('juzgado', $cuenta->juzgado ?? '') }}"
                    >
                    <span class="material-symbols-rounded form-icon">account_balance</span>
                </div>
                @error('juzgado')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
        </div>
    </div>
    </details>

    {{-- Sección: Observaciones y Notas --}}
    @php
        $openNotas = $shouldOpenSection([
            'clausulas_especiales','observaciones_legales','notas_cobro'
        ]);
    @endphp
    <details class="form-section optional-section" {{ $openNotas ? 'open' : '' }}>
        <summary>
            <span class="section-title">
                <span class="material-symbols-rounded">note_alt</span>
                Observaciones y Notas
            </span>
            <span class="badge-optional">
                <span class="material-symbols-rounded" style="font-size:1rem;">info</span>
                Opcional
            </span>
        </summary>
        <div class="optional-content">
        <div class="form-grid">
            <div class="form-group full-width">
                <label for="clausulas_especiales" class="form-label">
                    <span class="material-symbols-rounded">gavel</span>
                    Cláusulas especiales <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <textarea
                        id="clausulas_especiales"
                        name="clausulas_especiales"
                        class="form-textarea @error('clausulas_especiales') is-invalid @enderror"
                        placeholder="Incluya condiciones específicas o anexos legales"
                    >{{ old('clausulas_especiales', $cuenta->clausulas_especiales ?? '') }}</textarea>
                    <span class="material-symbols-rounded form-icon">rule</span>
                </div>
                @error('clausulas_especiales')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="observaciones_legales" class="form-label">
                    <span class="material-symbols-rounded">library_books</span>
                    Observaciones legales <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <textarea
                        id="observaciones_legales"
                        name="observaciones_legales"
                        class="form-textarea @error('observaciones_legales') is-invalid @enderror"
                        placeholder="Notas para el equipo jurídico o aprobación"
                    >{{ old('observaciones_legales', $cuenta->observaciones_legales ?? '') }}</textarea>
                    <span class="material-symbols-rounded form-icon">description</span>
                </div>
                @error('observaciones_legales')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="notas_cobro" class="form-label">
                    <span class="material-symbols-rounded">speaker_notes</span>
                    Notas del cobro <span class="optional-tag">(opcional)</span>
                </label>
                <div class="form-input-wrapper">
                    <textarea
                        id="notas_cobro"
                        name="notas_cobro"
                        class="form-textarea @error('notas_cobro') is-invalid @enderror"
                        placeholder="Información adicional para el pagador"
                    >{{ old('notas_cobro', $cuenta->notas_cobro ?? '') }}</textarea>
                    <span class="material-symbols-rounded form-icon">notes</span>
                </div>
                @error('notas_cobro')
                    <div class="form-error">
                        <span class="material-symbols-rounded">error</span>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    </details>

    {{-- Sección: Soportes y Documentos --}}
    <div class="form-section">
        <h2 class="section-title">
            <span class="material-symbols-rounded">attach_file</span>
            Soportes y Documentos
        </h2>
        <div class="attachments-card">
            @if(isset($cuenta) && $cuenta?->id)
                <p style="margin:0;color:#4b5563;">Adjunta contratos, actas o soportes visuales directamente a la cuenta. Tamaño máximo por archivo: 10&nbsp;MB.</p>
                @if($canManageAttachments)
                    <div class="attachments-upload">
                        <label for="soportes-upload-input" class="form-label" style="margin-bottom:0;">
                            <span class="material-symbols-rounded">file_upload</span>
                            Selecciona archivos para cargar
                        </label>
                        <input type="file" id="soportes-upload-input" multiple accept="application/pdf,image/*">
                        <small style="color:#6b7280;">Formatos sugeridos: PDF, JPG, PNG.</small>
                        <div class="form-error" id="attachments-feedback" style="display:none;">
                            <span class="material-symbols-rounded">error</span>
                            <span id="attachments-feedback-text"></span>
                        </div>
                        <button type="button" class="btn-attach" id="upload-soportes-btn" data-upload-url="{{ route('cuentas_cobro.soportes.store', $cuenta->id) }}">
                            <span class="material-symbols-rounded">cloud_upload</span>
                            Adjuntar archivos
                        </button>
                    </div>
                @else
                    <div class="chip-note">Solo el contratista titular puede gestionar soportes mientras la cuenta esté en revisión o corrección.</div>
                @endif

                <div class="attachment-list">
                    @forelse($existingSoportes as $soporte)
                        @php
                            $sizeLabel = $soporte->size ? number_format($soporte->size / 1024, 1).' KB' : 'Tamaño no disponible';
                            $uploadedAt = optional($soporte->created_at)->format('d/m/Y H:i');
                        @endphp
                        <div class="attachment-item">
                            <div>
                                <strong>{{ $soporte->nombre }}</strong>
                                <div class="form-hint" style="margin-top:0.2rem;">
                                    Subido {{ $uploadedAt ?? '—' }} · {{ $sizeLabel }}
                                </div>
                            </div>
                            <div class="attachment-actions">
                                <a class="btn-link-light" href="{{ \Illuminate\Support\Facades\Storage::url($soporte->path) }}" target="_blank" rel="noopener">
                                    <span class="material-symbols-rounded" style="font-size:1.1rem;">open_in_new</span>
                                    Ver
                                </a>
                                @if($canManageAttachments)
                                    <button type="button" class="btn-link-danger btn-delete-soporte" data-delete-url="{{ route('cuentas_cobro.soportes.destroy', [$cuenta->id, $soporte->id]) }}" data-name="{{ $soporte->nombre }}">
                                        <span class="material-symbols-rounded" style="font-size:1.1rem;">delete</span>
                                        Quitar
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="chip-note">Aún no se han cargado soportes.</div>
                    @endforelse
                </div>
            @else
                <div class="chip-note">Guarda la cuenta para habilitar la carga de soportes.</div>
            @endif
        </div>
    </div>

    {{-- Sección: Impuestos y Retenciones --}}
    <div class="form-section">
        <h2 class="section-title">
            <span class="material-symbols-rounded">balance</span>
            Impuestos y Retenciones
        </h2>

        {{-- Calculadora de Retención Art. 383 ET --}}
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                <span class="material-symbols-rounded" style="color: #f59e0b;">calculate</span>
                <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1e293b;">Calculadora de Retención (Art. 383 ET)</h3>
            </div>
            <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">
                Calcula la retención en la fuente para ingresos laborales gravados (personas naturales) según la tabla del Art. 383 del Estatuto Tributario (Año 2025).
                <br><strong>UVT 2025 (Estimado): $49.799</strong> (Ajustar si es necesario).
            </p>
            
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Base Gravable (Mensual)</label>
                    <div class="form-input-wrapper">
                        <input type="number" id="calc_base" class="form-input" placeholder="Ingrese valor base">
                        <span class="material-symbols-rounded form-icon">attach_money</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Retención Calculada</label>
                    <div class="form-input-wrapper">
                        <input type="text" id="calc_resultado" class="form-input" readonly style="background: #f1f5f9; font-weight: 700; color: #0f172a;">
                        <span class="material-symbols-rounded form-icon">payments</span>
                    </div>
                </div>
                <div class="form-group" style="justify-content: flex-end;">
                    <button type="button" id="btn_calcular_retencion" class="wix-btn wix-btn-secondary" style="width: 100%; justify-content: center;">
                        Calcular y Aplicar
                    </button>
                </div>
            </div>
            <div id="calc_detalle" style="margin-top: 12px; font-size: 12px; color: #64748b; font-style: italic;"></div>
        </div>

        <div class="form-grid-3">


            <div class="form-group">
                <label class="form-label">
                    <span class="material-symbols-rounded">percent</span>
                    ReteICA (%)
                </label>
                <div class="form-input-wrapper">
                    <input type="number" step="0.001" min="0" max="100" id="reteica_porcentaje" class="form-input" placeholder="Ej: 0.966 (9.66 por mil)" value="{{ old('reteica_porcentaje', 0) }}">
                    <span class="material-symbols-rounded form-icon">percent</span>
                </div>
                <div class="form-hint" style="color:#86868b; font-size:0.85rem; margin-top:.4rem;">
                    En Bogotá 9.66‰ ≈ 0.966% (varía por actividad/ciudad).
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <span class="material-symbols-rounded">percent</span>
                    ReteIVA (%)
                </label>
                <div class="form-input-wrapper">
                    <input type="number" step="0.01" min="0" max="100" id="reteiva_porcentaje" class="form-input" placeholder="Ej: 15" value="{{ old('reteiva_porcentaje', 0) }}">
                    <span class="material-symbols-rounded form-icon">percent</span>
                </div>
                <div class="form-hint" style="color:#86868b; font-size:0.85rem; margin-top:.4rem;">
                    Aplica sólo si hay IVA y el cliente es agente de retención de IVA.
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnCalcular = document.getElementById('btn_calcular_retencion');
            const inputBase = document.getElementById('calc_base');
            const inputResultado = document.getElementById('calc_resultado');
            const divDetalle = document.getElementById('calc_detalle');
            const inputRetefuente = document.getElementById('retencion_fuente'); // Hidden input for value
            const inputRetefuentePorc = document.getElementById('retefuente_porcentaje'); // Input for percentage (we might need to adjust logic here as Art 383 is value based, not fixed %)

            // UVT 2025 (Provisional)
            const UVT = 49799; 

            btnCalcular.addEventListener('click', function() {
                const base = parseFloat(inputBase.value) || 0;
                if (base <= 0) return;

                // Convertir a UVT
                const baseUVT = base / UVT;
                let retencionUVT = 0;
                let tarifa = 0;

                // Tabla Art. 383 ET
                if (baseUVT > 2300) {
                    retencionUVT = (baseUVT - 2300) * 0.39 + 770;
                    tarifa = 39;
                } else if (baseUVT > 945) {
                    retencionUVT = (baseUVT - 945) * 0.37 + 268;
                    tarifa = 37;
                } else if (baseUVT > 640) {
                    retencionUVT = (baseUVT - 640) * 0.35 + 162;
                    tarifa = 35;
                } else if (baseUVT > 360) {
                    retencionUVT = (baseUVT - 360) * 0.33 + 69;
                    tarifa = 33;
                } else if (baseUVT > 150) {
                    retencionUVT = (baseUVT - 150) * 0.28 + 10;
                    tarifa = 28;
                } else if (baseUVT > 95) {
                    retencionUVT = (baseUVT - 95) * 0.19;
                    tarifa = 19;
                } else {
                    retencionUVT = 0;
                    tarifa = 0;
                }

                const retencionPesos = Math.round(retencionUVT * UVT);
                
                // Formatear resultado
                inputResultado.value = '$ ' + new Intl.NumberFormat('es-CO').format(retencionPesos);
                divDetalle.innerHTML = `Base en UVT: ${baseUVT.toFixed(2)} | Tarifa Marginal: ${tarifa}% | Retención en UVT: ${retencionUVT.toFixed(2)}`;

                // Aplicar al formulario principal
                // Nota: Como Art 383 no es un porcentaje fijo sobre el total, sino progresivo, 
                // lo ideal es poner el valor calculado directamente en el campo de valor de retención
                // pero el formulario actual calcula basado en porcentaje.
                // Solución: Calcular el porcentaje efectivo y ponerlo en el campo de porcentaje.
                
                if (base > 0) {
                    const porcentajeEfectivo = (retencionPesos / base) * 100;
                    inputRetefuentePorc.value = porcentajeEfectivo.toFixed(2);
                    // Disparar evento para recalcular totales
                    inputRetefuentePorc.dispatchEvent(new Event('input'));
                }
            });
        });
    </script>

    {{-- Total --}}
    <div class="form-section">
        <div class="form-grid">
            <div class="form-group full-width">
                <div class="total-display">
                    <span class="total-display-label">Valor Total</span>
                    <span class="total-display-value">$<span id="total-formatted">0</span></span>
                    <div class="totals-breakdown">
                        <div class="row"><span>Subtotal</span><strong>$ <span id="subtotal-formatted">0</span></strong></div>
                        <div class="row"><span>IVA <span class="badge-mini" id="iva-badge">0%</span></span><strong>+$ <span id="iva-formatted">0</span></strong></div>
                        <div class="row"><span>ReteFuente <span class="badge-mini" id="retefuente-badge">0%</span></span><strong>- $ <span id="retefuente-formatted">0</span></strong></div>
                        <div class="row"><span>ReteICA <span class="badge-mini" id="reteica-badge">0%</span></span><strong>- $ <span id="reteica-formatted">0</span></strong></div>
                        <div class="row"><span>ReteIVA <span class="badge-mini" id="reteiva-badge">0%</span></span><strong>- $ <span id="reteiva-formatted">0</span></strong></div>
                    </div>
                    <input type="hidden" id="valor_total" name="valor_total" value="{{ old('valor_total', $cuenta->valor_total ?? 0) }}">
                    <input type="hidden" id="subtotal" name="subtotal" value="{{ old('subtotal', 0) }}">
                    <input type="hidden" id="iva_valor" name="iva_valor" value="{{ old('iva_valor', 0) }}">
                    <input type="hidden" id="retencion_fuente" name="retencion_fuente" value="{{ old('retencion_fuente', 0) }}">
                    <input type="hidden" id="retencion_ica" name="retencion_ica" value="{{ old('retencion_ica', 0) }}">
                    <input type="hidden" id="retencion_iva" name="retencion_iva" value="{{ old('retencion_iva', 0) }}">
                </div>
            </div>
        </div>
    </div>

    {{-- Botones de Acción --}}
    <div class="form-actions">
        <a href="{{ route('cuentas_cobro.index') }}" class="btn-cancel">
            <span class="material-symbols-rounded">close</span>
            Cancelar
        </a>
        @if(empty($hideSubmit) || !$hideSubmit)
            <button type="submit" class="btn-submit">
                <span class="material-symbols-rounded">save</span>
                {{ $btnText ?? 'Guardar' }}
            </button>
        @endif
    </div>
</div>

<!-- Modal Crear Tercero -->
<div id="createTerceroModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:12px; padding:32px; width:90%; max-width:600px; max-height:90vh; overflow-y:auto;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <h3 style="margin:0; font-size:20px; font-weight:700; color:var(--wix-text);">Crear Nuevo Tercero</h3>
            <button type="button" onclick="closeTerceroModal()" style="background:none; border:none; cursor:pointer; font-size:24px; color:#6b7c93;">&times;</button>
        </div>
        
        <form id="createTerceroForm">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Tipo de Persona</label>
                    <select name="tipo_persona" id="modal_tipo_persona" class="form-select" onchange="toggleModalFields()">
                        <option value="natural">Persona Natural</option>
                        <option value="juridica">Persona Jurídica</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tipo Identificación</label>
                    <select name="tipo_identificacion" class="form-select" required>
                        <option value="CC">Cédula de Ciudadanía</option>
                        <option value="NIT">NIT</option>
                        <option value="CE">Cédula de Extranjería</option>
                        <option value="PA">Pasaporte</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Identificación</label>
                    <input type="text" name="identificacion" class="form-input" required>
                </div>
                <div class="form-group" id="div_dv" style="display:none;">
                    <label class="form-label">DV</label>
                    <input type="text" name="dv" class="form-input" maxlength="1">
                </div>
                
                <div class="form-group full-width" id="div_nombre_completo">
                    <label class="form-label">Nombre Completo</label>
                    <input type="text" name="nombre_completo" class="form-input">
                </div>
                <div class="form-group full-width" id="div_razon_social" style="display:none;">
                    <label class="form-label">Razón Social</label>
                    <input type="text" name="razon_social" class="form-input">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Departamento</label>
                    <input type="text" name="departamento" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Ciudad</label>
                    <input type="text" name="ciudad" class="form-input">
                </div>
                <div class="form-group full-width">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-input">
                </div>
            </div>

            <div style="margin-top:24px; display:flex; justify-content:flex-end; gap:12px;">
                <button type="button" onclick="closeTerceroModal()" class="btn-cancel" style="width:auto; padding:10px 20px;">Cancelar</button>
                <button type="submit" class="btn-submit" style="width:auto; padding:10px 20px;">Guardar Tercero</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    (function(){
        const deps = @json($departamentos ?? []);
        const depSelect = document.getElementById('departamento');
        const munSelect = document.getElementById('municipio');

        function fillMunicipios(dep, selectedValue){
            const list = deps[dep] || [];
            if (!munSelect) return;
            const current = typeof selectedValue === 'string' ? selectedValue : (munSelect.getAttribute('data-current') || '');
            munSelect.innerHTML = '<option value="">Seleccione un municipio</option>';
            list.forEach(m => {
                const opt = document.createElement('option');
                opt.value = m;
                opt.textContent = m;
                if (current === m) opt.selected = true;
                munSelect.appendChild(opt);
            });
            munSelect.disabled = list.length === 0;
            if (!list.length) {
                munSelect.value = '';
            }
        }

        if (depSelect) {
            depSelect.addEventListener('change', (e)=> {
                if (munSelect) {
                    munSelect.setAttribute('data-current', '');
                }
                fillMunicipios(e.target.value, '');
            });
            if (depSelect.value) {
                fillMunicipios(depSelect.value);
            } else if (munSelect) {
                munSelect.disabled = true;
            }
        }

        // Items dinámicos + total
        const container = document.getElementById('items-container');
        const addBtn = document.getElementById('add-item');
    const totalInput = document.getElementById('valor_total');
    const totalFormatted = document.getElementById('total-formatted');
    const subtotalHidden = document.getElementById('subtotal');
    const ivaHidden = document.getElementById('iva_valor');
    const retefuenteHidden = document.getElementById('retencion_fuente');
    const reteicaHidden = document.getElementById('retencion_ica');
    const reteivaHidden = document.getElementById('retencion_iva');

    // Porcentajes
    const ivaPct = document.getElementById('iva_porcentaje');
    const retefuentePct = document.getElementById('retefuente_porcentaje');
    const reteicaPct = document.getElementById('reteica_porcentaje');
    const reteivaPct = document.getElementById('reteiva_porcentaje');

    // Labels breakdown
    const subtotalFormatted = document.getElementById('subtotal-formatted');
    const ivaFormatted = document.getElementById('iva-formatted');
    const retefuenteFormatted = document.getElementById('retefuente-formatted');
    const reteicaFormatted = document.getElementById('reteica-formatted');
    const reteivaFormatted = document.getElementById('reteiva-formatted');
    const ivaBadge = document.getElementById('iva-badge');
    const retefuenteBadge = document.getElementById('retefuente-badge');
    const reteicaBadge = document.getElementById('reteica-badge');
    const reteivaBadge = document.getElementById('reteiva-badge');

        function fmt(n){
            return n.toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        function recalcTotal(){
            let subtotal = 0;
            let totalIva = 0;
            let totalRetefuente = 0;

            container.querySelectorAll('.item-row').forEach(row => {
                const cant = parseFloat(row.querySelector('[name$="[cantidad]"]').value) || 0;
                const precio = parseFloat(row.querySelector('[name$="[precio_unitario]"]').value) || 0;
                const ivaP = parseFloat(row.querySelector('[name$="[iva]"]')?.value) || 0;
                const rfP = parseFloat(row.querySelector('[name$="[retefuente]"]')?.value) || 0;

                const rowTotal = cant * precio;
                subtotal += rowTotal;
                totalIva += rowTotal * (ivaP / 100);
                totalRetefuente += rowTotal * (rfP / 100);
            });

            const icaPor = parseFloat(reteicaPct?.value || 0) / 100;
            const rivaPor = parseFloat(reteivaPct?.value || 0) / 100;

            const reteica = subtotal * icaPor;
            const reteiva = totalIva * rivaPor;

            let total = subtotal + totalIva - totalRetefuente - reteica - reteiva;

            // Hidden values
            subtotalHidden.value = subtotal.toFixed(2);
            ivaHidden.value = totalIva.toFixed(2);
            retefuenteHidden.value = totalRetefuente.toFixed(2);
            reteicaHidden.value = reteica.toFixed(2);
            reteivaHidden.value = reteiva.toFixed(2);
            totalInput.value = total.toFixed(2);

            // UI
            subtotalFormatted.textContent = fmt(subtotal);
            ivaFormatted.textContent = fmt(totalIva);
            retefuenteFormatted.textContent = fmt(totalRetefuente);
            reteicaFormatted.textContent = fmt(reteica);
            reteivaFormatted.textContent = fmt(reteiva);
            totalFormatted.textContent = fmt(total);
            
            if(ivaBadge) ivaBadge.textContent = '';
            if(retefuenteBadge) retefuenteBadge.textContent = '';
            if(reteicaBadge) reteicaBadge.textContent = (parseFloat(reteicaPct?.value || 0)).toFixed(3) + '%';
            if(reteivaBadge) reteivaBadge.textContent = (parseFloat(reteivaPct?.value || 0)).toFixed(2) + '%';
        }

        function bindRow(row){
            row.querySelectorAll('input').forEach(inp => {
                inp.addEventListener('input', recalcTotal);
            });
            const rm = row.querySelector('.btn-remove-item');
            rm && rm.addEventListener('click', ()=>{ 
                if(container.querySelectorAll('.item-row').length > 1) {
                    row.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => {
                        row.remove(); 
                        recalcTotal();
                    }, 300);
                } else {
                    alert('Debe mantener al menos un ítem');
                }
            });
        }

    // Bind existing
        container.querySelectorAll('.item-row').forEach(bindRow);

        addBtn?.addEventListener('click', ()=>{
            const index = container.querySelectorAll('.item-row').length;
            const row = document.createElement('div');
            row.className = 'item-row';
            row.innerHTML = `
                <div class="form-group">
                    <label class="form-label">
                        <span class="material-symbols-rounded">label</span>
                        Nombre del Ítem
                    </label>
                    <div class="form-input-wrapper">
                        <input type="text" name="items[${index}][item]" placeholder="Ej: Desarrollo de software" class="form-input" required>
                        <span class="material-symbols-rounded form-icon">shopping_cart</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <span class="material-symbols-rounded">info</span>
                        Detalle
                    </label>
                    <div class="form-input-wrapper">
                        <input type="text" name="items[${index}][detalle]" placeholder="Detalle adicional" class="form-input">
                        <span class="material-symbols-rounded form-icon">description</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <span class="material-symbols-rounded">production_quantity_limits</span>
                        Cantidad
                    </label>
                    <div class="form-input-wrapper">
                        <input type="number" name="items[${index}][cantidad]" placeholder="1" class="form-input" min="1" value="1" required>
                        <span class="material-symbols-rounded form-icon">add_circle</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <span class="material-symbols-rounded">payments</span>
                        Precio Unitario
                    </label>
                    <div class="form-input-wrapper">
                        <input type="number" name="items[${index}][precio_unitario]" placeholder="0.00" class="form-input" step="0.01" required>
                        <span class="material-symbols-rounded form-icon">attach_money</span>
                    </div>
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label class="form-label">Impuestos</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div class="form-input-wrapper">
                            <span class="form-icon" style="font-size: 0.8em; left: 8px; width: auto;">IVA%</span>
                            <input type="number" name="items[${index}][iva]" value="19" placeholder="19" class="form-input" step="0.01" min="0" max="100" style="padding-left: 50px;">
                        </div>
                        <div class="form-input-wrapper">
                            <span class="form-icon" style="font-size: 0.8em; left: 8px; width: auto;">Rete%</span>
                            <input type="number" name="items[${index}][retefuente]" value="0" placeholder="0" class="form-input" step="0.01" min="0" max="100" style="padding-left: 50px;">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-remove-item">
                    <span class="material-symbols-rounded">close</span>
                </button>
            `;
            container.appendChild(row);
            bindRow(row);
            recalcTotal();
        });

        // Animación de entrada
        document.querySelectorAll('.form-input, .form-select, .form-textarea').forEach((input, index) => {
            input.style.opacity = '0';
            input.style.transform = 'translateY(20px)';
            setTimeout(() => {
                input.style.transition = 'all 0.4s ease';
                input.style.opacity = '1';
                input.style.transform = 'translateY(0)';
            }, 50 * index);
        });

        // Animación slideOut
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideOutRight {
                from {
                    opacity: 1;
                    transform: translateX(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(100px);
                }
            }
        `;
        document.head.appendChild(style);

        // Recalc on percentage changes
        [ivaPct, retefuentePct, reteicaPct, reteivaPct].forEach(el => {
            el?.addEventListener('input', recalcTotal);
            el?.addEventListener('change', recalcTotal);
        });

        // Manejo de soportes (adjuntos)
        const uploadBtn = document.getElementById('upload-soportes-btn');
        if (uploadBtn) {
            const uploadInput = document.getElementById('soportes-upload-input');
            const feedback = document.getElementById('attachments-feedback');
            const feedbackText = document.getElementById('attachments-feedback-text');
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');

            uploadBtn.addEventListener('click', () => {
                if (!uploadInput || !uploadInput.files.length) {
                    if (feedback && feedbackText) {
                        feedback.style.display = 'flex';
                        feedbackText.textContent = 'Selecciona al menos un archivo.';
                    } else {
                        alert('Selecciona al menos un archivo.');
                    }
                    return;
                }
                if (!csrfMeta) {
                    alert('No se encontró el token CSRF. Actualiza la página.');
                    return;
                }
                const formData = new FormData();
                Array.from(uploadInput.files).forEach(file => formData.append('soportes[]', file));
                uploadBtn.disabled = true;
                uploadBtn.style.opacity = '0.7';
                if (feedback) feedback.style.display = 'none';

                fetch(uploadBtn.dataset.uploadUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfMeta.getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData,
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => Promise.reject(data));
                    }
                    return response.text();
                })
                .then(() => window.location.reload())
                .catch(error => {
                    const message = error?.message
                        || Object.values(error?.errors || {})[0]?.[0]
                        || 'No se pudieron subir los archivos. Verifica el tamaño y formato.';
                    if (feedback && feedbackText) {
                        feedback.style.display = 'flex';
                        feedbackText.textContent = message;
                    } else {
                        alert(message);
                    }
                })
                .finally(() => {
                    uploadBtn.disabled = false;
                    uploadBtn.style.opacity = '';
                    if (uploadInput) {
                        uploadInput.value = '';
                    }
                });
            });
        }

        document.querySelectorAll('.btn-delete-soporte').forEach(btn => {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            btn.addEventListener('click', () => {
                if (!csrfMeta) {
                    alert('No se encontró el token CSRF.');
                    return;
                }
                const nombre = btn.dataset.name || 'el soporte';
                if (!confirm('¿Eliminar ' + nombre + '?')) {
                    return;
                }
                fetch(btn.dataset.deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfMeta.getAttribute('content'),
                        'Accept': 'application/json'
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => Promise.reject(data));
                    }
                    return response.text();
                })
                .then(() => window.location.reload())
                .catch(() => alert('No se pudo eliminar el soporte.'));
            });
        });

        // Inicial
        recalcTotal();
    })();
</script>
<script>
    let currentTerceroTarget = '';

    window.openTerceroModal = function(target) {
        currentTerceroTarget = target;
        const modal = document.getElementById('createTerceroModal');
        if(modal) {
            modal.style.display = 'flex';
            const form = document.getElementById('createTerceroForm');
            if(form) form.reset();
            if(typeof window.toggleModalFields === 'function') {
                window.toggleModalFields();
            }
        } else {
            console.error('Modal createTerceroModal not found');
        }
    }

    window.closeTerceroModal = function() {
        const modal = document.getElementById('createTerceroModal');
        if(modal) modal.style.display = 'none';
    }

    window.toggleModalFields = function() {
        const tipoSelect = document.getElementById('modal_tipo_persona');
        if(!tipoSelect) return;
        
        const tipo = tipoSelect.value;
        const isNatural = tipo === 'natural';
        
        const divNombre = document.getElementById('div_nombre_completo');
        const divRazon = document.getElementById('div_razon_social');
        const divDv = document.getElementById('div_dv');
        
        if(divNombre) divNombre.style.display = isNatural ? 'block' : 'none';
        if(divRazon) divRazon.style.display = isNatural ? 'none' : 'block';
        if(divDv) divDv.style.display = isNatural ? 'none' : 'block';
        
        const nombreInput = document.querySelector('input[name="nombre_completo"]');
        const razonInput = document.querySelector('input[name="razon_social"]');
        
        if(isNatural) {
            if(nombreInput) nombreInput.setAttribute('required', 'required');
            if(razonInput) razonInput.removeAttribute('required');
        } else {
            if(nombreInput) nombreInput.removeAttribute('required');
            if(razonInput) razonInput.setAttribute('required', 'required');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const createForm = document.getElementById('createTerceroForm');
        if(createForm) {
            createForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const data = Object.fromEntries(formData.entries());
                
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfMeta ? csrfMeta.content : '';

                fetch('{{ route("terceros.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        alert('Tercero creado correctamente');
                        closeTerceroModal();
                        if(typeof selectTercero === 'function') {
                            selectTercero(res.tercero, currentTerceroTarget);
                        }
                    } else {
                        alert('Error al crear tercero: ' + (res.message || 'Desconocido'));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Error de conexión');
                });
            });
        }

        // Initialize fields on load if values exist
        // Check Beneficiario
        const benName = document.getElementById('nombre_beneficiario');
        if(benName && benName.value) {
            const container = document.getElementById('beneficiario-search-container');
            const card = document.getElementById('beneficiario-selected-card');
            if(container) container.style.display = 'none';
            if(card) {
                card.style.display = 'flex';
                const dispName = document.getElementById('beneficiario-display-name');
                if(dispName) dispName.textContent = benName.value;
                
                const benId = document.getElementById('identificacion').value;
                const benType = document.getElementById('tipo_identificacion').value;
                const dispId = document.getElementById('beneficiario-display-id');
                if(dispId) dispId.textContent = `${benType} ${benId}`;
            }
        }

        // Check Deudor
        const deuName = document.getElementById('nombre_deudor');
        if(deuName && deuName.value) {
            const container = document.getElementById('deudor-search-container');
            const card = document.getElementById('deudor-selected-card');
            if(container) container.style.display = 'none';
            if(card) {
                card.style.display = 'flex';
                const dispName = document.getElementById('deudor-display-name');
                if(dispName) dispName.textContent = deuName.value;
                
                const deuId = document.getElementById('numero_documento_deudor').value;
                const deuType = document.getElementById('tipo_documento_deudor').value;
                const dispId = document.getElementById('deudor-display-id');
                if(dispId) dispId.textContent = `${deuType} ${deuId}`;
            }
        }
        
        // Close search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.form-group')) {
                document.querySelectorAll('.search-results').forEach(el => el.style.display = 'none');
            }
        });
    });

    let searchTimeout;

    window.handleTerceroSearch = function(query, target) {
        clearTimeout(searchTimeout);
        const resultsDiv = document.getElementById(`${target}-results`);
        if(!resultsDiv) return;
        
        if(query.length < 2) {
            resultsDiv.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`{{ route("terceros.search") }}?q=${query}`)
            .then(res => res.json())
            .then(data => {
                resultsDiv.innerHTML = '';
                if(data.length > 0) {
                    data.forEach(item => {
                        const tercero = item.data;
                        const div = document.createElement('div');
                        div.style.padding = '10px';
                        div.style.cursor = 'pointer';
                        div.style.borderBottom = '1px solid #eee';
                        div.innerHTML = `<strong>${item.value}</strong><br><small>${tercero.identificacion}</small>`;
                        div.onclick = () => selectTercero(tercero, target);
                        div.onmouseover = () => div.style.background = '#f0f0f0';
                        div.onmouseout = () => div.style.background = 'white';
                        resultsDiv.appendChild(div);
                    });
                    resultsDiv.style.display = 'block';
                } else {
                    resultsDiv.innerHTML = '<div style="padding:10px; color:#666;">No encontrado</div>';
                    resultsDiv.style.display = 'block';
                }
            });
        }, 300);
    }

    window.selectTercero = function(tercero, target) {
        // Hide search, show card
        const searchContainer = document.getElementById(`${target}-search-container`);
        const selectedCard = document.getElementById(`${target}-selected-card`);
        const resultsDiv = document.getElementById(`${target}-results`);
        
        if(searchContainer) searchContainer.style.display = 'none';
        if(selectedCard) selectedCard.style.display = 'flex';
        if(resultsDiv) resultsDiv.style.display = 'none';

        // Update Card - use computed 'nombre' attribute or fallback
        const name = tercero.nombre || (tercero.tipo_persona === 'juridica' ? tercero.razon_social : tercero.nombre_completo);
        const dispName = document.getElementById(`${target}-display-name`);
        const dispId = document.getElementById(`${target}-display-id`);
        
        if(dispName) dispName.textContent = name || 'Sin nombre';
        if(dispId) dispId.textContent = `${tercero.tipo_identificacion || ''} ${tercero.identificacion || ''}`;
        
        if(target === 'deudor') {
             const emailSpan = document.getElementById(`${target}-display-email`);
             if(emailSpan) emailSpan.textContent = tercero.email || '';
        }

        // Fill Hidden Fields
        fillTerceroFields(tercero, target);
    }

    window.clearTerceroSelection = function(target) {
        const searchContainer = document.getElementById(`${target}-search-container`);
        const selectedCard = document.getElementById(`${target}-selected-card`);
        const searchInput = document.getElementById(`search_${target}`);
        
        if(searchContainer) searchContainer.style.display = 'block';
        if(selectedCard) selectedCard.style.display = 'none';
        if(searchInput) searchInput.value = '';
        
        // Clear hidden fields
        if(target === 'beneficiario') {
            const id = document.getElementById('identificacion'); if(id) id.value = '';
            const tid = document.getElementById('tipo_identificacion'); if(tid) tid.value = '';
            const nom = document.getElementById('nombre_beneficiario'); if(nom) nom.value = '';
            const tcl = document.getElementById('tipo_cliente'); if(tcl) tcl.value = '';
        } else {
            const nd = document.getElementById('numero_documento_deudor'); if(nd) nd.value = '';
            const td = document.getElementById('tipo_documento_deudor'); if(td) td.value = '';
            const nom = document.getElementById('nombre_deudor'); if(nom) nom.value = '';
            const em = document.getElementById('email_deudor'); if(em) em.value = '';
            const tel = document.getElementById('telefono_deudor'); if(tel) tel.value = '';
        }
    }

    function fillTerceroFields(tercero, target) {
        if(target === 'beneficiario') {
            const idField = document.getElementById('identificacion');
            if(idField) idField.value = tercero.identificacion;

            const tipoIdField = document.getElementById('tipo_identificacion');
            if(tipoIdField) tipoIdField.value = tercero.tipo_identificacion;

            const nameField = document.getElementById('nombre_beneficiario');
            if(nameField) nameField.value = tercero.tipo_persona === 'juridica' ? tercero.razon_social : tercero.nombre_completo;

            const tipoClienteField = document.getElementById('tipo_cliente');
            if(tipoClienteField) {
                tipoClienteField.value = tercero.tipo_persona === 'juridica' ? 'juridico' : 'natural';
            }
            
            // Address, phone, etc.
            const dirAcreedor = document.getElementById('direccion_acreedor');
            if(dirAcreedor) dirAcreedor.value = tercero.direccion;

            const telAcreedor = document.getElementById('telefono_acreedor');
            if(telAcreedor) telAcreedor.value = tercero.telefono;

            const emailAcreedor = document.getElementById('email_acreedor');
            if(emailAcreedor) emailAcreedor.value = tercero.email;

            const ciudadAcreedor = document.getElementById('ciudad_expedicion_acreedor');
            if(ciudadAcreedor) ciudadAcreedor.value = tercero.ciudad;

        } else {
            // Deudor
            const idField = document.getElementById('numero_documento_deudor');
            if(idField) idField.value = tercero.identificacion;
            
            let tipoDoc = document.getElementById('tipo_documento_deudor');
            if(!tipoDoc) tipoDoc = document.querySelector('select[name="tipo_documento_deudor"]');
            if(tipoDoc) tipoDoc.value = tercero.tipo_identificacion;
            
            const nameField = document.getElementById('nombre_deudor');
            if(nameField) nameField.value = tercero.tipo_persona === 'juridica' ? tercero.razon_social : tercero.nombre_completo;
            
            const dirField = document.getElementById('direccion_deudor');
            if(dirField) dirField.value = tercero.direccion;
            
            const telField = document.getElementById('telefono_deudor');
            if(telField) telField.value = tercero.telefono;
            
            const emailField = document.getElementById('email_deudor');
            if(emailField) emailField.value = tercero.email;
            
            const ciudadField = document.getElementById('ciudad_expedicion_deudor');
            if(ciudadField) ciudadField.value = tercero.ciudad;
        }
    }
</script>
@endpush

