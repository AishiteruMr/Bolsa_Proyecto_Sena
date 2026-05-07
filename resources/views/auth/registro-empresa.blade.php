@extends('layouts.app')

@section('title', 'Registro Empresa')
@section('styles')
@vite(['resources/css/register.css'])
<style>
    .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 600px) { .input-row { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="register-page-wrapper">
    <a href="{{ route('home') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Volver al Inicio
    </a>

    <div class="register-container">
        <div class="register-brand">
            <div class="brand-header">
                <img src="{{ asset('assets/logo.webp') }}" alt="SENA">
                <span>Inspírate<br>SENA</span>
            </div>
             
            <div class="brand-quote">
                <h2>Regístrate como <span style="color: #4ADE80;">Empresa</span></h2>
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
                Bolsa de Proyectos &amp; Talentos
            </div>
        </div>

        <div class="register-content">
            <div class="content-header">
                <h3>Crear Cuenta</h3>
                <p>Ingresa los datos de tu empresa para comenzar.</p>
            </div>

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error) <span>{{ $error }}</span><br> @endforeach
                </div>
            @endif

            <form action="{{ route('registro.empresa.post') }}" method="POST" id="registroForm">
                @csrf
                
                <!-- Paso 1: Información de la empresa -->
                <div class="form-step active" data-step="1">
                    <h4 class="step-title">Paso 1: Información de la empresa</h4>
                    <div class="form-group">
                        <label>Nombre de la Empresa <i class="fas fa-question-circle hint-icon" data-hint="Nombre oficial de tu empresa según documento legal"></i></label>
                        <div class="input-wrapper">
                            <i class="fas fa-building"></i>
                            <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa') }}" placeholder="Nombre de la empresa" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>NIT <i class="fas fa-question-circle hint-icon" data-hint="Número de Identificación Tributaria (sin puntos ni guión)"></i></label>
                        <div class="input-wrapper">
                            <i class="fas fa-id-card"></i>
                            <input type="text" name="nit" value="{{ old('nit') }}" placeholder="Número de identificación" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Representante Legal <i class="fas fa-question-circle hint-icon" data-hint="Nombre completo del representante legal"></i></label>
                        <div class="input-wrapper">
                            <i class="fas fa-user-tie"></i>
                            <input type="text" name="representante" value="{{ old('representante') }}" placeholder="Nombre completo" required>
                        </div>
                    </div>
                </div>

                <!-- Paso 2: Información de contacto -->
                <div class="form-step" data-step="2">
                    <h4 class="step-title">Paso 2: Información de contacto</h4>
                    <div class="form-group">
                        <label>Correo Electrónico <i class="fas fa-question-circle hint-icon" data-hint="Correo institucional o empresarial activo"></i></label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope"></i>
                            <input type="email" name="correo" value="{{ old('correo') }}" placeholder="correo@empresa.com" required>
                        </div>
                    </div>

                    <div class="input-row">
                        <div class="form-group">
                            <label>Contraseña <i class="fas fa-question-circle hint-icon" data-hint="Mínimo 6 caracteres"></i></label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" placeholder="Mín. 6 caracteres" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Confirmar <i class="fas fa-question-circle hint-icon" data-hint="Debe ser idéntica a la contraseña"></i></label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password_confirmation" placeholder="Confirmar" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 3: Términos y finalización -->
                <div class="form-step" data-step="3">
                    <h4 class="step-title">Paso 3: Términos y condiciones</h4>
                    <div class="form-group">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <input type="checkbox" id="terminos" name="terminos" required style="width: 16px; height: 16px; accent-color: var(--primary);">
                            <label for="terminos" style="margin:0; font-size: 13px; color: var(--text-light);">Acepto los Términos y Condiciones</label>
                        </div>
                    </div>
                </div>

                <!-- Indicador de pasos (solo móvil) -->
                <div class="step-indicators">
                    <span class="step-dot active" data-step="1"></span>
                    <span class="step-dot" data-step="2"></span>
                    <span class="step-dot" data-step="3"></span>
                </div>

                <!-- Botones de navegación (solo móvil) -->
                <div class="step-navigation">
                    <button type="button" class="btn-prev" style="display:none;"><i class="fas fa-arrow-left"></i> Anterior</button>
                    <button type="button" class="btn-next">Siguiente <i class="fas fa-arrow-right"></i></button>
                    <button type="submit" class="btn-submit" style="display:none;">Crear Cuenta</button>
                </div>

                <!-- Botón submit para desktop -->
                <button type="submit" class="btn-submit desktop-submit">Crear Cuenta</button>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const desktopSubmit = document.querySelector('.desktop-submit');
    if (window.innerWidth <= 640) {
        if (desktopSubmit) desktopSubmit.style.display = 'none';
    } else {
        return;
    }
    
    const form = document.getElementById('registroForm');
    const steps = form.querySelectorAll('.form-step');
    const dots = form.querySelectorAll('.step-dot');
    const btnPrev = form.querySelector('.btn-prev');
    const btnNext = form.querySelector('.btn-next');
    const btnSubmit = form.querySelector('.step-navigation .btn-submit');
    let currentStep = 1;
    
    function showStep(step) {
        steps.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));
        
        form.querySelector('.form-step[data-step="' + step + '"]').classList.add('active');
        form.querySelector('.step-dot[data-step="' + step + '"]').classList.add('active');
        
        btnPrev.style.display = step === 1 ? 'none' : 'block';
        btnNext.style.display = step === steps.length ? 'none' : 'block';
        btnSubmit.style.display = step === steps.length ? 'block' : 'none';
        
        currentStep = step;
    }
    
    btnNext.addEventListener('click', function() {
        if (currentStep < steps.length) {
            showStep(currentStep + 1);
        }
    });
    
    btnPrev.addEventListener('click', function() {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    });
    
    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            showStep(parseInt(this.dataset.step));
        });
    });
    
    showStep(1);
});
</script>
@endsection