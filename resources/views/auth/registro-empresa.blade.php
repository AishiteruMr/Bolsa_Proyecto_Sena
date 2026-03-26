@extends('layouts.app')

@section('title', 'Registro Empresa')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
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
