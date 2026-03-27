@extends('layouts.dashboard')
@section('title', 'Perfil Corporativo - Inspírate SENA')
@section('page-title', 'Perfil Corporativo')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Configuración</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/empresa.css') }}">
@endsection

@section('content')
@php
    $camposCompletos = 0;
    if(!empty($empresa->emp_nombre))         $camposCompletos++;
    if(!empty($empresa->emp_representante))  $camposCompletos++;
    if(!empty($empresa->emp_nit))            $camposCompletos++;
    if(!empty($empresa->emp_correo))         $camposCompletos++;
    $progresoPerfil = ($camposCompletos / 4) * 100;
    $totalProyectos = $empresa->proyectos()->count();
    $proyectosActivos = $empresa->proyectos()->where('pro_estado','Activo')->count();
@endphp

<div class="animate-fade-in" style="max-width: 1100px; margin: 0 auto; padding-bottom: 40px;">

    {{-- ── HERO BANNER ──────────────────────────────────────────── --}}
    <div class="profile-hero">
        <div class="company-logo">
            {{ strtoupper(substr($empresa->emp_nombre, 0, 1)) }}
        </div>
        <div class="hero-meta">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                <span style="background:rgba(57,169,0,0.25); border:1px solid rgba(57,169,0,0.4); color:#86efac; padding:4px 14px; border-radius:20px; font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">Socio Estratégico SENA</span>
                <span style="color:rgba(255,255,255,0.4); font-size:13px; font-weight:600;">NIT: {{ $empresa->emp_nit }}</span>
            </div>
            <h2 style="font-size:36px; font-weight:900; letter-spacing:-1px; margin-bottom:4px;">{{ $empresa->emp_nombre }}</h2>
            <p style="font-size:14px; color:rgba(255,255,255,0.55); font-weight:500;">{{ $empresa->emp_representante }} · Representante Legal</p>

            <div class="profile-integrity-bar">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:11px; font-weight:700; color:rgba(255,255,255,0.6); text-transform:uppercase; letter-spacing:0.5px;">Integridad del Perfil</span>
                    <span style="font-size:13px; font-weight:900; color:var(--primary);">{{ $progresoPerfil }}%</span>
                </div>
                <div class="integrity-track"><div class="integrity-fill" style="width:{{ $progresoPerfil }}%;"></div></div>
            </div>
        </div>

        {{-- Quick Stats --}}
        <div style="display:grid; gap:16px; position:relative; z-index:1; flex-shrink:0;">
            <div style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12); border-radius:20px; padding:20px 28px; text-align:center; backdrop-filter:blur(10px);">
                <div style="font-size:36px; font-weight:900; color:white; line-height:1;">{{ $totalProyectos }}</div>
                <div style="font-size:11px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:4px;">Convocatorias</div>
            </div>
            <div style="background:rgba(57,169,0,0.2); border:1px solid rgba(57,169,0,0.3); border-radius:20px; padding:16px 28px; text-align:center;">
                <div style="font-size:28px; font-weight:900; color:#86efac; line-height:1;">{{ $proyectosActivos }}</div>
                <div style="font-size:11px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:4px;">Activas</div>
            </div>
        </div>
    </div>

    {{-- ── MAIN GRID ────────────────────────────────────────────── --}}
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:28px; align-items:start;">

        {{-- FORM CARD --}}
        <div class="glass-card" style="padding:44px;">
            <div class="section-divider">
                <div class="section-number"><i class="fas fa-building"></i></div>
                <div>
                    <h3 style="font-size:20px; font-weight:800; color:var(--text);">Información <span style="color:var(--primary);">Corporativa</span></h3>
                    <p style="font-size:13px; color:var(--text-light); font-weight:500; margin-top:2px;">Mantén tus datos actualizados para mejorar la confianza.</p>
                </div>
            </div>

            <form action="{{ route('empresa.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display:grid; gap:24px; margin-bottom:32px;">
                    <div class="form-group">
                        <label class="empresa-form-label">Razón Social / Nombre Comercial</label>
                        <div class="empresa-input-container">
                            <i class="fas fa-building empresa-input-icon"></i>
                            <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa', $empresa->emp_nombre) }}" required class="empresa-form-control" placeholder="Nombre oficial de la empresa">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="empresa-form-label">Representante Legal</label>
                        <div class="empresa-input-container">
                            <i class="fas fa-user-tie empresa-input-icon"></i>
                            <input type="text" name="representante" value="{{ old('representante', $empresa->emp_representante) }}" required class="empresa-form-control" placeholder="Nombre del representante">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div class="form-group">
                            <label class="empresa-form-label" style="color:#94a3b8;">NIT (Solo Lectura)</label>
                            <div class="empresa-input-container">
                                <i class="fas fa-id-card empresa-input-icon" style="color:#cbd5e1;"></i>
                                <input type="text" value="{{ $empresa->emp_nit }}" disabled class="empresa-form-control" style="background:#f8fafc; color:#94a3b8; border-style:dashed;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="empresa-form-label" style="color:#94a3b8;">Email (Solo Lectura)</label>
                            <div class="empresa-input-container">
                                <i class="fas fa-envelope empresa-input-icon" style="color:#cbd5e1;"></i>
                                <input type="email" value="{{ $empresa->emp_correo }}" disabled class="empresa-form-control" style="background:#f8fafc; color:#94a3b8; border-style:dashed;">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Security --}}
                <div style="background:#f8fafc; border:2px dashed #e2e8f0; border-radius:20px; padding:28px; margin-bottom:32px;">
                    <h4 style="font-size:15px; font-weight:800; color:var(--text); display:flex; align-items:center; gap:10px; margin-bottom:20px;">
                        <i class="fas fa-shield-halved" style="color:#64748b;"></i> Seguridad de Cuenta
                    </h4>
                    <div class="empresa-input-container" style="max-width:400px;">
                        <i class="fas fa-key empresa-input-icon"></i>
                        <input type="password" name="password" placeholder="Nueva contraseña (dejar vacío para no cambiar)" class="empresa-form-control">
                    </div>
                    <p style="font-size:12px; color:#94a3b8; margin-top:10px; font-weight:600;"><i class="fas fa-info-circle"></i> Solo completa este campo si deseas cambiar tu clave actual.</p>
                </div>

                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn-premium" style="padding:16px 48px; font-size:15px;">
                        <i class="fas fa-cloud-arrow-up"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        {{-- SIDEBAR --}}
        <div style="display:grid; gap:20px; align-content:start;">

            {{-- Contacto --}}
            <div class="glass-card" style="padding:28px;">
                <h4 style="font-size:12px; font-weight:800; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;">Puntos de Contacto</h4>
                <div style="display:grid; gap:14px;">
                    <div class="contact-pill">
                        <div class="contact-pill-icon" style="background:#eff6ff; color:#3b82f6;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div>
                            <span style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; display:block;">Representante</span>
                            <span style="font-size:14px; font-weight:700; color:var(--text);">{{ $empresa->emp_representante ?: '—' }}</span>
                        </div>
                    </div>
                    <div class="contact-pill">
                        <div class="contact-pill-icon" style="background:#fef2f2; color:#ef4444;">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div style="min-width:0;">
                            <span style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; display:block;">Email Oficial</span>
                            <span style="font-size:13px; font-weight:700; color:var(--text); word-break:break-all;">{{ $empresa->emp_correo }}</span>
                        </div>
                    </div>
                    <div class="contact-pill">
                        <div class="contact-pill-icon" style="background:var(--primary-soft); color:var(--primary);">
                            <i class="fas fa-fingerprint"></i>
                        </div>
                        <div>
                            <span style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; display:block;">NIT</span>
                            <span style="font-size:14px; font-weight:700; color:var(--text);">{{ $empresa->emp_nit }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Insignia --}}
            <div class="glass-card" style="padding:32px; background:linear-gradient(135deg,#0f172a,#1e293b); border:none; color:white; position:relative; overflow:hidden;">
                <div style="position:absolute; right:-15px; bottom:-15px; font-size:90px; color:rgba(255,255,255,0.04);"><i class="fas fa-award"></i></div>
                <div style="width:48px; height:48px; background:rgba(57,169,0,0.2); border:1px solid rgba(57,169,0,0.3); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; color:#86efac; margin-bottom:16px;">
                    <i class="fas fa-medal"></i>
                </div>
                <h4 style="font-size:17px; font-weight:900; margin-bottom:8px;">Socio Verificado</h4>
                <p style="font-size:13px; color:rgba(255,255,255,0.5); line-height:1.6; font-weight:500; margin-bottom:20px;">Tu empresa está activa en la red de aliados SENA. Accede a talento calificado en formación.</p>
                <div style="background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:12px 16px; text-align:center; font-size:12px; font-weight:700; color:rgba(255,255,255,0.4);">
                    <i class="fas fa-clock"></i> Insignia Descargable — Próximamente
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
