@extends('layouts.app')

@section('title', '¿Olvidaste tu Contraseña?')

@section('styles')
@vitebuilt
@vite(['resources/css/auth_forms.css'])
@endvitebuilt
<style>
    .auth-main {
        background: radial-gradient(ellipse at top left, #0d1a0d 0%, #051005 50%, #0a150a 100%),
                    radial-gradient(circle at 80% 20%, rgba(62,180,137,0.12) 0%, transparent 40%),
                    radial-gradient(circle at 20% 80%, rgba(62,180,137,0.08) 0%, transparent 35%);
    }
    .auth-main::before {
        display: none;
    }
    .recovery-info {
        background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 16px 18px;
        margin-bottom: 24px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .recovery-info i {
        color: #22c55e;
        font-size: 18px;
        margin-top: 1px;
        flex-shrink: 0;
    }
    .recovery-info-content {
        font-size: 13px;
        color: #166534;
        line-height: 1.6;
    }
    .recovery-info-content strong {
        display: block;
        font-weight: 700;
        margin-bottom: 2px;
    }
    .reg-header h2 i {
        color: var(--primary);
        margin-right: 8px;
    }
    .reg-header .subtitle {
        color: var(--text-light);
        font-size: 14px;
        margin-top: 8px;
        font-weight: 400;
    }
    .btn-registro i {
        margin-right: 8px;
    }
    .alert {
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert i {
        font-size: 16px;
        flex-shrink: 0;
    }
    .alert-success {
        background: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }
    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .back-btn i {
        font-size: 12px;
    }
</style>
@endsection

@section('content')
<main class="auth-main">
    <div class="registro-container" style="max-width: 420px;">
        <a href="{{ route('login') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Volver al inicio de sesión
        </a>

        <div class="reg-header">
            <h2><i class="fas fa-lock"></i> ¿Olvidaste tu contraseña?</h2>
            <p class="subtitle">Ingresa tu correo para recibir el enlace de recuperación.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error') || $errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') ?: $errors->first() }}
            </div>
        @endif

        <div class="recovery-info">
            <i class="fas fa-info-circle"></i>
            <div class="recovery-info-content">
                <strong>Te enviaremos un enlace seguro</strong>
                El enlace expirará en 30 minutos. Si no lo ves en tu bandeja de entrada, revisa la carpeta de spam.
            </div>
        </div>

        <form action="{{ route('auth.enviar-recuperacion') }}" method="POST">
            @csrf
            <div class="form-group input-icon">
                <i class="fas fa-envelope"></i>
                <input type="email" name="correo" placeholder="tu@correo.com" required value="{{ old('correo') }}">
            </div>

            <button type="submit" class="btn-registro">
                <i class="fas fa-paper-plane"></i> Enviar Enlace de Recuperación
            </button>
        </form>

        <div class="link-text">
            ¿Recordaste tu contraseña?
            <a href="{{ route('login') }}">Inicia sesión aquí</a>
        </div>
    </div>
</main>
@endsection
