@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('styles')
<style>
    /* Estilos específicos para la página de login */
    main {
        background: linear-gradient(135deg, #0d3a00 0%, #1a5c00 40%, #39a900 100%);
        min-height: calc(100vh - 68px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .login-wrapper {
        display: flex;
        max-width: 950px;
        width: 100%;
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 80px rgba(0,0,0,.35);
    }

    .login-form {
        flex: 1;
        padding: 52px 44px;
    }

    .form-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .form-header img {
        width: 68px;
        margin-bottom: 14px;
    }

    .form-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1a5c00;
        margin-bottom: 4px;
    }

    .form-header p {
        font-size: 13px;
        color: #666;
    }

    .form-group {
        position: relative;
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i.icon-left {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 15px;
    }

    .input-icon input {
        width: 100%;
        padding: 14px 16px 14px 46px;
        border: 2px solid #e8edf0;
        border-radius: 12px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        outline: none;
        transition: all .2s;
    }

    .input-icon input:focus {
        border-color: #39a900;
        box-shadow: 0 0 0 4px rgba(57,169,0,0.1);
    }

    .btn-login-form {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #39a900, #2d8500);
        color: #fff;
        border: none;
        border-radius: 30px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 12px;
        transition: all .3s;
        box-shadow: 0 4px 15px rgba(57,169,0,0.3);
    }

    .btn-login-form:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(57,169,0,0.4);
    }

    .links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        margin-top: 20px;
        color: #666;
    }

    .links a {
        color: #39a900;
        font-weight: 500;
    }

    .links a:hover {
        text-decoration: underline;
    }

    .divider {
        text-align: center;
        color: #ccc;
        font-size: 12px;
        margin: 24px 0;
        position: relative;
    }

    .divider::before,
    .divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 38%;
        height: 1px;
        background: #e8edf0;
    }

    .divider::before {
        left: 0;
    }

    .divider::after {
        right: 0;
    }

    .register-options {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .reg-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 18px;
        border: 2px solid #e8edf0;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 500;
        transition: all .2s;
        cursor: pointer;
        text-decoration: none;
        color: #2c3e50;
    }

    .reg-btn:hover {
        border-color: #39a900;
        background: #f0fbe8;
        transform: translateX(4px);
    }

    .reg-btn i {
        font-size: 18px;
        width: 22px;
        text-align: center;
    }

    .login-message {
        width: 380px;
        background: linear-gradient(180deg, #0d3a00, #1a5c00, #2d8500);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 48px 36px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .login-message::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .login-message .quote {
        color: rgba(255,255,255,.95);
        font-size: 16px;
        line-height: 1.8;
        font-style: italic;
        margin-bottom: 32px;
        z-index: 1;
        position: relative;
    }

    .login-message .team {
        color: rgba(255,255,255,.7);
        font-size: 12px;
        z-index: 1;
        position: relative;
    }

    .back-link {
        position: absolute;
        top: 20px;
        left: 20px;
        color: rgba(255,255,255,.7);
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .back-link:hover {
        color: #fff;
    }

    .input-error {
        border-color: #e74c3c !important;
    }

    .error-message {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 4px;
    }

    @media (max-width: 700px) {
        .login-message {
            display: none;
        }

        .login-form {
            padding: 36px 24px;
        }

        .login-wrapper {
            border-radius: 16px;
        }
    }
</style>
@endsection

@section('content')
<div class="login-wrapper">
    <div class="login-form">
        <div class="form-header">
            <img src="{{ asset('assets/logo.png') }}" alt="SENA">
            <h2>Bolsa de Proyecto</h2>
            <p>Inicia sesión en tu cuenta</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="background:#d4edda; color:#155724; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:13px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error" style="background:#f8d7da; color:#721c24; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:13px;">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div style="background:#f8d7da; color:#721c24; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:13px;">
                @foreach($errors->all() as $error){{ $error }}<br>@endforeach
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Correo electrónico</label>
                <div class="input-icon">
                    <i class="fa-solid fa-envelope icon-left"></i>
                    <input type="email" name="correo" value="{{ old('correo') }}" placeholder="tucorreo@email.com" required>
                </div>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <div class="input-icon">
                    <i class="fa-solid fa-lock icon-left"></i>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login-form">Iniciar Sesión</button>
        </form>

        <div class="links">
            <a href="{{ route('auth.olvide-contraseña') }}"><i class="fas fa-key"></i> ¿Olvidaste tu contraseña?</a>
            <a href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Volver al inicio</a>
        </div>

        <div class="divider">¿No tienes cuenta? Regístrate como</div>

        <div class="register-options">
            <a href="{{ route('registro.aprendiz') }}" class="reg-btn">
                <i class="fas fa-graduation-cap" style="color:#39a900;"></i> Aprendiz
            </a>
            <a href="{{ route('registro.instructor') }}" class="reg-btn">
                <i class="fas fa-chalkboard-teacher" style="color:#2980b9;"></i> Instructor
            </a>
            <a href="{{ route('registro.empresa') }}" class="reg-btn">
                <i class="fas fa-building" style="color:#8e44ad;"></i> Empresa
            </a>
        </div>
    </div>

    <div class="login-message">
        <img src="{{ asset('assets/logo.png') }}" alt="SENA" style="width:80px; margin-bottom:24px; border-radius:50%; background:rgba(255,255,255,.2); padding:8px;">
        <p class="quote">
            "Cada proyecto que nace aquí tiene el poder de transformar ideas en realidades.
            Tu talento, conocimiento y sueños tienen un propósito."
        </p>
        <div class="team">
            <strong style="color:#fff; font-size:14px;">Equipo Adso-10</strong><br>
            SENA — Inspírate SENA
        </div>
    </div>
</div>
@endsection
