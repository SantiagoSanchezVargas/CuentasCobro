@extends('layouts.app')

@section('title', 'Configuración DIAN')

@section('content')
<div class="page-container">
    <!-- Header -->
    <div class="page-header" style="margin-bottom: 24px;">
        <h1 style="font-size: 28px; font-weight: 700; color: var(--apple-dark); margin-bottom: 4px;">
            <span class="material-symbols-rounded" style="vertical-align: middle; margin-right: 8px;">settings</span>
            Configuración DIAN
        </h1>
        <p style="color: var(--apple-text-muted); font-size: 15px;">
            Parámetros de conexión y certificados para facturación electrónica
        </p>
    </div>

    <!-- Mode Selector -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 32px;">
        <div onclick="selectMode('set')" id="modeSet" class="mode-card {{ ($config->mode ?? 'set') == 'set' ? 'active' : '' }}" style="background: white; border-radius: 16px; padding: 24px; cursor: pointer; border: 2px solid {{ ($config->mode ?? 'set') == 'set' ? '#3b82f6' : '#e2e8f0' }}; transition: all 0.2s;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 48px; height: 48px; background: #fef3c7; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-rounded" style="font-size: 24px; color: #d97706;">science</span>
                </div>
                <div>
                    <h3 style="margin: 0 0 4px 0; font-size: 18px; font-weight: 700;">Modo SET (Pruebas)</h3>
                    <p style="margin: 0; font-size: 13px; color: #64748b;">Ambiente de habilitación y pruebas DIAN</p>
                </div>
            </div>
        </div>
        <div onclick="selectMode('production')" id="modeProduction" class="mode-card {{ ($config->mode ?? 'set') == 'production' ? 'active' : '' }}" style="background: white; border-radius: 16px; padding: 24px; cursor: pointer; border: 2px solid {{ ($config->mode ?? 'set') == 'production' ? '#3b82f6' : '#e2e8f0' }}; transition: all 0.2s;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 48px; height: 48px; background: #d1fae5; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-rounded" style="font-size: 24px; color: #059669;">verified</span>
                </div>
                <div>
                    <h3 style="margin: 0 0 4px 0; font-size: 18px; font-weight: 700;">Modo Producción</h3>
                    <p style="margin: 0; font-size: 13px; color: #64748b;">Ambiente de facturación electrónica real</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Config Form -->
    <form action="{{ route('dian.configuracion.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="mode" id="modeInput" value="{{ $config->mode ?? 'set' }}">

        <div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                <span class="material-symbols-rounded">link</span>
                Conexión API
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">URL de la API</label>
                    <input type="url" name="api_url" value="{{ $config->api_url ?? '' }}" class="form-input" placeholder="https://vpfe-hab.dian.gov.co/..." style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <p style="font-size: 12px; color: #64748b; margin: 4px 0 0 0;">Endpoint principal de la DIAN (SET o Producción)</p>
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Token / API Key</label>
                    <input type="password" name="token" value="{{ $config->token ?? '' }}" class="form-input" placeholder="••••••••••" style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <p style="font-size: 12px; color: #64748b; margin: 4px 0 0 0;">Token de autenticación (se cifra automáticamente)</p>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                <span class="material-symbols-rounded">key</span>
                Certificado Digital
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Archivo de Certificado (.p12 / .pfx)</label>
                    <input type="file" name="certificate" accept=".p12,.pfx" class="form-input" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0; background: #f8fafc;">
                    @if($config->certificate_path ?? false)
                    <p style="font-size: 12px; color: #059669; margin: 4px 0 0 0;">
                        <span class="material-symbols-rounded" style="font-size: 14px; vertical-align: middle;">check_circle</span>
                        Certificado cargado: {{ basename($config->certificate_path) }}
                    </p>
                    @endif
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Contraseña del Certificado</label>
                    <input type="password" name="certificate_pass" placeholder="••••••••••" class="form-input" style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <p style="font-size: 12px; color: #64748b; margin: 4px 0 0 0;">Se cifra y almacena de forma segura</p>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="margin: 0 0 20px 0; font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                <span class="material-symbols-rounded">mail</span>
                Contacto
            </h3>
            <div style="max-width: 400px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Email de Contacto DIAN</label>
                <input type="email" name="email_contact" value="{{ $config->email_contact ?? '' }}" class="form-input" placeholder="facturacion@empresa.com" style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <p style="font-size: 12px; color: #64748b; margin: 4px 0 0 0;">Email registrado ante la DIAN para notificaciones</p>
            </div>
        </div>

        <!-- Actions -->
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="testConnection()" class="btn-apple btn-apple-secondary">
                    <span class="material-symbols-rounded">wifi_tethering</span>
                    Probar Conexión
                </button>
            </div>
            <button type="submit" class="btn-apple">
                <span class="material-symbols-rounded">save</span>
                Guardar Configuración
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function selectMode(mode) {
    document.getElementById('modeInput').value = mode;
    document.getElementById('modeSet').style.borderColor = mode === 'set' ? '#3b82f6' : '#e2e8f0';
    document.getElementById('modeProduction').style.borderColor = mode === 'production' ? '#3b82f6' : '#e2e8f0';
}

function testConnection() {
    alert('Probando conexión con la DIAN...\n\nFuncionalidad en desarrollo.');
}
</script>
@endpush
@endsection
