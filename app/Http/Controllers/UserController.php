@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Nuevo Rol</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hay problemas con los datos ingresados.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <!-- Nombre del rol -->
        <div class="form-group mb-3">
            <label for="name">Nombre del Rol</label>
            <select name="name" id="name" class="form-control" required>
                <option value="">-- Selecciona un rol --</option>
                @foreach (\App\Models\Role::getSystemRoles() as $key => $label)
                    <option value="{{ $key }}" {{ old('name') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <!-- Descripción -->
        <div class="form-group mb-3">
            <label for="description">Descripción</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <!-- Permisos -->
        <div class="form-group mb-3">
            <label>Permisos</label><br>
            @php
                $allPermissions = [
                    'create_cuenta_cobro', 'view_own_cuenta_cobro', 'edit_own_cuenta_cobro', 'upload_documents', 'view_contract_info',
                    'view_cuenta_cobro', 'review_cuenta_cobro', 'approve_cuenta_cobro', 'reject_cuenta_cobro', 'add_comments', 'request_corrections',
                    'view_all_cuenta_cobro', 'final_approval', 'override_decisions', 'view_reports', 'manage_users', 'system_admin',
                    'authorize_payment', 'view_budget', 'manage_budget', 'generate_payment_orders', 'view_financial_reports',
                    'process_payment', 'generate_checks', 'bank_transfers', 'payment_confirmation', 'financial_reports',
                    'manage_contracts', 'manage_contractors', 'contract_validation', 'contractor_registration', 'contract_reports'
                ];
            @endphp

            @foreach ($allPermissions as $perm)
                <div class="form-check">
                    <input type="checkbox" name="permissions[]" value="{{ $perm }}" class="form-check-input" id="{{ $perm }}" 
                        {{ is_array(old('permissions')) && in_array($perm, old('permissions')) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $perm }}">{{ $perm }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">Crear Rol</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
