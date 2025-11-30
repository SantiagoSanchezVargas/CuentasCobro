{{-- resources/views/cuentas_cobro/partials/details-grid.blade.php --}}
@php
    $sectionsVisibility = is_array($visibleSections ?? null) ? $visibleSections : [];
    $canShowSection = static function (string $key) use ($sectionsVisibility): bool {
        return (bool) ($sectionsVisibility[$key] ?? false);
    };
    $formatDate = static function ($value, string $format = 'd/m/Y') {
        if (empty($value)) {
            return null;
        }
        try {
            return \Illuminate\Support\Carbon::parse($value)->format($format);
        } catch (\Throwable $th) {
            return $value;
        }
    };
    $formatMoney = static function ($value) {
        if ($value === null || $value === '') {
            return null;
        }
        return '$' . number_format((float) $value, 2, ',', '.');
    };
    $boolLabel = static fn ($value) => $value ? 'Sí' : 'No';
    $resolveUrl = static function ($path) {
        if (empty($path)) {
            return null;
        }
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }
        if (\Illuminate\Support\Facades\Storage::exists($path)) {
            return \Illuminate\Support\Facades\Storage::url($path);
        }
        return $path;
    };
    $documentoSoporteUrl = $resolveUrl($cuenta->documento_soporte_url ?? null);
@endphp

{{-- Acreedor --}}
@if($canShowSection('acreedor'))
    @php
        $acreedorFields = array_filter([
            ['label' => 'Nombre del acreedor', 'icon' => 'account_balance', 'value' => $cuenta->nombre_acreedor],
            ['label' => 'Tipo de documento', 'icon' => 'badge', 'value' => $cuenta->tipo_documento_acreedor],
            ['label' => 'Número de documento', 'icon' => 'fingerprint', 'value' => $cuenta->numero_documento_acreedor],
            ['label' => 'Ciudad de expedición', 'icon' => 'location_city', 'value' => $cuenta->ciudad_expedicion_acreedor],
            ['label' => 'Dirección', 'icon' => 'place', 'value' => $cuenta->direccion_acreedor],
            ['label' => 'Teléfono', 'icon' => 'call', 'value' => $cuenta->telefono_acreedor],
            ['label' => 'Correo electrónico', 'icon' => 'mail', 'value' => $cuenta->email_acreedor],
        ], fn($field) => filled($field['value']));
    @endphp
    @if(count($acreedorFields))
    <div class="wix-card">
        <div class="wix-card-header">
            <h3 class="wix-section-title">Datos del Acreedor</h3>
        </div>
        <div class="wix-card-body">
            <div class="info-grid">
                @foreach($acreedorFields as $field)
                    <div class="info-item">
                        <div class="info-label">{{ $field['label'] }}</div>
                        <div class="info-value">{{ $field['value'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endif

{{-- Deudor --}}
@if($canShowSection('deudor'))
    @php
        $deudorFields = array_filter([
            ['label' => 'Nombre del deudor', 'icon' => 'person', 'value' => $cuenta->nombre_deudor],
            ['label' => 'Tipo de documento', 'icon' => 'badge', 'value' => $cuenta->tipo_documento_deudor],
            ['label' => 'Número de documento', 'icon' => 'fingerprint', 'value' => $cuenta->numero_documento_deudor],
            ['label' => 'Ciudad de expedición', 'icon' => 'location_city', 'value' => $cuenta->ciudad_expedicion_deudor],
            ['label' => 'Dirección', 'icon' => 'place', 'value' => $cuenta->direccion_deudor],
            ['label' => 'Teléfono', 'icon' => 'call', 'value' => $cuenta->telefono_deudor],
            ['label' => 'Correo electrónico', 'icon' => 'mail', 'value' => $cuenta->email_deudor],
        ], fn($field) => filled($field['value']));
    @endphp
    @if(count($deudorFields))
    <div class="wix-card">
        <div class="wix-card-header">
            <h3 class="wix-section-title">Datos del Deudor</h3>
        </div>
        <div class="wix-card-body">
            <div class="info-grid">
                @foreach($deudorFields as $field)
                    <div class="info-item">
                        <div class="info-label">{{ $field['label'] }}</div>
                        <div class="info-value">{{ $field['value'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endif

{{-- Servicio --}}
@if($canShowSection('servicio'))
    @php
        $serviceMeta = array_filter([
            ['label' => 'Fecha prestación', 'value' => $formatDate($cuenta->fecha_prestacion_servicio)],
            ['label' => 'Fecha inicio', 'value' => $formatDate($cuenta->fecha_inicio_servicio)],
            ['label' => 'Fecha fin', 'value' => $formatDate($cuenta->fecha_fin_servicio)],
            ['label' => 'Lugar de prestación', 'value' => $cuenta->lugar_prestacion_servicio],
        ], fn($field) => filled($field['value']));
    @endphp
    @if($cuenta->concepto_cobro || $cuenta->descripcion_servicio || count($serviceMeta))
    <div class="wix-card">
        <div class="wix-card-header">
            <h3 class="wix-section-title">Detalle del Servicio</h3>
        </div>
        <div class="wix-card-body">
            <div class="info-grid">
                @if($cuenta->concepto_cobro)
                    <div class="info-item full-width">
                        <div class="info-label">Concepto del cobro</div>
                        <div class="info-value">{{ $cuenta->concepto_cobro }}</div>
                    </div>
                @endif
                @if($cuenta->descripcion_servicio)
                    <div class="info-item full-width">
                        <div class="info-label">Descripción del servicio</div>
                        <div class="info-value">{{ $cuenta->descripcion_servicio }}</div>
                    </div>
                @endif
                @foreach($serviceMeta as $field)
                    <div class="info-item">
                        <div class="info-label">{{ $field['label'] }}</div>
                        <div class="info-value">{{ $field['value'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endif

{{-- Contractual --}}
@if($canShowSection('contractual'))
    @php
        $contractFields = array_filter([
            ['label' => 'Número de contrato', 'value' => $cuenta->numero_contrato_referencia],
            ['label' => 'Fecha del contrato', 'value' => $formatDate($cuenta->fecha_contrato)],
            ['label' => 'Tipo de contrato', 'value' => $cuenta->tipo_contrato],
            ['label' => 'Objeto contractual', 'value' => $cuenta->objeto_contrato],
        ], fn($field) => filled($field['value']));
    @endphp
    @if(count($contractFields))
    <div class="wix-card">
        <div class="wix-card-header">
            <h3 class="wix-section-title">Información Contractual</h3>
        </div>
        <div class="wix-card-body">
            <div class="info-grid">
                @foreach($contractFields as $field)
                    <div class="info-item {{ $field['label'] === 'Objeto contractual' ? 'full-width' : '' }}">
                        <div class="info-label">{{ $field['label'] }}</div>
                        <div class="info-value">{{ $field['value'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
@endif

{{-- Condiciones --}}
@if($canShowSection('condiciones'))
    @php
        $paymentFields = array_filter([
            ['label' => 'Ciudad de expedición', 'value' => $cuenta->ciudad_expedicion_cuenta],
            ['label' => 'Fecha y hora de emisión', 'value' => $formatDate($cuenta->fecha_hora_emision, 'd/m/Y H:i')],
            ['label' => 'Plazo pactado (días)', 'value' => $cuenta->dias_plazo_pago ?? $cuenta->plazo_pago],
            ['label' => 'Fecha de vencimiento', 'value' => $formatDate($cuenta->fecha_vencimiento_real)],
            ['label' => 'Días de gracia', 'value' => $cuenta->dias_gracia],
            ['label' => 'Vence con gracia', 'value' => $formatDate($cuenta->fecha_vencimiento_con_gracia)],
            ['label' => 'Forma de pago acordada', 'value' => $cuenta->forma_pago_acordada],
            ['label' => '¿Cobra intereses de mora?', 'value' => $cuenta->cobra_intereses_mora ? 'Sí' : 'No'],
            ['label' => 'Interés de mora (%)', 'value' => $cuenta->interes_mora_porcentaje !== null ? number_format($cuenta->interes_mora_porcentaje, 2, ',', '.') . ' %' : null],
            ['label' => 'Valor pendiente por pagar', 'value' => $formatMoney($cuenta->valor_pendiente_pago)],
        ], fn($field) => filled($field['value']));
    @endphp
    @if(count($paymentFields) || $cuenta->condiciones_pago || $cuenta->penalidades_retraso)
    <div class="wix-card">
        <div class="wix-card-header">
            <h3 class="wix-section-title">Condiciones de Pago</h3>
        </div>
        <div class="wix-card-body">
            <div class="info-grid">
                @foreach($paymentFields as $field)
                    <div class="info-item">
                        <div class="info-label">{{ $field['label'] }}</div>
                        <div class="info-value">{{ $field['value'] }}</div>
                    </div>
                @endforeach
                @if($cuenta->condiciones_pago)
                    <div class="info-item full-width">
                        <div class="info-label">Condiciones adicionales</div>
                        <div class="info-value">{{ $cuenta->condiciones_pago }}</div>
                    </div>
                @endif
                @if($cuenta->penalidades_retraso)
                    <div class="info-item full-width">
                        <div class="info-label">Penalidades por retraso</div>
                        <div class="info-value">{{ $cuenta->penalidades_retraso }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
@endif

{{-- Judicial --}}
@if($canShowSection('judicial'))
    @php
        $judicialFields = array_filter([
            ['label' => 'Estado del proceso', 'value' => $cuenta->estado_cobro_judicial],
            ['label' => 'Número de proceso', 'value' => $cuenta->numero_proceso_judicial],
            ['label' => 'Fecha inicio proceso', 'value' => $formatDate($cuenta->fecha_inicio_proceso)],
            ['label' => 'Juzgado', 'value' => $cuenta->juzgado],
            ['label' => 'Radicado', 'value' => $cuenta->radicado_judicial],
            ['label' => 'Tiene mérito ejecutivo', 'value' => $boolLabel($cuenta->tiene_merito_ejecutivo)],
            ['label' => 'Deuda reconocida por deudor', 'value' => $boolLabel($cuenta->deuda_reconocida_deudor)],
        ], fn($field) => filled($field['value']));
    @endphp
    @if(count($judicialFields) || $cuenta->evidencias_obligacion || $cuenta->testigos)
    <div class="wix-card">
        <div class="wix-card-header">
            <h3 class="wix-section-title">Estado Legal y Judicial</h3>
        </div>
        <div class="wix-card-body">
            <div class="info-grid">
                @foreach($judicialFields as $field)
                    <div class="info-item">
                        <div class="info-label">{{ $field['label'] }}</div>
                        <div class="info-value">{{ $field['value'] }}</div>
                    </div>
                @endforeach
                @if($cuenta->evidencias_obligacion)
                    <div class="info-item full-width">
                        <div class="info-label">Evidencias de la obligación</div>
                        <div class="info-value">{{ $cuenta->evidencias_obligacion }}</div>
                    </div>
                @endif
                @if($cuenta->testigos)
                    <div class="info-item full-width">
                        <div class="info-label">Testigos</div>
                        <div class="info-value">{{ $cuenta->testigos }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
@endif

{{-- Numeracion --}}
@if($canShowSection('numeracion'))
    @php
        $numeracionFields = array_filter([
            ['label' => 'Prefijo', 'value' => $cuenta->prefijo_cuenta],
            ['label' => 'Serie', 'value' => $cuenta->serie_cuenta],
            ['label' => 'Consecutivo', 'value' => $cuenta->consecutivo_cuenta],
            ['label' => 'Número documento soporte', 'value' => $cuenta->numero_documento_soporte],
            ['label' => 'Fecha documento soporte', 'value' => $formatDate($cuenta->fecha_documento_soporte)],
        ], fn($field) => filled($field['value']));
    @endphp
    @if(count($numeracionFields) || $documentoSoporteUrl)
    <div class="wix-card">
        <div class="wix-card-header">
            <h3 class="wix-section-title">Consecutivo y Soportes</h3>
        </div>
        <div class="wix-card-body">
            <div class="info-grid">
                @foreach($numeracionFields as $field)
                    <div class="info-item">
                        <div class="info-label">{{ $field['label'] }}</div>
                        <div class="info-value">{{ $field['value'] }}</div>
                    </div>
                @endforeach
                @if($documentoSoporteUrl)
                    <div class="info-item full-width">
                        <div class="info-label">Archivo soporte</div>
                        <div class="info-value">
                            <a href="{{ $documentoSoporteUrl }}" target="_blank" rel="noopener" style="color: var(--wix-blue); font-weight: 600; text-decoration: none;">
                                Ver documento
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
@endif

{{-- Notas --}}
@if($canShowSection('notas'))
    @if($cuenta->observaciones_legales || $cuenta->notas_cobro)
    <div class="wix-card">
        <div class="wix-card-header">
            <h3 class="wix-section-title">Anexos y Observaciones</h3>
        </div>
        <div class="wix-card-body">
            <div class="info-grid">
                @if($cuenta->observaciones_legales)
                    <div class="info-item full-width">
                        <div class="info-label">Observaciones legales</div>
                        <div class="info-value">{{ $cuenta->observaciones_legales }}</div>
                    </div>
                @endif
                @if($cuenta->notas_cobro)
                    <div class="info-item full-width">
                        <div class="info-label">Notas adicionales del cobro</div>
                        <div class="info-value">{{ $cuenta->notas_cobro }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
@endif
