@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Panel Administrador</h1>
    <p>Bienvenido, {{ Auth::user()->name }} 👋</p>

    <div class="row mt-4">
        <div class="col-md-6">
            <a href="{{ route('aprobaciones.index') }}" class="btn btn-success w-100">📄 Aprobar Cuentas de Cobro</a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('reportes.index') }}" class="btn btn-info w-100">📊 Ver Reportes</a>
        </div>
    </div>
</div>
@endsection
