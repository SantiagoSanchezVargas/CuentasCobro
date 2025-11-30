{{-- resources/views/cuentas_cobro/partials/legal-panels.blade.php --}}
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

@if($canShowSection('acreedor'))
    @php
        $acreedorFields = array_filter([
            ['label' => 'Nombre del acreedor', 'icon' => 'badge', 'value' => $cuenta->nombre_acreedor],
            ['label' => 'Tipo de documento', 'icon' => 'how_to_reg', 'value' => $cuenta->tipo_documento_acreedor],
            ['label' => 'Número de documento', 'icon' => 'fingerprint', 'value' => $cuenta->numero_documento_acreedor],
            ['label' => 'Ciudad de expedición', 'icon' => 'location_city', 'value' => $cuenta->ciudad_expedicion_acreedor],
            ['label' => 'Dirección', 'icon' => 'home_pin', 'value' => $cuenta->direccion_acreedor],
            ['label' => 'Teléfono', 'icon' => 'call', 'value' => $cuenta->telefono_acreedor],
            ['label' => 'Correo electrónico', 'icon' => 'mail', 'value' => $cuenta->email_acreedor],
        ], fn($field) => filled($field['value']));
    @endphp
    @if(count($acreedorFields))
    <div class="detail-section">
        <h3 class="section-title">
            <span class="material-symbols-rounded">account_balance</span>
            Datos del Acreedor
        </h3>
        <div class="info-grid">
            @foreach($acreedorFields as $field)
                <div class="info-item">
                    <div class="info-label">
                        <span class="material-symbols-rounded">{{ $field['icon'] }}</span>
                        {{ $field['label'] }}
                    </div>
                    <div class="info-value">{{ $field['value'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
@endif

@if($canShowSection('deudor'))
    @php
        $deudorFields = array_filter([
            ['label' => 'Nombre del deudor', 'icon' => 'person', 'value' => $cuenta->nombre_deudor],
            ['label' => 'Tipo de documento', 'icon' => 'how_to_reg', 'value' => $cuenta->tipo_documento_deudor],
            ['label' => 'Número de documento', 'icon' => 'fingerprint', 'value' => $cuenta->numero_documento_deudor],
            ['label' => 'Ciudad de expedición', 'icon' => 'location_city', 'value' => $cuenta->ciudad_expedicion_deudor],
            ['label' => 'Dirección', 'icon' => 'home', 'value' => $cuenta->direccion_deudor],
            ['label' => 'Teléfono', 'icon' => 'call', 'value' => $cuenta->telefono_deudor],
            ['label' => 'Correo electrónico', 'icon' => 'alternate_email', 'value' => $cuenta->email_deudor],
        ], fn($field) => filled($field['value']));
    @endphp
    @if(count($deudorFields))
    <div class="detail-section">
        <h3 class="section-title">
            <span class="material-symbols-rounded">groups</span>
            Datos del Deudor
        </h3>
        <div class="info-grid">
            @foreach($deudorFields as $field)
                <div class="info-item">
                    <div class="info-label">
                        <span class="material-symbols-rounded">{{ $field['icon'] }}</span>
                        {{ $field['label'] }}
                    </div>
                    <div class="info-value">{{ $field['value'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
@endif

@if($canShowSection('servicio'))
    @php
        $serviceMeta = array_filter([
            ['label' => 'Fecha prestación', 'icon' => 'event', 'value' => $formatDate($cuenta->fecha_prestacion_servicio)],
            ['label' => 'Fecha inicio', 'icon' => 'play_arrow', 'value' => $formatDate($cuenta->fecha_inicio_servicio)],
            ['label' => 'Fecha fin', 'icon' => 'stop', 'value' => $formatDate($cuenta->fecha_fin_servicio)],
            ['label' => 'Lugar de prestación', 'icon' => 'map', 'value' => $cuenta->lugar_prestacion_servicio],
        ], fn($field) => filled($field['value']));
    @endphp
    @if($cuenta->concepto_cobro || $cuenta->descripcion_servicio || count($serviceMeta))
    <div class="detail-section">
        <h3 class="section-title">
            <span class="material-symbols-rounded">work</span>
            Detalle del Servicio
        </h3>
        <div class="info-grid">
            @if($cuenta->concepto_cobro)
                <div class="info-item full-width">
                    <div class="info-label">
                        <span class="material-symbols-rounded">sticky_note_2</span>
                        Concepto del cobro
                    </div>
                    <div class="info-value">{{ $cuenta->concepto_cobro }}</div>
                </div>
            @endif
            @if($cuenta->descripcion_servicio)
                <div class="info-item full-width">
                    <div class="info-label">
                        <span class="material-symbols-rounded">description</span>
                        Descripción del servicio
                    </div>
                    <div class="info-value">{{ $cuenta->descripcion_servicio }}</div>
                </div>
            @endif
            @foreach($serviceMeta as $field)
                <div class="info-item">
                    <div class="info-label">
                        <span class="material-symbols-rounded">{{ $field['icon'] }}</span>
                        {{ $field['label'] }}
                    </div>
                    <div class="info-value">{{ $field['value'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
@endif

@if($canShowSection('contractual'))
    @php
        $contractFields = array_filter([
            ['label' => 'Número de contrato', 'icon' => 'receipt_long', 'value' => $cuenta->numero_contrato_referencia],
            ['label' => 'Fecha del contrato', 'icon' => 'event_available', 'value' => $formatDate($cuenta->fecha_contrato)],
            ['label' => 'Tipo de contrato', 'icon' => 'category', 'value' => $cuenta->tipo_contrato],
            ['label' => 'Objeto contractual', 'icon' => 'list_alt', 'value' => $cuenta->objeto_contrato],
        ], fn($field) => filled($field['value']));
    @endphp
    @if(count($contractFields))
    <div class="detail-section">
        <h3 class="section-title">
            <span class="material-symbols-rounded">gavel</span>
            Información Contractual
        </h3>
        <div class="info-grid">
            @foreach($contractFields as $field)
                <div class="info-item {{ $field['label'] === 'Objeto contractual' ? 'full-width' : '' }}">
                    <div class="info-label">
                        <span class="material-symbols-rounded">{{ $field['icon'] }}</span>
                        {{ $field['label'] }}
                    </div>
                    <div class="info-value">{{ $field['value'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
@endif

@if($canShowSection('condiciones'))
    @php
        $paymentFields = array_filter([
            ['label' => 'Ciudad de expedición', 'icon' => 'location_on', 'value' => $cuenta->ciudad_expedicion_cuenta],
            ['label' => 'Fecha y hora de emisión', 'icon' => 'schedule', 'value' => $formatDate($cuenta->fecha_hora_emision, 'd/m/Y H:i')],
            ['label' => 'Plazo pactado (días)', 'icon' => 'hourglass_top', 'value' => $cuenta->dias_plazo_pago ?? $cuenta->plazo_pago],
            ['label' => 'Fecha de vencimiento', 'icon' => 'event_busy', 'value' => $formatDate($cuenta->fecha_vencimiento_real)],
            ['label' => 'Días de gracia', 'icon' => 'hourglass_empty', 'value' => $cuenta->dias_gracia],
            ['label' => 'Vence con gracia', 'icon' => 'update', 'value' => $formatDate($cuenta->fecha_vencimiento_con_gracia)],
            ['label' => 'Forma de pago acordada', 'icon' => 'payments', 'value' => $cuenta->forma_pago_acordada],
            ['label' => '¿Cobra intereses de mora?', 'icon' => 'percent', 'value' => $cuenta->cobra_intereses_mora ? 'Sí' : 'No'],
            ['label' => 'Interés de mora (%)', 'icon' => 'trending_up', 'value' => $cuenta->interes_mora_porcentaje !== null ? number_format($cuenta->interes_mora_porcentaje, 2, ',', '.') . ' %' : null],
            ['label' => 'Valor pendiente por pagar', 'icon' => 'request_quote', 'value' => $formatMoney($cuenta->valor_pendiente_pago)],
        ], fn($field) => filled($field['value']));
    @endphp
    @if(count($paymentFields) || $cuenta->condiciones_pago || $cuenta->penalidades_retraso)
    <div class="detail-section">
        <h3 class="section-title">
            <span class="material-symbols-rounded">payments</span>
            Condiciones de Pago
        </h3>
        <div class="info-grid">
            @foreach($paymentFields as $field)
                <div class="info-item">
                    <div class="info-label">
                        <span class="material-symbols-rounded">{{ $field['icon'] }}</span>
                        {{ $field['label'] }}
                    </div>
                    <div class="info-value">{{ $field['value'] }}</div>
                </div>
            @endforeach
            @if($cuenta->condiciones_pago)
                <div class="info-item full-width">
                    <div class="info-label">
                        <span class="material-symbols-rounded">rule</span>
                        Condiciones adicionales
                    </div>
                    <div class="info-value">{{ $cuenta->condiciones_pago }}</div>
                </div>
            @endif
            @if($cuenta->penalidades_retraso)
                <div class="info-item full-width">
                    <div class="info-label">
                        <span class="material-symbols-rounded">gpp_maybe</span>
                        Penalidades por retraso
                    </div>
                    <div class="info-value">{{ $cuenta->penalidades_retraso }}</div>
                </div>
            @endif
        </div>
    </div>
    @endif
@endif

@if($canShowSection('judicial'))
    @php
        $judicialFields = array_filter([
            ['label' => 'Estado del proceso', 'icon' => 'gavel', 'value' => $cuenta->estado_cobro_judicial],
            ['label' => 'Número de proceso', 'icon' => 'tag', 'value' => $cuenta->numero_proceso_judicial],
            ['label' => 'Fecha inicio proceso', 'icon' => 'calendar_month', 'value' => $formatDate($cuenta->fecha_inicio_proceso)],
            ['label' => 'Juzgado', 'icon' => 'account_balance', 'value' => $cuenta->juzgado],
            ['label' => 'Radicado', 'icon' => 'description', 'value' => $cuenta->radicado_judicial],
            ['label' => 'Tiene mérito ejecutivo', 'icon' => 'verified', 'value' => $boolLabel($cuenta->tiene_merito_ejecutivo)],
            ['label' => 'Deuda reconocida por deudor', 'icon' => 'edit_note', 'value' => $boolLabel($cuenta->deuda_reconocida_deudor)],
        ], fn($field) => filled($field['value']));
    @endphp
    @if(count($judicialFields) || $cuenta->evidencias_obligacion || $cuenta->testigos)
    <div class="detail-section">
        <h3 class="section-title">
            <span class="material-symbols-rounded">gavel</span>
            Estado Legal y Judicial
        </h3>
        <div class="info-grid">
            @foreach($judicialFields as $field)
                <div class="info-item">
                    <div class="info-label">
                        <span class="material-symbols-rounded">{{ $field['icon'] }}</span>
                        {{ $field['label'] }}
                    </div>
                    <div class="info-value">{{ $field['value'] }}</div>
                </div>
            @endforeach
            @if($cuenta->evidencias_obligacion)
                <div class="info-item full-width">
                    <div class="info-label">
                        <span class="material-symbols-rounded">folder</span>
                        Evidencias de la obligación
                    </div>
                    <div class="info-value">{{ $cuenta->evidencias_obligacion }}</div>
                </div>
            @endif
            @if($cuenta->testigos)
                <div class="info-item full-width">
                    <div class="info-label">
                        <span class="material-symbols-rounded">groups_2</span>
                        Testigos
                    </div>
                    <div class="info-value">{{ $cuenta->testigos }}</div>
                </div>
            @endif
        </div>
    </div>
    @endif
@endif

@if($canShowSection('numeracion'))
    @php
        $numeracionFields = array_filter([
            ['label' => 'Prefijo', 'icon' => 'sell', 'value' => $cuenta->prefijo_cuenta],
            ['label' => 'Serie', 'icon' => 'sell', 'value' => $cuenta->serie_cuenta],
            ['label' => 'Consecutivo', 'icon' => 'sell', 'value' => $cuenta->consecutivo_cuenta],
            ['label' => 'Número documento soporte', 'icon' => 'bookmark', 'value' => $cuenta->numero_documento_soporte],
            ['label' => 'Fecha documento soporte', 'icon' => 'event_note', 'value' => $formatDate($cuenta->fecha_documento_soporte)],
        ], fn($field) => filled($field['value']));
    @endphp
    @if(count($numeracionFields) || $documentoSoporteUrl)
    <div class="detail-section">
        <h3 class="section-title">
            <span class="material-symbols-rounded">qr_code_2</span>
            Consecutivo y Soportes
        </h3>
        <div class="info-grid">
            @foreach($numeracionFields as $field)
                <div class="info-item">
                    <div class="info-label">
                        <span class="material-symbols-rounded">{{ $field['icon'] }}</span>
                        {{ $field['label'] }}
                    </div>
                    <div class="info-value">{{ $field['value'] }}</div>
                </div>
            @endforeach
            @if($documentoSoporteUrl)
                <div class="info-item full-width">
                    <div class="info-label">
                        <span class="material-symbols-rounded">attach_file</span>
                        Archivo soporte
                    </div>
                    <div class="info-value">
                        <a href="{{ $documentoSoporteUrl }}" target="_blank" rel="noopener" style="color:#007AFF;font-weight:600;">
                            Ver documento
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif
@endif

@if($canShowSection('notas'))
    @if($cuenta->observaciones_legales || $cuenta->notas_cobro)
    <div class="detail-section">
        <h3 class="section-title">
            <span class="material-symbols-rounded">note_alt</span>
            Anexos y Observaciones
        </h3>
        <div class="info-grid">
            @if($cuenta->observaciones_legales)
                <div class="info-item full-width">
                    <div class="info-label">
                        <span class="material-symbols-rounded">library_books</span>
                        Observaciones legales
                    </div>
                    <div class="info-value">{{ $cuenta->observaciones_legales }}</div>
                </div>
            @endif
            @if($cuenta->notas_cobro)
                <div class="info-item full-width">
                    <div class="info-label">
                        <span class="material-symbols-rounded">speaker_notes</span>
                        Notas adicionales del cobro
                    </div>
                    <div class="info-value">{{ $cuenta->notas_cobro }}</div>
                </div>
            @endif
        </div>
    </div>
    @endif
@endif
