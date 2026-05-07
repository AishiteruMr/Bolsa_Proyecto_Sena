@extends('layouts.app')

@section('title', 'Registro Instructor')
@section('styles')
@vite(['resources/css/login.css'])
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
                <img src="{{ asset('assets/logo.webp') }}" alt="SENA">
                <span>Inspírate<br>SENA</span>
            </div>
            
            <div class="brand-quote">
                <h2>¡Guía el <span style="color: #4ADE80;">Futuro!</span></h2>
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

        <div class="login-brand login-brand-show">
            <div class="brand-header">
                <img src="{{ asset('assets/logo.webp') }}" alt="SENA">
                <span>Inspírate<br>SENA</span>
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
                        <label>Nombre <i class="fas fa-question-circle hint-icon" data-hint="Como aparece en tu documento de identidad"></i></label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Tu nombre" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Apellidos <i class="fas fa-question-circle hint-icon" data-hint="Como aparece en tu documento de identidad"></i></label>
                        <div class="input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Tus apellidos" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Documento de Identidad <i class="fas fa-question-circle hint-icon" data-hint="Cédula de ciudadanía (sin puntos ni guión)"></i></label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card"></i>
                        <input type="text" name="documento" value="{{ old('documento') }}" placeholder="Número de documento" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Especialización SENA <i class="fas fa-question-circle hint-icon" data-hint="Área en la que teachas: Desarrollo de Software, Electricidad, Mecánica, etc."></i></label>
                    <div class="input-wrapper">
                        <i class="fas fa-chalkboard-user"></i>
                        <input type="text" name="especialidad" value="{{ old('especialidad') }}" placeholder="Área de especialización" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Correo Electrónico <i class="fas fa-question-circle hint-icon" data-hint="Correo institucional o personal activo"></i></label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="correo" value="{{ old('correo') }}" placeholder="tu@email.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Contraseña <i class="fas fa-question-circle hint-icon" data-hint="Mínimo 6 caracteres, usa letras y números"></i></label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Mín. 6 caracteres" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirmar Contraseña <i class="fas fa-question-circle hint-icon" data-hint="Debe ser idéntica a la contraseña"></i></label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="terminos" name="terminos" required>
                        <label for="terminos">Acepto los Términos y Condiciones</label>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Crear Cuenta</button>
            </form>

            <div class="divider">¿Ya tienes cuenta?</div>

            <a href="{{ route('login') }}" class="btn-submit" style="text-decoration: none;">
                Iniciar Sesión
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@vite(['resources/js/login.js'])
@endsection