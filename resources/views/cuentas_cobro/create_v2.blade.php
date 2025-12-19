@extends('layouts.app')

@section('title', 'Nueva Cuenta de Cobro')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/views/cuenta-cobro-form.css') }}">
@endpush

@section('content')
<div class="siigo-page">
    <form action="{{ route('cuentas_cobro.store') }}" method="POST" id="cuentaCobroForm" enctype="multipart/form-data">
        @csrf
        
        {{-- Alertas del Consecutivo --}}
        @if(isset($consecutivoInfo))
            @if(!empty($consecutivoInfo['alertas']))
                <div class="consecutivo-alertas">
                    @foreach($consecutivoInfo['alertas'] as $alerta)
                        <div class="alert-consecutivo alert-{{ $alerta['tipo'] }}">
                            <span class="material-symbols-rounded">
                                @if($alerta['tipo'] === 'danger')
                                    error
                                @elseif($alerta['tipo'] === 'warning')
                                    warning
                                @else
                                    check_circle
                                @endif
                            </span>
                            <div>
                                <strong>{{ $alerta['titulo'] }}</strong>
                                <p style="margin: 4px 0 0; font-size: 13px; opacity: 0.9;">{{ $alerta['mensaje'] }}</p>
                            </div>
                            @if($alerta['tipo'] === 'danger' || $alerta['tipo'] === 'warning')
                                @if(auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin_programa'))
                                    <a href="{{ route('admin.consecutivos.create') }}" class="btn-new-consecutivo">
                                        <span class="material-symbols-rounded">add</span>
                                        Nuevo Consecutivo
                                    </a>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
            
            {{-- Info del consecutivo actual --}}
            <div class="consecutivo-info-bar">
                <div class="info-left">
                    <span class="material-symbols-rounded" style="font-size: 28px; opacity: 0.9;">receipt_long</span>
                    <div>
                        <div class="info-title">Consecutivo Activo</div>
                        <div class="info-number">{{ $siguienteNumero }}</div>
                        <div class="info-resolution">Resolución: {{ $consecutivoInfo['resolucion'] ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="info-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ number_format($consecutivoInfo['disponibles']) }}</div>
                        <div class="stat-label">Disponibles</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $consecutivoInfo['porcentaje_uso'] }}%</div>
                        <div class="stat-label">Usado</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" style="font-size: 14px;">{{ $consecutivoInfo['vigencia_formato'] ?? $consecutivoInfo['dias_restantes'] . ' días' }}</div>
                        <div class="stat-label">Vigencia Restante</div>
                    </div>
                    <div class="stat-item" style="border-left: 1px solid rgba(255,255,255,0.3); padding-left: 24px;">
                        <div class="stat-value" style="font-size: 13px;">Vence</div>
                        <div class="stat-label">{{ $consecutivoInfo['vigencia_fin'] }}</div>
                    </div>
                </div>
            </div>
        @endif
        
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

                <!-- Comprador / Deudor (quien paga) -->
                <div class="siigo-card" id="cardDeudor">
                    <div class="siigo-card-header" onclick="toggleCard('cardDeudor')">
                        <h3>
                            <span class="material-symbols-rounded icon">domain</span>
                            Comprador / Deudor (quien paga)
                        </h3>
                        <span class="material-symbols-rounded chevron">expand_more</span>
                    </div>
                    <div class="siigo-card-body">
                        <div class="siigo-form-grid">
                            <div class="siigo-form-group full-width">
                                <label class="siigo-label">Buscar Comprador <span class="required">*</span></label>
                                <div class="siigo-input-group" style="position: relative;">
                                    <span class="material-symbols-rounded input-icon">search</span>
                                    <input type="text" id="searchDeudor" class="siigo-input" placeholder="Buscar por nombre, cédula o NIT..." autocomplete="off">
                                    <button type="button" class="input-action" onclick="openNewTerceroModal('deudor')">
                                        <span class="material-symbols-rounded" style="font-size: 14px;">add</span>
                                        Nuevo
                                    </button>
                                    <div class="siigo-search-dropdown" id="deudorDropdown">
                                        <!-- Results populated by JS -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="deudorDetails" style="display: none; margin-top: 20px; padding: 16px; background: var(--siigo-gray-100); border-radius: 8px;">
                            <div class="siigo-form-grid cols-3">
                                <div class="siigo-form-group">
                                    <label class="siigo-label">Nombre Completo</label>
                                    <input type="text" name="nombre_deudor" id="nombreDeudor" class="siigo-input" required>
                                </div>
                                <div class="siigo-form-group">
                                    <label class="siigo-label">Tipo Documento</label>
                                    <select name="tipo_documento_deudor" id="tipoDocDeudor" class="siigo-input">
                                        <option value="CC">Cédula de Ciudadanía</option>
                                        <option value="NIT">NIT</option>
                                        <option value="CE">Cédula de Extranjería</option>
                                        <option value="PA">Pasaporte</option>
                                    </select>
                                </div>
                                <div class="siigo-form-group">
                                    <label class="siigo-label">Número Documento</label>
                                    <input type="text" name="numero_documento_deudor" id="numDocDeudor" class="siigo-input" required>
                                </div>
                                <div class="siigo-form-group">
                                    <label class="siigo-label">Teléfono</label>
                                    <input type="text" name="telefono_deudor" id="telefonoDeudor" class="siigo-input">
                                </div>
                                <div class="siigo-form-group">
                                    <label class="siigo-label">Email</label>
                                    <input type="email" name="email_deudor" id="emailDeudor" class="siigo-input">
                                </div>
                                <div class="siigo-form-group">
                                    <label class="siigo-label">Dirección</label>
                                    <input type="text" name="direccion_deudor" id="direccionDeudor" class="siigo-input">
                                </div>
                            </div>
                            <input type="hidden" name="deudor_id" id="deudorId">
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
                                            {{ $contrato->numero }} - {{ substr($contrato->objeto ?? '', 0, 40) }}{{ strlen($contrato->objeto ?? '') > 40 ? '...' : '' }}
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
                    <div class="siigo-card-body" style="padding: 0; overflow-x: auto;">
                        <table class="siigo-items-table" style="min-width: 900px;">
                            <thead>
                                <tr>
                                    <th style="width: 40px; min-width: 40px;">#</th>
                                    <th style="width: 100px; min-width: 100px;">Código PUC</th>
                                    <th style="width: 180px; min-width: 180px;">Servicio / Producto</th>
                                    <th style="width: 160px; min-width: 160px;">Descripción</th>
                                    <th style="width: 130px; min-width: 130px;">Centro Costo</th>
                                    <th style="width: 70px; min-width: 70px;">Cant.</th>
                                    <th style="width: 120px; min-width: 120px;">Valor Unit.</th>
                                    <th style="width: 90px; min-width: 90px;">Impuesto</th>
                                    <th style="width: 110px; min-width: 110px;">Total</th>
                                    <th style="width: 50px; min-width: 50px;"></th>
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
                        <!-- Concepto / Observaciones -->
                        <div class="siigo-form-group" style="margin-bottom: 20px;">
                            <label class="siigo-label" style="font-size: 14px; font-weight: 600;">Concepto / Observaciones <span class="required">*</span></label>
                            <textarea name="concepto_cobro" class="siigo-input" rows="4" placeholder="Describe detalladamente el servicio prestado o el motivo del cobro..." required minlength="10" style="font-size: 14px; padding: 14px; border-radius: 8px; resize: vertical;"></textarea>
                            <small style="color: var(--siigo-gray-500); font-size: 12px;">Mínimo 10 caracteres. Este texto aparecerá en el documento PDF.</small>
                        </div>
                        
                        <!-- Grid de fechas -->
                        <div class="siigo-form-grid cols-2" style="margin-bottom: 20px;">
                            <div class="siigo-form-group">
                                <label class="siigo-label">Fecha Prestación del Servicio <span class="required">*</span></label>
                                <input type="date" name="fecha_prestacion_servicio" class="siigo-input" value="{{ date('Y-m-d') }}" required style="font-size: 14px; padding: 12px;">
                            </div>
                            <div class="siigo-form-group">
                                <label class="siigo-label">Fecha de Vencimiento</label>
                                <input type="date" name="fecha_vencimiento" class="siigo-input" value="{{ date('Y-m-d', strtotime('+30 days')) }}" style="font-size: 14px; padding: 12px;">
                            </div>
                        </div>
                        
                        <!-- Adjuntar Archivo -->
                        <div class="siigo-form-group" style="margin-bottom: 20px;">
                            <label class="siigo-label" style="font-size: 14px; font-weight: 600;">Adjuntar Soporte (Opcional)</label>
                            <div class="file-upload-area" style="border: 2px dashed var(--siigo-gray-300); border-radius: 10px; padding: 24px; text-align: center; background: var(--siigo-gray-100); cursor: pointer; transition: all 0.2s;" onclick="document.getElementById('soporteFile').click()" onmouseover="this.style.borderColor='var(--siigo-primary)'" onmouseout="this.style.borderColor='var(--siigo-gray-300)'">
                                <input type="file" name="soporte" id="soporteFile" class="siigo-input" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx" style="display: none;" onchange="updateFileLabel(this)">
                                <span class="material-symbols-rounded" style="font-size: 40px; color: var(--siigo-primary); display: block; margin-bottom: 8px;">cloud_upload</span>
                                <p id="fileLabel" style="margin: 0; color: var(--siigo-gray-500); font-size: 14px;">Haz clic o arrastra un archivo aquí</p>
                                <small style="color: var(--siigo-gray-400); font-size: 12px;">PDF, imágenes, Word o Excel. Máximo 5MB</small>
                            </div>
                        </div>
                        
                        <!-- Plazo de pago -->
                        <div class="siigo-form-grid cols-2">
                            <div class="siigo-form-group">
                                <label class="siigo-label">Plazo de Pago (días)</label>
                                <input type="number" name="plazo_pago" class="siigo-input" value="30" min="0" max="365" style="font-size: 14px; padding: 12px;">
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
        <div class="siigo-modal modal-lg">
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
                    <div class="siigo-form-grid cols-2" style="gap: 20px;">
                        <div class="siigo-form-group full-width">
                            <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Tipo de Persona <span class="required">*</span></label>
                            <div style="display: flex; gap: 24px; margin-top: 8px;">
                                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px;">
                                    <input type="radio" name="modal_tipo_persona" value="natural" checked style="width: 18px; height: 18px;">
                                    <span>Persona Natural</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 14px;">
                                    <input type="radio" name="modal_tipo_persona" value="juridica" style="width: 18px; height: 18px;">
                                    <span>Persona Jurídica</span>
                                </label>
                            </div>
                        </div>
                        <div class="siigo-form-group">
                            <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Tipo de Identificación <span class="required">*</span></label>
                            <select id="modal_tipo_id" class="siigo-input" required style="font-size: 14px; padding: 10px 12px;">
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="NIT">NIT</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="PA">Pasaporte</option>
                                <option value="TI">Tarjeta de Identidad</option>
                            </select>
                        </div>
                        <div class="siigo-form-group">
                            <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Número de Identificación <span class="required">*</span></label>
                            <div style="display: flex; gap: 8px;">
                                <input type="text" id="modal_identificacion" class="siigo-input" placeholder="Ej: 1234567890" required style="flex: 1; font-size: 14px; padding: 10px 12px;">
                                <input type="text" id="modal_dv" class="siigo-input" placeholder="DV" style="width: 70px; display: none; font-size: 14px; padding: 10px 12px;">
                            </div>
                        </div>
                        <div class="siigo-form-group" id="divNombreCompleto">
                            <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Nombre Completo <span class="required">*</span></label>
                            <input type="text" id="modal_nombre" class="siigo-input" placeholder="Ej: Juan Pérez García" required style="font-size: 14px; padding: 10px 12px;">
                        </div>
                        <div class="siigo-form-group" id="divRazonSocial" style="display: none;">
                            <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Razón Social <span class="required">*</span></label>
                            <input type="text" id="modal_razon_social" class="siigo-input" placeholder="Ej: Empresa S.A.S." style="font-size: 14px; padding: 10px 12px;">
                        </div>
                        <div class="siigo-form-group">
                            <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Teléfono</label>
                            <div style="display: flex; gap: 8px;">
                                <select id="modal_codigo_pais" class="siigo-input" style="width: 160px; font-size: 14px; padding: 10px 12px;">
                                    @foreach($paises as $pais)
                                    <option value="{{ $pais->indicativo }}" {{ $pais->codigo_iso2 === 'CO' ? 'selected' : '' }}>
                                        {{ $pais->codigo_iso2 }} {{ $pais->indicativo }}
                                    </option>
                                    @endforeach
                                </select>
                                <input type="text" id="modal_telefono" class="siigo-input" placeholder="Ej: 3001234567" style="flex: 1; font-size: 14px; padding: 10px 12px;">
                            </div>
                        </div>
                        <div class="siigo-form-group">
                            <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Email</label>
                            <input type="email" id="modal_email" class="siigo-input" placeholder="Ej: correo@ejemplo.com" style="font-size: 14px; padding: 10px 12px;">
                        </div>
                        <div class="siigo-form-group full-width">
                            <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Responsabilidades Fiscales</label>
                            <div id="responsabilidadesFiscalesContainer" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; max-height: 180px; overflow-y: auto; border: 1px solid var(--siigo-gray-200); border-radius: 8px; padding: 16px; background: #fafafa;">
                                @foreach($responsabilidadesFiscales as $resp)
                                <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-size: 13px;">
                                    <input type="checkbox" name="modal_responsabilidades[]" value="{{ $resp->codigo }}" style="width: 16px; height: 16px; margin-top: 2px;">
                                    <span><strong>{{ $resp->codigo }}</strong>: {{ $resp->nombre }}</span>
                                </label>
                                @endforeach
                            </div>
                            <small style="color: var(--siigo-gray-500); font-size: 11px; margin-top: 4px; display: block;">Según Resolución DIAN - Ley 2024/2025</small>
                        </div>
                        <div class="siigo-form-group full-width">
                            <label class="siigo-label" style="font-size: 13px; font-weight: 600;">País</label>
                            <select id="modal_pais" class="siigo-input" style="font-size: 14px; padding: 10px 12px;" onchange="toggleUbicacion()">
                                @foreach($paises as $pais)
                                <option value="{{ $pais->nombre }}" data-code="{{ $pais->codigo_iso2 }}" {{ $pais->codigo_iso2 === 'CO' ? 'selected' : '' }}>
                                    {{ $pais->nombre }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ubicación Colombia -->
                        <div id="divUbicacionColombia" class="siigo-form-group full-width" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin: 0;">
                            <div class="siigo-form-group">
                                <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Departamento</label>
                                <select id="modal_departamento" class="siigo-input" style="font-size: 14px; padding: 10px 12px;">
                                    <option value="">Seleccionar...</option>
                                    @foreach($departamentos as $dep)
                                    <option value="{{ $dep->nombre }}" data-id="{{ $dep->id }}">{{ $dep->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="siigo-form-group">
                                <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Ciudad/Municipio</label>
                                <select id="modal_ciudad" class="siigo-input" style="font-size: 14px; padding: 10px 12px;">
                                    <option value="">Seleccionar departamento primero</option>
                                </select>
                            </div>
                        </div>

                        <!-- Ubicación Extranjero -->
                        <div id="divUbicacionExtranjero" class="siigo-form-group full-width" style="display: none; grid-template-columns: 1fr 1fr; gap: 16px; margin: 0;">
                            <div class="siigo-form-group">
                                <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Estado/Provincia</label>
                                <input type="text" id="modal_estado_ext" class="siigo-input" placeholder="Ej: Florida" style="font-size: 14px; padding: 10px 12px;">
                            </div>
                            <div class="siigo-form-group">
                                <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Ciudad</label>
                                <input type="text" id="modal_ciudad_ext" class="siigo-input" placeholder="Ej: Miami" style="font-size: 14px; padding: 10px 12px;">
                            </div>
                        </div>
                        <div class="siigo-form-group full-width">
                            <label class="siigo-label" style="font-size: 13px; font-weight: 600;">Dirección</label>
                            <input type="text" id="modal_direccion" class="siigo-input" placeholder="Ej: Calle 123 # 45-67, Barrio Centro" style="font-size: 14px; padding: 10px 12px;">
                        </div>
                    </div>
                </form>
            </div>
            <div class="siigo-modal-footer" style="padding: 20px 24px;">
                <button type="button" class="siigo-btn siigo-btn-secondary" onclick="closeNewTerceroModal()" style="padding: 12px 24px; font-size: 14px;">
                    Cancelar
                </button>
                <button type="button" class="siigo-btn siigo-btn-primary" onclick="saveNewTercero()" style="padding: 12px 24px; font-size: 14px;">
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
        <div class="siigo-modal" style="max-width: 600px; margin: auto;">
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
                <!-- Centered Search Box -->
                <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                    <div class="siigo-input-group" style="width: 100%; max-width: 450px; position: relative;">
                        <span class="material-symbols-rounded" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--siigo-gray-400);">search</span>
                        <input type="text" id="searchPuc" class="siigo-input" placeholder="Buscar por código o nombre..." style="padding-left: 40px; text-align: left;">
                    </div>
                </div>
                
                <!-- PUC List with dynamic loading -->
                <div id="pucList" style="max-height: 350px; overflow-y: auto; border: 1px solid var(--siigo-gray-200); border-radius: 8px;">
                    <div id="pucListContent" style="display: flex; flex-direction: column;">
                        <!-- Items loaded dynamically via JS -->
                        <div style="padding: 20px; text-align: center; color: var(--siigo-gray-500);">
                            <span class="material-symbols-rounded" style="font-size: 32px; display: block; margin-bottom: 8px;">search</span>
                            Escriba para buscar cuentas PUC
                        </div>
                    </div>
                </div>
            </div>
            <div class="siigo-modal-footer" style="justify-content: center;">
                <button type="button" class="siigo-btn siigo-btn-secondary" onclick="closePucModal()">
                    <span class="material-symbols-rounded">close</span>
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

    // ==================== PUC MODAL ====================
    function openPucModal() {
        document.getElementById('modalPuc').classList.add('active');
        document.getElementById('searchPuc').focus();
        // Show initial hint
        renderPucListModal('');
    }

    function closePucModal() {
        document.getElementById('modalPuc').classList.remove('active');
        document.getElementById('searchPuc').value = '';
        selectedItemRow = null;
    }

    function renderPucListModal(query) {
        const container = document.getElementById('pucListContent');
        const q = query.toLowerCase().trim();
        
        if (q.length === 0) {
            // Show initial message
            container.innerHTML = `
                <div style="padding: 30px; text-align: center; color: var(--siigo-gray-500);">
                    <span class="material-symbols-rounded" style="font-size: 40px; display: block; margin-bottom: 12px; color: var(--siigo-primary);">search</span>
                    <p style="margin: 0;">Escriba un código o nombre para buscar</p>
                    <small>Ej: 1105, Caja, Bancos, Honorarios</small>
                </div>
            `;
            return;
        }
        
        // Filter results
        const filtered = pucData.filter(p => 
            p.codigo.startsWith(q) || 
            p.nombre.toLowerCase().includes(q) ||
            (p.grupo && p.grupo.toLowerCase().includes(q)) ||
            (p.clase && p.clase.toLowerCase().includes(q))
        ).slice(0, 100);
        
        if (filtered.length === 0) {
            container.innerHTML = `
                <div style="padding: 30px; text-align: center; color: var(--siigo-gray-500);">
                    <span class="material-symbols-rounded" style="font-size: 40px; display: block; margin-bottom: 12px;">search_off</span>
                    No se encontraron resultados para "${query}"
                </div>
            `;
            return;
        }
        
        let html = '';
        filtered.forEach(p => {
            const safeName = p.nombre.replace(/'/g, "\\'").replace(/"/g, '&quot;');
            html += `
                <div class="puc-modal-item" onclick="selectPucFromModal('${p.codigo}', '${safeName}')" 
                     style="padding: 12px 16px; border-bottom: 1px solid var(--siigo-gray-100); cursor: pointer; transition: background 0.15s;"
                     onmouseover="this.style.background='#f0f9ff'" onmouseout="this.style.background='white'">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <span style="font-family: monospace; font-weight: 700; color: var(--siigo-primary); font-size: 14px;">${p.codigo}</span>
                            <span style="margin-left: 12px; color: var(--siigo-dark);">${p.nombre}</span>
                        </div>
                        <span class="material-symbols-rounded" style="color: var(--siigo-gray-400); font-size: 18px;">chevron_right</span>
                    </div>
                    <div style="font-size: 11px; color: var(--siigo-gray-500); margin-top: 4px;">
                        Clase: ${p.clase || '-'} | ${p.naturaleza || 'Sin naturaleza'}
                    </div>
                </div>
            `;
        });
        
        container.innerHTML = html;
    }
    
    function selectPucFromModal(codigo, nombre) {
        if (selectedItemRow) {
            const pucInput = selectedItemRow.querySelector('.item-puc');
            const pucNombreInput = selectedItemRow.querySelector('.item-puc-nombre');
            if (pucInput) pucInput.value = codigo;
            if (pucNombreInput) pucNombreInput.value = nombre;
        } else {
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

    document.getElementById('searchPuc')?.addEventListener('input', function() {
        renderPucListModal(this.value);
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

    // ==================== PUC DROPDOWN LOGIC ====================
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.puc-selector')) {
            closeAllPucDropdowns();
        }
    });

    function closeAllPucDropdowns() {
        document.querySelectorAll('.puc-dropdown').forEach(el => el.remove());
    }

    function showPucDropdown(input) {
        closeAllPucDropdowns(); // Close others
        
        const container = input.closest('.puc-selector');
        let dropdown = container.querySelector('.puc-dropdown');
        
        if (!dropdown) {
            dropdown = document.createElement('div');
            dropdown.className = 'puc-dropdown active';
            container.appendChild(dropdown);
        }
        
        // If input is empty, show initial list (e.g. first 20)
        filterPucDropdown(input);
    }

    function filterPucDropdown(input) {
        const container = input.closest('.puc-selector');
        let dropdown = container.querySelector('.puc-dropdown');
        
        if (!dropdown) {
            showPucDropdown(input);
            dropdown = container.querySelector('.puc-dropdown');
        }

        const query = input.value.toLowerCase();
        
        // Filter data
        const filtered = pucData.filter(p => 
            p.codigo.startsWith(query) || 
            p.nombre.toLowerCase().includes(query) ||
            (p.grupo && p.grupo.toLowerCase().includes(query)) ||
            (p.clase && p.clase.toLowerCase().includes(query))
        ).slice(0, 50); // Limit to 50 results for performance

        if (filtered.length === 0) {
            dropdown.innerHTML = '<div class="puc-dropdown-item" style="cursor: default; color: #999;">No se encontraron resultados</div>';
            return;
        }

        let html = '';
        filtered.forEach(p => {
            // Escape quotes in name
            const safeName = p.nombre.replace(/'/g, "\\'");
            html += `
                <div class="puc-dropdown-item" onclick="selectPucFromDropdown('${p.codigo}', '${safeName}', this)">
                    <div>
                        <span class="code">${p.codigo}</span>
                        <span class="name">${p.nombre}</span>
                    </div>
                    <div class="meta">
                        <span>Clase: ${p.clase || '-'}</span>
                        <span>•</span>
                        <span>${p.naturaleza || '-'}</span>
                    </div>
                </div>
            `;
        });
        
        dropdown.innerHTML = html;
    }

    function selectPucFromDropdown(codigo, nombre, element) {
        const container = element.closest('.puc-selector');
        const input = container.querySelector('.item-puc');
        const nameInput = container.querySelector('.item-puc-nombre');
        
        input.value = codigo;
        if (nameInput) nameInput.value = nombre;
        
        closeAllPucDropdowns();
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

    // Deudor (Comprador) Search
    const searchDeudorInput = document.getElementById('searchDeudor');
    const deudorDropdown = document.getElementById('deudorDropdown');
    let currentModalTarget = 'beneficiario'; // Track which field the modal is for

    searchDeudorInput?.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        if (query.length < 2) {
            deudorDropdown.classList.remove('active');
            return;
        }

        const filtered = terceros.filter(t => 
            t.nombre?.toLowerCase().includes(query) || 
            t.identificacion?.includes(query)
        );

        if (filtered.length > 0) {
            deudorDropdown.innerHTML = filtered.slice(0, 5).map(t => `
                <div class="siigo-search-item" onclick='selectDeudor(${JSON.stringify(t)})'>
                    <div class="name">${t.nombre}</div>
                    <div class="meta">${t.tipo_identificacion || 'CC'}: ${t.identificacion} • ${t.email || 'Sin email'}</div>
                </div>
            `).join('');
            deudorDropdown.classList.add('active');
        } else {
            deudorDropdown.innerHTML = `
                <div class="siigo-search-item" onclick="openNewTerceroModal('deudor')">
                    <div class="name" style="color: var(--siigo-primary);">
                        <span class="material-symbols-rounded" style="font-size: 16px; vertical-align: text-bottom;">add</span>
                        Crear nuevo tercero
                    </div>
                    <div class="meta">No se encontraron resultados para "${query}"</div>
                </div>
            `;
            deudorDropdown.classList.add('active');
        }
    });

    function selectDeudor(tercero) {
        document.getElementById('deudorId').value = tercero.id || '';
        document.getElementById('nombreDeudor').value = tercero.nombre || '';
        document.getElementById('tipoDocDeudor').value = tercero.tipo_identificacion || 'CC';
        document.getElementById('numDocDeudor').value = tercero.identificacion || '';
        document.getElementById('telefonoDeudor').value = tercero.telefono || '';
        document.getElementById('emailDeudor').value = tercero.email || '';
        document.getElementById('direccionDeudor').value = tercero.direccion || '';

        document.getElementById('deudorDetails').style.display = 'block';
        document.getElementById('searchDeudor').value = tercero.nombre;
        deudorDropdown.classList.remove('active');
        
        updateProgress();
    }

    // Modal Tercero Functions
    function openNewTerceroModal(target = 'beneficiario') {
        currentModalTarget = target;
        document.getElementById('modalTercero').classList.add('active');
        dropdown?.classList.remove('active');
        deudorDropdown?.classList.remove('active');
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

    // Toggle Ubicación
    function toggleUbicacion() {
        const paisSelect = document.getElementById('modal_pais');
        const selectedOption = paisSelect.options[paisSelect.selectedIndex];
        const isColombia = selectedOption.dataset.code === 'CO';
        
        document.getElementById('divUbicacionColombia').style.display = isColombia ? 'grid' : 'none';
        document.getElementById('divUbicacionExtranjero').style.display = isColombia ? 'none' : 'grid';
        
        // Update phone code if possible
        const phoneSelect = document.getElementById('modal_codigo_pais');
        // Try to match by ISO code in the text
        const phoneOption = Array.from(phoneSelect.options).find(opt => opt.text.includes(selectedOption.dataset.code));
        if (phoneOption) {
            phoneSelect.value = phoneOption.value;
        }
    }

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
        const direccion = document.getElementById('modal_direccion').value;
        
        // Ubicación
        const paisSelect = document.getElementById('modal_pais');
        const pais = paisSelect.value;
        const paisCodigo = paisSelect.options[paisSelect.selectedIndex].dataset.code;
        
        let departamento, ciudad;
        if (paisCodigo === 'CO') {
            departamento = document.getElementById('modal_departamento').value;
            ciudad = document.getElementById('modal_ciudad').value;
        } else {
            departamento = document.getElementById('modal_estado_ext').value;
            ciudad = document.getElementById('modal_ciudad_ext').value;
        }
        
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
                    pais: pais,
                    pais_codigo: paisCodigo,
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
                
                // Ensure it's added to the array
                terceros.push(nuevoTercero);
                
                // Seleccionar automáticamente según el target
                if (currentModalTarget === 'deudor') {
                    selectDeudor(nuevoTercero);
                } else {
                    selectTercero(nuevoTercero);
                }
                closeNewTerceroModal();
                
                // Show success message
                const toast = document.createElement('div');
                toast.style.cssText = 'position: fixed; bottom: 20px; right: 20px; background: #00b894; color: white; padding: 12px 24px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 9999; animation: slideIn 0.3s ease-out;';
                toast.innerHTML = '<span class="material-symbols-rounded" style="vertical-align: middle; margin-right: 8px;">check_circle</span> Tercero creado y seleccionado';
                document.body.appendChild(toast);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
                
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
        // Recopilar datos del formulario
        const terceroNombre = document.getElementById('nombreBeneficiario')?.value || 'Sin especificar';
        const terceroId = document.getElementById('identificacion')?.value || '';
        const terceroTipoId = document.getElementById('tipoIdentificacion')?.value || 'CC';
        const docNumber = document.getElementById('docNumber')?.textContent || 'Auto';
        const fecha = new Date().toLocaleDateString('es-CO');
        
        // Recopilar items
        let itemsHtml = '';
        let subtotal = 0;
        let totalIva = 0;
        
        document.querySelectorAll('#itemsTableBody tr').forEach((row, idx) => {
            const item = row.querySelector('.item-name')?.value || '';
            const desc = row.querySelector('input[name*="descripcion"]')?.value || '';
            const qty = parseFloat(row.querySelector('.item-qty')?.value) || 0;
            const price = parseFloat(row.querySelector('.item-price')?.value) || 0;
            const tax = parseFloat(row.querySelector('.item-tax')?.value) || 0;
            const lineTotal = qty * price;
            const lineTax = lineTotal * (tax / 100);
            
            subtotal += lineTotal;
            totalIva += lineTax;
            
            if (item) {
                itemsHtml += `
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;">${idx + 1}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;">${item}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;">${desc}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: center;">${qty}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: right;">${formatCurrency(price)}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: center;">${tax}%</td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee; text-align: right; font-weight: 600;">${formatCurrency(lineTotal + lineTax)}</td>
                    </tr>
                `;
            }
        });
        
        const total = subtotal + totalIva;
        const concepto = document.querySelector('textarea[name="concepto_cobro"]')?.value || '';
        
        // Crear ventana de vista previa
        const previewWindow = window.open('', '_blank', 'width=800,height=900');
        previewWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Vista Previa - Cuenta de Cobro ${docNumber}</title>
                <style>
                    body { font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 40px; background: #f5f5f5; }
                    .container { max-width: 700px; margin: 0 auto; background: white; padding: 40px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
                    .header { text-align: center; border-bottom: 3px solid #00a699; padding-bottom: 20px; margin-bottom: 30px; }
                    .header h1 { color: #00a699; margin: 0; font-size: 28px; }
                    .header p { color: #666; margin: 10px 0 0; }
                    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
                    .info-box { background: #f8f9fa; padding: 15px; border-radius: 8px; }
                    .info-box label { font-size: 11px; color: #666; text-transform: uppercase; display: block; margin-bottom: 5px; }
                    .info-box span { font-size: 14px; font-weight: 600; color: #333; }
                    table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
                    thead { background: #00a699; color: white; }
                    th { padding: 12px; text-align: left; font-size: 12px; text-transform: uppercase; }
                    .totals { background: #f8f9fa; padding: 20px; border-radius: 8px; }
                    .totals-row { display: flex; justify-content: space-between; padding: 8px 0; }
                    .totals-row.total { font-size: 20px; font-weight: 700; color: #00a699; border-top: 2px solid #00a699; padding-top: 15px; margin-top: 10px; }
                    .concepto { background: #fff3cd; padding: 15px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #ffc107; }
                    .footer { text-align: center; color: #999; font-size: 12px; margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; }
                    .btn-print { background: #00a699; color: white; border: none; padding: 12px 30px; border-radius: 6px; cursor: pointer; font-size: 14px; margin-top: 20px; }
                    .btn-print:hover { background: #008f84; }
                    @media print { .no-print { display: none; } body { background: white; } .container { box-shadow: none; } }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <h1>CUENTA DE COBRO</h1>
                        <p>Nº ${docNumber} | Fecha: ${fecha}</p>
                    </div>
                    
                    <div class="info-grid">
                        <div class="info-box">
                            <label>Beneficiario</label>
                            <span>${terceroNombre}</span>
                        </div>
                        <div class="info-box">
                            <label>${terceroTipoId}</label>
                            <span>${terceroId}</span>
                        </div>
                    </div>
                    
                    ${concepto ? `<div class="concepto"><strong>Concepto:</strong> ${concepto}</div>` : ''}
                    
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Descripción</th>
                                <th>Detalle</th>
                                <th>Cant.</th>
                                <th>V. Unit.</th>
                                <th>IVA</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemsHtml || '<tr><td colspan="7" style="text-align: center; padding: 20px; color: #999;">Sin items</td></tr>'}
                        </tbody>
                    </table>
                    
                    <div class="totals">
                        <div class="totals-row"><span>Subtotal:</span><span>${formatCurrency(subtotal)}</span></div>
                        <div class="totals-row"><span>IVA:</span><span>${formatCurrency(totalIva)}</span></div>
                        <div class="totals-row total"><span>TOTAL A PAGAR:</span><span>${formatCurrency(total)}</span></div>
                    </div>
                    
                    <div class="footer">
                        <p>Documento generado el ${new Date().toLocaleString('es-CO')}</p>
                        <button class="btn-print no-print" onclick="window.print()">Imprimir</button>
                    </div>
                </div>
            </body>
            </html>
        `);
        previewWindow.document.close();
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

    // File upload label update
    function updateFileLabel(input) {
        const label = document.getElementById('fileLabel');
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const sizeMB = (file.size / 1024 / 1024).toFixed(2);
            label.innerHTML = `<strong>${file.name}</strong> (${sizeMB} MB)`;
            label.style.color = 'var(--siigo-primary)';
            
            // Update container style
            const container = input.closest('.file-upload-area');
            if (container) {
                container.style.borderColor = 'var(--siigo-success)';
                container.style.background = '#f0fdf4';
            }
        } else {
            label.textContent = 'Haz clic o arrastra un archivo aquí';
            label.style.color = 'var(--siigo-gray-500)';
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        addItemRow(); // Add first row
        updateProgress();
    });
</script>
@endsection
