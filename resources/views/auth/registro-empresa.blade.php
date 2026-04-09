@extends('layouts.app')

@section('title', 'Registro Empresa')
@section('styles')
<style>
.minimal-wrapper {
    background: #fafafa;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
}
.minimal-container {
    width: 100%;
    max-width: 420px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 30px rgba(0,0,0,0.06);
    padding: 48px 40px;
}
.minimal-header { text-align: center; margin-bottom: 36px; }
.minimal-header h1 {
    font-size: 26px; font-weight: 800; color: #1a1a1a;
    margin-bottom: 8px; letter-spacing: -0.5px;
}
.minimal-header p { font-size: 14px; color: #888; }
.minimal-form .form-group { margin-bottom: 20px; }
.minimal-form label {
    display: block; font-size: 12px; font-weight: 600;
    color: #333; margin-bottom: 8px; letter-spacing: 0.5px;
}
.minimal-form input {
    width: 100%; padding: 14px 16px;
    border: 1px solid #e5e5e5; border-radius: 10px;
    font-size: 14px; color: #333;
    transition: all 0.2s; background: #fafafa;
}
.minimal-form input:focus {
    border-color: #3eb489; background: #fff;
    outline: none; box-shadow: 0 0 0 3px rgba(62,180,137,0.1);
}
.minimal-form input::placeholder { color: #aaa; }
.minimal-form .btn-submit {
    width: 100%; padding: 16px; border-radius: 12px;
    background: #1a1a1a; color: #fff; border: none;
    font-size: 14px; font-weight: 700; cursor: pointer;
    transition: all 0.2s; margin-top: 8px;
}
.minimal-form .btn-submit:hover { background: #333; transform: translateY(-1px); }
.minimal-divider {
    text-align: center; margin: 28px 0; color: #bbb;
    font-size: 12px; text-transform: uppercase; letter-spacing: 1px;
}
.minimal-link { display: block; text-align: center; color: #666; font-size: 13px; text-decoration: none; }
.minimal-link:hover { color: #3eb489; }
.minimal-checkbox {
    display: flex; align-items: center; gap: 10px; margin-bottom: 24px;
}
.minimal-checkbox input { width: 16px; height: 16px; accent-color: #3eb489; }
.minimal-checkbox label { font-size: 12px; color: #666; }
</style>
@endsection

@section('content')
<div class="minimal-wrapper">
    <a href="{{ route('home') }}" style="position: absolute; top: 24px; left: 24px; color: #666; text-decoration: none; font-size: 14px; font-weight: 600;">
        <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>Volver
    </a>

    <div class="minimal-container">
        <div class="minimal-header">
            <h1>Crear Cuenta</h1>
            <p>Registra tu empresa</p>
        </div>

        @if($errors->any())
            <div style="background: #fff5f5; border-left: 3px solid #ef4444; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; color: #991b1b;">
                @foreach($errors->all() as $e){{ $e }}<br>@endforeach
            </div>
        @endif

        <form action="{{ route('registro.empresa.post') }}" method="POST" class="minimal-form">
            @csrf
            <div class="form-group">
                <label>Nombre de la Empresa</label>
                <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa') }}" placeholder="Nombre de la empresa" required>
            </div>
            <div class="form-group">
                <label>NIT</label>
                <input type="text" name="nit" value="{{ old('nit') }}" placeholder="NIT" required>
            </div>
            <div class="form-group">
                <label>Representante</label>
                <input type="text" name="representante" value="{{ old('representante') }}" placeholder="Nombre del representante" required>
            </div>
            <div class="form-group">
                <label>Correo</label>
                <input type="email" name="correo" value="{{ old('correo') }}" placeholder="correo@empresa.com" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" placeholder="Mín. 6 caracteres" required>
            </div>
            <div class="form-group">
                <label>Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
            </div>
            <div class="minimal-checkbox">
                <input type="checkbox" id="terminos" name="terminos" required>
                <label for="terminos">Acepto los Términos y Condiciones</label>
            </div>
            <button type="submit" class="btn-submit">Crear Cuenta</button>
        </form>

        <div class="minimal-divider">¿Ya tienes cuenta?</div>
        <a href="{{ route('login') }}" class="minimal-link">Iniciar Sesión</a>
    </div>
</div>
@endsection