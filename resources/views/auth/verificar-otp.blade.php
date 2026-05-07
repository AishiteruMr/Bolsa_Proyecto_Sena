@extends('layouts.otp')

@section('title', 'Verificación OTP')

@section('content')
    <style>
        .otp-header {
            text-align: center;
            margin-bottom: 35px;
        }
        .otp-icon-wrapper {
            width: 90px;
            height: 90px;
            margin: 0 auto 25px;
        }
        .otp-icon-bg {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, hsl(158, 49%, 47%) 0%, hsl(158, 49%, 57%) 100%);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 35px rgba(62, 180, 137, 0.35);
            animation: float 3s ease-in-out infinite;
            transform: rotate(-5deg);
        }
        .otp-icon-bg i {
            font-size: 36px;
            color: white;
            transform: rotate(5deg);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(-5deg); }
            50% { transform: translateY(-10px) rotate(-5deg); }
        }
        .otp-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a2e1a;
            margin-bottom: 10px;
        }
        .otp-description {
            font-size: 14px;
            color: #4a5d4a;
            line-height: 1.7;
        }
        .otp-description strong {
            color: hsl(158, 49%, 47%);
            font-weight: 700;
        }
        .otp-inputs-wrapper {
            margin: 30px 0;
        }
        .otp-container {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-bottom: 20px;
        }
        .otp-input {
            width: 58px;
            height: 70px;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            border: 2.5px solid rgba(62, 180, 137, 0.15);
            border-radius: 12px;
            outline: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.82);
            color: #1a2e1a;
            font-family: 'Open Sans', sans-serif;
        }
        .otp-input:hover {
            border-color: rgba(62, 180, 137, 0.3);
            background: #ffffff;
        }
        .otp-input:focus {
            border-color: hsl(158, 49%, 47%);
            background: #ffffff;
            box-shadow: 0 0 0 5px rgba(62, 180, 137, 0.08), 0 8px 20px rgba(62, 180, 137, 0.15);
            transform: translateY(-3px);
        }
        .otp-input.filled {
            border-color: hsl(158, 49%, 47%);
            background: rgba(62, 180, 137, 0.08);
            color: hsl(158, 49%, 47%);
        }
        .otp-input::-webkit-outer-spin-button,
        .otp-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .otp-input[type="number"] {
            -moz-appearance: textfield;
        }
        .timer-label {
            font-size: 12px;
            color: #8fa38f;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        .timer-display {
            font-size: 32px;
            font-weight: 800;
            color: hsl(158, 49%, 47%);
            font-variant-numeric: tabular-nums;
            transition: color 0.3s;
        }
        .timer-display.expired {
            color: #e74c3c;
            animation: blink 1s infinite;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .btn-submit {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            border-radius: 12px;
            background: linear-gradient(135deg, hsl(158, 49%, 47%) 0%, hsl(158, 49%, 57%) 100%);
            box-shadow: 0 8px 25px rgba(62, 180, 137, 0.35);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            color: white;
            cursor: pointer;
            font-family: 'Open Sans', sans-serif;
        }
        .btn-submit:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(62, 180, 137, 0.45);
        }
        .btn-submit:active:not(:disabled) {
            transform: translateY(0);
        }
        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }
        @media (max-width: 480px) {
            .otp-container {
                gap: 8px;
            }
            .otp-input {
                width: 48px;
                height: 60px;
                font-size: 24px;
            }
        }
    </style>

    <div>
        <div class="otp-header">
            <div class="otp-icon-wrapper">
                <div class="otp-icon-bg">
                    <i class="fas fa-shield-alt"></i>
                </div>
            </div>
            <h2 class="otp-title">Verifica tu correo</h2>
            <p class="otp-description">
                Hemos enviado un código de 6 dígitos a<br>
                <strong>{{ $email }}</strong>
            </p>
        </div>

        <form action="{{ route('auth.verificar-otp') }}" method="POST" id="otp-form">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="otp" id="otp-hidden">

            <div class="otp-inputs-wrapper">
                <div class="otp-container">
                    @for($i = 0; $i < 6; $i++)
                    <input type="text" 
                           class="otp-input" 
                           maxlength="1" 
                           inputmode="numeric" 
                           pattern="\d*" 
                           data-index="{{ $i }}"
                           required>
                    @endfor
                </div>
                @error('otp')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit" id="submit-btn" disabled>
                <i class="fas fa-check-circle"></i> Verificar Cuenta
            </button>
        </form>

        <div class="timer-card" id="timer-card">
            <div class="timer-label">El código expira en</div>
            <div class="timer-display" id="timer">05:00</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const hiddenOtpInput = document.getElementById('otp-hidden');
            const submitBtn = document.getElementById('submit-btn');
            const form = document.getElementById('otp-form');
            const timerDisplay = document.getElementById('timer');
            const timerCard = document.getElementById('timer-card');

            let timeLeft = 300;
            let timerInterval;

            function updateHiddenOtp() {
                const otp = Array.from(otpInputs).map(input => input.value).join('');
                hiddenOtpInput.value = otp;
                submitBtn.disabled = otp.length !== 6;
                
                otpInputs.forEach(input => {
                    if (input.value) {
                        input.classList.add('filled');
                    } else {
                        input.classList.remove('filled');
                    }
                });
            }

            function startTimer() {
                timerInterval = setInterval(function() {
                    timeLeft--;
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    const minStr = String(minutes).padStart(2, '0');
                    const secStr = String(seconds).padStart(2, '0');
                    timerDisplay.textContent = minStr + ':' + secStr;
                    
                    if (timeLeft <= 60) {
                        timerDisplay.classList.add('expired');
                        timerCard.classList.add('warning');
                    }
                    
                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        timerDisplay.textContent = '00:00';
                    }
                }, 1000);
            }

            otpInputs.forEach(function(input, index) {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '');
                    if (this.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                    updateHiddenOtp();
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                    if (e.key === 'ArrowLeft' && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                    if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').trim();
                    const digits = pastedData.replace(/\D/g, '').split('').slice(0, 6);
                    
                    for (var i = 0; i < digits.length; i++) {
                        if (otpInputs[i]) {
                            otpInputs[i].value = digits[i];
                            otpInputs[i].classList.add('filled');
                        }
                    }

                    const nextIndex = digits.length < 6 ? digits.length : 5;
                    otpInputs[nextIndex].focus();
                    updateHiddenOtp();
                });

                input.addEventListener('focus', function() {
                    this.select();
                });
            });

            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verificando...';
            });

            otpInputs[0].focus();
            startTimer();
            updateHiddenOtp();
        });
    </script>
@endsection
