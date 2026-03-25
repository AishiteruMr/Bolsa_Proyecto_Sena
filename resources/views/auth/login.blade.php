@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
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
