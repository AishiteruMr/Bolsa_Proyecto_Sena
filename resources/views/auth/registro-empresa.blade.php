@extends('layouts.app')

@section('title', 'Registro Empresa')

@section('styles')
<style>
    main {
        background: linear-gradient(135deg, #0f4a41 0%, #1b6b5f 40%, #4a9b8d 100%);
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 20px;
        position: relative;
        overflow: hidden;
    }

    main::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
    }

    .registro-container {
        background: #fff;
        border-radius: 16px;
        padding: 48px;
        max-width: 480px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        z-index: 1;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .reg-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .reg-header img {
        width: 60px;
        height: 60px;
        margin-bottom: 16px;
    }

    .reg-header h2 {
        font-size: 26px;
        font-weight: 800;
        color: #0f2419;
        letter-spacing: -0.5px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #bbb;
        font-size: 15px;
        transition: color .3s;
    }

    .input-icon input {
        width: 100%;
        padding: 11px 12px 11px 40px;
        border: 2px solid #e8e8e8;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        outline: none;
        transition: all .3s ease;
        background: #fafafa;
    }

    .input-icon input:focus {
        border-color: #1b6b5f;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(27, 107, 95, 0.1);
    }

    .input-icon input:focus + i {
        color: #1b6b5f;
    }

    .btn-registro {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #1b6b5f 0%, #0f4a41 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 8px;
        transition: all .3s ease;
        box-shadow: 0 4px 15px rgba(27, 107, 95, 0.25);
        letter-spacing: 0.3px;
    }

    .btn-registro:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(27, 107, 95, 0.35);
    }

    .checkbox-group {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 13px;
        margin-bottom: 16px;
        margin-top: 4px;
    }

    .checkbox-group input[type="checkbox"] {
        cursor: pointer;
        margin-top: 3px;
        accent-color: #1b6b5f;
    }

    .checkbox-group label {
        cursor: pointer;
        color: #666;
        line-height: 1.4;
    }

    .link-text {
        text-align: center;
        font-size: 13px;
        color: #666;
        margin-top: 16px;
    }

    .link-text a {
        color: #1b6b5f;
        font-weight: 700;
        text-decoration: none;
        transition: color .2s;
    }

    .link-text a:hover {
        color: #0f4a41;
    }

    .back-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #666;
        margin-bottom: 20px;
        text-decoration: none;
        transition: color .2s;
    }

    .back-btn:hover {
        color: #1b6b5f;
    }

    .error-msg {
        background: #fef0f0;
        color: #c0392b;
        padding: 12px 14px;
        border-radius: 8px;
        margin-bottom: 18px;
        font-size: 13px;
        border-left: 4px solid #e74c3c;
        animation: slideDown 0.4s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 600px) {
        .registro-container {
            padding: 32px 24px;
        }

        main {
            padding: 20px;
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
