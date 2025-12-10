@extends('layouts.app')

@section('title', 'Diagnostic - User Permissions')

@section('content')
<div class="container">
    <a href="{{ route('admin.users.index') }}" class="back-link">&larr; Volver a usuarios</a>
    <h2 class="mt-4">Permisos de usuario: {{ $user->name }}</h2>

    <div class="card mt-4 p-4">
        <h3>Rol</h3>
        <p><strong>{{ $role?->name ?? 'Sin rol' }}</strong></p>
        <h3>Permisos globales</h3>
        @if($globalPerms->count())
            <ul>
                @foreach($globalPerms as $p)
                    <li>{{ $p->name }}</li>
                @endforeach
            </ul>
        @else
            <p>No hay permisos globales asignados a este rol.</p>
        @endif

        <h3>Permisos granulares</h3>
        @if($granular->count())
            <ul>
                @foreach($granular as $g)
                    <li>{{ $g->getDescripcion() }} — {{ json_encode($g->getResumenPermisos()) }}</li>
                @endforeach
            </ul>
        @else
            <p>No hay permisos granulares activos para este rol.</p>
        @endif
    </div>
</div>
@endsection
