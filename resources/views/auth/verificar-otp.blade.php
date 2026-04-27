@extends('layouts.auth')

@section('title', 'Verificación OTP')
@section('form-title', 'Verificación de Correo')
@section('form-subtitle', 'Ingresa el código enviado a tu correo')

@section('content')
    <form action="{{ route('auth.verificar-otp') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">

        <div style="margin-bottom: 24px;">
            <label for="otp" style="display: block; font-size: 14px; font-weight: 600; color: #475569; margin-bottom: 8px;">Código de verificación (6 dígitos)</label>
            <input type="text" 
                   id="otp" 
                   name="otp" 
                   required 
                   maxlength="6" 
                   placeholder="000000"
                   style="width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 24px; font-weight: 700; text-align: center; letter-spacing: 0.5em; transition: all 0.3s ease; outline: none;">
            <style>
                #otp:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(62,180,137,0.2); }
            </style>
        </div>

        <button type="submit" 
                style="width: 100%; padding: 14px; background: var(--primary); color: #fff; border: none; border-radius: 12px; font-weight: 700; font-size: 16px; cursor: pointer; transition: background 0.3s ease; box-shadow: 0 4px 12px rgba(62,180,137,0.3);">
            Verificar Cuenta
        </button>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ route('login') }}" style="font-size: 14px; color: var(--text-light); text-decoration: none; font-weight: 500;">Volver al login</a>
    </div>
@endsection
