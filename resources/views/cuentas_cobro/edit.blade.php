@extends('layouts.app')

@section('title', 'Editar Cuenta - Dewey Accounts')

@section('content')
<style>
    :root {
        --wix-blue: #116dff;
        --wix-dark: #20303c;
        --wix-gray: #f4f4f4;
        --wix-text: #162d3d;
        --wix-border: #eef1f5;
    }

    .wix-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .wix-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 32px;
    }

    .wix-title h1 {
        font-family: 'Inter', sans-serif;
        font-size: 32px;
        font-weight: 800;
        color: var(--wix-text);
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .wix-title p {
        color: #6b7c93;
        font-size: 16px;
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

    .wix-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        border: 1px solid var(--wix-border);
        padding: 40px;
    }
</style>

<div class="wix-container">
    <div class="wix-header">
        <div class="wix-title">
            <h1>Editar Cuenta de Cobro</h1>
            <p>Modifica los detalles de tu cuenta de cobro.</p>
        </div>
        <a href="{{ route('cuentas_cobro.index') }}" class="wix-back-btn">
            <span class="material-symbols-rounded">arrow_back</span>
            Volver al listado
        </a>
    </div>

    <div class="wix-card">
        <form action="{{ route('cuentas_cobro.update', $cuenta) }}" method="POST">
            @csrf
            @method('PUT')

            @if(!empty($readonly) && $readonly)
                <fieldset disabled>
                    @include('cuentas_cobro.partials.form', ['btnText' => 'Actualizar', 'hideSubmit' => true, 'readonly' => true])
                </fieldset>
                <div style="background: #e0f2fe; color: #0369a1; padding: 16px; border-radius: 8px; margin-top: 24px; font-weight: 500;">
                    <span class="material-symbols-rounded" style="vertical-align: middle; margin-right: 8px;">info</span>
                    Vista de solo lectura (Tesorería).
                </div>
                <a href="{{ route('cuentas_cobro.pdf', $cuenta->id) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; background: #ef4444; color: white; padding: 12px 24px; border-radius: 30px; text-decoration: none; font-weight: 600; margin-top: 16px;">
                    <span class="material-symbols-rounded">picture_as_pdf</span> Descargar PDF
                </a>
            @else
                @include('cuentas_cobro.partials.form', ['btnText' => 'Actualizar Cuenta'])
            @endif
        </form>
    </div>
</div>
@endsection
