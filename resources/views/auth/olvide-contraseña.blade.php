@extends('layouts.app')

@section('title', '¿Olvidaste tu Contraseña?')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth_forms.css') }}">
@endsection

@section('content')
<main class="auth-main">
    <div class="registro-container" style="max-width: 420px;">
        <a href="{{ route('login') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Volver al inicio</a>

        <div class="reg-header">
            <h2 style="font-size: 24px;">🔐 Recuperar Contraseña</h2>
            <p style="color: var(--text-light); font-size: 14px; margin-top: 8px;">Ingresa tu correo para recibir el enlace.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error') || $errors->any())
            <div class="alert alert-error" style="margin-bottom: 20px;">
                {{ session('error') ?: $errors->first() }}
            </div>
        @endif

        <div style="background: var(--primary-soft); border-left: 4px solid var(--primary); padding: 15px; border-radius: 12px; margin-bottom: 24px; font-size: 13px; color: var(--text); line-height: 1.6;">
            <strong>📧 ¿Olvidaste tu contraseña?</strong><br>
            Te enviaremos un enlace para restablecer tu contraseña. El enlace expirará en 30 minutos.
        </div>

        <form action="{{ route('auth.enviar-recuperacion') }}" method="POST">
            @csrf
            <div class="form-group input-icon">
                <i class="fas fa-envelope"></i>
                <input type="email" name="correo" placeholder="tu@correo.com" required value="{{ old('correo') }}">
            </div>

            <button type="submit" class="btn-registro" style="margin-top: 10px;">
                🔗 Enviar Enlace de Recuperación
            </button>
        </form>

        <div class="link-text">
            ¿Recordaste tu contraseña? 
            <a href="{{ route('login') }}">Inicia sesión aquí</a>
        </div>
    </div>
</main>
@endsection
