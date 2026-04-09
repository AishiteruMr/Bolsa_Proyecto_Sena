@extends('layouts.app')

@section('title', 'Registro Instructor')
@section('styles')
<style>
.glass-wrapper {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #667eea 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}
.glass-container {
    width: 100%;
    max-width: 440px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    padding: 40px 36px;
    position: relative;
}
.glass-header { text-align: center; margin-bottom: 32px; }
.glass-header h1 {
    font-size: 28px; font-weight: 900; color: #fff;
    margin-bottom: 8px; text-shadow: 0 2px 10px rgba(0,0,0,0.2);
}
.glass-header p { font-size: 14px; color: rgba(255,255,255,0.7); }
.glass-form .form-group { margin-bottom: 18px; }
.glass-form label {
    display: block; font-size: 11px; font-weight: 800;
    color: rgba(255,255,255,0.9); margin-bottom: 6px; 
    text-transform: uppercase; letter-spacing: 1px;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}
.glass-form input {
    width: 100%; padding: 14px 16px;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 12px;
    font-size: 14px; color: #fff;
    transition: all 0.2s;
    backdrop-filter: blur(10px);
}
.glass-form input::placeholder { 
    color: rgba(255, 255, 255, 0.5); 
}
.glass-form input:focus {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
    outline: none;
    box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
}
.glass-form .btn-submit {
    width: 100%; padding: 16px; border-radius: 14px;
    background: #fff; color: #1e3c72; border: none;
    font-size: 15px; font-weight: 800; cursor: pointer;
    transition: all 0.3s; margin-top: 8px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}
.glass-form .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.3);
}
.glass-divider {
    text-align: center; margin: 24px 0; color: rgba(255,255,255,0.5);
    font-size: 11px; text-transform: uppercase; letter-spacing: 1px;
}
.glass-link { display: block; text-align: center; color: #fff; font-size: 13px; font-weight: 700; text-decoration: none; }
.glass-link:hover { color: rgba(255,255,255,0.8); }
.glass-checkbox {
    display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
}
.glass-checkbox input { width: 16px; height: 16px; accent-color: #fff; }
.glass-checkbox label { font-size: 12px; color: rgba(255,255,255,0.8); }
</style>
@endsection

@section('content')
<div class="glass-wrapper">
    <a href="{{ route('home') }}" style="position: absolute; top: 24px; left: 24px; color: #fff; text-decoration: none; font-size: 14px; font-weight: 600; text-shadow: 0 1px 3px rgba(0,0,0,0.3);">
        <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>Volver
    </a>

    <div class="glass-container">
        <div class="glass-header">
            <h1>¡Conviértete en Instructor!</h1>
            <p>Crea tu cuenta de instructor</p>
        </div>

        @if($errors->any())
            <div style="background: rgba(255,255,255,0.15); border-left: 3px solid #f87171; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; color: #fecaca;">
                @foreach($errors->all() as $e){{ $e }}<br>@endforeach
            </div>
        @endif

        <form action="{{ route('registro.instructor.post') }}" method="POST" class="glass-form">
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
                <label>Especialización</label>
                <input type="text" name="especialidad" value="{{ old('especialidad') }}" placeholder="Área de especialización" required>
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
            <div class="glass-checkbox">
                <input type="checkbox" id="terminos" name="terminos" required>
                <label for="terminos">Acepto los Términos y Condiciones</label>
            </div>
            <button type="submit" class="btn-submit">Crear Cuenta</button>
        </form>

        <div class="glass-divider">¿Ya tienes cuenta?</div>
        <a href="{{ route('login') }}" class="glass-link">Iniciar Sesión</a>
    </div>
</div>
@endsection