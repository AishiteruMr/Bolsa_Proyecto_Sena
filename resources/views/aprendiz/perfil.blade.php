@extends('layouts.dashboard')
@section('title', 'Mi Perfil - Inspírate SENA')
@section('page-title', 'Mi Perfil')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> Explorar Proyectos
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> Mis Postulaciones
    </a>
    <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> Mis Entregas
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('styles')
    @vite(['resources/css/aprendiz.css'])
    <style>
    @media (max-width: 1024px) {
        .instructor-hero {
            padding: 32px 20px !important;
        }
        .instructor-hero h1 {
            font-size: 24px !important;
        }
        .instructor-hero p {
            font-size: 14px !important;
        }
        .instructor-hero-bg-icon {
            font-size: 120px !important;
        }
        .instructor-hero .instructor-hero-bg-icon {
            width: 80px !important;
            height: 80px !important;
            font-size: 32px !important;
        }
        .instructor-hero .instructor-hero-bg-icon div:first-child {
            width: 80px !important;
            height: 80px !important;
            font-size: 32px !important;
        }
        .instructor-stat-grid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 16px !important;
        }
        .apr-stat-chip {
            padding: 16px !important;
        }
        .apr-stat-chip div:first-child {
            font-size: 24px !important;
        }
        .apr-stat-chip div:last-child {
            font-size: 9px !important;
        }
    }
    @media (max-width: 768px) {
        .animate-fade-in {
            padding-bottom: 20px !important;
        }
        .instructor-hero {
            padding: 24px 16px !important;
            flex-direction: column !important;
            text-align: center !important;
            gap: 24px !important;
        }
        .instructor-hero h1 {
            font-size: 20px !important;
        }
        .instructor-hero p {
            font-size: 13px !important;
        }
        .instructor-hero-bg-icon {
            width: 60px !important;
            height: 60px !important;
            font-size: 24px !important;
        }
        .instructor-hero .instructor-hero-bg-icon div:first-child {
            width: 60px !important;
            height: 60px !important;
            font-size: 24px !important;
        }
        .instructor-stat-grid {
            grid-template-columns: 1fr !important;
        }
        .apr-stat-chip {
            padding: 12px !important;
            justify-content: center !important;
        }
        .apr-stat-chip div:first-child {
            font-size: 20px !important;
        }
        .apr-stat-chip div:last-child {
            font-size: 8px !important;
        }
        .main-grid {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
        }
        .glass-card {
            padding: 20px !important;
        }
        .aprendiz-form-group {
            margin-bottom: 16px !important;
        }
        .btn-aprendiz-action {
            padding: 12px 24px !important;
            font-size: 14px !important;
        }
    }
    @media (max-width: 480px) {
        .animate-fade-in {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 16px !important;
        }
        .instructor-hero {
            padding: 20px 12px !important;
        }
        .instructor-hero h1 {
            font-size: 18px !important;
        }
        .instructor-hero p {
            font-size: 12px !important;
        }
        .instructor-hero-bg-icon {
            width: 50px !important;
            height: 50px !important;
            font-size: 20px !important;
        }
        .instructor-hero .instructor-hero-bg-icon div:first-child {
            width: 50px !important;
            height: 50px !important;
            font-size: 20px !important;
        }
        .instructor-stat-grid {
            gap: 12px !important;
        }
        .apr-stat-chip {
            padding: 10px !important;
        }
        .apr-stat-chip div:first-child {
            font-size: 18px !important;
        }
        .apr-stat-chip div:last-child {
            font-size: 7px !important;
        }
        .main-grid {
            gap: 16px !important;
        }
        .glass-card {
            padding: 16px !important;
        }
        .aprendiz-form-group {
            margin-bottom: 12px !important;
        }
        .btn-aprendiz-action {
            padding: 10px 20px !important;
            font-size: 13px !important;
        }
    }
    </style>
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('aprendiz.dashboard')], ['label' => 'Perfil']]; @endphp
@section('content')
@php
    $camposCompletos = 0;
    if(!empty($aprendiz->nombres))  $camposCompletos++;
    if(!empty($aprendiz->apellidos)) $camposCompletos++;
    if(!empty($aprendiz->programa_formacion)) $camposCompletos++;
    if(!empty($usuario->correo))    $camposCompletos++;
    $progresoPerfil = ($camposCompletos / 4) * 100;

    $totalPost     = $aprendiz->postulaciones()->count();
    $aprobadas     = $aprendiz->postulacionesAprobadas()->count();
    $evidencias    = $aprendiz->evidencias()->count();
@endphp

<div class="animate-fade-in" style="max-width: 1100px; margin: 0 auto; padding-bottom: 40px;">

    {{-- ── HERO ──────────────────────────────────────────────────── --}}
    <div class="instructor-hero" style="padding: 48px;">
        <div class="instructor-hero-bg-icon"><i class="fas fa-user-circle"></i></div>
        <div style="display: flex; align-items: center; gap: 32px; position: relative; z-index: 1;">
            <div style="position: relative; flex-shrink: 0;">
                <div style="width: 96px; height: 96px; border-radius: 50%; background: rgba(255,255,255,0.18); border: 3px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: 900; color: white;">
                    {{ strtoupper(substr($aprendiz->nombres ?? 'A', 0, 1)) }}
                </div>
                <div style="position: absolute; bottom: -4px; right: -4px; width: 28px; height: 28px; border-radius: 50%; background: #fbbf24; border: 3px solid white; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #78350f;">
                    <i class="fas fa-star"></i>
                </div>
            </div>

            <div style="flex: 1;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                    <span class="instructor-tag">Mi Perfil</span>
                    @if($aprendiz->activo)
                        <span style="background:rgba(251,191,36,0.2); border:1px solid rgba(251,191,36,0.35); color:#fde68a; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:800;">En Formación</span>
                    @endif
                </div>
                <h1 class="instructor-title">Hola, <span style="color: var(--primary);">{{ $aprendiz->nombres }}!</span></h1>
                <p style="font-size:15px; color:rgba(255,255,255,0.7); font-weight:500;">
                    <i class="fas fa-graduation-cap" style="margin-right:8px;"></i>{{ $aprendiz->programa_formacion }}
                </p>

                <div style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:14px; padding:14px 18px; margin-top:16px; max-width:380px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <span style="font-size:11px; font-weight:700; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.5px;">Integridad del Perfil</span>
                        <span style="font-size:13px; font-weight:900; color:#fde68a;">{{ $progresoPerfil }}%</span>
                    </div>
                    <div style="height:6px; background:rgba(255,255,255,0.15); border-radius:3px; overflow:hidden;">
                        <div style="width:{{ $progresoPerfil }}%; height:100%; background:linear-gradient(90deg,#fde68a,#fbbf24); border-radius:3px; transition:width 1.2s ease;"></div>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div style="display:grid; gap:12px; flex-shrink:0;">
                <div class="apr-stat-chip">
                    <div style="font-size:28px; font-weight:900; color:white;">{{ $totalPost }}</div>
                    <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:2px;">Postulaciones</div>
                </div>
                <div class="apr-stat-chip">
                    <div style="font-size:28px; font-weight:900; color:#86efac;">{{ $aprobadas }}</div>
                    <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:2px;">Aprobadas</div>
                </div>
                <div class="apr-stat-chip">
                    <div style="font-size:28px; font-weight:900; color:#fde68a;">{{ $evidencias }}</div>
                    <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:2px;">Evidencias</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── MAIN GRID ────────────────────────────────────────────── --}}
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:28px; align-items:start;">

        {{-- FORM --}}
        <div class="glass-card" style="padding:32px;">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:28px; padding-bottom:24px; border-bottom:1.5px solid rgba(62,180,137,0.1);">
                <div style="width:48px; height:48px; border-radius:14px; background:rgba(62,180,137,0.1); color:#3eb489; display:flex; align-items:center; justify-content:center; font-size:20px;">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <h3 style="font-size:20px; font-weight:800; color:var(--text);">Datos <span style="color:var(--primary);">Personales</span></h3>
                    <p style="font-size:13px; color:var(--text-light); font-weight:500; margin-top:2px;">Tu información visible en la plataforma.</p>
                </div>
            </div>

            <form action="{{ route('aprendiz.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:20px;">
                    <div class="aprendiz-form-group">
                        <label class="aprendiz-form-label">Nombres</label>
                        <div class="aprendiz-input-wrapper">
                            <i class="fas fa-user aprendiz-input-icon"></i>
                            <input type="text" name="nombre" value="{{ old('nombre', $aprendiz->nombres) }}" required class="aprendiz-input-control" placeholder="Tu nombre">
                        </div>
                    </div>
                    <div class="aprendiz-form-group">
                        <label class="aprendiz-form-label">Apellidos</label>
                        <div class="aprendiz-input-wrapper">
                            <i class="fas fa-user-tie aprendiz-input-icon"></i>
                            <input type="text" name="apellido" value="{{ old('apellido', $aprendiz->apellidos) }}" required class="aprendiz-input-control" placeholder="Tus apellidos">
                        </div>
                    </div>
                </div>

                <div class="aprendiz-form-group" style="margin-bottom:20px;">
                    <label class="aprendiz-form-label">Programa de Formación</label>
                    <div class="aprendiz-input-wrapper">
                        <i class="fas fa-graduation-cap aprendiz-input-icon"></i>
                        <input type="text" value="{{ $aprendiz->programa_formacion }}" disabled class="aprendiz-input-control aprendiz-input-disabled">
                    </div>
                    <p style="font-size:11px; color:#94a3b8; margin-top:6px; font-weight:500;"><i class="fas fa-info-circle"></i> El programa de formación no se puede modificar, está asociado a tu matrícula SENA.</p>
                </div>

                <div class="aprendiz-form-group" style="margin-bottom:28px;">
                    <label class="aprendiz-form-label" style="color:#94a3b8;">Correo Institucional (Solo Lectura)</label>
                    <div class="aprendiz-input-wrapper">
                        <i class="fas fa-envelope aprendiz-input-icon"></i>
                        <input type="email" value="{{ $usuario->correo }}" disabled class="aprendiz-input-control aprendiz-input-disabled">
                    </div>
                </div>

                {{-- Security --}}
                <div style="background:#f8fafc; border:2px dashed rgba(62,180,137,0.2); border-radius:20px; padding:24px; margin-bottom:28px;">
                    <h4 style="font-size:15px; font-weight:800; color:var(--text); display:flex; align-items:center; gap:10px; margin-bottom:20px;">
                        <i class="fas fa-shield-alt" style="color:#3eb489;"></i> Seguridad
                    </h4>
                    <div class="aprendiz-form-group" style="margin-bottom:16px;">
                        <label class="aprendiz-form-label">Nueva Contraseña (Opcional)</label>
                        <div class="aprendiz-input-wrapper">
                            <i class="fas fa-lock aprendiz-input-icon"></i>
                            <input type="password" name="password" placeholder="Mínimo 6 caracteres (vacío = sin cambio)" class="aprendiz-input-control">
                        </div>
                    </div>
                    <div class="aprendiz-form-group" style="margin-bottom:0;">
                        <label class="aprendiz-form-label">Confirmar Contraseña</label>
                        <div class="aprendiz-input-wrapper">
                            <i class="fas fa-lock aprendiz-input-icon"></i>
                            <input type="password" name="password_confirmation" placeholder="Repite la contraseña" class="aprendiz-input-control">
                        </div>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn-aprendiz-action" style="padding:16px 40px; font-size:15px;">
                        <i class="fas fa-sync-alt"></i> Actualizar Mi Perfil
                    </button>
                </div>
            </form>
        </div>

        {{-- SIDEBAR --}}
        <div style="display:flex; flex-direction:column; gap:20px;">

            {{-- Contacto --}}
            <div class="glass-card" style="padding:24px;">
                <h4 style="font-size:12px; font-weight:800; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;">Datos de Contacto</h4>
                <div style="display:grid; gap:12px;">
                    <div style="display:flex; align-items:center; gap:14px; padding:14px 16px; background:#eff6ff; border-radius:14px; border:1px solid rgba(0,0,0,0.05);">
                        <div style="width:36px; height:36px; border-radius:10px; background:rgba(59,130,246,0.1); color:#3b82f6; display:flex; align-items:center; justify-content:center; font-size:14px;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div style="min-width:0;">
                            <span style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; display:block;">Correo</span>
                            <span style="font-size:13px; font-weight:700; color:var(--text); word-break:break-all;">{{ $usuario->correo }}</span>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:14px; padding:14px 16px; background:rgba(62,180,137,0.1); border-radius:14px; border:1px solid rgba(62,180,137,0.1);">
                        <div style="width:36px; height:36px; border-radius:10px; background:rgba(62,180,137,0.1); color:#3eb489; display:flex; align-items:center; justify-content:center; font-size:14px;">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <span style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; display:block;">Programa</span>
                            <span style="font-size:14px; font-weight:700; color:var(--text);">{{ $aprendiz->programa_formacion }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Estudiante card --}}
            <div style="padding:28px; background:linear-gradient(135deg, #0f172a, #1e293b); border:none; color:white; position:relative; overflow:hidden; border-radius:var(--radius); box-shadow:var(--shadow); box-sizing:border-box;">
                <div style="position:absolute; right:-15px; bottom:-15px; font-size:90px; color:rgba(255,255,255,0.04);"><i class="fas fa-award"></i></div>
                <div style="width:48px; height:48px; background:rgba(62,180,137,0.2); border:1px solid rgba(62,180,137,0.3); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; color:#86efac; margin-bottom:16px;">
                    <i class="fas fa-medal"></i>
                </div>
                <h4 style="font-size:17px; font-weight:900; margin-bottom:8px; color:white;">Aprendiz SENA</h4>
                <p style="font-size:13px; color:rgba(255,255,255,0.5); line-height:1.6; font-weight:500; margin-bottom:20px;">Formándote para el futuro laboral con proyectos reales.</p>
                <div style="background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:12px 16px; text-align:center; font-size:12px; font-weight:700; color:rgba(255,255,255,0.4);">
                    <i class="fas fa-check-circle" style="color:#86efac; margin-right:6px;"></i> Cuenta Verificada
                </div>
            </div>

            {{-- Programa --}}
            <div class="glass-card" style="padding:24px; background:linear-gradient(135deg, #3eb489, #2d9d74); color:white; border:none; position:relative; overflow:hidden;">
                <div style="position:absolute; top:-20px; right:-20px; font-size:100px; color:rgba(255,255,255,0.08);"><i class="fas fa-graduation-cap"></i></div>
                <h4 style="font-size:12px; font-weight:700; color:rgba(255,255,255,0.7); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px; position:relative;">Programa Activo</h4>
                <p style="font-size:17px; font-weight:800; line-height:1.4; position:relative; margin-bottom:16px;">{{ $aprendiz->programa_formacion }}</p>
                <span style="background:rgba(255,255,255,0.2); border:1px solid rgba(255,255,255,0.25); padding:6px 14px; border-radius:20px; font-size:12px; font-weight:700; position:relative;">En Formación</span>
            </div>
        </div>
    </div>
</div>
@endsection
