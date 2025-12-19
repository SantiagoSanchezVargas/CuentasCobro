@extends('layouts.app')

@section('title', 'Crear Permiso Granular')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/views/permisos.css') }}">
@endpush

@section('content')
<div class="container">
    <!-- Header con gradiente oscuro -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-icon">
                <span class="material-symbols-rounded">admin_panel_settings</span>
            </div>
            <div class="header-text">
                <h1>Nuevo Permiso Granular</h1>
                <p>Configure permisos específicos por rol y etapa del flujo de trabajo</p>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.permisos.index') }}" class="btn-header">
                <span class="material-symbols-rounded">arrow_back</span>
                Volver a Matriz
            </a>
        </div>
    </div>

    <!-- Alertas -->
    @if($errors->any())
        <div class="alert alert-danger">
            <span class="material-symbols-rounded">error</span>
            <div>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.permisos.store') }}" method="POST" class="permissions-form">
        @csrf

        <!-- Card: Información Básica -->
        <div class="form-card">
            <div class="card-header">
                <span class="material-symbols-rounded">info</span>
                <h3>Información Básica</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group">
                        <label for="role_id">
                            <span class="material-symbols-rounded">badge</span>
                            Rol *
                        </label>
                        <select name="role_id" id="role_id" class="form-control" required>
                            <option value="">Seleccione un rol</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="etapa_flujo">
                            <span class="material-symbols-rounded">route</span>
                            Etapa del Flujo
                        </label>
                        <select name="etapa_flujo" id="etapa_flujo" class="form-control">
                            <option value="">Todas las etapas</option>
                            @foreach($etapasFluj as $etapa)
                                <option value="{{ $etapa }}" {{ old('etapa_flujo') == $etapa ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $etapa)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="descripcion">
                        <span class="material-symbols-rounded">description</span>
                        Descripción
                    </label>
                    <textarea name="descripcion" id="descripcion" class="form-control" rows="3" 
                              placeholder="Descripción opcional de esta configuración de permisos...">{{ old('descripcion') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Card: Permisos de CRUD -->
        <div class="form-card">
            <div class="card-header">
                <span class="material-symbols-rounded">storage</span>
                <h3>Permisos de Gestión de Datos</h3>
            </div>
            <div class="card-body">
                <div class="permissions-grid">
                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_crear" value="1" {{ old('puede_crear') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon create">
                                <span class="material-symbols-rounded">add_circle</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Crear</strong>
                                <small>Crear nuevas cuentas de cobro</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_leer" value="1" {{ old('puede_leer', true) ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon read">
                                <span class="material-symbols-rounded">visibility</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Leer</strong>
                                <small>Ver cuentas de cobro</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_editar" value="1" {{ old('puede_editar') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon edit">
                                <span class="material-symbols-rounded">edit</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Editar</strong>
                                <small>Modificar información</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_eliminar" value="1" {{ old('puede_eliminar') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon delete">
                                <span class="material-symbols-rounded">delete</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Eliminar</strong>
                                <small>Eliminar registros</small>
                            </span>
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Card: Permisos de Flujo de Trabajo -->
        <div class="form-card">
            <div class="card-header">
                <span class="material-symbols-rounded">account_tree</span>
                <h3>Permisos de Flujo de Trabajo</h3>
            </div>
            <div class="card-body">
                <div class="permissions-grid">
                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_aprobar" value="1" {{ old('puede_aprobar') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon approve">
                                <span class="material-symbols-rounded">check_circle</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Aprobar</strong>
                                <small>Aprobar cuentas de cobro</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_rechazar" value="1" {{ old('puede_rechazar') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon reject">
                                <span class="material-symbols-rounded">cancel</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Rechazar</strong>
                                <small>Rechazar cuentas de cobro</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_devolver" value="1" {{ old('puede_devolver') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon return">
                                <span class="material-symbols-rounded">undo</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Devolver</strong>
                                <small>Devolver a etapa anterior</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_devolver_correccion" value="1" {{ old('puede_devolver_correccion') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon correction">
                                <span class="material-symbols-rounded">edit_note</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Devolver para Corrección</strong>
                                <small>Solicitar correcciones al creador</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_comentar" value="1" {{ old('puede_comentar', true) ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon comment">
                                <span class="material-symbols-rounded">chat</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Comentar</strong>
                                <small>Agregar comentarios y notas</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_archivar" value="1" {{ old('puede_archivar') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon archive">
                                <span class="material-symbols-rounded">archive</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Archivar</strong>
                                <small>Archivar documentos finalizados</small>
                            </span>
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Card: Permisos de Documentos -->
        <div class="form-card">
            <div class="card-header">
                <span class="material-symbols-rounded">folder_open</span>
                <h3>Permisos de Documentos</h3>
            </div>
            <div class="card-body">
                <div class="permissions-grid cols-3">
                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_subir_documentos" value="1" {{ old('puede_subir_documentos') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon upload">
                                <span class="material-symbols-rounded">upload_file</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Subir Documentos</strong>
                                <small>Adjuntar archivos y soportes</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_descargar_documentos" value="1" {{ old('puede_descargar_documentos', true) ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon download">
                                <span class="material-symbols-rounded">download</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Descargar Documentos</strong>
                                <small>Descargar archivos adjuntos</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_enviar_cliente" value="1" {{ old('puede_enviar_cliente') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon send">
                                <span class="material-symbols-rounded">send</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Enviar a Cliente</strong>
                                <small>Enviar documentos por correo</small>
                            </span>
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Card: Permisos Especiales -->
        <div class="form-card">
            <div class="card-header">
                <span class="material-symbols-rounded">verified_user</span>
                <h3>Permisos Especiales</h3>
            </div>
            <div class="card-body">
                <div class="permissions-grid">
                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_registrar_pago" value="1" {{ old('puede_registrar_pago') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon payment">
                                <span class="material-symbols-rounded">payments</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Registrar Pago</strong>
                                <small>Registrar pagos realizados</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_ver_todas_cuentas" value="1" {{ old('puede_ver_todas_cuentas') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon all">
                                <span class="material-symbols-rounded">visibility</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Ver Todas las Cuentas</strong>
                                <small>Acceso a todas las cuentas del sistema</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_ver_reportes" value="1" {{ old('puede_ver_reportes') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon reports">
                                <span class="material-symbols-rounded">analytics</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Ver Reportes</strong>
                                <small>Acceso al módulo de reportes</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_gestionar_usuarios" value="1" {{ old('puede_gestionar_usuarios') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon users">
                                <span class="material-symbols-rounded">group</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Gestionar Usuarios</strong>
                                <small>Administrar usuarios del sistema</small>
                            </span>
                        </span>
                    </label>

                    <label class="permission-toggle">
                        <input type="checkbox" name="puede_gestionar_contratos" value="1" {{ old('puede_gestionar_contratos') ? 'checked' : '' }}>
                        <span class="toggle-content">
                            <span class="toggle-icon contracts">
                                <span class="material-symbols-rounded">description</span>
                            </span>
                            <span class="toggle-text">
                                <strong>Gestionar Contratos</strong>
                                <small>Administrar contratos</small>
                            </span>
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="form-actions">
            <a href="{{ route('admin.permisos.index') }}" class="btn-cancel">
                <span class="material-symbols-rounded">close</span>
                Cancelar
            </a>
            <button type="submit" class="btn-submit">
                <span class="material-symbols-rounded">save</span>
                Guardar Permiso
            </button>
        </div>
    </form>
</div>
@endsection
