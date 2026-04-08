@extends('layouts.app')

@section('title', 'Registro Instructor')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth_forms.css') }}">
<style>
    .form-hint {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        color: #64748b;
        margin-top: 4px;
        font-weight: 500;
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
        max-width: 220px;
        white-space: normal;
        z-index: 100;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .input-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    @media (max-width: 640px) {
        .input-row { grid-template-columns: 1fr; }
    }
    .password-requirements {
        background: #f8fafc;
        border-radius: 8px;
        padding: 12px;
        margin-top: 8px;
        font-size: 11px;
        color: #64748b;
    }
    .password-requirements li {
        margin: 4px 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .password-requirements li.valid { color: #22c55e; }
    .password-requirements li.valid i { color: #22c55e; }
</style>
@endsection

@section('content')
<main class="auth-main">
<div class="registro-container">
    <a href="{{ route('home') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Volver al inicio</a>
    <div class="reg-header">
        <img src="{{ asset('assets/logo.png') }}" alt="SENA">
        <h2>Registro Instructor</h2>
    </div>

    @if($errors->any())
        <div class="error-msg">@foreach($errors->all() as $e){{ $e }}<br>@endforeach</div>
    @endif

    <form action="{{ route('registro.instructor.post') }}" method="POST">
        @csrf
        <div class="input-row">
            <div class="form-group input-icon">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Nombres completos" required>
                <div class="form-hint">
                    <i class="fas fa-info-circle hint-icon" data-hint="Nombres tal como aparecen en tu documento de identidad"></i>
                    Ej: María del Pilar
                </div>
            </div>
            <div class="form-group input-icon">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Apellidos completos" required>
                <div class="form-hint">
                    <i class="fas fa-info-circle hint-icon" data-hint="Ambos apellidos"></i>
                    Ej: Rodríguez Mendoza
                </div>
            </div>
        </div>
        <div class="form-group input-icon">
            <i class="fa-solid fa-id-card"></i>
            <input type="text" name="documento" value="{{ old('documento') }}" placeholder="Número de documento (CC)" required>
            <div class="form-hint">
                <i class="fas fa-info-circle hint-icon" data-hint="Número sin puntos ni comas. Mínimo 8 dígitos."></i>
                Cédula de ciudadanía
            </div>
        </div>
        <div class="form-group input-icon">
            <i class="fa-solid fa-chalkboard-user"></i>
            <input type="text" name="especialidad" value="{{ old('especialidad') }}" placeholder="Área de especialización SENA" required>
            <div class="form-hint">
                <i class="fas fa-info-circle hint-icon" data-hint="Área técnica o profesional en la que te especializas"></i>
                Ej: Desarrollo de Software, Electricidad, Mecánica
            </div>
        </div>
        <div class="form-group input-icon">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="correo" value="{{ old('correo') }}" placeholder="Correo electrónico institucional" required>
            <div class="form-hint">
                <i class="fas fa-info-circle hint-icon" data-hint="Correo del SENA o institucional activo"></i>
                Recibirás un enlace de verificación
            </div>
        </div>
        <div class="form-group input-icon">
            <i class="fa-solid fa-lock"></i>
            <input type="password" id="password" name="password" placeholder="Contraseña" required>
            <div class="password-requirements" id="passwordReq" style="display: none;">
                La contraseña debe tener:
                <ul style="list-style: none; padding: 0; margin: 8px 0 0;">
                    <li id="req-length"><i class="fas fa-circle"></i> Mínimo 8 caracteres</li>
                    <li id="req-upper"><i class="fas fa-circle"></i> Al menos una mayúscula</li>
                    <li id="req-lower"><i class="fas fa-circle"></i> Al menos una minúscula</li>
                    <li id="req-number"><i class="fas fa-circle"></i> Al menos un número</li>
                </ul>
            </div>
        </div>
        <div class="form-group input-icon">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="terminos" name="terminos" required>
            <label for="terminos">Acepto los <a href="#" style="color: var(--primary);">Términos y Condiciones</a></label>
        </div>
        <button type="submit" class="btn-registro">Registrarse</button>
    </form>
    <p class="link-text">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia Sesión</a></p>
</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const passwordReq = document.getElementById('passwordReq');
    
    passwordInput.addEventListener('focus', function() {
        passwordReq.style.display = 'block';
    });
    
    passwordInput.addEventListener('input', function() {
        const val = this.value;
        
        document.getElementById('req-length').className = val.length >= 8 ? 'valid' : '';
        document.getElementById('req-length').querySelector('i').className = val.length >= 8 ? 'fas fa-check-circle' : 'fas fa-circle';
        
        document.getElementById('req-upper').className = /[A-Z]/.test(val) ? 'valid' : '';
        document.getElementById('req-upper').querySelector('i').className = /[A-Z]/.test(val) ? 'fas fa-check-circle' : 'fas fa-circle';
        
        document.getElementById('req-lower').className = /[a-z]/.test(val) ? 'valid' : '';
        document.getElementById('req-lower').querySelector('i').className = /[a-z]/.test(val) ? 'fas fa-check-circle' : 'fas fa-circle';
        
        document.getElementById('req-number').className = /\d/.test(val) ? 'valid' : '';
        document.getElementById('req-number').querySelector('i').className = /\d/.test(val) ? 'fas fa-check-circle' : 'fas fa-circle';
    });
});
</script>
@endsection
