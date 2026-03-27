@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-page-wrapper">
    <a href="{{ route('home') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Volver al Inicio
    </a>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="login-container">
        <!-- Left: Branding -->
        <div class="login-brand">
            <div class="brand-header">
                <img src="{{ asset('assets/logo.png') }}" alt="SENA">
                <span>Inspírate<br>SENA</span>
            </div>
            
            <div class="brand-quote">
                <h2>Impulsa <span style="color: var(--primary-light);">Ideas</span>,<br>Cosecha <span style="color: var(--primary-light);">Éxitos</span>.</h2>
                <p>"La innovación es el camino que transforma el conocimiento en soluciones reales para el mundo."</p>
            </div>

            <div class="brand-footer">
                Bolsa de Proyectos & Talentos v2.0
            </div>
        </div>

        <!-- Right: Login Flow -->
        <div class="login-content">
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
            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error) <span>{{ $error }}</span><br> @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="correo" value="{{ old('correo') }}" placeholder="tucorreo@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Contraseña</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="••••••••" required>
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
