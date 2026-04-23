@extends('layouts.dashboard')
@section('title', 'Perfil Corporativo - Inspírate SENA')
@section('page-title', 'Perfil Corporativo')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
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
    if(!empty($empresa->nombre))         $camposCompletos++;
    if(!empty($empresa->representante))  $camposCompletos++;
    if(!empty($empresa->nit))            $camposCompletos++;
    if(!empty($empresa->correo_contacto))         $camposCompletos++;
    $progresoPerfil = ($camposCompletos / 4) * 100;
    $totalProyectos = $empresa->proyectos()->count();
    $proyectosActivos = $empresa->proyectos()->where('estado','aprobado')->count();
@endphp

<div class="animate-fade-in" style="max-width: 1100px; margin: 0 auto; padding-bottom: 40px;">

    <!-- Hero Header -->
    <div class="instructor-hero" style="padding: 48px;">
        <div class="instructor-hero-bg-icon"><i class="fas fa-building"></i></div>
        <div style="display: flex; align-items: center; gap: 32px; position: relative; z-index: 1;">
            <div style="width: 100px; height: 100px; border-radius: 24px; background: rgba(255,255,255,0.1); border: 2px solid rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 48px; color: white; flex-shrink: 0; backdrop-filter: blur(10px);">
                {{ strtoupper(substr($empresa->nombre, 0, 1)) }}
            </div>

            <div style="flex: 1;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:12px;">
                    <span class="instructor-tag">Perfil Corporativo</span>
                    <span style="color:rgba(255,255,255,0.5); font-size:13px; font-weight:600;">NIT: {{ $empresa->nit }}</span>
                </div>
                <h1 class="instructor-title">{{ $empresa->nombre }}</h1>
                <p style="font-size:14px; color:rgba(255,255,255,0.6); font-weight:500;">
                    <i class="fas fa-user-tie" style="margin-right:8px;"></i>{{ $empresa->representante }} · Representante Legal
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

            <!-- Quick Stats -->
            <div style="display:grid; gap:12px; flex-shrink:0;">
                <div style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.12); border-radius:16px; padding:16px 24px; text-align:center; backdrop-filter:blur(10px);">
                    <div style="font-size:32px; font-weight:900; color:white; line-height:1;">{{ $totalProyectos }}</div>
                    <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:4px;">Convocatorias</div>
                </div>
                <div style="background:rgba(62,180,137,0.2); border:1px solid rgba(62,180,137,0.3); border-radius:16px; padding:14px 24px; text-align:center;">
                    <div style="font-size:28px; font-weight:900; color:#86efac; line-height:1;">{{ $proyectosActivos }}</div>
                    <div style="font-size:10px; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; margin-top:4px;">Activas</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:28px; align-items:start;">

        <!-- Form Card -->
        <div class="glass-card" style="padding:32px;">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:28px; padding-bottom:24px; border-bottom:1.5px solid rgba(62,180,137,0.1);">
                <div style="width:48px; height:48px; border-radius:14px; background:rgba(62,180,137,0.1); color:#3eb489; display:flex; align-items:center; justify-content:center; font-size:20px;">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <h3 style="font-size:20px; font-weight:800; color:var(--text);">Información <span style="color:var(--primary);">Corporativa</span></h3>
                    <p style="font-size:13px; color:var(--text-light); font-weight:500; margin-top:2px;">Mantén tus datos actualizados para mejorar la confianza.</p>
                </div>
            </div>

            <form action="{{ route('empresa.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display:grid; gap:24px; margin-bottom:28px;">
                    <div class="form-group">
                        <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Razón Social / Nombre Comercial</label>
                        <div style="position: relative;">
                            <i class="fas fa-building" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                            <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa', $empresa->nombre) }}" required style="width: 100%; padding: 14px 16px 14px 48px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none;" placeholder="Nombre oficial de la empresa">
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="display: block; font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Representante Legal</label>
                        <div style="position: relative;">
                            <i class="fas fa-user-tie" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                            <input type="text" name="representante" value="{{ old('representante', $empresa->representante) }}" required style="width: 100%; padding: 14px 16px 14px 48px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; outline: none;" placeholder="Nombre del representante">
                        </div>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
                        <div class="form-group">
                            <label style="display: block; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">NIT (Solo Lectura)</label>
                            <div style="position: relative;">
                                <i class="fas fa-id-card" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #cbd5e1;"></i>
                                <input type="text" value="{{ $empresa->nit }}" disabled style="width: 100%; padding: 14px 16px 14px 48px; border: 1.5px dashed #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; background: #f8fafc; color: #94a3b8; outline: none;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="display: block; font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Email (Solo Lectura)</label>
                            <div style="position: relative;">
                                <i class="fas fa-envelope" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #cbd5e1;"></i>
                                <input type="email" value="{{ $empresa->correo_contacto }}" disabled style="width: 100%; padding: 14px 16px 14px 48px; border: 1.5px dashed #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; background: #f8fafc; color: #94a3b8; outline: none;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security -->
                <div style="background:#f8fafc; border:2px dashed rgba(62,180,137,0.2); border-radius:20px; padding:24px; margin-bottom:28px;">
                    <h4 style="font-size:15px; font-weight:800; color:var(--text); display:flex; align-items:center; gap:10px; margin-bottom:20px;">
                        <i class="fas fa-shield-halved" style="color:#3eb489;"></i> Seguridad de Cuenta
                    </h4>
                    <div style="position: relative;">
                        <i class="fas fa-key" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8;"></i>
                        <input type="password" name="password" placeholder="Nueva contraseña (vacío = sin cambio)" style="width: 100%; padding: 14px 16px 14px 48px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: 14px; font-weight: 600; background: white; outline: none;">
                    </div>
                    <p style="font-size:12px; color:#94a3b8; margin-top:10px; font-weight:600;"><i class="fas fa-info-circle"></i> Solo completa si deseas cambiar tu clave.</p>
                </div>

                <div style="display:flex; justify-content:flex-end;">
                    <button type="submit" class="btn-premium" style="padding:14px 40px; font-size:15px;">
                        <i class="fas fa-cloud-arrow-up"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar -->
        <div style="display:grid; gap:20px; align-content:start;">

            <!-- Contacto -->
            <div class="glass-card" style="padding:24px;">
                <h4 style="font-size:12px; font-weight:800; color:#94a3b8; text-transform:uppercase; letter-spacing:1px; margin-bottom:20px;">Puntos de Contacto</h4>
                <div style="display:grid; gap:14px;">
                    <div style="display:flex; align-items:center; gap:14px; padding:14px 16px; background:#eff6ff; border-radius:14px; border:1px solid rgba(0,0,0,0.05);">
                        <div style="width:36px; height:36px; border-radius:10px; background:rgba(59,130,246,0.1); color:#3b82f6; display:flex; align-items:center; justify-content:center; font-size:14px;">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div>
                            <span style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; display:block;">Representante</span>
                            <span style="font-size:14px; font-weight:700; color:var(--text);">{{ $empresa->representante ?: '—' }}</span>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:14px; padding:14px 16px; background:#fef2f2; border-radius:14px; border:1px solid rgba(0,0,0,0.05);">
                        <div style="width:36px; height:36px; border-radius:10px; background:rgba(239,68,68,0.1); color:#ef4444; display:flex; align-items:center; justify-content:center; font-size:14px;">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div style="min-width:0;">
                            <span style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; display:block;">Email</span>
                            <span style="font-size:13px; font-weight:700; color:var(--text); word-break:break-all;">{{ $empresa->correo_contacto }}</span>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:14px; padding:14px 16px; background:rgba(62,180,137,0.1); border-radius:14px; border:1px solid rgba(62,180,137,0.1);">
                        <div style="width:36px; height:36px; border-radius:10px; background:rgba(62,180,137,0.1); color:#3eb489; display:flex; align-items:center; justify-content:center; font-size:14px;">
                            <i class="fas fa-fingerprint"></i>
                        </div>
                        <div>
                            <span style="font-size:11px; font-weight:700; color:#94a3b8; text-transform:uppercase; display:block;">NIT</span>
                            <span style="font-size:14px; font-weight:700; color:var(--text);">{{ $empresa->nit }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Badge -->
            <div class="glass-card" style="padding:28px; background:linear-gradient(135deg, #0f172a, #1e293b); border:none; color:white; position:relative; overflow:hidden;">
                <div style="position:absolute; right:-15px; bottom:-15px; font-size:90px; color:rgba(255,255,255,0.04);"><i class="fas fa-award"></i></div>
                <div style="width:48px; height:48px; background:rgba(62,180,137,0.2); border:1px solid rgba(62,180,137,0.3); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:22px; color:#86efac; margin-bottom:16px;">
                    <i class="fas fa-medal"></i>
                </div>
                <h4 style="font-size:17px; font-weight:900; margin-bottom:8px;">Socio Verificado</h4>
                <p style="font-size:13px; color:rgba(255,255,255,0.5); line-height:1.6; font-weight:500; margin-bottom:20px;">Tu empresa está activa en la red de aliados SENA.</p>
                <div style="background:rgba(255,255,255,0.07); border:1px solid rgba(255,255,255,0.1); border-radius:12px; padding:12px 16px; text-align:center; font-size:12px; font-weight:700; color:rgba(255,255,255,0.4);">
                    <i class="fas fa-clock"></i> Insignia — Próximamente
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
