@extends('layouts.app')

@section('title', 'Registro Aprendiz')
@section('styles')
<style>
.colorful-wrapper {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}
.colorful-container {
    width: 100%;
    max-width: 440px;
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.25);
    padding: 40px 36px;
    position: relative;
    overflow: hidden;
}
.colorful-container::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0;
    height: 6px;
    background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
}
.colorful-header { text-align: center; margin-bottom: 32px; }
.colorful-header h1 {
    font-size: 28px; font-weight: 900; color: #1a1a2e;
    margin-bottom: 8px;
}
.colorful-header p { font-size: 14px; color: #666; }
.colorful-form .form-group { margin-bottom: 18px; }
.colorful-form label {
    display: block; font-size: 11px; font-weight: 800;
    color: #1a1a2e; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 1px;
}
.colorful-form input {
    width: 100%; padding: 14px 16px;
    border: 2px solid #e8e8e8; border-radius: 12px;
    font-size: 14px; color: #333;
    transition: all 0.2s;
}
.colorful-form input:focus {
    border-color: #764ba2; outline: none;
    box-shadow: 0 0 0 4px rgba(118,75,162,0.15);
}
.colorful-form input::placeholder { color: #aaa; }
.colorful-form .btn-submit {
    width: 100%; padding: 16px; border-radius: 14px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #fff; border: none;
    font-size: 15px; font-weight: 800; cursor: pointer;
    transition: all 0.3s; margin-top: 8px;
    box-shadow: 0 8px 20px rgba(118,75,162,0.35);
}
.colorful-form .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(118,75,162,0.45);
}
.colorful-divider {
    text-align: center; margin: 24px 0; color: #bbb;
    font-size: 11px; text-transform: uppercase; letter-spacing: 1px;
}
.colorful-link { display: block; text-align: center; color: #764ba2; font-size: 13px; font-weight: 700; text-decoration: none; }
.colorful-link:hover { color: #667eea; }
.colorful-checkbox {
    display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
}
.colorful-checkbox input { width: 16px; height: 16px; accent-color: #764ba2; }
.colorful-checkbox label { font-size: 12px; color: #666; }
</style>
@endsection

@section('content')
<div class="colorful-wrapper">
    <a href="{{ route('home') }}" style="position: absolute; top: 24px; left: 24px; color: #fff; text-decoration: none; font-size: 14px; font-weight: 600; text-shadow: 0 1px 3px rgba(0,0,0,0.3);">
        <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>Volver
    </a>

    <div class="colorful-container">
        <div class="colorful-header">
            <h1>¡Únete como Aprendiz!</h1>
            <p>Crea tu cuenta para comenzar</p>
        </div>

        @if($errors->any())
            <div style="background: #fff5f5; border-left: 3px solid #ef4444; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; color: #991b1b;">
                @foreach($errors->all() as $e){{ $e }}<br>@endforeach
            </div>
        @endif

        <form action="{{ route('registro.aprendiz.post') }}" method="POST" class="colorful-form">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Tu nombre" required>
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Tus apellidos" required>
                </div>
            </div>
            <div class="form-group">
                <label>Documento</label>
                <input type="text" name="documento" value="{{ old('documento') }}" placeholder="Número de documento" required>
            </div>
            <div class="form-group">
                <label>Programa SENA</label>
                <input type="text" name="programa" value="{{ old('programa') }}" placeholder="Programa de formación" required>
            </div>
            <div class="form-group">
                <label>Correo</label>
                <input type="email" name="correo" value="{{ old('correo') }}" placeholder="tu@email.com" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" placeholder="Mín. 6 caracteres" required>
            </div>
            <div class="form-group">
                <label>Confirmar</label>
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
            </div>
            <div class="colorful-checkbox">
                <input type="checkbox" id="terminos" name="terminos" required>
                <label for="terminos">Acepto los Términos y Condiciones</label>
            </div>
            <button type="submit" class="btn-submit">Crear Cuenta</button>
        </form>

        <div class="colorful-divider">¿Ya tienes cuenta?</div>
        <a href="{{ route('login') }}" class="colorful-link">Iniciar Sesión</a>
    </div>
</div>
@endsection