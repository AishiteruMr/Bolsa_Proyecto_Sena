@extends('layouts.app')

@section('title', 'Centro de Soporte - Inspírate SENA')

@section('styles')
<style>
    .support-hero { padding: 60px 8%; text-align: center; background: linear-gradient(135deg, #f8f9fa, #e9ecef); }
    .support-container { padding: 50px 8%; }
    .support-section { margin-bottom: 50px; }
    .support-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; }
    .support-card { background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.3s; }
    .support-card:hover { transform: translateY(-5px); }
    .support-card h3 { color: var(--primary); margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
    .faq-list { list-style: none; padding: 0; }
    .faq-item { margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
    .faq-item h4 { color: #333; margin-bottom: 8px; cursor: pointer; }
    .faq-item p { color: #666; font-size: 15px; }
    .contact-form { background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; }
    .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
    .btn-submit { background: var(--primary); color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
</style>
@endsection

@section('content')
<section class="support-hero">
    <h1>Centro de Ayuda y Soporte</h1>
    <p>¿Necesitas asistencia? Encuentra soluciones rápidas o contacta con nuestro equipo.</p>
</section>

<div class="support-container">
    <section class="support-section">
        <h2>Preguntas Frecuentes (FAQ)</h2>
        <div class="support-grid">
            <div class="support-card">
                <h3>📖 Acceso y Cuenta</h3>
                <div class="faq-list">
                    <div class="faq-item">
                        <h4>¿Cómo recupero mi contraseña?</h4>
                        <p>Haz clic en "¿Olvidaste tu contraseña?" en la página de inicio de sesión y sigue las instrucciones enviadas a tu correo.</p>
                    </div>
                    <div class="faq-item">
                        <h4>¿Cómo verifico mi correo?</h4>
                        <p>Revisa tu bandeja de entrada (incluyendo SPAM) tras registrarte y haz clic en el enlace de verificación.</p>
                    </div>
                </div>
            </div>
            <div class="support-card">
                <h3>🚀 Proyectos y Postulaciones</h3>
                <div class="faq-list">
                    <div class="faq-item">
                        <h4>¿Cómo me postulo a un proyecto?</h4>
                        <p>Ingresa como aprendiz, navega a "Proyectos", selecciona uno de interés y presiona el botón "Postular".</p>
                    </div>
                    <div class="faq-item">
                        <h4>¿Qué pasa después de postularme?</h4>
                        <p>La empresa revisará tu perfil. Recibirás notificaciones sobre el estado de tu solicitud en tu dashboard.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="support-section">
        <h2>Solución de Problemas Comunes</h2>
        <div class="support-grid">
            <div class="support-card">
                <h3>🛠 Problemas Técnicos</h3>
                <ul>
                    <li><strong>La página no carga:</strong> Intenta limpiar la caché de tu navegador o usar otro navegador.</li>
                    <li><strong>No recibo correos:</strong> Verifica si están en la carpeta de correo no deseado o SPAM.</li>
                    <li><strong>Error al subir archivos:</strong> Asegúrate de que el formato sea correcto (PDF/JPG) y no exceda el tamaño máximo.</li>
                </ul>
            </div>
            <div class="support-card">
                <h3>📢 Quejas y Sugerencias</h3>
                <p>Valoramos tu opinión. Si tienes alguna queja sobre el funcionamiento de la plataforma o sugerencias de mejora, por favor utiliza el formulario de contacto o escribe a <strong>soporte@sena.edu.co</strong>.</p>
            </div>
        </div>
    </section>

    <section class="support-section">
        <h2>Formulario de Contacto</h2>
        <div class="contact-form">
            <form action="#" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="motivo">Motivo</label>
                    <select id="motivo" name="motivo" style="width: 100%; padding: 10px;">
                        <option value="tecnico">Problema Técnico</option>
                        <option value="queja">Queja</option>
                        <option value="sugerencia">Sugerencia</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn-submit">Enviar Mensaje</button>
            </form>
        </div>
    </section>
</div>
@endsection
