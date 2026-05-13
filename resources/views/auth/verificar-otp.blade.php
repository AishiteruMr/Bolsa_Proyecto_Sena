@extends('layouts.app')

@section('title', 'Verificar Código OTP')

@section('styles')
@vitebuilt
@vite(['resources/css/login.css'])
@endvitebuilt
@endsection

@section('content')
<div class="login-page-wrapper">
    <a href="{{ route('home') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Volver al Inicio
    </a>

    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="login-container">
        <div class="login-brand login-brand-show">
            <div class="brand-header">
                <img src="{{ asset('assets/logo.webp') }}" alt="SENA">
                <span>Inspírate<br>SENA</span>
            </div>
            
            <div class="brand-quote">
                <h2>Impulsa <span style="color: var(--primary-light);"> Ideas</span>,<br>Cosecha <span style="color: var(--primary-light);">Éxitos</span>.</h2>
                <p>"La innovación es el camino que transforma el conocimiento en soluciones reales para el mundo."</p>
            </div>
            
            <div class="brand-features">
                <div class="brand-feature">
                    <i class="fas fa-rocket"></i>
                    <span>Proyectos Innovadores</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-handshake"></i>
                    <span>Red de Contactos</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-chart-line"></i>
                    <span>Seguimiento Profesional</span>
                </div>
            </div>
            
            <div class="brand-footer">
                Bolsa de Proyectos & Talentos v2.0
            </div>
        </div>

        <div class="login-content">
            <div class="content-header">
                <h3>Verifica tu correo</h3>
                <p>Ingresa el código de 6 dígitos que te enviamos a tu correo para activar tu cuenta.</p>
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

            @php $otpFallback = \Illuminate\Support\Facades\Cache::get('otp_fallback_' . $email); @endphp
            @if($otpFallback)
                <div class="alert alert-info" style="background: #fef3c7; border-color: #f59e0b; color: #92400e;">
                    <strong> Depuración:</strong> El correo no pudo enviarse.<br>
                    Usa este código manualmente: <span style="font-size: 24px; font-weight: bold; letter-spacing: 4px; display: block; text-align: center; margin-top: 8px;">{{ $otpFallback }}</span>
                </div>
            @endif

            <form action="{{ route('auth.verificar-otp') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                
                <div class="form-group">
                    <label>
                        Código de Verificación
                        <i class="fas fa-question-circle hint-icon" data-hint="Código de 6 dígitos enviado a tu correo" style="margin-left: 4px;"></i>
                    </label>
                    <div class="input-wrapper">
                        <i class="fas fa-key"></i>
                        <input type="text" name="otp" maxlength="6" placeholder="000000" required 
                               inputmode="numeric" pattern="[0-9]*">
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Verificar Código <i class="fas fa-check" style="margin-left: 8px;"></i>
                </button>
            </form>

            <div class="divider">¿No recibiste el código?</div>
            
            <p style="text-align: center; margin-top: 15px;">
                <a href="{{ route('login') }}" style="color: var(--secondary); text-decoration: none;">
                    Volver a iniciar sesión para solicitar uno nuevo
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@vitebuilt
@vite(['resources/js/login.js'])
@endvitebuilt
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Focus on the OTP input when the page loads
    const otpInput = document.querySelector('input[name="otp"]');
    if (otpInput) {
        otpInput.focus();
    }
    
    // Auto-submit when 6 digits are entered
    const otpField = document.querySelector('input[name="otp"]');
    if (otpField) {
        otpField.addEventListener('input', function(e) {
            // Remove any non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Limit to 6 digits
            if (this.value.length > 6) {
                this.value = this.value.slice(0, 6);
            }
            
            // Auto-submit when 6 digits are entered
            if (this.value.length === 6) {
                // Small delay to allow user to see the last digit
                setTimeout(() => {
                    this.form.submit();
                }, 300);
            }
        });
    }
});
</script>
@endsection