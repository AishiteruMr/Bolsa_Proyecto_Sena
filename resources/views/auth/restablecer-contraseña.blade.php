@extends('layouts.app')

@section('title', 'Restablecer Contraseña')

@section('styles')
@vitebuilt
@vite(['resources/css/auth_forms.css'])
@endvitebuilt
<style>
    .auth-main {
        background: radial-gradient(ellipse at top left, #0d1a0d 0%, #051005 50%, #0a150a 100%),
                    radial-gradient(circle at 80% 20%, rgba(62,180,137,0.12) 0%, transparent 40%),
                    radial-gradient(circle at 20% 80%, rgba(62,180,137,0.08) 0%, transparent 35%);
    }
    .auth-main::before {
        display: none;
    }
    .reset-header {
        text-align: center;
        margin-bottom: 28px;
    }
    .reset-header .icon-circle {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--primary-soft), #d1fae5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }
    .reset-header .icon-circle i {
        font-size: 24px;
        color: var(--primary);
    }
    .reset-header h2 {
        font-size: 22px;
        font-weight: var(--font-black);
        color: var(--secondary);
    }
    .reset-header p {
        color: var(--text-light);
        font-size: 14px;
        margin-top: 6px;
    }
    .alert {
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert i {
        font-size: 16px;
        flex-shrink: 0;
    }
    .alert-danger {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }
    .alert-warning {
        background: #fffbeb;
        color: #92400e;
        border: 1px solid #fde68a;
    }
    .password-requirements {
        background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 16px 18px;
        margin-bottom: 24px;
    }
    .password-requirements-header {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #166534;
        margin-bottom: 12px;
    }
    .password-requirements-header i {
        color: #22c55e;
        font-size: 15px;
    }
    .requirement {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 3px 0;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .requirement .req-icon {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }
    .requirement.met {
        color: #166534;
    }
    .requirement.met .req-icon {
        background: #bbf7d0;
        color: #16a34a;
    }
    .requirement.unmet {
        color: #94a394;
    }
    .requirement.unmet .req-icon {
        background: #f1f5f1;
        color: #94a394;
    }
    .form-group {
        margin-bottom: 18px;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--secondary);
        margin-bottom: 6px;
    }
    .password-field {
        position: relative;
    }
    .password-field input {
        width: 100%;
        padding: 11px 44px 11px 40px;
        border: 2px solid #e8e8e8;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: all 0.3s ease;
        background: #fafafa;
    }
    .password-field input:focus {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 3px var(--primary-glow);
    }
    .password-field .field-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #bbb;
        font-size: 15px;
        transition: color 0.3s;
    }
    .password-field input:focus ~ .field-icon {
        color: var(--primary);
    }
    .password-field .toggle-pw {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #bbb;
        cursor: pointer;
        font-size: 15px;
        padding: 4px;
        transition: color 0.3s;
    }
    .password-field .toggle-pw:hover {
        color: var(--primary);
    }
    .field-error {
        font-size: 12px;
        color: #dc2626;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .field-match {
        font-size: 12px;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .field-match.match {
        color: #16a34a;
    }
    .field-match.no-match {
        color: #dc2626;
    }
    .btn-registro i {
        margin-right: 8px;
    }
    .back-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #666;
        margin-bottom: 20px;
        text-decoration: none;
        transition: color 0.2s;
    }
    .back-btn:hover {
        color: var(--primary);
    }
    .link-text {
        text-align: center;
        font-size: 13px;
        color: #666;
        margin-top: 16px;
    }
    .link-text a {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s;
    }
    .link-text a:hover {
        color: var(--primary-hover);
    }
    @media (max-width: 600px) {
        .registro-container {
            padding: 32px 24px;
        }
    }
    @media (max-width: 400px) {
        .registro-container {
            padding: 24px 16px;
        }
    }
</style>
@endsection

@section('content')
<main class="auth-main">
    <div class="registro-container" style="max-width: 440px;">
        <a href="{{ route('login') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </a>

        <div class="reset-header">
            <div class="icon-circle">
                <i class="fas fa-key"></i>
            </div>
            <h2>Restablecer Contraseña</h2>
            <p>Crea una contraseña segura para tu cuenta.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span><br>
                    @endforeach
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('warning') }}
            </div>
        @endif

        <div class="password-requirements">
            <div class="password-requirements-header">
                <i class="fas fa-shield-alt"></i> Requisitos de seguridad
            </div>
            <div class="requirement unmet" id="req-length">
                <span class="req-icon"><i class="fas fa-check"></i></span>
                Mínimo 8 caracteres
            </div>
            <div class="requirement unmet" id="req-upper">
                <span class="req-icon"><i class="fas fa-check"></i></span>
                Al menos una letra mayúscula
            </div>
            <div class="requirement unmet" id="req-lower">
                <span class="req-icon"><i class="fas fa-check"></i></span>
                Al menos una letra minúscula
            </div>
            <div class="requirement unmet" id="req-number">
                <span class="req-icon"><i class="fas fa-check"></i></span>
                Al menos un número
            </div>
        </div>

        <form action="{{ route('auth.restablecer-contraseña') }}" method="POST" id="formRestablecer">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="correo" value="{{ $correo }}">

            <div class="form-group">
                <label for="password">Nueva Contraseña</label>
                <div class="password-field">
                    <i class="fas fa-lock field-icon"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Ingresa tu nueva contraseña"
                        required
                        autocomplete="new-password"
                        onkeyup="validarContraseña()"
                    >
                    <button type="button" class="toggle-pw" onclick="togglePassword('password', this)" tabindex="-1">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña</label>
                <div class="password-field">
                    <i class="fas fa-lock field-icon"></i>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirma tu nueva contraseña"
                        required
                        autocomplete="new-password"
                        onkeyup="validarCoincidencia()"
                    >
                    <button type="button" class="toggle-pw" onclick="togglePassword('password_confirmation', this)" tabindex="-1">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
                <div class="field-match no-match" id="coincidencia" style="display: none;">
                    <i class="fas fa-times-circle"></i> Las contraseñas no coinciden
                </div>
            </div>

            <button type="submit" class="btn-registro" id="btnEnviar">
                <i class="fas fa-check-circle"></i> Restablecer Contraseña
            </button>
        </form>

        <div class="link-text">
            ¿Problemas con el enlace?
            <a href="{{ route('auth.olvide-contraseña') }}">Solicitar nuevo enlace</a>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    function validarContraseña() {
        const password = document.getElementById('password').value;

        actualizarRequisito('req-length', password.length >= 8);
        actualizarRequisito('req-upper', /[A-Z]/.test(password));
        actualizarRequisito('req-lower', /[a-z]/.test(password));
        actualizarRequisito('req-number', /[0-9]/.test(password));

        validarCoincidencia();
    }

    function validarCoincidencia() {
        const password = document.getElementById('password').value;
        const confirmation = document.getElementById('password_confirmation').value;
        const el = document.getElementById('coincidencia');

        if (!confirmation) {
            el.style.display = 'none';
            return;
        }

        el.style.display = 'flex';
        if (password === confirmation) {
            el.classList.remove('no-match');
            el.classList.add('match');
            el.innerHTML = '<i class="fas fa-check-circle"></i> Las contraseñas coinciden';
        } else {
            el.classList.remove('match');
            el.classList.add('no-match');
            el.innerHTML = '<i class="fas fa-times-circle"></i> Las contraseñas no coinciden';
        }
    }

    function actualizarRequisito(id, met) {
        const el = document.getElementById(id);
        el.classList.toggle('met', met);
        el.classList.toggle('unmet', !met);
    }

    function togglePassword(fieldId, btn) {
        const field = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        const isPassword = field.type === 'password';
        field.type = isPassword ? 'text' : 'password';
        icon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('password').focus();

        document.getElementById('formRestablecer').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;

            if (password !== confirmation) {
                e.preventDefault();
                const el = document.getElementById('coincidencia');
                el.style.display = 'flex';
                el.classList.remove('match');
                el.classList.add('no-match');
                el.innerHTML = '<i class="fas fa-times-circle"></i> Las contraseñas no coinciden';
                return false;
            }

            const length = password.length >= 8;
            const upper = /[A-Z]/.test(password);
            const lower = /[a-z]/.test(password);
            const number = /[0-9]/.test(password);

            if (!length || !upper || !lower || !number) {
                e.preventDefault();
                alert('La contraseña no cumple con todos los requisitos de seguridad.');
                return false;
            }
        });
    });
</script>
@endsection
