@extends('layouts.dashboard')

@section('title', 'Mi Perfil - Inspírate SENA')
@section('page-title', 'Perfil de Instructor')

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

@section('content')
<div class="profile-container" style="max-width: 1200px; margin: 0 auto; padding-bottom: 40px;">
    
    <!-- HEADER BENTO -->
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px; margin-bottom: 32px;">
        
        <!-- Mentor Profile Card -->
        <div class="glass-card" style="grid-column: span 2; display: flex; align-items: center; gap: 40px; padding: 40px; background: linear-gradient(135deg, #0f766e, #115e59); color: white; border: none;">
            <div class="profile-image-wrapper">
                <div style="width: 130px; height: 130px; border-radius: 50%; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 4px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 56px; font-weight: 800; box-shadow: 0 20px 40px rgba(0,0,0,0.2);">
                    {{ strtoupper(substr($instructor->ins_nombre ?? 'I', 0, 1)) }}
                </div>
            </div>
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                    <span style="background: var(--primary); color: white; padding: 4px 14px; border-radius: 30px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Instructor Líder</span>
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
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: center; padding: 32px; gap: 24px; background: #fff;">
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
        <div class="glass-card" style="padding: 40px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px;">
                <h3 style="font-size: 20px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-id-badge" style="color: var(--primary);"></i> Perfil Profesional
                </h3>
            </div>

            <form action="{{ route('instructor.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <div class="form-group-modern">
                        <label>Nombres</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user-tag"></i>
                            <input type="text" name="nombre" value="{{ old('nombre', $instructor->ins_nombre) }}" required>
                        </div>
                    </div>
                    <div class="form-group-modern">
                        <label>Apellidos</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user-tag"></i>
                            <input type="text" name="apellido" value="{{ old('apellido', $instructor->ins_apellido) }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group-modern" style="margin-bottom: 24px;">
                    <label>Especialidad / Área de Influencia</label>
                    <div class="input-with-icon">
                        <i class="fas fa-graduation-cap"></i>
                        <input type="text" name="especialidad" value="{{ old('especialidad', $instructor->ins_especialidad) }}" required>
                    </div>
                </div>

                <div class="form-group-modern" style="margin-bottom: 40px;">
                    <label>Correo Electrónico (Solo Lectura)</label>
                    <div class="input-with-icon disabled">
                        <i class="fas fa-envelope-open"></i>
                        <input type="email" value="{{ $usuario->usr_correo }}" disabled>
                    </div>
                </div>

                <!-- Account Security -->
                <div style="padding: 32px; background: #f0fdfa; border: 1.5px solid #ccfbf1; border-radius: 24px;">
                    <h4 style="font-size: 16px; font-weight: 800; color: #115e59; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-key"></i> Parámetros de Seguridad
                    </h4>
                    <div class="form-group-modern">
                        <label>Actualizar Contraseña</label>
                        <div class="input-with-icon">
                            <i class="fas fa-shield-alt"></i>
                            <input type="password" name="password" placeholder="Define una nueva contraseña segura">
                        </div>
                        <p style="font-size: 13px; color: #64748b; margin-top: 8px;">Mantén este campo vacío para conservar tu contraseña actual.</p>
                    </div>
                </div>

                <div style="margin-top: 40px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" style="padding: 16px 48px; font-size: 16px; border-radius: 14px; background: #0f766e; height: auto;">
                        <i class="fas fa-check-circle" style="margin-right: 12px;"></i> Actualizar Información
                    </button>
                </div>
            </form>
        </div>

        <!-- Performance Stats -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <div class="glass-card" style="padding: 24px;">
                <h4 style="font-size: 14px; font-weight: 700; color: #64748b; margin-bottom: 24px; text-transform: uppercase;">Métricas de Seguimiento</h4>
                
                <div style="display: grid; gap: 20px;">
                    <div class="stat-row">
                        <div class="stat-info">
                            <div class="stat-icon" style="background: rgba(15, 118, 110, 0.1); color: #0f766e;"><i class="fas fa-project-diagram"></i></div>
                            <span style="font-size: 14px; font-weight: 600; color: #475569;">Proyectos Liderados</span>
                        </div>
                        <span class="stat-number">{{ \App\Models\Proyecto::where('ins_id', $instructor->usr_id)->count() }}</span>
                    </div>

                    <div class="stat-row">
                        <div class="stat-info">
                            <div class="stat-icon" style="background: rgba(57, 169, 0, 0.1); color: var(--primary);"><i class="fas fa-user-graduate"></i></div>
                            <span style="font-size: 14px; font-weight: 600; color: #475569;">Aprendices a Cargo</span>
                        </div>
                        <span class="stat-number">{{ \App\Models\Aprendiz::count() }}</span>
                    </div>

                    <div class="stat-row">
                        <div class="stat-info">
                            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;"><i class="fas fa-clipboard-check"></i></div>
                            <span style="font-size: 14px; font-weight: 600; color: #475569;">Revisiones Pendientes</span>
                        </div>
                        <span class="stat-number">3</span>
                    </div>
                </div>
            </div>

            <!-- Profile Completion -->
            <div class="glass-card" style="padding: 32px; background: #fff; border: 1.5px solid var(--border);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <span style="font-size: 14px; font-weight: 700; color: #1e293b;">Integridad de Perfil</span>
                    <span style="font-size: 14px; font-weight: 800; color: var(--primary);">100%</span>
                </div>
                <div style="height: 10px; background: #f1f5f9; border-radius: 5px; overflow: hidden; margin-bottom: 20px;">
                    <div style="width: 100%; height: 100%; background: var(--primary); border-radius: 5px;"></div>
                </div>
                <p style="font-size: 13px; color: #64748b; line-height: 1.4;">Tu perfil profesional está al día. Esto garantiza que los aprendices y empresas puedan identificar tu área de competencia rápidamente.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .glass-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 32px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.01);
    }

    .form-group-modern {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .form-group-modern label {
        font-size: 14px;
        font-weight: 700;
        color: #475569;
        padding-left: 4px;
    }

    .input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-with-icon i {
        position: absolute;
        left: 20px;
        color: #94a3b8;
        font-size: 18px;
        transition: color 0.3s;
    }

    .input-with-icon input {
        width: 100%;
        padding: 16px 20px 16px 56px;
        border-radius: 18px;
        border: 2px solid #f1f5f9;
        background: #f8fafc;
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        transition: all 0.3s ease;
        outline: none;
    }

    .input-with-icon input:focus {
        border-color: #0f766e;
        background: #fff;
        box-shadow: 0 0 0 5px rgba(15, 118, 110, 0.1);
    }

    .input-with-icon input:focus + i {
        color: #0f766e;
    }

    .input-with-icon.disabled input {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
        border-style: dashed;
    }

    .stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        border-radius: 16px;
        transition: background 0.3s;
    }

    .stat-row:hover {
        background: #f8fafc;
    }

    .stat-info {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .stat-number {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(15, 118, 110, 0.25);
    }
</style>
@endsection
