@extends('layouts.app')

@section('title', 'Registro Empresa')

@section('styles')
<style>
    /* Estilos específicos para registro */
    main {
        background: linear-gradient(135deg, #4a0080, #8e44ad);
        min-height: calc(100vh - 68px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .registro-container {
        background: #fff;
        border-radius: 20px;
        padding: 40px;
        max-width: 480px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
    }

    .reg-header {
        text-align: center;
        margin-bottom: 28px;
    }

    .reg-header img {
        width: 56px;
        margin-bottom: 8px;
    }

    .reg-header h2 {
        font-size: 20px;
        font-weight: 700;
        color: #4a0080;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 13px;
    }

    .input-icon input {
        width: 100%;
        padding: 11px 12px 11px 36px;
        border: 2px solid #e8edf0;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        outline: none;
        transition: border-color .2s;
    }

    .input-icon input:focus {
        border-color: #8e44ad;
    }

    .btn-registro {
        width: 100%;
        padding: 13px;
        background: linear-gradient(135deg, #8e44ad, #6c3483);
        color: #fff;
        border: none;
        border-radius: 30px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 8px;
        transition: all .3s;
    }

    .btn-registro:hover {
        opacity: .9;
        transform: translateY(-2px);
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        margin-bottom: 12px;
    }

    .checkbox-group input[type="checkbox"] {
        cursor: pointer;
    }

    .link-text {
        text-align: center;
        font-size: 13px;
        color: #666;
        margin-top: 14px;
    }

    .link-text a {
        color: #8e44ad;
        font-weight: 500;
        text-decoration: none;
    }

    .link-text a:hover {
        text-decoration: underline;
    }

    .back-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #666;
        margin-bottom: 16px;
        text-decoration: none;
    }

    .back-btn:hover {
        color: #8e44ad;
    }

    .error-msg {
        background: #f8d7da;
        color: #721c24;
        padding: 10px 14px;
        border-radius: 8px;
        margin-bottom: 14px;
        font-size: 13px;
    }

    @media (max-width: 600px) {
        .registro-container {
            padding: 24px;
        }
    }
</style>
@endsection

@section('content')
<div class="registro-container">
    <a href="{{ route('home') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Volver al inicio</a>
    <div class="reg-header">
        <img src="{{ asset('assets/logo.png') }}" alt="SENA">
        <h2>Registro Empresa</h2>
    </div>

    @if($errors->any())
        <div class="error-msg">@foreach($errors->all() as $e){{ $e }}<br>@endforeach</div>
    @endif

    <form action="{{ route('registro.empresa.post') }}" method="POST">
        @csrf
        <div class="form-group input-icon">
            <i class="fa-solid fa-building"></i>
            <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa') }}" placeholder="Nombre de la empresa" required>
        </div>
        <div class="form-group input-icon">
            <i class="fa-solid fa-id-card"></i>
            <input type="text" name="nit" value="{{ old('nit') }}" placeholder="NIT" required>
        </div>
        <div class="form-group input-icon">
            <i class="fa-solid fa-user-tie"></i>
            <input type="text" name="representante" value="{{ old('representante') }}" placeholder="Representante legal" required>
        </div>
        <div class="form-group input-icon">
            <i class="fa-solid fa-envelope"></i>
            <input type="email" name="correo" value="{{ old('correo') }}" placeholder="Correo electrónico" required>
        </div>
        <div class="form-group input-icon">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password" placeholder="Contraseña (mín. 6 caracteres)" required>
        </div>
        <div class="form-group input-icon">
            <i class="fa-solid fa-lock"></i>
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
        </div>
        <div class="checkbox-group">
            <input type="checkbox" id="terminos" name="terminos" required>
            <label for="terminos">Acepto los Términos y Condiciones</label>
        </div>
        <button type="submit" class="btn-registro">Registrarse</button>
    </form>
    <p class="link-text">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia Sesión</a></p>
</div>
@endsection
