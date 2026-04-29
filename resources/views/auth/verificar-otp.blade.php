@extends('layouts.auth')

@section('title', 'Verificación OTP')
@section('form-title', 'Verificación de Correo')
@section('form-subtitle', 'Ingresa el código enviado a tu correo')

@section('content')
    <form action="{{ route('auth.verificar-otp') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="form-group">
            <label for="otp">Código de verificación (6 dígitos)</label>
            <div class="input-wrapper">
                <input type="text" 
                       id="otp" 
                       name="otp" 
                       required 
                       maxlength="6" 
                       placeholder="000000"
                       style="font-size: 24px; font-weight: 700; text-align: center; letter-spacing: 0.5em;">
            </div>
        </div>

        <button type="submit" class="btn-submit">
            Verificar Cuenta
        </button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('login') }}" class="forgot-link">Volver al login</a>
    </div>
@endsection
