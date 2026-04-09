@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
<style>
    .form-hint {
        font-size: 11px;
        color: #64748b;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .hint-icon {
        color: var(--primary, #3eb489);
        cursor: help;
        position: relative;
    }
    .hint-icon:hover::after {
        content: attr(data-hint);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #1a1a2e;
        color: #fff;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
        max-width: 250px;
        white-space: normal;
        z-index: 100;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .resend-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 12px;
        font-size: 12px;
        color: var(--primary, #3eb489);
        text-decoration: none;
        font-weight: 600;
    }
    .resend-link:hover {
        text-decoration: underline;
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

    <div class="login-container" style="max-width: 1100px;">
        <div class="login-brand">
            <div class="brand-header">
                <img src="{{ asset('assets/logo.png') }}" alt="SENA">
                <span>Inspírate<br>SENA</span>
            </div>
            
            <div class="brand-quote">
                <h2>Impulsa <span style="color: var(--primary-light);"> Ideas</span>,<br>Cosecha <span style="color: var(--primary-light);">Éxitos</span>.</h2>
                <p>"La innovación es el camino que transforma el conocimiento en soluciones reales para el mundo."</p>
            </div>

            <div class="brand-features">
                <div class="brand-feature">
                    <i class="fas fa-rocket"></i>
                    <span>Proyectos Innovadores</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-handshake"></i>
                    <span>Red de Contactos</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-chart-line"></i>
                    <span>Seguimiento Profesional</span>
                </div>
            </div>

            <div class="brand-footer">
                Bolsa de Proyectos & Talentos v2.0
            </div>
        </div>

        <div class="login-content" style="padding: 64px;">
            <div class="content-header">
                <h3>Bienvenido de nuevo</h3>
                <p>Ingresa tus credenciales para continuar.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success"> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error"> {{ session('error') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-info" style="background: #eff6ff; border-color: #3b82f6; color: #1e40af;"> {{ session('info') }}
                    <form action="{{ route('verification.resend') }}" method="POST" style="margin-top: 8px;">
                        @csrf
                        <input type="hidden" name="correo" value="{{ old('correo') }}">
                        <button type="submit" class="resend-link">
                            <i class="fas fa-paper-plane"></i> Reenviar enlace de verificación
                        </button>
                    </form>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error) <span>{{ $error }}</span><br> @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>
                        Correo Electrónico
                        <i class="fas fa-info-circle hint-icon" data-hint="Correo con el que te registraste en la plataforma" style="margin-left: 4px;"></i>
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="correo" value="{{ old('correo') }}" placeholder="tucorreo@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>
                        Contraseña
                        <i class="fas fa-info-circle hint-icon" data-hint="Mínimo 8 caracteres, con mayúsculas, minúsculas y números" style="margin-left: 4px;"></i>
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                    <div class="form-hint">
                        <i class="fas fa-shield-alt" style="color: #64748b;"></i>
                        Tu información está protegida
                    </div>
                </div>

                <a href="{{ route('auth.olvide-contraseña') }}" class="forgot-link">¿Olvidaste tu contraseña?</a>

                <button type="submit" class="btn-submit">
                    Entrar al Portal <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                </button>
            </form>

            <div class="divider">ó regístrate como</div>

            <div class="role-grid">
                <a href="{{ route('registro.aprendiz') }}" class="role-card">
                    <i class="fas fa-user-graduate"></i>
                    <span>Aprendiz</span>
                </a>
                <a href="{{ route('registro.instructor') }}" class="role-card">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Instructor</span>
                </a>
                <a href="{{ route('registro.empresa') }}" class="role-card">
                    <i class="fas fa-building"></i>
                    <span>Empresa</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/login.js') }}"></script>
@endsection