@extends('layouts.app')

@section('title', 'Soporte | Inspírate SENA')

@section('styles')
    @vite(['resources/css/soporte.css'])
@endsection

@section('content')
    <section class="soporte-section">
        <div class="soporte-blobs">
            <div class="soporte-blob" style="top:-100px; right:-80px;"></div>
            <div class="soporte-blob"></div>
        </div>
        <div class="soporte-hero-content">
            <h1>¿Cómo podemos <span>ayudarte</span> hoy?</h1>
            <p>Tu experiencia es nuestra prioridad. Encuentra soluciones rápidas o conecta con nuestro equipo de soporte.</p>
        </div>
    </section>

    @if(session('success'))
        <div class="alert-custom" style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="soporte-grid">
        <div class="soporte-card">
            <div class="soporte-card-icon"><i class="fas fa-key"></i></div>
            <h3>Acceso a tu Cuenta</h3>
            <ul>
                <li><i class="fas fa-exclamation-circle"></i> <a href="{{ route('auth.olvide-contraseña') }}">Olvidé mi contraseña - Restablecer</a></li>
                <li><i class="fas fa-check"></i> <a href="{{ route('registro.aprendiz') }}">¿No tienes cuenta? Regístrate aquí</a></li>
                <li><i class="fas fa-check"></i> <a href="{{ route('registro.empresa') }}">Crear cuenta de Empresa</a></li>
                <li><i class="fas fa-check"></i> <a href="{{ route('registro.instructor') }}">Crear cuenta de Instructor</a></li>
            </ul>
        </div>
        <div class="soporte-card">
            <div class="soporte-card-icon"><i class="fas fa-question-circle"></i></div>
            <h3>Preguntas Frecuentes</h3>
            <ul>
                <li><i class="fas fa-check"></i> ¿Cómo publicar un proyecto? (Paso a paso)</li>
                <li><i class="fas fa-check"></i> ¿Cómo postularme a un proyecto? (Guía rápida)</li>
                <li><i class="fas fa-check"></i> ¿Cómo actualizar mi perfil? (Datos y foto)</li>
                <li><i class="fas fa-check"></i> ¿Cómo cambiar mi contraseña? (Seguridad)</li>
            </ul>
        </div>
        <div class="soporte-card">
            <div class="soporte-card-icon"><i class="fas fa-life-ring"></i></div>
            <h3>Solución Rápida</h3>
            <ul>
                <li><i class="fas fa-exclamation-circle"></i> <a href="{{ route('login') }}">Iniciar Sesión</a> - Accede a tu panel</li>
                <li><i class="fas fa-exclamation-circle"></i> <a href="{{ route('verification.resend') }}">Reenviar correo de verificación</a></li>
                <li><i class="fas fa-exclamation-circle"></i> Contacta a soporte vía el formulario abajo</li>
            </ul>
        </div>
    </div>

    <section class="form-section">
        <div class="form-container">
            <h2>Envía tu consulta</h2>
            <p class="form-subtitle">Estaremos encantados de ayudarte, respetamos tu tiempo.</p>
            <form action="{{ route('soporte.enviar') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <div class="input-wrapper">
                        <i class="fas fa-user"></i>
                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Tu nombre" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Tu correo electrónico" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="motivo">Motivo de contacto</label>
                    <div class="input-wrapper">
                        <i class="fas fa-tag"></i>
                        <select id="motivo" name="motivo" class="form-control">
                            <option value="Duda">Duda General</option>
                            <option value="Queja">Queja / Incidente</option>
                            <option value="Sugerencia">Sugerencia de Mejora</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <div class="input-wrapper">
                        <i class="fas fa-comment-dots" style="top: 20px; transform: none;"></i>
                        <textarea id="mensaje" name="mensaje" class="form-control" placeholder="Describe detalladamente tu situación..." rows="6" required></textarea>
                    </div>
                </div>
                <button type="submit" class="form-submit">
                    Enviar solicitud <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </section>
@endsection
