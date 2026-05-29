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
    @vite(['resources/css/instructor.css'])
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

<div class="animate-fade-in" style="max-width: 1100px; margin: 0 auto; padding-bottom: 40px;">

    {{-- ── HERO ──────────────────────────────────────────────────── --}}
    <div class="instructor-hero" style="padding: 48px;">
        <div class="instructor-hero-bg-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <div style="display: flex; align-items: center; gap: 32px; position: relative; z-index: 1;">
            <div style="position: relative; flex-shrink: 0;">
                <div style="width: 96px; height: 96px; border-radius: 50%; background: rgba(255,255,255,0.18); border: 3px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: 900; color: white;">
                    {{ strtoupper(substr($instructor->nombres ?? 'I', 0, 1)) }}
                </div>
                <div style="position: absolute; bottom: -4px; right: -4px; width: 28px; height: 28px; border-radius: 50%; background: #3eb489; border: 3px solid white; display: flex; align-items: center; justify-content: center; font-size: 12px; color: white;">
                    <i class="fas fa-check"></i>
                </div>
            </div>

            <div style="flex: 1;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                    <span class="instructor-tag">Instructor SENA</span>
                    <span style="color:rgba(255,255,255,0.5); font-size:13px; font-weight:600;"><i class="fas fa-envelope" style="margin-right:4px;"></i>{{ $usuario->correo }}</span>
                </div>
                <h1 class="instructor-title">{{ $instructor->nombres }} {{ $instructor->apellidos }}</h1>
                <div style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:14px; padding:14px 18px; margin-top:16px; max-width:380px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                        <span style="font-size:11px; font-weight:700; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.5px;">Integridad del Perfil</span>
                        <span style="font-size:13px; font-weight:900; color:#fde68a;">{{ round($progresoPerfil) }}%</span>
                    </div>
                    <div style="height:6px; background:rgba(255,255,255,0.15); border-radius:3px; overflow:hidden;">
                        <div style="width:{{ $progresoPerfil }}%; height:100%; background:linear-gradient(90deg,#fde68a,#fbbf24); border-radius:3px; transition:width 1.2s ease;"></div>
                    </div>
                </div>
            </div>

            {{-- Stats --}}
            <div style="display:grid; gap:12px; flex-shrink:0;">
                <div style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12); border-radius:16px; padding:16px 24px; text-align:center; backdrop-filter:blur(10px);">
                    <div style="font-size:32px; font-weight:900; color:white; line-height:1;">{{ $proyectosCount }}</div>
                    <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:4px;">Proyectos</div>
                </div>
                <div style="background:rgba(62,180,137,0.15); border:1px solid rgba(62,180,137,0.25); border-radius:16px; padding:14px 24px; text-align:center;">
                    <div style="font-size:28px; font-weight:900; color:#86efac; line-height:1;">{{ $aprendicesCount }}</div>
                    <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:4px;">Aprendices</div>
                </div>
                <div style="background:rgba(251,191,36,0.15); border:1px solid rgba(251,191,36,0.2); border-radius:16px; padding:14px 24px; text-align:center;">
                    <div style="font-size:28px; font-weight:900; color:#fde68a; line-height:1;">{{ $evidenciasPendientesCount }}</div>
                    <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:4px;">Pendientes</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── GRID ────────────────────────────────────────────────── --}}
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:28px; align-items:start;">

        {{-- FORM --}}
        <div class="glass-card" style="padding:32px;">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:28px; padding-bottom:24px; border-bottom:1.5px solid rgba(62,180,137,0.1);">
                <div style="width:48px; height:48px; border-radius:14px; background:rgba(62,180,137,0.1); color:#3eb489; display:flex; align-items:center; justify-content:center; font-size:20px;">
                    <i class="fas fa-id-badge"></i>
                </div>
                <div>
                    <h3 style="font-size:20px; font-weight:800; color:var(--text);">Perfil <span style="color:var(--primary);">Profesional</span></h3>
                    <p style="font-size:13px; color:var(--text-light); font-weight:500; margin-top:2px;">Tu información visible para aprendices y empresas.</p>
                </div>
            </div>

            <form action="{{ route('instructor.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:20px;">
                    <div class="instructor-form-group">
                        <label class="ins-form-label">Nombres</label>
                        <div class="instructor-input-wrapper">
                            <i class="fas fa-user-tag instructor-input-icon"></i>
                            <input type="text" name="nombre" value="{{ old('nombre', $instructor->nombres) }}" required class="instructor-input-control">
                        </div>
                    </div>
                    <div class="instructor-form-group">
                        <label class="ins-form-label">Apellidos</label>
                        <div class="instructor-input-wrapper">
                            <i class="fas fa-user-tag instructor-input-icon"></i>
                            <input type="text" name="apellido" value="{{ old('apellido', $instructor->apellidos) }}" required class="instructor-input-control">
                        </div>
                    </div>
                </div>

                <div class="instructor-form-group" style="margin-bottom:20px;">
                    <label class="ins-form-label">Especialidad / Área de Influencia</label>
                    <div class="instructor-input-wrapper">
                        <i class="fas fa-graduation-cap instructor-input-icon"></i>
                        <input type="text" name="especialidad" value="{{ old('especialidad', $instructor->especialidad) }}" required class="instructor-input-control">
                    </div>
                </div>

                <div class="instructor-form-group" style="margin-bottom:28px;">
                    <label class="ins-form-label" style="color:#94a3b8;">Correo Electrónico (Solo Lectura)</label>
                    <div class="instructor-input-wrapper">
                        <i class="fas fa-envelope-open instructor-input-icon"></i>
                        <input type="email" value="{{ $usuario->correo }}" disabled class="instructor-input-control" style="background:#f8fafc; color:#94a3b8; cursor:not-allowed; border-style:dashed;">
                    </div>
                </div>

                {{-- Security --}}
                <div style="background:#f8fafc; border:2px dashed rgba(62,180,137,0.2); border-radius:20px; padding:24px; margin-bottom:28px;">
                    <h4 style="font-size:15px; font-weight:800; color:var(--text); display:flex; align-items:center; gap:10px; margin-bottom:20px;">
                        <i class="fas fa-shield-alt" style="color:#3eb489;"></i> Seguridad
                    </h4>
                    <div class="instructor-form-group" style="margin-bottom:0;">
                        <div class="instructor-input-wrapper">
                            <i class="fas fa-lock instructor-input-icon"></i>
                            <input type="password" name="password" placeholder="Nueva contraseña (vacío = sin cambio)" class="instructor-input-control">
                        </div>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn-premium" style="padding:16px 40px; font-size:15px; border: none; cursor: pointer;">
                        <i class="fas fa-sync-alt"></i> Actualizar Mi Perfil
                    </button>
                </div>
            </form>
        </div>

        {{-- SIDEBAR --}}
        <div style="display:grid; gap:20px; align-content:start;">

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
                            <i class="fas fa-medal"></i>
                        </div>
                        <div>
                            <span style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; display:block;">Especialidad</span>
                            <span style="font-size:14px; font-weight:700; color:var(--text);">{{ $instructor->especialidad }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rol card --}}
            <div style="padding:28px; background:linear-gradient(135deg, #0f172a, #1e293b); border:none; color:white; position:relative; overflow:hidden; border-radius:var(--radius); box-shadow:var(--shadow); box-sizing:border-box;">
                <div style="position:absolute; right:-15px; bottom:-15px; font-size:90px; color:rgba(255,255,255,0.04);"><i class="fas fa-award"></i></div>
                <div style="width:48px; height:48px; background:rgba(62,180,137,0.2); border:1px solid rgba(62,180,137,0.3); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; color:#86efac; margin-bottom:16px;">
                    <i class="fas fa-medal"></i>
                </div>
                <h4 style="font-size:17px; font-weight:900; margin-bottom:8px; color:white;">Instructor Verificado</h4>
                <p style="font-size:13px; color:rgba(255,255,255,0.5); line-height:1.6; font-weight:500; margin-bottom:20px;">Gestión de Proyectos & Supervisión de Aprendices SENA.</p>
                <div style="background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:12px 16px; text-align:center; font-size:12px; font-weight:700; color:rgba(255,255,255,0.4);">
                    <i class="fas fa-check-circle" style="color:#86efac; margin-right:6px;"></i> Cuenta Verificada
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
