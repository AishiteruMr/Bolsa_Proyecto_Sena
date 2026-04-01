@extends('layouts.dashboard')
@section('title', 'Mi Perfil - ' . ($instructor->ins_nombre ?? 'Instructor'))
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
    <link rel="stylesheet" href="{{ asset('css/instructor.css') }}">
@endsection

@section('content')
@php
    $camposCompletos = 0;
    if(!empty($instructor->ins_nombre))      $camposCompletos++;
    if(!empty($instructor->ins_apellido))    $camposCompletos++;
    if(!empty($instructor->ins_especialidad))$camposCompletos++;
    if(!empty($usuario->usr_correo))         $camposCompletos++;
    $progresoPerfil = ($camposCompletos / 4) * 100;
@endphp

<div class="animate-fade-in" style="max-width: 1100px; margin: 0 auto; padding-bottom: 40px;">

    {{-- ── HERO ──────────────────────────────────────────────────── --}}
    <div class="ins-hero">
        <div style="position: relative; flex-shrink: 0; z-index: 1;">
            <div class="ins-avatar-hero">
                {{ strtoupper(substr($instructor->ins_nombre ?? 'I', 0, 1)) }}
            </div>
            <div class="ins-avatar-badge"><i class="fas fa-check"></i></div>
        </div>

        <div class="ins-hero-meta">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                <span style="background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.2); padding:4px 14px; border-radius:20px; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">Instructor SENA</span>
                <span style="color:rgba(255,255,255,0.5); font-size:13px; font-weight:600;"><i class="fas fa-envelope" style="margin-right:4px;"></i>{{ $usuario->usr_correo }}</span>
            </div>
            <h2 style="font-size:34px; font-weight:900; letter-spacing:-0.5px; margin-bottom:4px;">
                {{ $instructor->ins_nombre }} {{ $instructor->ins_apellido }}
            </h2>
            <div style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:12px; padding:8px 16px; display:inline-flex; align-items:center; gap:10px; margin-top:8px; font-size:14px; font-weight:600;">
                <i class="fas fa-award" style="color:#a7f3d0;"></i>
                {{ $instructor->ins_especialidad }}
            </div>
        </div>

        {{-- Mini stats --}}
        <div style="display:grid; gap:12px; position:relative; z-index:1; flex-shrink:0;">
            <div class="stat-mini">
                <div style="font-size:30px; font-weight:900; color:white;">{{ $proyectosCount }}</div>
                <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:2px;">Proyectos</div>
            </div>
            <div class="stat-mini">
                <div style="font-size:30px; font-weight:900; color:white;">{{ $aprendicesCount }}</div>
                <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:2px;">Aprendices</div>
            </div>
            <div class="stat-mini">
                <div style="font-size:30px; font-weight:900; color:#fde68a;">{{ $evidenciasPendientesCount }}</div>
                <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:2px;">Pendientes</div>
            </div>
        </div>
    </div>

    {{-- ── GRID ────────────────────────────────────────────────── --}}
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:28px; align-items:start;">

        {{-- FORM --}}
        <div class="glass-card" style="padding:44px;">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:32px; padding-bottom:24px; border-bottom:1.5px solid #f1f5f9;">
                <div style="width:42px; height:42px; border-radius:12px; background:#ccfbf1; color:#0f766e; display:flex; align-items:center; justify-content:center; font-size:18px;">
                    <i class="fas fa-id-badge"></i>
                </div>
                <div>
                    <h3 style="font-size:20px; font-weight:800; color:var(--text);">Perfil <span style="color:#0f766e;">Profesional</span></h3>
                    <p style="font-size:13px; color:var(--text-light); font-weight:500; margin-top:2px;">Tu información visible para aprendices y empresas.</p>
                </div>
            </div>

            <form action="{{ route('instructor.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                    <div class="instructor-form-group">
                        <label class="ins-form-label">Nombres</label>
                        <div class="instructor-input-wrapper">
                            <i class="fas fa-user-tag instructor-input-icon"></i>
                            <input type="text" name="nombre" value="{{ old('nombre', $instructor->ins_nombre) }}" required class="instructor-input-control">
                        </div>
                    </div>
                    <div class="instructor-form-group">
                        <label class="ins-form-label">Apellidos</label>
                        <div class="instructor-input-wrapper">
                            <i class="fas fa-user-tag instructor-input-icon"></i>
                            <input type="text" name="apellido" value="{{ old('apellido', $instructor->ins_apellido) }}" required class="instructor-input-control">
                        </div>
                    </div>
                </div>

                <div class="instructor-form-group" style="margin-bottom:20px;">
                    <label class="ins-form-label">Especialidad / Área de Influencia</label>
                    <div class="instructor-input-wrapper">
                        <i class="fas fa-graduation-cap instructor-input-icon"></i>
                        <input type="text" name="especialidad" value="{{ old('especialidad', $instructor->ins_especialidad) }}" required class="instructor-input-control">
                    </div>
                </div>

                <div class="instructor-form-group" style="margin-bottom:32px;">
                    <label class="ins-form-label" style="color:#94a3b8;">Correo Electrónico (Solo Lectura)</label>
                    <div class="instructor-input-wrapper">
                        <i class="fas fa-envelope-open instructor-input-icon"></i>
                        <input type="email" value="{{ $usuario->usr_correo }}" disabled class="instructor-input-control" style="background:#f1f5f9; color:#94a3b8; cursor:not-allowed; border-style:dashed;">
                    </div>
                </div>

                {{-- Security --}}
                <div style="background:#f0fdfa; border:1.5px solid #ccfbf1; border-radius:20px; padding:28px; margin-bottom:32px;">
                    <h4 style="font-size:15px; font-weight:800; color:#115e59; display:flex; align-items:center; gap:10px; margin-bottom:20px;">
                        <i class="fas fa-key"></i> Parámetros de Seguridad
                    </h4>
                    <div class="instructor-form-group" style="margin-bottom:0;">
                        <div class="instructor-input-wrapper">
                            <i class="fas fa-shield-alt instructor-input-icon"></i>
                            <input type="password" name="password" placeholder="Nueva contraseña (dejar vacío para conservar)" class="instructor-input-control">
                        </div>
                    </div>
                </div>

                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn-instructor-save" style="padding:16px 44px; font-size:15px;">
                        <i class="fas fa-check-circle"></i> Actualizar Información
                    </button>
                </div>
            </form>
        </div>

        {{-- SIDEBAR --}}
        <div style="display:grid; gap:20px; align-content:start;">

            {{-- Integridad --}}
            <div class="glass-card" style="padding:28px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                    <span style="font-size:13px; font-weight:700; color:var(--text);">Integridad del Perfil</span>
                    <span style="font-size:15px; font-weight:900; color:#0f766e;">{{ round($progresoPerfil) }}%</span>
                </div>
                <div style="height:8px; background:#f1f5f9; border-radius:4px; overflow:hidden; margin-bottom:16px;">
                    <div style="width:{{ $progresoPerfil }}%; height:100%; background:linear-gradient(90deg,#0f766e,#10b981); border-radius:4px; transition:width 1.2s cubic-bezier(0.4,0,0.2,1);"></div>
                </div>
                <p style="font-size:12px; color:#64748b; font-weight:600; line-height:1.5;">
                    {{ $progresoPerfil == 100 ? '✅ Tu perfil está completo. Generas mayor confianza en aprendices y empresas.' : 'Completa todos tus datos para mejorar tu visibilidad.' }}
                </p>
            </div>

            {{-- Contacto --}}
            <div class="glass-card" style="padding:28px;">
                <h4 style="font-size:12px; font-weight:800; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;">Datos de Contacto</h4>
                <div style="display:grid; gap:12px;">
                    <div class="ins-contact-row">
                        <div class="ins-contact-icon"><i class="fas fa-envelope"></i></div>
                        <div style="min-width:0;">
                            <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase;">Correo</div>
                            <div style="font-size:13px; font-weight:700; color:var(--text); word-break:break-all;">{{ $usuario->usr_correo }}</div>
                        </div>
                    </div>
                    <div class="ins-contact-row">
                        <div class="ins-contact-icon"><i class="fas fa-medal"></i></div>
                        <div>
                            <div style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase;">Especialidad</div>
                            <div style="font-size:13px; font-weight:700; color:var(--text);">{{ $instructor->ins_especialidad }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rol card --}}
            <div class="glass-card" style="padding:28px; background:linear-gradient(135deg,#0f766e,#0d9488); border:none; color:white; position:relative; overflow:hidden;">
                <div style="position:absolute; right:-10px; bottom:-10px; font-size:80px; color:rgba(255,255,255,0.05);"><i class="fas fa-chalkboard-teacher"></i></div>
                <div style="width:44px; height:44px; background:rgba(255,255,255,0.15); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; margin-bottom:16px;">
                    <i class="fas fa-users-cog"></i>
                </div>
                <h4 style="font-size:16px; font-weight:800; margin-bottom:6px;">Rol Activo</h4>
                <p style="font-size:13px; color:rgba(255,255,255,0.65); font-weight:500; line-height:1.5;">Gestión de Proyectos & Supervisión de Aprendices SENA.</p>
            </div>
        </div>
    </div>
</div>
@endsection
