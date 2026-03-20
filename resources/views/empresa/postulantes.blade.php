@extends('layouts.dashboard')

@section('title', 'Postulantes')
@section('page-title', 'Postulantes del Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('content')
    <link rel="stylesheet" href="{{ asset('css/empresa.css') }}">

    <div class="postulantes-header">
        <a href="{{ route('empresa.proyectos') }}" class="postulantes-back-link">
            <i class="fas fa-arrow-left"></i> Volver a proyectos
        </a>
        <h2 class="postulantes-title">{{ $proyecto->pro_titulo_proyecto }}</h2>
        <p class="postulantes-subtitle">Postulantes al proyecto</p>
    </div>

    <div class="card">
        @forelse($postulantes as $p)
            <div class="postulante-card">
                <div class="postulante-avatar">
                    <span>{{ strtoupper(substr($p->apr_nombre ?? 'A', 0, 1)) }}</span>
                </div>
                <div class="postulante-info">
                    <h4 class="postulante-name">{{ $p->apr_nombre ?? '' }} {{ $p->apr_apellido ?? '' }}</h4>
                    <p class="postulante-program">
                        <i class="fas fa-graduation-cap"></i>{{ $p->apr_programa ?? 'Sin programa' }}
                    </p>
                    <p class="postulante-email">
                        <i class="fas fa-envelope"></i>{{ $p->usr_correo ?? 'Sin correo' }}
                    </p>
                </div>
                <div class="postulante-status">
                    @switch($p->pos_estado)
                        @case('Pendiente')
                            <span class="badge badge-warning">{{ $p->pos_estado }}</span>
                            @break
                        @case('Aprobada')
                            <span class="badge badge-success">{{ $p->pos_estado }}</span>
                            @break
                        @case('Rechazada')
                            <span class="badge badge-danger">{{ $p->pos_estado }}</span>
                            @break
                        @default
                            <span class="badge badge-info">{{ $p->pos_estado }}</span>
                    @endswitch
                    <p class="postulante-date">
                        <i class="fas fa-calendar"></i>{{ \Carbon\Carbon::parse($p->pos_fecha)->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        @empty
            <div class="postulantes-empty">
                <i class="fas fa-users postulantes-empty-icon"></i>
                <h4 class="postulantes-empty-title">No hay postulantes</h4>
                <p class="postulantes-empty-message">Aún no hay aprendices postulados a este proyecto.</p>
            </div>
        @endforelse
    </div>
@endsection
