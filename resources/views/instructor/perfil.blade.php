@extends('layouts.dashboard')

@section('title', 'Mi Perfil')
@section('page-title', 'Mi Perfil')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos', 'instructor.proyecto.detalle', 'instructor.evidencias.ver', 'instructor.reporte') ? 'active' : '' }}">
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
        <i class="fas fa-user-circle"></i> Perfil
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 32px;">
        <h2 style="font-size:26px; font-weight:700; color:var(--primary-dark)">Mi Perfil</h2>
        <p style="color:var(--text-muted); font-size:15px; margin-top:4px;">Actualiza tu información profesional y gestiona tu cuenta.</p>
    </div>

    @if(session('success'))
        <div class="glass-card" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2); color: #065f46; padding: 1rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 12px;">
            <i class="fas fa-check-circle" style="font-size: 1.25rem;"></i>
            <span style="font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; align-items: flex-start;">
        
        <!-- TARJETA DE PERFIL (VISTA) -->
        <div class="glass-card" style="padding: 2.5rem; text-align: center;">
            <div style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 700; margin: 0 auto 1.5rem; box-shadow: 0 10px 20px rgba(41, 133, 100, 0.2);">
                {{ strtoupper(substr($instructor->ins_nombre ?? 'I', 0, 1)) }}
            </div>
            <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem;">{{ $instructor->ins_nombre ?? '' }} {{ $instructor->ins_apellido ?? '' }}</h3>
            <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">{{ $usuario->usr_correo ?? '' }}</p>
            
            <div style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background: var(--bg-main); border-radius: 30px; border: 1px solid var(--border); color: var(--primary); font-weight: 600; font-size: 0.85rem;">
                <i class="fas fa-chalkboard-teacher"></i>
                {{ $instructor->ins_especialidad ?? 'Sin especialidad' }}
            </div>

            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border); text-align: left;">
                <h4 style="font-size: 0.9rem; font-weight: 700; color: var(--text-main); margin-bottom: 1rem;">Estadísticas Rápidas</h4>
                <div style="display: grid; gap: 12px;">
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem;">
                        <span style="color: var(--text-muted);">Proyectos Activos</span>
                        <span style="font-weight: 600; color: var(--primary);">{{ $instructor->proyectos_count ?? '0' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- FORMULARIO DE EDICIÓN -->
        <div class="glass-card" style="padding: 2.5rem;">
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 2rem; display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-user-edit"></i>
                Editar Información Personal
            </h3>

            <form action="{{ route('instructor.perfil.update') }}" method="POST" style="display: grid; gap: 1.5rem;">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--text-main);">Nombres</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $instructor->ins_nombre ?? '') }}" required class="form-input" style="padding: 0.75rem; width: 100%;">
                    </div>
                    <div class="form-group">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--text-main);">Apellidos</label>
                        <input type="text" name="apellido" value="{{ old('apellido', $instructor->ins_apellido ?? '') }}" required class="form-input" style="padding: 0.75rem; width: 100%;">
                    </div>
                </div>

                <div class="form-group">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--text-main);">Especialidad / Área Técnica</label>
                    <input type="text" name="especialidad" value="{{ old('especialidad', $instructor->ins_especialidad ?? '') }}" required class="form-input" style="padding: 0.75rem; width: 100%;">
                </div>

                <div class="form-group">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--text-main);">Correo Institucional</label>
                    <input type="email" value="{{ $usuario->usr_correo ?? '' }}" disabled class="form-input" style="padding: 0.75rem; width: 100%; background: var(--bg-main); cursor: not-allowed; color: var(--text-muted);">
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 6px;"><i class="fas fa-info-circle"></i> El correo electrónico está vinculado a tu cuenta SENA y no puede modificarse.</p>
                </div>

                <div style="margin-top: 1rem; padding: 1.5rem; background: var(--bg-main); border-radius: var(--radius-sm); border: 1px solid var(--border);">
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--primary-dark); margin-bottom: 1.25rem; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-shield-alt"></i>
                        Seguridad de la Cuenta
                    </h4>
                    <div class="form-group">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px; color: var(--text-main);">Nueva Contraseña</label>
                        <input type="password" name="password" placeholder="Mínimo 6 caracteres" class="form-input" style="padding: 0.75rem; width: 100%;">
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 6px;">Deja este campo vacío si no deseas cambiar tu contraseña actual.</p>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 1rem;">
                    <button type="submit" class="btn-ver" style="width: auto; padding: 0.75rem 2.5rem;">
                        <i class="fas fa-save" style="margin-right: 8px;"></i> Actualizar Perfil
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .form-input {
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
            transition: border-color .3s;
        }
        .form-input:focus {
            border-color: var(--primary);
        }
    </style>
@endsection
