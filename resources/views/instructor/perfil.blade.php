@extends('layouts.dashboard')

@section('title', 'Mi Perfil - ' . ($instructor->ins_nombre ?? 'Instructor'))
@section('page-title', 'Perfil de ' . ($instructor->ins_nombre ?? 'Instructor'))

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
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
<div class="animate-fade-in" style="max-width: 1200px; margin: 0 auto; padding-bottom: 40px;">
    
    <!-- HEADER BENTO -->
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px; margin-bottom: 32px;">
        
        <!-- Mentor Profile Card -->
        <div class="instructor-profile-mentor-card glass-card">
            <div class="profile-image-wrapper">
                <div class="instructor-profile-avatar-lg">
                    {{ strtoupper(substr($instructor->ins_nombre ?? 'I', 0, 1)) }}
                </div>
            </div>
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <span class="instructor-tag">Instructor Líder</span>
                    <span style="color: rgba(255,255,255,0.6); font-size: 14px; font-weight: 500;"><i class="fas fa-envelope" style="margin-right: 6px;"></i>{{ $usuario->usr_correo }}</span>
                </div>
                <h2 style="font-size: 34px; font-weight: 800; letter-spacing: -0.5px;">{{ $instructor->ins_nombre }} {{ $instructor->ins_apellido }}</h2>
                <div style="margin-top: 16px; display: flex; align-items: center; gap: 12px; font-size: 15px; background: rgba(255,255,255,0.1); width: fit-content; padding: 8px 16px; border-radius: 12px;">
                    <i class="fas fa-award" style="color: var(--primary-light);"></i>
                    <span style="font-weight: 600;">Especialidad: {{ $instructor->ins_especialidad }}</span>
                </div>
            </div>
        </div>

        <!-- Role Breakdown -->
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: center; padding: 32px; gap: 24px; background: #fff; border-radius: var(--radius);">
            <div>
                <h4 style="font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Disponibilidad</h4>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 12px; height: 12px; border-radius: 50%; background: #10b981; box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);"></div>
                    <span style="font-size: 16px; font-weight: 700; color: #1e293b;">Activo en Plataforma</span>
                </div>
            </div>
            <div style="padding-top: 16px; border-top: 1px solid var(--border);">
                <span style="font-size: 13px; color: #64748b; font-weight: 500;">Rol Administrativo</span>
                <p style="font-size: 15px; font-weight: 700; color: #0f766e; margin-top: 4px;">Gestión de Proyectos & Aprendices</p>
            </div>
        </div>
    </div>

    <!-- CONTENT GRID -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        
        <!-- Main Management Form -->
        <div class="glass-card" style="padding: 40px; border-radius: var(--radius);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
                <h3 style="font-size: 20px; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-id-badge" style="color: var(--primary);"></i> Perfil Profesional
                </h3>
            </div>

            <form action="{{ route('instructor.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div class="instructor-form-group">
                        <label style="font-size: 14px; font-weight: 700; color: #475569;">Nombres</label>
                        <div class="instructor-input-wrapper">
                            <i class="fas fa-user-tag instructor-input-icon"></i>
                            <input type="text" name="nombre" value="{{ old('nombre', $instructor->ins_nombre) }}" required class="instructor-input-control">
                        </div>
                    </div>
                    <div class="instructor-form-group">
                        <label style="font-size: 14px; font-weight: 700; color: #475569;">Apellidos</label>
                        <div class="instructor-input-wrapper">
                            <i class="fas fa-user-tag instructor-input-icon"></i>
                            <input type="text" name="apellido" value="{{ old('apellido', $instructor->ins_apellido) }}" required class="instructor-input-control">
                        </div>
                    </div>
                </div>

                <div class="instructor-form-group">
                    <label style="font-size: 14px; font-weight: 700; color: #475569;">Especialidad / Área de Influencia</label>
                    <div class="instructor-input-wrapper">
                        <i class="fas fa-graduation-cap instructor-input-icon"></i>
                        <input type="text" name="especialidad" value="{{ old('especialidad', $instructor->ins_especialidad) }}" required class="instructor-input-control">
                    </div>
                </div>

                <div class="instructor-form-group" style="margin-bottom: 40px;">
                    <label style="font-size: 14px; font-weight: 700; color: #475569;">Correo Electrónico (Solo Lectura)</label>
                    <div class="instructor-input-wrapper">
                        <i class="fas fa-envelope-open instructor-input-icon"></i>
                        <input type="email" value="{{ $usuario->usr_correo }}" disabled class="instructor-input-control" style="background: #f1f5f9; color: #94a3b8; cursor: not-allowed; border-style: dashed;">
                    </div>
                </div>

                <!-- Account Security -->
                <div style="padding: 32px; background: #f0fdfa; border: 1.5px solid #ccfbf1; border-radius: 24px;">
                    <h4 style="font-size: 16px; font-weight: 800; color: #115e59; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-key"></i> Parámetros de Seguridad
                    </h4>
                    <div class="instructor-form-group" style="margin-bottom: 0;">
                        <label style="font-size: 14px; font-weight: 700; color: #475569;">Actualizar Contraseña</label>
                        <div class="instructor-input-wrapper">
                            <i class="fas fa-shield-alt instructor-input-icon"></i>
                            <input type="password" name="password" placeholder="Define una nueva contraseña segura" class="instructor-input-control">
                        </div>
                        <p style="font-size: 13px; color: #64748b; margin-top: 8px; font-weight: 500;">Mantén este campo vacío para conservar tu contraseña actual.</p>
                    </div>
                </div>

                <div style="margin-top: 40px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn-instructor-save">
                        <i class="fas fa-check-circle"></i> Actualizar Información
                    </button>
                </div>
            </form>
        </div>

        <!-- Performance Stats -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <div class="glass-card" style="padding: 24px;">
                <h4 style="font-size: 14px; font-weight: 700; color: #64748b; margin-bottom: 24px; text-transform: uppercase;">Métricas de Seguimiento</h4>
                
                <div style="display: grid; gap: 20px;">
                    <div class="instructor-stat-row">
                        <div class="stat-info">
                            <div class="stat-icon" style="background: rgba(15, 118, 110, 0.1); color: #0f766e;"><i class="fas fa-project-diagram"></i></div>
                            <span style="font-size: 14px; font-weight: 700; color: #475569;">Proyectos Liderados</span>
                        </div>
                        <span class="stat-number">{{ $proyectosCount }}</span>
                    </div>

                    <div class="stat-row instructor-stat-row">
                        <div class="stat-info">
                            <div class="stat-icon" style="background: rgba(57, 169, 0, 0.1); color: var(--primary);"><i class="fas fa-user-graduate"></i></div>
                            <span style="font-size: 14px; font-weight: 700; color: #475569;">Aprendices a Cargo</span>
                        </div>
                        <span class="stat-number">{{ $aprendicesCount }}</span>
                    </div>

                    <div class="stat-row instructor-stat-row">
                        <div class="stat-info">
                            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;"><i class="fas fa-clipboard-check"></i></div>
                            <span style="font-size: 14px; font-weight: 700; color: #475569;">Revisiones Pendientes</span>
                        </div>
                        <span class="stat-number">{{ $evidenciasPendientesCount }}</span>
                    </div>
                </div>
            </div>

            <!-- Profile Completion -->
            @php
                $camposCompletos = 0;
                if(!empty($instructor->ins_nombre)) $camposCompletos++;
                if(!empty($instructor->ins_apellido)) $camposCompletos++;
                if(!empty($instructor->ins_especialidad)) $camposCompletos++;
                if(!empty($usuario->usr_correo)) $camposCompletos++;
                $progresoPerfil = ($camposCompletos / 4) * 100;
            @endphp
            <div class="glass-card" style="padding: 32px; background: #fff; border: 1.5px solid var(--border);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <span style="font-size: 14px; font-weight: 700; color: #1e293b;">Integridad de Perfil</span>
                    <span style="font-size: 14px; font-weight: 800; color: var(--primary);">{{ round($progresoPerfil) }}%</span>
                </div>
                <div style="height: 10px; background: #f1f5f9; border-radius: 5px; overflow: hidden; margin-bottom: 20px;">
                    <div style="width: {{ $progresoPerfil }}%; height: 100%; background: var(--primary); border-radius: 5px; transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);"></div>
                </div>
                <p style="font-size: 13px; color: #64748b; line-height: 1.4;">{{ $progresoPerfil == 100 ? 'Tu perfil profesional está al día. Esto garantiza que los aprendices y empresas puedan identificar tu área de competencia rápidamente.' : 'Completa todos tus datos para mejorar tu visibilidad en la plataforma.' }}</p>
            </div>
        </div>
    </div>
</div>

@endsection
