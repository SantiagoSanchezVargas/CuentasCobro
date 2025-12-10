@extends('layouts.app')

@section('title', 'Gestión de Documentos')

@section('content')
<style>
    :root {
        --primary: #116dff;
        --secondary: #0f172a;
        --text-main: #334155;
        --bg-card: #ffffff;
        --border-color: #e2e8f0;
    }

    .doc-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .doc-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .doc-title h1 {
        font-size: 24px;
        font-weight: 800;
        color: var(--secondary);
    }

    .doc-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 24px;
    }

    .doc-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .doc-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: var(--primary);
    }

    .doc-icon {
        font-size: 40px;
        color: var(--primary);
        margin-bottom: 16px;
    }

    .doc-name {
        font-weight: 600;
        color: var(--secondary);
        margin-bottom: 4px;
        word-break: break-word;
    }

    .doc-meta {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 16px;
    }

    .doc-actions {
        display: flex;
        gap: 8px;
        margin-top: auto;
    }

    .btn-icon {
        padding: 6px;
        border-radius: 6px;
        color: #64748b;
        transition: all 0.2s;
        background: #f1f5f9;
    }

    .btn-icon:hover {
        background: #e2e8f0;
        color: var(--secondary);
    }
</style>

<div class="doc-container">
    <div class="doc-header">
        <div class="doc-title">
            <a href="{{ route('cuentas_cobro.show', $cuenta->id) }}" class="text-blue-600 hover:underline mb-2 inline-block">
                &larr; Volver a la Cuenta
            </a>
            <h1>Documentos de Cuenta #{{ $cuenta->numero ?? $cuenta->id }}</h1>
        </div>
        <a href="{{ route('documentos.create', $cuenta->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <span class="material-symbols-rounded">upload_file</span>
            Subir Documento
        </a>
    </div>

    @if($documentos->isEmpty())
        <div class="text-center py-12 bg-white rounded-xl border border-gray-200">
            <span class="material-symbols-rounded text-gray-300" style="font-size: 64px;">folder_open</span>
            <p class="text-gray-500 mt-4">No hay documentos adjuntos a esta cuenta.</p>
        </div>
    @else
        <div class="doc-grid">
            @foreach($documentos as $doc)
            <div class="doc-card">
                <div>
                    <div class="doc-icon">
                        <span class="material-symbols-rounded">
                            {{ Str::endsWith($doc->nombre_archivo, '.pdf') ? 'picture_as_pdf' : 'description' }}
                        </span>
                    </div>
                    <h3 class="doc-name">{{ $doc->nombre_original ?? $doc->nombre_archivo }}</h3>
                    <p class="doc-meta">
                        {{ $doc->created_at->format('d M Y') }} • {{ number_format($doc->tamano / 1024, 1) }} KB
                        <br>
                        Subido por: {{ $doc->user->name ?? 'Sistema' }}
                    </p>
                </div>
                <div class="doc-actions">
                    <a href="{{ route('documentos.descargar', $doc->id) }}" class="btn-icon" title="Descargar">
                        <span class="material-symbols-rounded">download</span>
                    </a>
                    <a href="{{ route('documentos.ver', $doc->id) }}" class="btn-icon" title="Ver" target="_blank">
                        <span class="material-symbols-rounded">visibility</span>
                    </a>
                    <form action="{{ route('documentos.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('¿Eliminar documento?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-icon text-red-500 hover:bg-red-50 hover:text-red-600" title="Eliminar">
                            <span class="material-symbols-rounded">delete</span>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
