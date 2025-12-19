@extends('layouts.app')

@section('title', 'Gestión de Terceros - Dewey Accounts')

@section('content')
<style>
    .terceros-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 24px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a2e;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin-top: 4px;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #00b5e2;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-primary:hover {
        background: #0097be;
        transform: translateY(-1px);
    }

    /* Search & Filters */
    .filters-bar {
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .search-box {
        flex: 1;
        min-width: 300px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
    }

    .search-box input:focus {
        outline: none;
        border-color: #00b5e2;
        box-shadow: 0 0 0 3px rgba(0, 181, 226, 0.1);
    }

    .search-box .icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .filter-select {
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        min-width: 180px;
        cursor: pointer;
    }

    /* Excel-like Table */
    .excel-table-wrapper {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .excel-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .excel-table thead {
        background: linear-gradient(135deg, #1a1a2e 0%, #2d3436 100%);
        color: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .excel-table th {
        padding: 14px 16px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
        border-right: 1px solid rgba(255,255,255,0.1);
    }

    .excel-table th:last-child {
        border-right: none;
    }

    .excel-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.15s;
    }

    .excel-table tbody tr:hover {
        background: #f0f9ff;
    }

    .excel-table tbody tr:nth-child(even) {
        background: #fafafa;
    }

    .excel-table tbody tr:nth-child(even):hover {
        background: #f0f9ff;
    }

    .excel-table td {
        padding: 12px 16px;
        border-right: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .excel-table td:last-child {
        border-right: none;
    }

    /* Editable cells */
    .editable-cell {
        position: relative;
        cursor: pointer;
        padding: 8px 12px;
        border-radius: 4px;
        transition: all 0.15s;
        min-height: 32px;
        display: flex;
        align-items: center;
    }

    .editable-cell:hover {
        background: #e0f2fe;
    }

    .editable-cell.editing {
        background: white;
        box-shadow: 0 0 0 2px #00b5e2;
    }

    .editable-cell input {
        width: 100%;
        border: none;
        background: transparent;
        font-size: 14px;
        padding: 0;
        outline: none;
    }

    .editable-cell .edit-icon {
        position: absolute;
        right: 4px;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0;
        font-size: 16px;
        color: #00b5e2;
        transition: opacity 0.15s;
    }

    .editable-cell:hover .edit-icon {
        opacity: 1;
    }

    /* Type badge */
    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .type-badge.natural {
        background: #dcfce7;
        color: #166534;
    }

    .type-badge.juridica {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Actions */
    .actions-cell {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.15s;
    }

    .btn-edit {
        background: #e0f2fe;
        color: #0284c7;
    }

    .btn-edit:hover {
        background: #bae6fd;
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background: #fecaca;
    }

    /* Stats bar */
    .stats-bar {
        display: flex;
        gap: 24px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        display: flex;
        align-items: center;
        gap: 16px;
        flex: 1;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon.total {
        background: linear-gradient(135deg, #00b5e2, #00d4ff);
        color: white;
    }

    .stat-icon.natural {
        background: linear-gradient(135deg, #10b981, #34d399);
        color: white;
    }

    .stat-icon.juridica {
        background: linear-gradient(135deg, #6366f1, #818cf8);
        color: white;
    }

    .stat-content h3 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
    }

    .stat-content p {
        font-size: 13px;
        color: #6b7280;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 16px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f3f4f6;
    }

    .pagination-info {
        color: #6b7280;
        font-size: 14px;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 60px 24px;
        color: #6b7280;
    }

    .empty-state .icon {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 16px;
    }

    /* Toast notification */
    .toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        background: #1a1a2e;
        color: white;
        padding: 16px 24px;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        display: none;
        z-index: 1000;
        animation: slideIn 0.3s ease;
    }

    .toast.success {
        background: #059669;
    }

    .toast.error {
        background: #dc2626;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        width: 90%;
        max-width: 500px;
        padding: 32px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }

    .modal-title {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 16px;
    }

    .modal-text {
        color: #6b7280;
        margin-bottom: 24px;
    }

    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .btn-cancel {
        padding: 10px 20px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: white;
        color: #374151;
        font-weight: 500;
        cursor: pointer;
    }

    .btn-danger {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        background: #dc2626;
        color: white;
        font-weight: 500;
        cursor: pointer;
    }

    .btn-danger:hover {
        background: #b91c1c;
    }
</style>

<div class="terceros-container">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Gestión de Terceros</h1>
            <p class="page-subtitle">Administra clientes, proveedores y compradores</p>
        </div>
        <a href="{{ route('cuentas_cobro.create') }}" class="btn-primary">
            <span class="material-symbols-rounded">add</span>
            Crear desde Cuenta
        </a>
    </div>

    <!-- Stats -->
    @php
        $totalTerceros = \App\Models\Tercero::count();
        $naturales = \App\Models\Tercero::where('tipo_persona', 'natural')->count();
        $juridicas = \App\Models\Tercero::where('tipo_persona', 'juridica')->count();
    @endphp
    <div class="stats-bar">
        <div class="stat-card">
            <div class="stat-icon total">
                <span class="material-symbols-rounded">groups</span>
            </div>
            <div class="stat-content">
                <h3>{{ $totalTerceros }}</h3>
                <p>Total Terceros</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon natural">
                <span class="material-symbols-rounded">person</span>
            </div>
            <div class="stat-content">
                <h3>{{ $naturales }}</h3>
                <p>Personas Naturales</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon juridica">
                <span class="material-symbols-rounded">domain</span>
            </div>
            <div class="stat-content">
                <h3>{{ $juridicas }}</h3>
                <p>Personas Jurídicas</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" class="filters-bar">
        <div class="search-box">
            <span class="material-symbols-rounded icon">search</span>
            <input type="text" name="search" placeholder="Buscar por nombre, identificación o email..." value="{{ request('search') }}">
        </div>
        <select name="tipo_persona" class="filter-select" onchange="this.form.submit()">
            <option value="">Todos los tipos</option>
            <option value="natural" {{ request('tipo_persona') === 'natural' ? 'selected' : '' }}>Persona Natural</option>
            <option value="juridica" {{ request('tipo_persona') === 'juridica' ? 'selected' : '' }}>Persona Jurídica</option>
        </select>
        <button type="submit" class="btn-primary">
            <span class="material-symbols-rounded">filter_list</span>
            Filtrar
        </button>
    </form>

    <!-- Flash Messages -->
    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <span class="material-symbols-rounded">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fee2e2; color: #dc2626; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <span class="material-symbols-rounded">error</span>
            {{ session('error') }}
        </div>
    @endif

    <!-- Table -->
    <div class="excel-table-wrapper">
        @if($terceros->count() > 0)
        <div style="overflow-x: auto;">
            <table class="excel-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Tipo</th>
                        <th>Identificación</th>
                        <th>Nombre / Razón Social</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>País</th>
                        <th>Ciudad</th>
                        <th>Creado</th>
                        <th style="width: 100px; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($terceros as $index => $tercero)
                    <tr data-id="{{ $tercero->id }}">
                        <td style="color: #9ca3af; font-weight: 500;">
                            {{ ($terceros->currentPage() - 1) * $terceros->perPage() + $index + 1 }}
                        </td>
                        <td>
                            <span class="type-badge {{ $tercero->tipo_persona }}">
                                <span class="material-symbols-rounded" style="font-size: 14px;">
                                    {{ $tercero->tipo_persona === 'juridica' ? 'domain' : 'person' }}
                                </span>
                                {{ $tercero->tipo_persona === 'juridica' ? 'Jurídica' : 'Natural' }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $tercero->tipo_identificacion }}</strong>
                            {{ $tercero->identificacion }}
                            @if($tercero->dv)
                                <span style="color: #9ca3af;">-{{ $tercero->dv }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="editable-cell" data-field="{{ $tercero->tipo_persona === 'juridica' ? 'razon_social' : 'nombre_completo' }}" data-id="{{ $tercero->id }}">
                                <span class="cell-value">{{ $tercero->nombre }}</span>
                                <span class="material-symbols-rounded edit-icon">edit</span>
                            </div>
                        </td>
                        <td>
                            <div class="editable-cell" data-field="email" data-id="{{ $tercero->id }}">
                                <span class="cell-value">{{ $tercero->email ?: '-' }}</span>
                                <span class="material-symbols-rounded edit-icon">edit</span>
                            </div>
                        </td>
                        <td>
                            <div class="editable-cell" data-field="telefono" data-id="{{ $tercero->id }}">
                                <span class="cell-value">{{ $tercero->telefono ?: '-' }}</span>
                                <span class="material-symbols-rounded edit-icon">edit</span>
                            </div>
                        </td>
                        <td>
                            <span title="{{ $tercero->pais ?? 'Colombia' }}">{{ $tercero->pais ?? 'Colombia' }}</span>
                        </td>
                        <td>
                            <div class="editable-cell" data-field="ciudad" data-id="{{ $tercero->id }}">
                                <span class="cell-value">{{ $tercero->ciudad ?: '-' }}</span>
                                <span class="material-symbols-rounded edit-icon">edit</span>
                            </div>
                        </td>
                        <td style="color: #6b7280; font-size: 13px;">
                            {{ $tercero->created_at->format('d/m/Y') }}
                        </td>
                        <td>
                            <div class="actions-cell">
                                <a href="{{ route('terceros.edit', $tercero->id) }}" class="btn-action btn-edit" title="Editar">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">edit</span>
                                </a>
                                <button type="button" class="btn-action btn-delete" onclick="confirmDelete({{ $tercero->id }}, '{{ addslashes($tercero->nombre) }}')" title="Eliminar">
                                    <span class="material-symbols-rounded" style="font-size: 18px;">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            <span class="pagination-info">
                Mostrando {{ $terceros->firstItem() }} - {{ $terceros->lastItem() }} de {{ $terceros->total() }} terceros
            </span>
            {{ $terceros->withQueryString()->links() }}
        </div>
        @else
        <div class="empty-state">
            <span class="material-symbols-rounded icon">person_off</span>
            <h3 style="font-size: 18px; font-weight: 600; color: #374151; margin-bottom: 8px;">No hay terceros registrados</h3>
            <p>Los terceros se crean automáticamente al agregar un nuevo cliente en las cuentas de cobro.</p>
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-content">
        <h2 class="modal-title">
            <span class="material-symbols-rounded" style="color: #dc2626; vertical-align: middle;">warning</span>
            Confirmar Eliminación
        </h2>
        <p class="modal-text">
            ¿Estás seguro de que deseas eliminar a <strong id="deleteName"></strong>? Esta acción no se puede deshacer.
        </p>
        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Cancelar</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <span class="material-symbols-rounded" style="font-size: 18px; vertical-align: middle;">delete</span>
                    Eliminar
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div class="toast" id="toast"></div>

<script>
    // Delete confirmation
    function confirmDelete(id, name) {
        document.getElementById('deleteName').textContent = name;
        document.getElementById('deleteForm').action = `/terceros/${id}`;
        document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    // Close modal on outside click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    // Toast notification
    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.className = 'toast ' + type;
        toast.style.display = 'block';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 3000);
    }

    // Inline editing
    document.querySelectorAll('.editable-cell').forEach(cell => {
        cell.addEventListener('click', function() {
            if (this.classList.contains('editing')) return;

            const field = this.dataset.field;
            const id = this.dataset.id;
            const valueSpan = this.querySelector('.cell-value');
            const currentValue = valueSpan.textContent.trim();
            const displayValue = currentValue === '-' ? '' : currentValue;

            // Create input
            this.classList.add('editing');
            valueSpan.style.display = 'none';
            this.querySelector('.edit-icon').style.display = 'none';

            const input = document.createElement('input');
            input.type = field === 'email' ? 'email' : 'text';
            input.value = displayValue;
            input.className = 'edit-input';
            this.appendChild(input);
            input.focus();
            input.select();

            // Handle save on blur/enter
            const saveEdit = async () => {
                const newValue = input.value.trim();
                
                if (newValue !== displayValue) {
                    try {
                        const response = await fetch(`/terceros/${id}/update-inline`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ field, value: newValue })
                        });

                        const data = await response.json();

                        if (data.success) {
                            valueSpan.textContent = newValue || '-';
                            showToast('Guardado correctamente', 'success');
                        } else {
                            showToast(data.message || 'Error al guardar', 'error');
                            valueSpan.textContent = currentValue;
                        }
                    } catch (error) {
                        showToast('Error de conexión', 'error');
                        valueSpan.textContent = currentValue;
                    }
                }

                // Cleanup
                input.remove();
                valueSpan.style.display = '';
                cell.querySelector('.edit-icon').style.display = '';
                cell.classList.remove('editing');
            };

            input.addEventListener('blur', saveEdit);
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    input.blur();
                }
                if (e.key === 'Escape') {
                    input.value = displayValue;
                    input.blur();
                }
            });
        });
    });
</script>
@endsection
