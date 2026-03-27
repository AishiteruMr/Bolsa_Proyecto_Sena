@extends('layouts.app')

@section('title', 'Registro Aprendiz')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/auth_forms.css') }}">
@endsection

@section('content')
<main class="auth-main">
<div class="registro-container">
    <a href="{{ route('home') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Volver al inicio</a>

    <div class="reg-header">
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

        <button type="submit" class="btn-registro">Registrarse</button>
    </form>

    <p class="link-text">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia Sesión</a></p>
</div>
</main>
@endsection
