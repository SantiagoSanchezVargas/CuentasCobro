@extends('layouts.app')

@section('title', 'Numeraciones DIAN')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/views/dian.css') }}">
@endpush

@section('content')
<div class="dian-page">
    <!-- Header con Gradiente -->
    <div class="dian-header">
        <div class="header-content">
            <div class="header-icon">
                <span class="material-symbols-rounded">tag</span>
            </div>
            <div class="header-text">
                <h1>Numeraciones DIAN</h1>
                <p>Rangos de numeración autorizados para facturación electrónica</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.consecutivos.index') }}" class="btn-header-secondary">
                <span class="material-symbols-rounded">sync</span>
                Ver Consecutivos
            </a>
            @if(auth()->user()->hasAnyRole(['super_admin', 'admin_programa']))
            <button onclick="openNuevaNumeracionModal()" class="btn-header-primary">
                <span class="material-symbols-rounded">add</span>
                Nueva Numeración
            </button>
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="dian-stats-grid">
        <div class="stat-card stat-success">
            <div class="stat-icon">
                <span class="material-symbols-rounded">check_circle</span>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['activas'] ?? 0 }}</div>
                <div class="stat-label">Activas</div>
            </div>
        </div>
        <div class="stat-card stat-primary">
            <div class="stat-icon">
                <span class="material-symbols-rounded">receipt_long</span>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                <div class="stat-label">Total Numeraciones</div>
            </div>
        </div>
        <div class="stat-card stat-warning">
            <div class="stat-icon">
                <span class="material-symbols-rounded">numbers</span>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ number_format($stats['disponibles'] ?? 0, 0, '', '.') }}</div>
                <div class="stat-label">Números Disponibles</div>
            </div>
        </div>
        <div class="stat-card stat-info">
            <div class="stat-icon">
                <span class="material-symbols-rounded">sync_alt</span>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $stats['consecutivos_vinculados'] ?? 0 }}</div>
                <div class="stat-label">Sincronizados</div>
            </div>
        </div>
    </div>

    <!-- Info Banner -->
    <div class="info-banner">
        <span class="material-symbols-rounded">info</span>
        <div>
            <strong>Sincronización con Consecutivos</strong>
            <p>Las numeraciones DIAN se pueden vincular con los consecutivos del sistema para mantener la trazabilidad de los documentos electrónicos.</p>
        </div>
    </div>

    <!-- Table -->
    <div class="dian-card">
        <div class="card-header">
            <h3>
                <span class="material-symbols-rounded">list_alt</span>
                Listado de Numeraciones
            </h3>
        </div>
        <div class="card-body table-responsive">
            <table class="dian-table">
                <thead>
                    <tr>
                        <th>Prefijo</th>
                        <th>Resolución</th>
                        <th class="text-center">Rango</th>
                        <th class="text-center">Actual</th>
                        <th>Uso</th>
                        <th>Vigencia</th>
                        <th class="text-center">Consecutivo</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($numeraciones as $num)
                    @php
                        $total = $num->end_number - $num->start_number + 1;
                        $usado = $num->current_number - $num->start_number;
                        $porcentaje = $total > 0 ? round(($usado / $total) * 100) : 0;
                        $consecutivoVinculado = \App\Models\Consecutivo::where('dian_numeration_id', $num->id)->first();
                    @endphp
                    <tr>
                        <td class="cell-prefix">{{ $num->prefix ?? 'SIN' }}</td>
                        <td>{{ $num->resolution_number ?? '—' }}</td>
                        <td class="text-center cell-mono">
                            {{ number_format($num->start_number, 0, '', '.') }} - {{ number_format($num->end_number, 0, '', '.') }}
                        </td>
                        <td class="text-center cell-current">{{ number_format($num->current_number, 0, '', '.') }}</td>
                        <td>
                            <div class="progress-bar-container">
                                <div class="progress-bar {{ $porcentaje > 90 ? 'danger' : ($porcentaje > 70 ? 'warning' : 'success') }}" style="width: {{ $porcentaje }}%"></div>
                            </div>
                            <span class="progress-text {{ $porcentaje > 90 ? 'text-danger' : '' }}">{{ $porcentaje }}%</span>
                        </td>
                        <td class="cell-date">
                            @if($num->authorized_at)
                                {{ \Carbon\Carbon::parse($num->authorized_at)->format('d/m/Y') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-center">
                            @if($consecutivoVinculado)
                                <a href="{{ route('admin.consecutivos.edit', $consecutivoVinculado->id) }}" class="link-consecutivo">
                                    <span class="material-symbols-rounded">link</span>
                                    {{ $consecutivoVinculado->prefijo }}
                                </a>
                            @else
                                <button onclick="vincularConsecutivo({{ $num->id }})" class="btn-vincular">
                                    <span class="material-symbols-rounded">add_link</span>
                                    Vincular
                                </button>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($num->active)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-inactive">Inactivo</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="action-buttons">
                                <button onclick="editarNumeracion({{ $num->id }})" class="btn-action" title="Editar">
                                    <span class="material-symbols-rounded">edit</span>
                                </button>
                                <button onclick="toggleNumeracion({{ $num->id }}, {{ $num->active ? 0 : 1 }})" 
                                        class="btn-action {{ $num->active ? 'warning' : 'primary' }}" 
                                        title="{{ $num->active ? 'Desactivar' : 'Activar' }}">
                                    <span class="material-symbols-rounded">{{ $num->active ? 'pause' : 'play_arrow' }}</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="empty-state">
                            <span class="material-symbols-rounded">inbox</span>
                            <p>No hay numeraciones registradas</p>
                            <button onclick="openNuevaNumeracionModal()" class="btn-primary-sm">
                                <span class="material-symbols-rounded">add</span>
                                Crear Primera Numeración
                            </button>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nueva Numeración -->
<div class="modal-overlay" id="modalNuevaNumeracion">
    <div class="modal-container">
        <div class="modal-header">
            <h2>
                <span class="material-symbols-rounded">add_circle</span>
                Nueva Numeración DIAN
            </h2>
            <button type="button" class="modal-close" onclick="closeModal('modalNuevaNumeracion')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form action="{{ route('dian.numeraciones.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-grid cols-2">
                    <div class="form-group">
                        <label class="form-label">Prefijo <span class="optional">(Opcional)</span></label>
                        <input type="text" name="prefix" class="form-input" placeholder="Ej: FV, CC, NC" maxlength="10">
                        <small class="form-help">Prefijo que aparecerá antes del número</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nº Resolución</label>
                        <input type="text" name="resolution_number" class="form-input" placeholder="Ej: 18760000001234">
                    </div>
                </div>
                
                <div class="form-grid cols-3">
                    <div class="form-group">
                        <label class="form-label">Número Inicial <span class="required">*</span></label>
                        <input type="number" name="start_number" class="form-input" required min="1" placeholder="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Número Final <span class="required">*</span></label>
                        <input type="number" name="end_number" class="form-input" required min="2" placeholder="1000">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fecha Autorización</label>
                        <input type="date" name="authorized_at" class="form-input">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Notas</label>
                    <textarea name="notes" class="form-input" rows="2" placeholder="Observaciones opcionales..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-checkbox">
                        <input type="checkbox" name="crear_consecutivo" value="1">
                        <span class="checkmark"></span>
                        <span>Crear consecutivo vinculado automáticamente</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('modalNuevaNumeracion')">Cancelar</button>
                <button type="submit" class="btn-primary">
                    <span class="material-symbols-rounded">save</span>
                    Guardar Numeración
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Vincular Consecutivo -->
<div class="modal-overlay" id="modalVincularConsecutivo">
    <div class="modal-container modal-sm">
        <div class="modal-header">
            <h2>
                <span class="material-symbols-rounded">link</span>
                Vincular Consecutivo
            </h2>
            <button type="button" class="modal-close" onclick="closeModal('modalVincularConsecutivo')">
                <span class="material-symbols-rounded">close</span>
            </button>
        </div>
        <form id="formVincular" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Seleccionar Consecutivo</label>
                    <select name="consecutivo_id" class="form-input" required id="selectConsecutivo">
                        <option value="">-- Seleccione --</option>
                        @foreach($consecutivos->whereNull('dian_numeration_id') as $cons)
                            <option value="{{ $cons->id }}">{{ $cons->prefijo }} - {{ $cons->nombre ?? 'Sin nombre' }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="form-info">
                    <span class="material-symbols-rounded">info</span>
                    Solo se muestran consecutivos activos que no tienen numeración vinculada.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('modalVincularConsecutivo')">Cancelar</button>
                <button type="submit" class="btn-primary">
                    <span class="material-symbols-rounded">link</span>
                    Vincular
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openNuevaNumeracionModal() {
    document.getElementById('modalNuevaNumeracion').classList.add('active');
}

function closeModal(id) {
    document.getElementById(id).classList.remove('active');
}

function vincularConsecutivo(numeracionId) {
    document.getElementById('formVincular').action = `/dian/numeraciones/${numeracionId}/vincular`;
    document.getElementById('modalVincularConsecutivo').classList.add('active');
}

function editarNumeracion(id) {
    alert('Editar numeración ' + id);
}

function toggleNumeracion(id, estado) {
    if (confirm('¿Está seguro de ' + (estado ? 'activar' : 'desactivar') + ' esta numeración?')) {
        // Crear formulario dinámico para el POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/dian/numeraciones/${id}/toggle`;
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}

document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
});
</script>
@endpush
