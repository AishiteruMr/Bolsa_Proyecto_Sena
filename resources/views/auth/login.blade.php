@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('styles')
<style>
    main {
        background: linear-gradient(135deg, #0f4a41 0%, #1b6b5f 40%, #4a9b8d 100%);
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 20px;
        position: relative;
        overflow: hidden;
    }

    main::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    main::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: -50px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .login-wrapper {
        display: flex;
        max-width: 1000px;
        width: 100%;
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 30px 80px rgba(15, 74, 65, 0.3);
        z-index: 1;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-form {
        flex: 1;
        padding: 56px 48px;
    }

    .form-header {
        text-align: center;
        margin-bottom: 36px;
    }

    .form-header img {
        width: 64px;
        height: 64px;
        margin-bottom: 16px;
        animation: fadeIn 0.6s ease-out;
    }

    .form-header h2 {
        font-size: 28px;
        font-weight: 800;
        color: #0f2419;
        margin-bottom: 4px;
        letter-spacing: -0.5px;
    }

    .form-header p {
        font-size: 14px;
        color: #999;
        font-weight: 500;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 13px;
        border-left: 4px solid;
        animation: slideDown 0.4s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: #ecf7f3;
        color: #0f4a41;
        border-left-color: #1b6b5f;
    }

    .alert-error {
        background: #fef0f0;
        color: #c0392b;
        border-left-color: #e74c3c;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
        letter-spacing: 0.3px;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i.icon-left {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #bbb;
        font-size: 16px;
        transition: color .3s;
    }

    .input-icon input {
        width: 100%;
        padding: 12px 14px 12px 44px;
        border: 2px solid #e8e8e8;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        outline: none;
        transition: all .3s ease;
        background: #fafafa;
    }

    .input-icon input:focus {
        border-color: #1b6b5f;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(27, 107, 95, 0.1);
    }

    .input-icon input:focus + i {
        color: #1b6b5f;
    }

    .btn-login-form {
        width: 100%;
        padding: 13px;
        background: linear-gradient(135deg, #1b6b5f 0%, #0f4a41 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 8px;
        transition: all .3s ease;
        box-shadow: 0 4px 15px rgba(27, 107, 95, 0.25);
        letter-spacing: 0.3px;
    }

    .btn-login-form:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(27, 107, 95, 0.35);
    }

    .btn-login-form:active {
        transform: translateY(0);
    }

    .links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        margin-top: 20px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .links a {
        color: #1b6b5f;
        font-weight: 600;
        transition: color .2s;
        text-decoration: none;
    }

    .links a:hover {
        color: #0f4a41;
    }

    .divider {
        text-align: center;
        color: #ccc;
        font-size: 12px;
        margin: 28px 0;
        position: relative;
        font-weight: 600;
    }

    .divider::before,
    .divider::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 36%;
        height: 1px;
        background: #e8e8e8;
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
        padding: 12px 16px;
        border: 2px solid #e8e8e8;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: all .3s ease;
        cursor: pointer;
        text-decoration: none;
        color: #1a1a1a;
        background: #fafafa;
    }

    .reg-btn:hover {
        border-color: #1b6b5f;
        background: #f0f9f7;
        transform: translateX(4px);
    }

    .reg-btn i {
        font-size: 18px;
        width: 24px;
        text-align: center;
    }

    .login-message {
        width: 380px;
        background: linear-gradient(180deg, #0f4a41 0%, #1b6b5f 50%, #4a9b8d 100%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 56px 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .login-message::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .login-message img {
        width: 80px;
        height: 80px;
        margin-bottom: 28px;
        border-radius: 50%;
        background: rgba(255,255,255,.15);
        padding: 8px;
        z-index: 1;
        position: relative;
    }

    .login-message .quote {
        color: rgba(255,255,255,.95);
        font-size: 16px;
        line-height: 1.8;
        font-style: italic;
        margin-bottom: 36px;
        z-index: 1;
        position: relative;
        font-weight: 500;
    }

    .login-message .team {
        color: rgba(255,255,255,.8);
        font-size: 12px;
        z-index: 1;
        position: relative;
        line-height: 1.6;
    }

    .login-message .team strong {
        display: block;
        font-size: 14px;
        margin-bottom: 4px;
        font-weight: 700;
    }

    @media (max-width: 800px) {
        .login-message {
            display: none;
        }

        .login-form {
            padding: 40px 30px;
        }

        .login-wrapper {
            border-radius: 12px;
        }

        .form-header h2 {
            font-size: 24px;
        }

        main {
            padding: 20px;
            min-height: auto;
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
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
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
                <i class="fas fa-graduation-cap" style="color:#1b6b5f;"></i> Aprendiz
            </a>
            <a href="{{ route('registro.instructor') }}" class="reg-btn">
                <i class="fas fa-chalkboard-teacher" style="color:#1b6b5f;"></i> Instructor
            </a>
            <a href="{{ route('registro.empresa') }}" class="reg-btn">
                <i class="fas fa-building" style="color:#1b6b5f;"></i> Empresa
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
