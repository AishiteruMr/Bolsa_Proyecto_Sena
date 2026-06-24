@extends('layouts.app')

@section('title', 'Soporte | Inspírate SENA')
@section('meta_description', 'Centro de ayuda de Inspírate SENA. Resuelve tus dudas, contacta soporte y encuentra respuestas a preguntas frecuentes sobre la bolsa de proyectos.')
@section('og_title', 'Soporte - Inspírate SENA')

@section('styles')
    @vitebuilt
        @vite(['resources/css/soporte.css'])
    @endvitebuilt
@endsection

@section('content')
    <section class="soporte-section">
        <div class="soporte-blobs">
            <div class="soporte-blob" style="top:-100px; right:-80px;"></div>
            <div class="soporte-blob"></div>
        </div>
        <div class="soporte-hero-content">
            <span class="hero-badge"><i class="fas fa-headset"></i> Centro de Ayuda</span>
            <h1>¿Cómo podemos <span>ayudarte</span> hoy?</h1>
            <p>Estamos aquí para resolver tus dudas, atender tus sugerencias y brindarte el soporte que necesitas en cada paso de tu experiencia en Inspírate SENA.</p>
        </div>
    </section>

    @if(session('success'))
        <div class="alert-custom" style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- ═══ CARDS DE AYUDA RÁPIDA ═══ --}}
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

    {{-- ═══ PREGUNTAS FRECUENTES ═══ --}}
    <section class="faq-section">
        <div class="faq-header">
            <span class="hero-badge"><i class="fas fa-question-circle"></i> FAQ</span>
            <h2>Preguntas <span>Frecuentes</span></h2>
            <p>Las dudas más comunes resueltas para que encuentres respuesta rápida sin esperar.</p>
        </div>
        <div class="faq-list">
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>¿Cómo publicar un proyecto en la plataforma?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Para publicar un proyecto, inicia sesión con tu cuenta de <strong>Empresa</strong> o <strong>Instructor</strong>. Dirígete a la sección "Proyectos" en tu panel y haz clic en "Crear Proyecto". Completa los datos solicitados (título, descripción, habilidades requeridas, duración estimada) y envía el proyecto a revisión. Un administrador lo validará y lo publicará en la plataforma para que los aprendices puedan postularse.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>¿Cómo postularme a un proyecto siendo aprendiz?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Como <strong>Aprendiz</strong>, inicia sesión en tu panel y ve a la sección "Proyectos". Explora los proyectos disponibles y haz clic en "Ver Detalle" para conocer los requisitos. Si cumples con el perfil, haz clic en "Postularme". El instructor o empresa revisará tu postulación y te notificará el resultado a través del sistema y por correo electrónico.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>¿Cómo actualizar mi perfil y datos personales?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Una vez autenticado, ingresa a la sección <strong>"Perfil"</strong> desde tu panel de control. Allí podrás editar tu nombre, foto de perfil, información de contacto, habilidades y más. No olvides guardar los cambios al finalizar. Recuerda que mantener tu perfil actualizado aumenta tus oportunidades de ser seleccionado en los proyectos.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>¿Cómo cambiar mi contraseña?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Si recuerdas tu contraseña actual, ingresa a <strong>Perfil → Cambiar Contraseña</strong> desde tu panel. Si la olvidaste, haz clic en <strong>"Olvidé mi contraseña"</strong> en la página de inicio de sesión. Ingresa tu correo electrónico y recibirás un enlace seguro para restablecerla. El enlace tiene una validez limitada por razones de seguridad.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>¿Qué hago si no recibo el correo de verificación?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Revisa primero la carpeta de <strong>Spam</strong> o <strong>Correo no deseado</strong>. Si no está allí, ve a la página de <a href="{{ route('verification.resend') }}">Reenviar correo de verificación</a> e ingresa tu dirección de email. Si el problema persiste, contacta a soporte a través del formulario de esta página y te ayudaremos a verificar tu cuenta manualmente.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span>¿Cómo puedo hacer seguimiento a mis postulaciones?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Desde tu panel de <strong>Aprendiz</strong>, ingresa a la sección <strong>"Mis Postulaciones"</strong>. Allí verás el estado de cada una: <span class="badge badge-warning">Pendiente</span>, <span class="badge badge-success">Aceptada</span> o <span class="badge badge-danger">Rechazada</span>. Recibirás una notificación dentro de la plataforma cuando el estado cambie.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CANALES DE CONTACTO ═══ --}}
    <section class="contact-channels">
        <div class="channels-header">
            <span class="hero-badge"><i class="fas fa-headset"></i> Canales de Contacto</span>
            <h2>Estamos aquí <span>para ti</span></h2>
            <p>Elige el canal de tu preferencia y te atenderemos con la mejor disposición.</p>
        </div>
        <div class="channels-grid">
            <div class="channel-card">
                <div class="channel-icon" style="background: var(--primary-soft); color: var(--primary);">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Correo Electrónico</h3>
                <p>Escríbenos y te responderemos en menos de 24 horas hábiles.</p>
                <a href="mailto:atencionalciudadano@sena.edu.co" class="channel-link">
                    <i class="fas fa-external-link-alt"></i> atencionalciudadano@sena.edu.co
                </a>
            </div>
            <div class="channel-card">
                <div class="channel-icon" style="background: #e8f5e9; color: #2e7d32;">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <h3>Línea Telefónica</h3>
                <p>Comunícate con nuestro equipo de soporte en horario laboral.</p>
                <a href="tel:018000910270" class="channel-link">
                    <i class="fas fa-external-link-alt"></i> 018000-910-270
                </a>
                <span class="channel-sub">PBX: (601) 5461500</span>
            </div>
            <div class="channel-card">
                <div class="channel-icon" style="background: #fff3e0; color: #e65100;">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Dirección Física</h3>
                <p>Visítanos en nuestra sede principal para atención personalizada.</p>
                <span class="channel-link" style="cursor: default;">
                    <i class="fas fa-external-link-alt"></i> Dg. 18 #111, Malambo, Atlántico
                </span>
            </div>
            <div class="channel-card">
                <div class="channel-icon" style="background: #e8f5e9; color: #1b5e20;">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h3>WhatsApp</h3>
                <p>Atención rápida y mensajería instantánea para consultas breves.</p>
                <a href="https://wa.me/576015461500" target="_blank" rel="noopener noreferrer" class="channel-link">
                    <i class="fas fa-external-link-alt"></i> Escríbenos por WhatsApp
                </a>
            </div>
        </div>
    </section>

    {{-- ═══ HORARIOS Y TIEMPOS DE RESPUESTA ═══ --}}
    <section class="info-bar">
        <div class="info-bar-content">
            <div class="info-bar-item">
                <div class="info-bar-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <strong>Horario de Atención</strong>
                    <p>Lunes a Viernes: 7:00 AM - 7:00 PM<br>Sábados: 8:00 AM - 1:00 PM</p>
                </div>
            </div>
            <div class="info-bar-divider"></div>
            <div class="info-bar-item">
                <div class="info-bar-icon"><i class="fas fa-bolt"></i></div>
                <div>
                    <strong>Tiempo de Respuesta</strong>
                    <p>Correo: hasta 24 horas hábiles<br>WhatsApp / Teléfono: respuesta inmediata</p>
                </div>
            </div>
            <div class="info-bar-divider"></div>
            <div class="info-bar-item">
                <div class="info-bar-icon"><i class="fas fa-shield-alt"></i></div>
                <div>
                    <strong>Compromiso de Calidad</strong>
                    <p>Resolvemos tu solicitud con la máxima dedicación y confidencialidad.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ FORMULARIO DE CONTACTO ═══ --}}
    <section class="form-section">
        <div class="form-container">
            <h2>Envía tu consulta</h2>
            <p class="form-subtitle">Estaremos encantados de ayudarte, respetamos tu tiempo.</p>
            <form id="form-soporte-ajax" action="{{ route('soporte.enviar') }}" method="POST">
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
                            <option value="Problema técnico">Problema Técnico</option>
                            <option value="Solicitud de información">Solicitud de Información</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje</label>
                    <div class="input-wrapper">
                        <i class="fas fa-comment-dots" style="top: 20px; transform: none;"></i>
                        <textarea id="mensaje" name="mensaje" class="form-control" placeholder="Describe detalladamente tu situación. Incluye toda la información relevante para que podamos ayudarte mejor." rows="6" required></textarea>
                    </div>
                </div>
                <button type="submit" class="form-submit" id="btn-soporte-enviar">
                    Enviar solicitud <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </section>

    {{-- ═══ CTA ═══ --}}
    <section class="soporte-cta">
        <div class="soporte-cta-content">
            <h2>¿No encuentras lo que buscas?</h2>
            <p>Nuestro equipo está listo para brindarte atención personalizada. Explora la plataforma o contáctanos directamente.</p>
            <div class="soporte-cta-actions">
                <a href="{{ route('home') }}" class="btn btn-outline">
                    <i class="fas fa-home"></i> Volver al Inicio
                </a>
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fas fa-rocket"></i> Ir a mi Panel
                </a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    function toggleFaq(btn) {
        const item = btn.parentElement;
        const answer = item.querySelector('.faq-answer');
        const icon = btn.querySelector('i');
        const isOpen = item.classList.contains('active');

        document.querySelectorAll('.faq-item.active').forEach(el => {
            if (el !== item) {
                el.classList.remove('active');
                el.querySelector('.faq-answer').style.maxHeight = null;
                el.querySelector('.faq-question i').className = 'fas fa-chevron-down';
            }
        });

        if (isOpen) {
            item.classList.remove('active');
            answer.style.maxHeight = null;
            icon.className = 'fas fa-chevron-down';
        } else {
            item.classList.add('active');
            answer.style.maxHeight = answer.scrollHeight + 'px';
            icon.className = 'fas fa-chevron-up';
        }
    }

    document.getElementById('form-soporte-ajax').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('btn-soporte-enviar');
        ajax.disableButton(btn, 'Enviando...');
        ajax.post(this.action, new FormData(this)).then(res => {
            ajax.showToast('success', res.data.message);
            this.reset();
            ajax.enableButton(btn);
        }).catch(err => {
            ajax.enableButton(btn);
            ajax.showToast('error', err.response?.data?.message || 'Error al enviar mensaje.');
        });
    });
</script>
@endsection
