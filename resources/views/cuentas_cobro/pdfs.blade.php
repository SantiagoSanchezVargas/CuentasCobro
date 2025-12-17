@extends('layouts.app')

@section('title', 'PDFs Generados')

@section('content')
<div class="page-container">
    <!-- Header -->
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 28px; font-weight: 700; color: var(--apple-dark); margin-bottom: 4px;">
                <span class="material-symbols-rounded" style="vertical-align: middle; margin-right: 8px;">picture_as_pdf</span>
                Documentos PDF Generados
            </h1>
            <p style="color: var(--apple-text-muted); font-size: 15px;">
                Historial de cuentas de cobro generadas en formato PDF
            </p>
        </div>
    </div>

    <!-- Filters -->
    <div style="background: white; border-radius: 16px; padding: 20px; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <form method="GET" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: flex-end;">
            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--apple-text-muted); margin-bottom: 6px;">Buscar</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Número o beneficiario..." class="form-input" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
            </div>
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--apple-text-muted); margin-bottom: 6px;">Desde</label>
                <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}" class="form-input" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
            </div>
            <div style="flex: 1; min-width: 150px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: var(--apple-text-muted); margin-bottom: 6px;">Hasta</label>
                <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}" class="form-input" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1px solid #e2e8f0;">
            </div>
            <div>
                <button type="submit" class="btn-apple">
                    <span class="material-symbols-rounded">search</span>
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Grid of PDFs -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
        @forelse($cuentas ?? [] as $cuenta)
        <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)';">
            <!-- PDF Preview Header -->
            <div style="background: linear-gradient(135deg, #ef4444, #dc2626); padding: 24px; text-align: center;">
                <span class="material-symbols-rounded" style="font-size: 48px; color: white; opacity: 0.9;">picture_as_pdf</span>
            </div>
            <!-- Content -->
            <div style="padding: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <div>
                        <h4 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 700;">{{ $cuenta->numero }}</h4>
                        <p style="margin: 0; font-size: 13px; color: #64748b;">{{ $cuenta->nombre_beneficiario }}</p>
                    </div>
                    <span style="padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; 
                        @if($cuenta->estado_aprobacion == 'aprobado') background: #d1fae5; color: #059669;
                        @elseif($cuenta->estado_aprobacion == 'pagado') background: #e0e7ff; color: #4f46e5;
                        @else background: #f1f5f9; color: #64748b; @endif">
                        {{ ucfirst($cuenta->estado_aprobacion) }}
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px solid #f1f5f9;">
                    <div>
                        <p style="margin: 0; font-size: 18px; font-weight: 700; color: var(--apple-dark);">${{ number_format($cuenta->valor_total, 0, ',', '.') }}</p>
                        <p style="margin: 0; font-size: 12px; color: #64748b;">{{ $cuenta->fecha_emision ? \Carbon\Carbon::parse($cuenta->fecha_emision)->format('d M Y') : '' }}</p>
                    </div>
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('cuentas_cobro.show', $cuenta->id) }}" class="btn-icon" title="Ver detalle" style="padding: 8px; border-radius: 8px; background: #f1f5f9; text-decoration: none; color: inherit;">
                            <span class="material-symbols-rounded" style="font-size: 20px;">visibility</span>
                        </a>
                        <a href="{{ route('cuentas_cobro.pdf', $cuenta->id) }}" target="_blank" class="btn-icon" title="Descargar PDF" style="padding: 8px; border-radius: 8px; background: #fee2e2; color: #dc2626; text-decoration: none;">
                            <span class="material-symbols-rounded" style="font-size: 20px;">download</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 64px; color: var(--apple-text-muted);">
            <span class="material-symbols-rounded" style="font-size: 64px; opacity: 0.5; display: block; margin-bottom: 16px;">folder_off</span>
            <p style="font-size: 18px; font-weight: 600; margin: 0 0 8px 0;">No hay documentos PDF</p>
            <p style="font-size: 14px; margin: 0;">Crea una cuenta de cobro para generar su PDF</p>
        </div>
        @endforelse
    </div>

    @if(isset($cuentas) && $cuentas->hasPages())
    <div style="margin-top: 24px;">
        {{ $cuentas->links() }}
    </div>
    @endif
</div>
@endsection
