@extends('layouts.dashboard')
@section('title', 'Mi Perfil - ' . ($instructor->nombres ?? 'Instructor'))
@section('page-title', 'Perfil Profesional')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('instructor.historial') }}" class="nav-item {{ request()->routeIs('instructor.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="{{ route('instructor.aprendices') }}" class="nav-item {{ request()->routeIs('instructor.aprendices') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Aprendices
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('instructor.perfil') }}" class="nav-item {{ request()->routeIs('instructor.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> Mi Perfil
    </a>
@endsection

@section('styles')
    @vite(['resources/css/instructor.css', 'resources/css/instructor-perfil.css'])
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('instructor.dashboard')], ['label' => 'Perfil']]; @endphp
@section('content')
@php
    $camposCompletos = 0;
    if(!empty($instructor->nombres))      $camposCompletos++;
    if(!empty($instructor->apellidos))    $camposCompletos++;
    if(!empty($instructor->especialidad))$camposCompletos++;
    if(!empty($usuario->correo))         $camposCompletos++;
    $progresoPerfil = ($camposCompletos / 4) * 100;
@endphp

<div class="perfil-container">

    {{-- ── HERO ──────────────────────────────────────────────────── --}}
    <div class="instructor-hero perfil-hero">
        <div class="instructor-hero-bg-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div class="perfil-hero-inner">
            <div class="perfil-avatar-wrap">
                <div class="perfil-avatar-circle">
                    {{ strtoupper(substr($instructor->nombres ?? 'I', 0, 1)) }}
                </div>
                <div class="perfil-avatar-badge">
                    <i class="fas fa-check"></i>
                </div>
            </div>

            <div class="perfil-hero-info">
                <div class="perfil-hero-meta">
                    <span class="instructor-tag">Instructor SENA</span>
                    <span class="perfil-hero-email"><i class="fas fa-envelope"></i>{{ $usuario->correo }}</span>
                </div>
                <h1 class="instructor-title perfil-hero-name">{{ $instructor->nombres }} {{ $instructor->apellidos }}</h1>
                <div class="perfil-progress-card">
                    <div class="perfil-progress-header">
                        <span class="perfil-progress-label">Integridad del Perfil</span>
                        <span class="perfil-progress-pct">{{ round($progresoPerfil) }}%</span>
                    </div>
                    <div class="perfil-progress-track">
                        <div class="perfil-progress-fill" style="width:{{ $progresoPerfil }}%;"></div>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div class="perfil-hero-stats">
                <div class="perfil-hero-stat perfil-hero-stat-default">
                    <div class="perfil-hero-stat-num">{{ $proyectosCount }}</div>
                    <div class="perfil-hero-stat-label">Proyectos</div>
                </div>
                <div class="perfil-hero-stat perfil-hero-stat-green">
                    <div class="perfil-hero-stat-num perfil-hero-stat-num-sm perfil-hero-stat-num-green">{{ $aprendicesCount }}</div>
                    <div class="perfil-hero-stat-label">Aprendices</div>
                </div>
                <div class="perfil-hero-stat perfil-hero-stat-amber">
                    <div class="perfil-hero-stat-num perfil-hero-stat-num-sm perfil-hero-stat-num-amber">{{ $evidenciasPendientesCount }}</div>
                    <div class="perfil-hero-stat-label">Pendientes</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── GRID ────────────────────────────────────────────────── --}}
    <div class="perfil-main-grid">

        {{-- FORM --}}
        <div class="glass-card perfil-form-section">
            <div class="perfil-form-header">
                <div class="perfil-form-header-icon">
                    <i class="fas fa-id-badge"></i>
                </div>
                <div class="perfil-form-header-text">
                    <h3>Perfil <span>Profesional</span></h3>
                    <p>Tu información visible para aprendices y empresas.</p>
                </div>
            </div>

            <form action="{{ route('instructor.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="perfil-form-grid">
                    <div class="perfil-form-group">
                        <label class="perfil-form-label">Nombres</label>
                        <div class="perfil-input-wrapper">
                            <i class="fas fa-user-tag perfil-input-icon"></i>
                            <input type="text" name="nombre" value="{{ old('nombre', $instructor->nombres) }}" required class="perfil-input-control">
                        </div>
                    </div>
                    <div class="perfil-form-group">
                        <label class="perfil-form-label">Apellidos</label>
                        <div class="perfil-input-wrapper">
                            <i class="fas fa-user-tag perfil-input-icon"></i>
                            <input type="text" name="apellido" value="{{ old('apellido', $instructor->apellidos) }}" required class="perfil-input-control">
                        </div>
                    </div>
                </div>

                <div class="perfil-form-group">
                    <label class="perfil-form-label">Especialidad / Área de Influencia</label>
                    <div class="perfil-input-wrapper">
                        <i class="fas fa-graduation-cap perfil-input-icon"></i>
                        <input type="text" name="especialidad" value="{{ old('especialidad', $instructor->especialidad) }}" required class="perfil-input-control">
                    </div>
                </div>

                <div class="perfil-form-group">
                    <label class="perfil-form-label">Correo Electrónico (Solo Lectura)</label>
                    <div class="perfil-input-wrapper">
                        <i class="fas fa-envelope-open perfil-input-icon"></i>
                        <input type="email" value="{{ $usuario->correo }}" disabled class="perfil-input-control">
                    </div>
                </div>

                {{-- Security --}}
                <div class="perfil-security-box">
                    <h4 class="perfil-security-title">
                        <i class="fas fa-shield-alt"></i> Seguridad
                    </h4>
                    <div class="perfil-form-group" style="margin-bottom:0;">
                        <div class="perfil-input-wrapper">
                            <i class="fas fa-lock perfil-input-icon"></i>
                            <input type="password" name="password" placeholder="Nueva contraseña (vacío = sin cambio)" class="perfil-input-control">
                        </div>
                    </div>
                </div>

                <div class="perfil-btn-row">
                    <button type="submit" class="btn-premium perfil-btn-update">
                        <i class="fas fa-sync-alt"></i> Actualizar Mi Perfil
                    </button>
                </div>
            </form>
        </div>

        {{-- SIDEBAR --}}
        <div class="perfil-sidebar">

            {{-- Contacto --}}
            <div class="glass-card perfil-contact-card">
                <h4 class="perfil-contact-title">Datos de Contacto</h4>
                <div class="perfil-contact-list">
                    <div class="perfil-contact-item perfil-contact-item-email">
                        <div class="perfil-contact-icon perfil-contact-icon-blue">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div style="min-width:0;">
                            <span class="perfil-contact-label">Correo</span>
                            <span class="perfil-contact-value">{{ $usuario->correo }}</span>
                        </div>
                    </div>
                    <div class="perfil-contact-item perfil-contact-item-specialty">
                        <div class="perfil-contact-icon perfil-contact-icon-green">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div>
                            <span class="perfil-contact-label">Especialidad</span>
                            <span class="perfil-contact-value perfil-contact-value-lg">{{ $instructor->especialidad }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rol card --}}
            <div class="perfil-verified-card">
                <div class="perfil-verified-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <h4 class="perfil-verified-title">Instructor Verificado</h4>
                <p class="perfil-verified-desc">Gestión de Proyectos & Supervisión de Aprendices SENA.</p>
                <div class="perfil-verified-badge">
                    <i class="fas fa-check-circle"></i> Cuenta Verificada
                </div>
            </div>

            {{-- Consentimiento de Datos --}}
            <div class="glass-card perfil-privacy-card">
                <h4 class="perfil-privacy-title">
                    <i class="fas fa-shield-alt"></i> Privacidad y Datos
                </h4>
                <div class="perfil-privacy-status {{ $usuario->consentimiento_datos ? 'perfil-privacy-status-ok' : 'perfil-privacy-status-warn' }}">
                    <i class="fas {{ $usuario->consentimiento_datos ? 'fa-check-circle' : 'fa-times-circle' }} perfil-privacy-status-icon {{ $usuario->consentimiento_datos ? 'perfil-privacy-status-icon-ok' : 'perfil-privacy-status-icon-warn' }}"></i>
                    <div>
                        <span class="perfil-privacy-status-text {{ $usuario->consentimiento_datos ? 'perfil-privacy-status-text-ok' : 'perfil-privacy-status-text-warn' }}">
                            {{ $usuario->consentimiento_datos ? 'Consentimiento otorgado' : 'Consentimiento retirado' }}
                        </span>
                        @if($usuario->fecha_consentimiento)
                            <span class="perfil-privacy-date">
                                {{ $usuario->consentimiento_datos ? 'Otorgado' : 'Actualizado' }}: {{ \Carbon\Carbon::parse($usuario->fecha_consentimiento)->format('d/m/Y H:i') }}
                            </span>
                        @endif
                    </div>
                </div>
                <p class="perfil-privacy-note">
                    Tus datos personales son tratados conforme a la Ley 1581 de 2012.
                </p>
                <div class="perfil-privacy-actions">
                    <a href="{{ route('politica.datos') }}" target="_blank" class="perfil-privacy-link">
                        <i class="fas fa-external-link-alt"></i> Ver política
                    </a>
                    @if($usuario->consentimiento_datos)
                        <form action="{{ route('consentimiento.retirar') }}" method="POST" onsubmit="return confirm('¿Estás seguro de retirar tu consentimiento? Esto puede limitar algunas funcionalidades de la plataforma.')" style="display:inline;">
                            @csrf
                            <button type="submit" class="perfil-privacy-revoke">
                                <i class="fas fa-user-slash"></i> Retirar consentimiento
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
