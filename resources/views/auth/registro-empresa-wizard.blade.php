@extends('layouts.app')

@section('title', 'Registro Empresa')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth_forms.css') }}">
<style>
    .wizard-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .wizard-progress {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        position: relative;
    }
    
    .wizard-progress::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 40px;
        right: 40px;
        height: 4px;
        background: #e2e8f0;
        border-radius: 2px;
        z-index: 0;
    }
    
    .wizard-progress-bar {
        position: absolute;
        top: 20px;
        left: 40px;
        height: 4px;
        background: var(--primary, #3eb489);
        border-radius: 2px;
        z-index: 1;
        transition: width 0.3s ease;
    }
    
    .wizard-step {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }
    
    .wizard-step-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 16px;
        color: #94a3b8;
        transition: all 0.3s ease;
    }
    
    .wizard-step.active .wizard-step-circle {
        border-color: var(--primary, #3eb489);
        color: var(--primary, #3eb489);
        background: rgba(62, 180, 137, 0.1);
    }
    
    .wizard-step.completed .wizard-step-circle {
        background: var(--primary, #3eb489);
        border-color: var(--primary, #3eb489);
        color: #fff;
    }
    
    .wizard-step-label {
        font-size: 12px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .wizard-step.active .wizard-step-label,
    .wizard-step.completed .wizard-step-label {
        color: var(--primary, #3eb489);
    }
    
    .wizard-card {
        background: #fff;
        border-radius: 24px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    .wizard-card-title {
        font-size: 24px;
        font-weight: 800;
        color: #1a1a2e;
        margin-bottom: 8px;
    }
    
    .wizard-card-subtitle {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 32px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 8px;
    }
    
    .form-input {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 500;
        transition: all 0.2s;
        outline: none;
    }
    
    .form-input:focus {
        border-color: var(--primary, #3eb489);
        box-shadow: 0 0 0 3px rgba(62, 180, 137, 0.15);
    }
    
    .form-input.error {
        border-color: #ef4444;
    }
    
    .error-text {
        font-size: 12px;
        color: #ef4444;
        margin-top: 4px;
        font-weight: 500;
    }
    
    .wizard-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 32px;
        gap: 16px;
    }
    
    .btn-wizard {
        padding: 14px 28px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-wizard-back {
        background: #f1f5f9;
        color: #64748b;
    }
    
    .btn-wizard-back:hover {
        background: #e2e8f0;
    }
    
    .btn-wizard-next {
        background: var(--primary, #3eb489);
        color: #fff;
    }
    
    .btn-wizard-next:hover {
        background: #2d9a75;
        transform: translateY(-1px);
    }
    
    .btn-wizard-submit {
        background: #22c55e;
        color: #fff;
    }
    
    .btn-wizard-submit:hover {
        background: #16a34a;
    }
    
    .btn-wizard:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }
    
    .wizard-footer {
        text-align: center;
        margin-top: 24px;
        font-size: 14px;
        color: #64748b;
    }
    
    .wizard-footer a {
        color: var(--primary, #3eb489);
        font-weight: 700;
        text-decoration: none;
    }
    
    .step-content {
        display: none;
    }
    
    .step-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .progress-dots {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 24px;
    }
    
    .progress-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #e2e8f0;
        transition: all 0.3s;
    }
    
    .progress-dot.active {
        background: var(--primary, #3eb489);
        transform: scale(1.2);
    }
    
    .progress-dot.completed {
        background: var(--primary, #3eb489);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    
    @media (max-width: 640px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        
        .wizard-card {
            padding: 24px;
        }
        
        .wizard-step-label {
            font-size: 10px;
        }
    }
</style>
@endsection

@section('content')
<main class="auth-main">
<div class="wizard-container">
    <a href="{{ route('home') }}" class="back-btn" style="margin-bottom: 24px;">
        <i class="fas fa-arrow-left"></i> Volver al inicio
    </a>
    
    <div class="wizard-card">
        <div class="wizard-progress">
            <div class="wizard-progress-bar" id="progressBar" style="width: 0%;"></div>
            
            <div class="wizard-step active" data-step="1">
                <div class="wizard-step-circle">1</div>
                <span class="wizard-step-label">Empresa</span>
            </div>
            
            <div class="wizard-step" data-step="2">
                <div class="wizard-step-circle">2</div>
                <span class="wizard-step-label">Representante</span>
            </div>
            
            <div class="wizard-step" data-step="3">
                <div class="wizard-step-circle">3</div>
                <span class="wizard-step-label">Cuenta</span>
            </div>
        </div>

        @if($errors->any())
            <div class="error-msg" style="margin-bottom: 24px; padding: 16px; background: #fef2f2; border-radius: 12px; border-left: 4px solid #ef4444;">
                @foreach($errors->all() as $e)
                    <p style="margin: 4px 0; color: #dc2626; font-size: 14px;">{{ $e }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('registro.empresa.post') }}" method="POST" id="wizardForm">
            @csrf
            
            <input type="hidden" name="current_step" id="currentStep" value="1">
            
            <div class="step-content active" data-step="1">
                <h2 class="wizard-card-title">Datos de la Empresa</h2>
                <p class="wizard-card-subtitle">Ingresa la información básica de tu organización.</p>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-building"></i> Nombre de la Empresa
                        <span class="hint-icon" data-hint="Razón social oficial de tu empresa"><i class="fas fa-question-circle"></i></span>
                    </label>
                    <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa') }}" class="form-input @error('nombre_empresa') error @enderror" placeholder="Ej: Tecnología Avanzada S.A.S." required>
                    @error('nombre_empresa')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-id-card"></i> NIT
                        <span class="hint-icon" data-hint="Número de Identificación Tributaria sin guiones"><i class="fas fa-question-circle"></i></span>
                    </label>
                    <input type="text" name="nit" value="{{ old('nit') }}" class="form-input @error('nit') error @enderror" placeholder="Ej: 901234567890" required>
                    @error('nit')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-tag"></i> Categoría
                        <span class="hint-icon" data-hint="Sector al que pertenece tu empresa"><i class="fas fa-question-circle"></i></span>
                    </label>
                    <select name="categoria" class="form-input">
                        <option value="">Seleccionar categoría</option>
                        <option value="tecnologia">Tecnología</option>
                        <option value="ingenieria">Ingeniería</option>
                        <option value="salud">Salud</option>
                        <option value="educacion">Educación</option>
                        <option value="comercio">Comercio</option>
                        <option value="manufactura">Manufactura</option>
                        <option value="servicios">Servicios</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
            </div>
            
            <div class="step-content" data-step="2">
                <h2 class="wizard-card-title">Representante Legal</h2>
                <p class="wizard-card-subtitle">Datos de quien representa legalmente a la empresa.</p>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user-tie"></i> Nombre Completo
                        <span class="hint-icon" data-hint="Nombre y apellidos tal como aparecen en el documento de identidad"><i class="fas fa-question-circle"></i></span>
                    </label>
                    <input type="text" name="representante" value="{{ old('representante') }}" class="form-input @error('representante') error @enderror" placeholder="Ej: María García López" required>
                    @error('representante')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-phone"></i> Teléfono de Contacto
                        <span class="hint-icon" data-hint="Número celular o fijo donde podemos contactarte"><i class="fas fa-question-circle"></i></span>
                    </label>
                    <input type="tel" name="telefono" value="{{ old('telefono') }}" class="form-input" placeholder="Ej: 3001234567">
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-map-marker-alt"></i> Dirección
                        <span class="hint-icon" data-hint="Dirección completa de sede principal"><i class="fas fa-question-circle"></i></span>
                    </label>
                    <input type="text" name="direccion" value="{{ old('direccion') }}" class="form-input" placeholder="Ej: Calle 100 #15-20, Bogotá">
                </div>
            </div>
            
            <div class="step-content" data-step="3">
                <h2 class="wizard-card-title">Credenciales de Acceso</h2>
                <p class="wizard-card-subtitle">Crea tu cuenta para administrar tus proyectos.</p>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i> Correo Electrónico
                        <span class="hint-icon" data-hint="Correo institucional o comercial"><i class="fas fa-question-circle"></i></span>
                    </label>
                    <input type="email" name="correo" value="{{ old('correo') }}" class="form-input @error('correo') error @enderror" placeholder="Ej: contacto@empresa.com" required>
                    @error('correo')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Contraseña
                            <span class="hint-icon" data-hint="Mínimo 8 caracteres, debe incluir mayúsculas, minúsculas y números"><i class="fas fa-question-circle"></i></span>
                        </label>
                        <input type="password" name="password" class="form-input @error('password') error @enderror" placeholder="Mínimo 8 caracteres" required>
                        @error('password')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Confirmar Contraseña
                        </label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="Repite la contraseña" required>
                    </div>
                </div>
                
                <div class="form-group" style="margin-top: 24px;">
                    <label style="display: flex; align-items: flex-start; gap: 12px; cursor: pointer;">
                        <input type="checkbox" name="terminos" required style="width: 20px; height: 20px; margin-top: 2px; accent-color: var(--primary, #3eb489);">
                        <span style="font-size: 13px; color: #64748b; line-height: 1.5;">
                            Acepto los <a href="#" style="color: var(--primary, #3eb489);">Términos y Condiciones</a> 
                            y la <a href="#" style="color: var(--primary, #3eb489);">Política de Privacidad</a>
                        </span>
                    </label>
                </div>
            </div>

            <div class="wizard-buttons">
                <button type="button" class="btn-wizard btn-wizard-back" id="btnBack" style="visibility: hidden;">
                    <i class="fas fa-arrow-left"></i> Anterior
                </button>
                <button type="button" class="btn-wizard btn-wizard-next" id="btnNext">
                    Siguiente <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            
            <div class="progress-dots">
                <div class="progress-dot active" data-step="1"></div>
                <div class="progress-dot" data-step="2"></div>
                <div class="progress-dot" data-step="3"></div>
            </div>
        </form>
    </div>
    
    <div class="wizard-footer">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia Sesión</a>
    </div>
</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 3;
    const form = document.getElementById('wizardForm');
    const btnNext = document.getElementById('btnNext');
    const btnBack = document.getElementById('btnBack');
    const progressBar = document.getElementById('progressBar');
    const currentStepInput = document.getElementById('currentStep');
    
    function updateUI() {
        document.querySelectorAll('.wizard-step').forEach((step, index) => {
            const stepNum = index + 1;
            step.classList.remove('active', 'completed');
            if (stepNum === currentStep) {
                step.classList.add('active');
            } else if (stepNum < currentStep) {
                step.classList.add('completed');
                step.querySelector('.wizard-step-circle').innerHTML = '<i class="fas fa-check"></i>';
            } else {
                step.querySelector('.wizard-step-circle').textContent = stepNum;
            }
        });
        
        document.querySelectorAll('.step-content').forEach(content => {
            content.classList.remove('active');
            if (parseInt(content.dataset.step) === currentStep) {
                content.classList.add('active');
            }
        });
        
        document.querySelectorAll('.progress-dot').forEach(dot => {
            dot.classList.remove('active', 'completed');
            const dotStep = parseInt(dot.dataset.step);
            if (dotStep === currentStep) {
                dot.classList.add('active');
            } else if (dotStep < currentStep) {
                dot.classList.add('completed');
            }
        });
        
        progressBar.style.width = ((currentStep - 1) / (totalSteps - 1) * 100) + '%';
        
        btnBack.style.visibility = currentStep > 1 ? 'visible' : 'hidden';
        
        if (currentStep === totalSteps) {
            btnNext.innerHTML = '<i class="fas fa-check"></i> Crear Cuenta';
            btnNext.classList.add('btn-wizard-submit');
        } else {
            btnNext.innerHTML = 'Siguiente <i class="fas fa-arrow-right"></i>';
            btnNext.classList.remove('btn-wizard-submit');
        }
    }
    
    function validateStep(step) {
        const currentContent = document.querySelector(`.step-content[data-step="${step}"]`);
        const requiredInputs = currentContent.querySelectorAll('[required]');
        let isValid = true;
        
        requiredInputs.forEach(input => {
            input.classList.remove('error');
            const errorSpan = input.parentElement.querySelector('.error-text');
            if (errorSpan) errorSpan.remove();
            
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('error');
                const error = document.createElement('span');
                error.className = 'error-text';
                error.textContent = 'Este campo es obligatorio';
                input.parentElement.appendChild(error);
            }
            
            if (input.type === 'email' && input.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(input.value)) {
                    isValid = false;
                    input.classList.add('error');
                }
            }
        });
        
        return isValid;
    }
    
    btnNext.addEventListener('click', function() {
        if (!validateStep(currentStep)) return;
        
        if (currentStep < totalSteps) {
            currentStep++;
            currentStepInput.value = currentStep;
            updateUI();
        } else {
            form.submit();
        }
    });
    
    btnBack.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            currentStepInput.value = currentStep;
            updateUI();
        }
    });
    
    updateUI();
});
</script>
<script src="{{ asset('js/login.js') }}"></script>
@endsection
