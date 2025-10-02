@extends('layouts.app')

@section('title', 'Registrar Usuario - CuentasCobro')

@section('content')
<div class="login-container d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-card p-4" style="border: 2px solid var(--uc-verde);">
                    <div class="text-center mb-4">
                        <i class="fas fa-file-invoice-dollar fa-3x mb-3" style="color: var(--uc-verde);"></i>
                        <h3 class="fw-bold" style="color: var(--uc-gris);">CuentasCobro</h3>
                        <p style="color: var(--uc-verde);">Registrar usuario</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label" style="color: var(--uc-gris);">
                                <i class="fas fa-user me-1"></i>Nombre
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   autocomplete="name" 
                                   autofocus
                                   placeholder="Ingresa tu nombre"
                                   style="border-color: var(--uc-verde);">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label" style="color: var(--uc-gris);">
                                <i class="fas fa-envelope me-1"></i>Correo electrónico
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   placeholder="Ingresa tu correo"
                                   style="border-color: var(--uc-verde);">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label" style="color: var(--uc-gris);">
                                <i class="fas fa-lock me-1"></i>Contraseña
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Ingresa tu contraseña"
                                   style="border-color: var(--uc-verde);">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <label for="password_confirmation" class="form-label" style="color: var(--uc-gris);">
                                <i class="fas fa-lock me-1"></i>Repetir Contraseña
                            </label>
                            <input type="password" 
                                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password"
                                   placeholder="Repite tu contraseña"
                                   style="border-color: var(--uc-verde);">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember" style="color: var(--uc-gris);">
                                Recordarme
                            </label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg" style="background: var(--uc-verde); color: var(--uc-blanco); border: none;">
                                <i class="fas fa-user-plus me-1"></i>Registrarse
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <small style="color: var(--uc-gris);">
                            ¿Ya tienes una cuenta? 
                            <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(--uc-verde); font-weight: bold;">Inicia sesión aquí</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection