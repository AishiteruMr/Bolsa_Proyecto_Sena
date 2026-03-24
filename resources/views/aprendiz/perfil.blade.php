@extends('layouts.dashboard')

@section('title', 'Mi Perfil - Inspírate SENA')
@section('page-title', 'Mi Perfil')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Dashboard
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> Explorar Proyectos
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> Mis Postulaciones
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('content')
<div class="profile-container" style="max-width: 1200px; margin: 0 auto; padding-bottom: 40px;">
    
    <!-- HEADER BENTO -->
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 24px; margin-bottom: 32px;">
        
        <!-- Welcome Card -->
        <div class="glass-card" style="grid-column: span 2; display: flex; align-items: center; gap: 32px; padding: 32px; background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(240,253,244,0.95));">
            <div class="profile-avatar-wrapper" style="position: relative;">
                <div style="width: 120px; height: 120px; border-radius: 30px; background: linear-gradient(135deg, var(--primary), #2d8500); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px; font-weight: 800; transform: rotate(-3deg); box-shadow: 0 15px 35px rgba(57, 169, 0, 0.25);">
                    {{ strtoupper(substr($aprendiz->apr_nombre ?? 'A', 0, 1)) }}
                </div>
                <div style="position: absolute; bottom: -5px; right: -5px; width: 32px; height: 32px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 3px solid #f0fdf4; color: var(--primary); font-size: 14px; box-shadow: var(--shadow-sm);">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div>
                <span style="font-size: 14px; font-weight: 600; color: var(--primary); text-transform: uppercase; letter-spacing: 1px;">Aprendiz SENA</span>
                <h2 style="font-size: 32px; font-weight: 800; color: #1e293b; margin-top: 4px;">Hola, {{ $aprendiz->apr_nombre }}!</h2>
                <p style="color: #64748b; font-size: 15px; margin-top: 8px;">Gestiona tu información académica y las credenciales de tu cuenta desde aquí.</p>
            </div>
        </div>

        <!-- Training Program Card -->
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between; padding: 32px; background: #fff; border-left: 6px solid var(--primary);">
            <div>
                <i class="fas fa-graduation-cap" style="font-size: 24px; color: var(--primary); margin-bottom: 16px;"></i>
                <h4 style="font-size: 14px; font-weight: 700; color: #64748b; text-transform: uppercase;">Programa</h4>
                <p style="font-size: 20px; font-weight: 700; color: #1e293b; margin-top: 4px; line-height: 1.3;">{{ $aprendiz->apr_programa }}</p>
            </div>
            <div style="margin-top: 16px;">
                <span class="badge badge-success">En Formación</span>
            </div>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        
        <!-- Editable Info -->
        <div class="glass-card" style="padding: 40px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; padding-bottom: 20px; border-bottom: 1px solid var(--border);">
                <h3 style="font-size: 20px; font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 12px;">
                    <i class="fas fa-user-edit" style="color: var(--primary);"></i> Datos Personales
                </h3>
            </div>

            <form action="{{ route('aprendiz.perfil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <div class="form-group-modern">
                        <label>Nombres</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="nombre" value="{{ old('nombre', $aprendiz->apr_nombre) }}" required>
                        </div>
                    </div>
                    <div class="form-group-modern">
                        <label>Apellidos</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="apellido" value="{{ old('apellido', $aprendiz->apr_apellido) }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group-modern" style="margin-bottom: 24px;">
                    <label>Programa de Formación</label>
                    <div class="input-with-icon">
                        <i class="fas fa-graduation-cap"></i>
                        <input type="text" name="programa" value="{{ old('programa', $aprendiz->apr_programa) }}" required>
                    </div>
                </div>

                <div class="form-group-modern" style="margin-bottom: 40px;">
                    <label>Correo Institucional (No editable)</label>
                    <div class="input-with-icon disabled">
                        <i class="fas fa-envelope"></i>
                        <input type="email" value="{{ $usuario->usr_correo }}" disabled>
                    </div>
                </div>

                <!-- Security Section -->
                <div style="background: var(--bg); border: 1px solid var(--border); border-radius: 20px; padding: 24px;">
                    <h4 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-shield-alt" style="color: #64748b;"></i> Seguridad
                    </h4>
                    <div class="form-group-modern">
                        <label>Nueva Contraseña (Opcional)</label>
                        <div class="input-with-icon password">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Mínimo 6 caracteres (deja vacío si no deseas cambiar)">
                        </div>
                    </div>
                </div>

                <div style="margin-top: 40px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" style="padding: 14px 40px; font-size: 16px; border-radius: 12px; height: auto;">
                        <i class="fas fa-sync-alt" style="margin-right: 10px;"></i> Actualizar Mi Perfil
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Bento -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Quick Stats -->
            <div class="glass-card" style="padding: 24px;">
                <h4 style="font-size: 15px; font-weight: 700; color: #64748b; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px;">Tu Actividad</h4>
                
                <div style="display: grid; gap: 16px;">
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: var(--bg); border-radius: 16px; border: 1px solid var(--border);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(57, 169, 0, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <span style="font-size: 14px; font-weight: 600; color: #64748b;">Postulaciones</span>
                        </div>
                        <span style="font-size: 20px; font-weight: 800; color: #1e293b;">{{ $aprendiz->postulaciones()->count() }}</span>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: var(--bg); border-radius: 16px; border: 1px solid var(--border);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(14, 165, 233, 0.1); color: #0ea5e9; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span style="font-size: 14px; font-weight: 600; color: #64748b;">Proyectos OK</span>
                        </div>
                        <span style="font-size: 20px; font-weight: 800; color: #1e293b;">{{ $aprendiz->postulacionesAprobadas()->count() }}</span>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: var(--bg); border-radius: 16px; border: 1px solid var(--border);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <span style="font-size: 14px; font-weight: 600; color: #64748b;">Evidencias</span>
                        </div>
                        <span style="font-size: 20px; font-weight: 800; color: #1e293b;">{{ $aprendiz->evidencias()->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="glass-card" style="padding: 32px; background: var(--primary); color: white; border: none; overflow: hidden; position: relative;">
                <div style="position: absolute; top: -20px; right: -20px; font-size: 120px; color: rgba(255,255,255,0.1); transform: rotate(15deg);">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 12px; position: relative; z-index: 1;">¿Necesitas ayuda?</h4>
                <p style="font-size: 14px; color: rgba(255,255,255,0.8); margin-bottom: 24px; line-height: 1.5; position: relative; z-index: 1;">Si tienes problemas con tu información institucional, contacta a la coordinación de tu programa.</p>
                <a href="#" style="background: white; color: var(--primary); padding: 12px 24px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 800; display: inline-block; position: relative; z-index: 1;">
                    Contactar Soporte
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        transition: transform 0.3s ease;
    }

    .form-group-modern {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group-modern label {
        font-size: 14px;
        font-weight: 700;
        color: #64748b;
        margin-left: 4px;
    }

    .input-with-icon {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-with-icon i {
        position: absolute;
        left: 16px;
        color: #94a3b8;
        font-size: 16px;
        transition: color 0.3s ease;
    }

    .input-with-icon input {
        width: 100%;
        padding: 14px 16px 14px 48px;
        border-radius: 14px;
        border: 2px solid #e2e8f0;
        background: #fff;
        font-size: 15px;
        font-weight: 500;
        color: #1e293b;
        transition: all 0.3s ease;
        outline: none;
    }

    .input-with-icon input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(57, 169, 0, 0.1);
    }

    .input-with-icon input:focus + i {
        color: var(--primary);
    }

    .input-with-icon.disabled input {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border: none;
        box-shadow: 0 4px 12px rgba(57, 169, 0, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(57, 169, 0, 0.4);
    }
</style>
@endsection
