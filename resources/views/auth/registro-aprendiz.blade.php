@extends('layouts.app')

@section('title', 'Registro Aprendiz')

@section('styles')
<style>
    body { background: linear-gradient(135deg, #1a5c00, #39a900); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
    .container { background: #fff; border-radius: 20px; padding: 40px; max-width: 480px; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,.2); }
    .header { text-align: center; margin-bottom: 28px; }
    .header img { width: 56px; margin-bottom: 8px; }
    .header h2 { font-size: 20px; font-weight: 700; color: #1a5c00; }
    .form-group { margin-bottom: 16px; position: relative; }
    .input-icon { position: relative; }
    .input-icon i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 13px; }
    .input-icon input { width: 100%; padding: 11px 12px 11px 36px; border: 2px solid #e8edf0; border-radius: 8px; font-family: 'Poppins', sans-serif; font-size: 14px; outline: none; transition: border-color .2s; }
    .input-icon input:focus { border-color: #39a900; }
    .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .btn-submit { width: 100%; padding: 13px; background: linear-gradient(135deg, #39a900, #2d8500); color: #fff; border: none; border-radius: 30px; font-family: 'Poppins', sans-serif; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: 8px; }
    .btn-submit:hover { opacity: .9; }
    .checkbox-group { display: flex; align-items: center; gap: 8px; font-size: 13px; margin-bottom: 12px; }
    .link-text { text-align: center; font-size: 13px; color: #666; margin-top: 14px; }
    .link-text a { color: #39a900; font-weight: 500; }
    .back-btn { display: flex; align-items: center; gap: 6px; font-size: 13px; color: #666; margin-bottom: 16px; }
    .back-btn:hover { color: #39a900; }
    .error-msg { background: #f8d7da; color: #721c24; padding: 10px 14px; border-radius: 8px; margin-bottom: 14px; font-size: 13px; }
</style>
@endsection

@section('content')
<div class="container">
    <a href="{{ route('home') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Volver al inicio</a>

    <div class="header">
        <img src="{{ asset('assets/logo.png') }}" alt="SENA">
        <h2>Registro Aprendiz</h2>
    </div>

    @if($errors->any())
        <div class="error-msg">@foreach($errors->all() as $e){{ $e }}<br>@endforeach</div>
    @endif

    <form action="{{ route('registro.aprendiz.post') }}" method="POST">
        @csrf
        <div class="input-row">
            <div class="form-group input-icon">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre" required>
            </div>
            <div class="form-group input-icon">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Apellido" required>
            </div>
        </div>

        <div class="form-group input-icon">
            <i class="fa-solid fa-id-card"></i>
            <input type="text" name="documento" value="{{ old('documento') }}" placeholder="Número de documento" required>
        </div>

        <div class="form-group input-icon">
            <i class="fa-solid fa-graduation-cap"></i>
            <input type="text" name="programa" value="{{ old('programa') }}" placeholder="Programa de formación" required>
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

        <button type="submit" class="btn-submit">Registrarse</button>
    </form>

    <p class="link-text">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia Sesión</a></p>
</div>
@endsection
