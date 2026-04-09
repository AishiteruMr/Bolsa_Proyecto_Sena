@extends('layouts.app')

@section('title', 'Registro Empresa')
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
        <div class="login-brand">
            <div class="brand-header">
                <img src="{{ asset('assets/logo.png') }}" alt="SENA">
                <span>Inspírate<br>SENA</span>
            </div>
            
            <div class="brand-quote">
                <h2>Regístrate como <span style="color: var(--primary-light);">Empresa</span></h2>
                <p>Únete a nuestra red de empresas y conecta con talentosos aprendices del SENA.</p>
            </div>

            <div class="brand-features">
                <div class="brand-feature">
                    <i class="fas fa-building"></i>
                    <span>Talento Calificado</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-user-graduate"></i>
                    <span>Aprendices SENA</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-handshake"></i>
                    <span>Alianzas Estratégicas</span>
                </div>
            </div>

            <div class="brand-footer">
                Bolsa de Proyectos & Talentos
            </div>
        </div>

        <div class="login-content">
            <div class="content-header">
                <h3>Crear Cuenta</h3>
                <p>Ingresa los datos de tu empresa para comenzar.</p>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error) <span>{{ $error }}</span><br> @endforeach
                </div>
            @endif

            <form action="{{ route('registro.empresa.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nombre de la Empresa</label>
                    <div class="input-wrapper">
                        <i class="fas fa-building"></i>
                        <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa') }}" placeholder="Nombre de la empresa" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>NIT</label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card"></i>
                        <input type="text" name="nit" value="{{ old('nit') }}" placeholder="Número de identificación" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Representante Legal</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user-tie"></i>
                        <input type="text" name="representante" value="{{ old('representante') }}" placeholder="Nombre completo" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="correo" value="{{ old('correo') }}" placeholder="correo@empresa.com" required>
                    </div>
                </div>

                <div class="input-row">
                    <div class="form-group">
                        <label>Contraseña</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" placeholder="Mín. 6 caracteres" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirmar</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password_confirmation" placeholder="Confirmar" required>
                        </div>
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