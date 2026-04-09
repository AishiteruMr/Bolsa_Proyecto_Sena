@extends('layouts.app')

@section('title', 'Registro Instructor')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<style>
    .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 600px) { .input-row { grid-template-columns: 1fr; } }
    .form-hint { font-size: 11px; color: #64748b; margin-top: 4px; display: flex; align-items: center; gap: 4px; }
    .hint-icon { color: var(--primary); cursor: help; position: relative; }
    .hint-icon:hover::after {
        content: attr(data-hint);
        position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%);
        background: #1a2e1a; color: #fff; padding: 8px 12px; border-radius: 8px;
        font-size: 11px; font-weight: 500; white-space: nowrap; z-index: 100;
    }
</style>
@endsection

@section('content')
<div class="login-page-wrapper">
    <a href="{{ route('home') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Volver al Inicio
    </a>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="login-container">
        <div class="login-brand">
            <div class="brand-header">
                <img src="{{ asset('assets/logo.png') }}" alt="SENA">
                <span>Inspírate<br>SENA</span>
            </div>
            
            <div class="brand-quote">
                <h2>¡Guía el <span style="color: var(--primary-light);">Futuro!</span></h2>
                <p>Lidera proyectos con aprendices y conecta con empresas.</p>
            </div>

            <div class="brand-features">
                <div class="brand-feature">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Mentoría de Talento</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-project-diagram"></i>
                    <span>Gestión de Proyectos</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-network-wired"></i>
                    <span>Red Empresarial</span>
                </div>
            </div>

            <div class="brand-footer">
                Bolsa de Proyectos & Talentos
            </div>
        </div>

        <div class="login-content">
            <div class="content-header">
                <h3>Registro Instructor</h3>
                <p>Crea tu cuenta de instructor</p>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error) <span>{{ $error }}</span><br> @endforeach
                </div>
            @endif

            <form action="{{ route('registro.instructor.post') }}" method="POST">
                @csrf
                <div class="input-row">
                    <div class="form-group">
                        <label>Nombre</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Tu nombre" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Apellidos</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Tus apellidos" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Documento de Identidad</label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card"></i>
                        <input type="text" name="documento" value="{{ old('documento') }}" placeholder="Número de documento" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Especialización SENA</label>
                    <div class="input-wrapper">
                        <i class="fas fa-chalkboard-user"></i>
                        <input type="text" name="especialidad" value="{{ old('especialidad') }}" placeholder="Área de especialización" required>
                    </div>
                    <div class="form-hint">Ej: Desarrollo de Software, Electricidad</div>
                </div>

                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="correo" value="{{ old('correo') }}" placeholder="tu@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Mín. 6 caracteres" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirmar Contraseña</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
                    </div>
                </div>

                <div class="form-group">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" id="terminos" name="terminos" required style="width: 16px; height: 16px; accent-color: var(--primary);">
                        <label for="terminos" style="margin: 0; font-size: 13px; color: var(--text-light);">Acepto los Términos y Condiciones</label>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Crear Cuenta</button>
            </form>

            <div class="divider">¿Ya tienes cuenta?</div>

            <a href="{{ route('login') }}" class="btn-submit" style="text-align: center; text-decoration: none;">
                Iniciar Sesión
            </a>
        </div>
    </div>
</div>
@endsection