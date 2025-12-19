@extends('layouts.app')

@section('title', 'Crear Nuevo Rol')

@section('content')
<style>
    :root {
        --slate-50: #f8fafc;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --slate-300: #cbd5e1;
        --slate-400: #94a3b8;
        --slate-500: #64748b;
        --slate-600: #475569;
        --slate-700: #334155;
        --slate-800: #1e293b;
        --slate-900: #0f172a;
        --primary-blue: #116dff;
        --primary-hover: #0056d6;
        --purple-gradient: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
    }

    .role-header {
        background: var(--purple-gradient);
        border-radius: 24px;
        padding: 40px 32px;
        color: white;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 24px;
        box-shadow: 0 10px 40px rgba(99, 102, 241, 0.2);
    }

    .role-icon-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        flex-shrink: 0;
        backdrop-filter: blur(8px);
    }

    .role-header-content h1 {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }

    .role-header-content p {
        font-size: 16px;
        opacity: 0.95;
        margin: 0;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary-blue);
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 24px;
        transition: all 0.2s;
    }

    .back-link:hover {
        gap: 12px;
        opacity: 0.8;
    }

    .card {
        background: white;
        border-radius: 18px;
        padding: 32px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--slate-200);
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--slate-800);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--slate-100);
    }

    .section-title .material-symbols-rounded {
        color: var(--primary-blue);
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--slate-700);
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid var(--slate-200);
        font-size: 15px;
        color: var(--slate-800);
        transition: all 0.2s;
        background: var(--slate-50);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-blue);
        background: white;
        box-shadow: 0 0 0 3px rgba(17, 109, 255, 0.1);
    }

    .permissions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 16px;
    }

    .permission-card {
        background: var(--slate-50);
        border: 1px solid var(--slate-200);
        border-radius: 12px;
        padding: 16px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .permission-card:hover {
        border-color: var(--primary-blue);
        background: white;
    }

    .permission-checkbox {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 2px solid var(--slate-300);
        appearance: none;
        cursor: pointer;
        position: relative;
        flex-shrink: 0;
        margin-top: 2px;
        transition: all 0.2s;
    }

    .permission-checkbox:checked {
        background: var(--primary-blue);
        border-color: var(--primary-blue);
    }

    .permission-checkbox:checked::after {
        content: 'check';
        font-family: 'Material Symbols Rounded';
        color: white;
        font-size: 16px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
    }

    .permission-label {
        font-size: 14px;
        color: var(--slate-700);
        font-weight: 500;
        cursor: pointer;
        line-height: 1.4;
    }

    .category-header {
        font-size: 15px;
        font-weight: 700;
        color: var(--slate-800);
        margin: 32px 0 16px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .category-header:first-of-type {
        margin-top: 0;
    }

    .category-header .material-symbols-rounded {
        color: var(--primary-blue);
        font-size: 20px;
    }

    .btn-submit {
        background: var(--primary-blue);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(17, 109, 255, 0.2);
    }

    .btn-cancel {
        background: white;
        color: var(--slate-600);
        border: 1px solid var(--slate-200);
        padding: 14px 32px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-cancel:hover {
        background: var(--slate-50);
        color: var(--slate-800);
    }

    .actions-footer {
        display: flex;
        gap: 16px;
        margin-top: 32px;
        padding-top: 32px;
        border-top: 1px solid var(--slate-200);
    }
</style>

<div class="container">
    <a href="{{ route('admin.roles.index') }}" class="back-link">
        <span class="material-symbols-rounded">arrow_back</span>
        Volver a roles
    </a>

    <div class="role-header">
        <div class="role-icon-large">
            <span class="material-symbols-rounded">add_moderator</span>
        </div>
        <div class="role-header-content">
            <h1>Crear Nuevo Rol</h1>
            <p>Define un nuevo perfil de acceso y sus permisos asociados</p>
        </div>
    </div>

    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        
        <div class="card">
            <div class="section-title">
                <span class="material-symbols-rounded">info</span>
                Información Básica
            </div>

            <div class="form-group">
                <label class="form-label">Nombre del Rol</label>
                <input type="text" name="name" class="form-input" placeholder="Ej: Revisor de Documentos" required value="{{ old('name') }}">
                @error('name')
                    <span style="color: #ef4444; font-size: 13px; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-input" rows="3" placeholder="Describe brevemente las responsabilidades de este rol...">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Acción de cumplimiento (qué ejecuta este rol/usuario)</label>
                <input type="text" name="accion_cumplimiento" class="form-input" value="{{ old('accion_cumplimiento') }}" placeholder="Ej: Aprobar pagos, Validar documentos, Enviar a DIAN">
            </div>
        </div>

        <div class="card">
            <div class="section-title">
                <span class="material-symbols-rounded">security</span>
                Asignar Permisos
            </div>

            @php
                $permissionCategories = [
                    'Cuentas de Cobro' => ['create_cuenta_cobro', 'view_cuenta_cobro', 'view_own_cuenta_cobro', 'view_all_cuenta_cobro', 'edit_own_cuenta_cobro', 'review_cuenta_cobro', 'approve_cuenta_cobro', 'reject_cuenta_cobro', 'final_approval'],
                    'Documentos' => ['upload_documents', 'view_documents'],
                    'Contratos' => ['view_contract_info', 'manage_contracts', 'contract_validation'],
                    'Pagos' => ['authorize_payment', 'process_payment', 'generate_checks', 'bank_transfers', 'payment_confirmation', 'generate_payment_orders'],
                    'Presupuesto' => ['view_budget', 'manage_budget'],
                    'Reportes' => ['view_reports', 'financial_reports', 'view_financial_reports', 'contract_reports'],
                    'Administración' => ['manage_users', 'manage_contractors', 'contractor_registration', 'system_admin'],
                    'Otros' => ['add_comments', 'request_corrections', 'override_decisions']
                ];

                // Flatten categories to check for uncategorized permissions
                $categorizedPermissions = [];
                foreach ($permissionCategories as $perms) {
                    $categorizedPermissions = array_merge($categorizedPermissions, $perms);
                }
            @endphp

            @foreach($permissionCategories as $category => $perms)
                @php
                    // Filter available permissions that belong to this category
                    $categoryPermissions = $availablePermissions->whereIn('name', $perms);
                @endphp

                @if($categoryPermissions->count() > 0)
                    <div class="category-header">
                        @switch($category)
                            @case('Cuentas de Cobro') <span class="material-symbols-rounded">receipt_long</span> @break
                            @case('Documentos') <span class="material-symbols-rounded">description</span> @break
                            @case('Contratos') <span class="material-symbols-rounded">handshake</span> @break
                            @case('Pagos') <span class="material-symbols-rounded">payment</span> @break
                            @case('Presupuesto') <span class="material-symbols-rounded">trending_up</span> @break
                            @case('Reportes') <span class="material-symbols-rounded">bar_chart</span> @break
                            @case('Administración') <span class="material-symbols-rounded">admin_panel_settings</span> @break
                            @default <span class="material-symbols-rounded">more_horiz</span>
                        @endswitch
                        {{ $category }}
                    </div>
                    <div class="permissions-grid">
                        @foreach($categoryPermissions as $permission)
                            <label class="permission-card">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="permission-checkbox">
                                <span class="permission-label">{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
            @endforeach

            {{-- Handle uncategorized permissions --}}
            @php
                $uncategorized = $availablePermissions->whereNotIn('name', $categorizedPermissions);
            @endphp

            @if($uncategorized->count() > 0)
                <div class="category-header">
                    <span class="material-symbols-rounded">extension</span>
                    Otros Permisos
                </div>
                <div class="permissions-grid">
                    @foreach($uncategorized as $permission)
                        <label class="permission-card">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="permission-checkbox">
                            <span class="permission-label">{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</span>
                        </label>
                    @endforeach
                </div>
            @endif

            <div class="actions-footer">
                <button type="submit" class="btn-submit">
                    <span class="material-symbols-rounded">save</span>
                    Guardar Rol
                </button>
                <a href="{{ route('admin.roles.index') }}" class="btn-cancel">Cancelar</a>
            </div>
        </div>
    </form>
</div>
@endsection
