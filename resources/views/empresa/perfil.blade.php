@extends('layouts.dashboard')

@section('title', 'Perfil Empresa - Inspírate SENA')
@section('page-title', 'Perfil Corporativo')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
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
<div class="profile-container" style="max-width: 1200px; margin: 0 auto; padding-bottom: 40px;">
    
    <!-- HEADER BENTO -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 32px;">
        
        <!-- Company Info Card -->
        <div class="glass-card" style="display: flex; align-items: center; gap: 32px; padding: 40px; background: linear-gradient(135deg, #2c3e50, #1a252f); color: white; border: none;">
            <div class="company-logo-wrapper">
                <div style="width: 140px; height: 140px; border-radius: 24px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
                    <i class="fas fa-building" style="font-size: 64px; color: #fff;"></i>
                </div>
            </div>
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                    <span style="background: var(--primary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; text-transform: uppercase;">Aliado SENA</span>
                    <span style="color: rgba(255,255,255,0.6); font-size: 13px; font-weight: 500;">NIT: {{ $empresa->emp_nit }}</span>
                </div>
                <h2 style="font-size: 36px; font-weight: 800; letter-spacing: -1px;">{{ $empresa->emp_nombre }}</h2>
                <div style="display: flex; align-items: center; gap: 20px; margin-top: 16px; color: rgba(255,255,255,0.8);">
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                        <i class="fas fa-user-tie" style="color: var(--primary);"></i>
                        {{ $empresa->emp_representante }}
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 14px;">
                        <i class="fas fa-envelope" style="color: var(--primary);"></i>
                        {{ $empresa->emp_correo }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Card -->
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 32px; text-align: center; gap: 20px;">
            <div style="width: 60px; height: 60px; border-radius: 16px; background: rgba(57, 169, 0, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 24px;">
                <i class="fas fa-rocket"></i>
            </div>
            <div>
                <h4 style="font-size: 18px; font-weight: 700; color: #1e293b;">Impulsa tu Talento</h4>
                <p style="font-size: 13px; color: #64748b; margin-top: 4px;">Publica nuevas vacantes y encuentra el mejor talento SENA.</p>
            </div>
            <a href="{{ route('empresa.proyectos.crear') }}" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 12px;">
                <i class="fas fa-plus"></i> Nueva Convocatoria
            </a>
        </div>
    </div>

    <!-- MAIN FORM GRID -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        
        <!-- Editable Content -->
        <div class="glass-card" style="padding: 40px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; padding-bottom: 20px; border-bottom: 1px solid var(--border);">
                <h3 style="font-size: 20px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-edit" style="color: var(--primary);"></i> Gestión de Información
                </h3>
            </div>

            <form action="{{ route('empresa.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display: grid; gap: 24px; margin-bottom: 32px;">
                    <div class="form-group-modern">
                        <label>Nombre de la Razón Social</label>
                        <div class="input-with-icon">
                            <i class="fas fa-building"></i>
                            <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa', $empresa->emp_nombre) }}" required>
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <label>Representante Legal</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user-tie"></i>
                            <input type="text" name="representante" value="{{ old('representante', $empresa->emp_representante) }}" required>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                        <div class="form-group-modern">
                            <label>NIT (No editable)</label>
                            <div class="input-with-icon disabled">
                                <i class="fas fa-id-card"></i>
                                <input type="text" value="{{ $empresa->emp_nit }}" disabled>
                            </div>
                        </div>
                        <div class="form-group-modern">
                            <label>Correo Corporativo (No editable)</label>
                            <div class="input-with-icon disabled">
                                <i class="fas fa-envelope"></i>
                                <input type="email" value="{{ $empresa->emp_correo }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Reset -->
                <div style="background: rgba(44, 62, 80, 0.03); border: 1px dashed #cbd5e1; border-radius: 20px; padding: 24px;">
                    <h4 style="font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-lock" style="color: #64748b;"></i> Seguridad de Acceso
                    </h4>
                    <div class="form-group-modern">
                        <label>Cambiar Contraseña</label>
                        <div class="input-with-icon">
                            <i class="fas fa-key"></i>
                            <input type="password" name="password" placeholder="Ingresa una nueva contraseña para actualizar">
                        </div>
                        <p style="font-size: 12px; color: #94a3b8; margin-top: 6px;">Mínimo 6 caracteres. Deja en blanco si no deseas cambiarla.</p>
                    </div>
                </div>

                <div style="margin-top: 40px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" style="padding: 14px 40px; font-size: 16px; border-radius: 12px; height: auto;">
                        <i class="fas fa-save" style="margin-right: 10px;"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Activity -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Statistics Bento -->
            <div class="glass-card" style="padding: 24px;">
                <h4 style="font-size: 14px; font-weight: 700; color: #64748b; margin-bottom: 20px; text-transform: uppercase;">Impacto en Cifras</h4>
                
                <div style="display: grid; gap: 16px;">
                    <div style="padding: 24px; background: #f8fafc; border-radius: 16px; border: 1px solid #e2e8f0;">
                        <span style="font-size: 13px; font-weight: 600; color: #64748b; display: block; margin-bottom: 8px;">Proyectos Publicados</span>
                        <div style="display: flex; align-items: baseline; gap: 8px;">
                            <span style="font-size: 32px; font-weight: 800; color: #1e293b;">{{ $empresa->proyectos()->count() }}</span>
                            <span style="font-size: 13px; font-weight: 600; color: var(--primary);">+Vigentes</span>
                        </div>
                    </div>

                    <div style="padding: 20px; background: linear-gradient(135deg, rgba(57, 169, 0, 0.05), rgba(57, 169, 0, 0.1)); border-radius: 16px; border: 1px solid rgba(57, 169, 0, 0.1);">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <span style="font-size: 13px; font-weight: 600; color: #1a5c00;">Estado de Cuenta</span>
                                <h5 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-top: 2px;">Verificada</h5>
                            </div>
                            <i class="fas fa-check-shield" style="font-size: 24px; color: var(--primary);"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promotion Card -->
            <div class="glass-card" style="background: linear-gradient(135deg, #1e293b, #0f172a); border: none; padding: 32px; color: white;">
                <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 12px;">Reporte de Impacto</h4>
                <p style="font-size: 14px; color: rgba(255,255,255,0.7); line-height: 1.5; margin-bottom: 24px;">Descarga el reporte detallado de tus convocatorias y el talento SENA vinculado.</p>
                <button class="btn" style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); color: white; width: 100%; justify-content: center; backdrop-filter: blur(5px);">
                    <i class="fas fa-file-download"></i> Próximamente
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 32px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.02);
    }

    .form-group-modern {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group-modern label {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-left: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
        border: 1.5px solid #e2e8f0;
        background: #fff;
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        transition: all 0.3s ease;
        outline: none;
    }

    .input-with-icon input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 5px rgba(57, 169, 0, 0.1);
    }

    .input-with-icon input:focus + i {
        color: var(--primary);
    }

    .input-with-icon.disabled input {
        background: #f8fafc;
        color: #94a3b8;
        cursor: not-allowed;
        border-style: dashed;
    }

    .btn-primary {
        background: var(--primary);
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        box-shadow: 0 10px 20px rgba(57, 169, 0, 0.2);
    }
</style>
@endsection
