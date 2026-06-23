@extends('layouts.app')

@section('title', 'Política de Tratamiento de Datos Personales')
@section('meta_description', 'Política de tratamiento de datos personales de Inspírate SENA, conforme a la Ley 1581 de 2012 y el Decreto 1377 de 2013.')

@section('styles')
<style>
    .pd-hero {
        background: linear-gradient(135deg, #0a1f0a 0%, #1a3a1a 100%);
        padding: 80px 20px 60px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .pd-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 30% 50%, rgba(62,180,137,0.08) 0%, transparent 50%);
    }
    .pd-hero h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: #fff;
        position: relative;
    }
    .pd-hero p {
        color: rgba(255,255,255,0.7);
        max-width: 600px;
        margin: 12px auto 0;
        position: relative;
    }
    .pd-container {
        max-width: 860px;
        margin: 0 auto;
        padding: 50px 24px 80px;
    }
    .pd-section {
        margin-bottom: 36px;
    }
    .pd-section h2 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a2e1a;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid #3eb489;
        display: inline-block;
    }
    .pd-section p, .pd-section li {
        font-size: 0.95rem;
        line-height: 1.7;
        color: #374151;
    }
    .pd-section ul {
        padding-left: 24px;
        margin-top: 8px;
    }
    .pd-section li {
        margin-bottom: 6px;
    }
    .pd-section li strong {
        color: #1a2e1a;
    }
    .pd-badge {
        display: inline-block;
        background: rgba(62,180,137,0.1);
        color: #3eb489;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 14px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    @media (max-width: 640px) {
        .pd-hero h1 { font-size: 1.5rem; }
        .pd-container { padding: 30px 16px 60px; }
    }
</style>
@endsection

@section('content')
<section class="pd-hero">
    <h1>Política de Tratamiento de Datos Personales</h1>
    <p>Conoce cómo recopilamos, usamos y protegemos tus datos personales, conforme a la normatividad colombiana vigente.</p>
</section>

<div class="pd-container">
    <a href="{{ route('home') }}" style="display:inline-flex; align-items:center; gap:8px; margin-bottom:24px; font-size:14px; font-weight:700; color:#3eb489; text-decoration:none;">
        <i class="fas fa-arrow-left"></i> Volver al inicio
    </a>

    <div class="pd-section">
        <span class="pd-badge">Ley 1581 de 2012</span>
        <h2>Responsable del Tratamiento</h2>
        <p><strong>Inspírate SENA</strong>, parte del Servicio Nacional de Aprendizaje (SENA), con domicilio en #16- a 16-123, Dg. 18 #111, Malambo, Atlántico, Colombia. Correo de contacto: <a href="mailto:atencionalciudadano@sena.edu.co">atencionalciudadano@sena.edu.co</a>.</p>
        <p>Actuamos como responsables del tratamiento de sus datos personales, entendiendo el tratamiento en los términos definidos por la Ley 1581 de 2012 y el Decreto 1377 de 2013.</p>
    </div>

    <div class="pd-section">
        <h2>Datos Personales que Recopilamos</h2>
        <p>En el marco de nuestras actividades como Bolsa de Proyectos y Talentos, recopilamos la siguiente información:</p>
        <ul>
            <li><strong>Datos de identificación:</strong> nombres, apellidos, número de documento de identidad, NIT (para empresas).</li>
            <li><strong>Datos de contacto:</strong> correo electrónico, teléfono, dirección.</li>
            <li><strong>Datos académicos y profesionales:</strong> programa de formación, especialidad, hoja de vida, perfil profesional.</li>
            <li><strong>Datos de usuario:</strong> credenciales de acceso, historial de navegación en la plataforma, preferencias.</li>
            <li><strong>Datos de uso:</strong> registro de proyectos, postulaciones, evidencias, calificaciones y evaluaciones.</li>
        </ul>
    </div>

    <div class="pd-section">
        <h2>Finalidades del Tratamiento</h2>
        <p>Sus datos personales serán tratados para las siguientes finalidades:</p>
        <ul>
            <li>Gestionar su registro y autenticación en la plataforma Inspírate SENA.</li>
            <li>Facilitar la conexión entre aprendices, instructores y empresas para la ejecución de proyectos.</li>
            <li>Administrar postulaciones, asignaciones, evaluaciones y certificaciones.</li>
            <li>Enviar comunicaciones relacionadas con el funcionamiento de la plataforma y notificaciones del sistema.</li>
            <li>Generar reportes estadísticos anonimizados para la mejora continua del servicio.</li>
            <li>Cumplir con obligaciones legales y regulatorias aplicables.</li>
            <li>Atender solicitudes, quejas y reclamos a través de nuestro canal de soporte.</li>
        </ul>
    </div>

    <div class="pd-section">
        <h2>Derechos ARCO</h2>
        <p>De conformidad con la Ley 1581 de 2012, usted tiene los siguientes derechos <strong>(ARCO)</strong> sobre sus datos personales:</p>
        <ul>
            <li><strong>Acceso:</strong> Conocer qué datos personales tenemos almacenados y para qué fines son tratados.</li>
            <li><strong>Rectificación:</strong> Solicitar la corrección o actualización de sus datos cuando sean inexactos o incompletos.</li>
            <li><strong>Cancelación:</strong> Solicitar la eliminación de sus datos cuando considere que no están siendo tratados conforme a la ley.</li>
            <li><strong>Oposición:</strong> Oponerse al tratamiento de sus datos personales para fines específicos.</li>
        </ul>
        <p>Para ejercer sus derechos ARCO, puede enviar una solicitud escrita al correo <a href="mailto:atencionalciudadano@sena.edu.co">atencionalciudadano@sena.edu.co</a> o a través de nuestro <a href="{{ route('soporte') }}">canal de soporte</a>. Su solicitud será atendida en un plazo máximo de 15 días hábiles.</p>
    </div>

    <div class="pd-section">
        <h2>Seguridad de los Datos</h2>
        <p>Implementamos medidas de seguridad técnicas, administrativas y físicas para proteger sus datos personales contra accesos no autorizados, pérdida, alteración o divulgación indebida. Estas medidas incluyen:</p>
        <ul>
            <li>Encriptación de contraseñas mediante algoritmos seguros (bcrypt).</li>
            <li>Uso de protocolos HTTPS para la transmisión segura de datos.</li>
            <li>Control de acceso basado en roles (RBAC) para limitar el acceso a la información.</li>
            <li>Monitoreo y registro de actividades (auditoría) para detectar accesos no autorizados.</li>
            <li>Almacenamiento seguro en servidores con protección firewalls y actualizaciones periódicas.</li>
        </ul>
    </div>

    <div class="pd-section">
        <h2>Transferencia de Datos</h2>
        <p>Sus datos personales podrán ser compartidos con:</p>
        <ul>
            <li><strong>Entidades educativas:</strong> Instructores SENA asignados a sus proyectos para fines de seguimiento académico.</li>
            <li><strong>Empresas aliadas:</strong> Cuando usted se postula a un proyecto, la empresa correspondiente podrá acceder a su perfil y datos de postulación.</li>
            <li><strong>Autoridades competentes:</strong> Cuando sea requerido por ley o por orden judicial.</li>
        </ul>
        <p>No compartiremos sus datos personales con terceros para fines comerciales sin su consentimiento previo y expreso.</p>
    </div>

    <div class="pd-section">
        <h2>Conservación de los Datos</h2>
        <p>Conservaremos sus datos personales durante el tiempo necesario para cumplir con las finalidades descritas en esta política, y posteriormente durante los plazos legales aplicables. Una vez cumplidos dichos plazos, procederemos a la eliminación segura de sus datos.</p>
    </div>

    <div class="pd-section">
        <h2>Actualizaciones de la Política</h2>
        <p>Nos reservamos el derecho de modificar esta política en cualquier momento. Las modificaciones serán notificadas a través de la plataforma y, cuando sea necesario, mediante comunicación directa a su correo electrónico registrado. Le recomendamos revisar periódicamente esta página para mantenerse informado sobre cómo protegemos sus datos.</p>
        <p><em>Última actualización: {{ date('d/m/Y') }}</em></p>
    </div>

    <div class="pd-section">
        <h2>Legislación Aplicable</h2>
            <p>Consulte también nuestros <a href="{{ route('terminos.condiciones') }}" style="color: var(--primary);">Términos y Condiciones</a> para conocer las reglas de uso de la plataforma.</p>
            <p>Esta política se rige por la legislación colombiana, en particular por:</p>
        <ul>
            <li>Ley 1581 de 2012 - "Por la cual se dictan disposiciones generales para la protección de datos personales".</li>
            <li>Decreto 1377 de 2013 - Reglamentario de la Ley 1581 de 2012.</li>
            <li>Sentencia C-748 de 2011 de la Corte Constitucional.</li>
        </ul>
    </div>
</div>
@endsection
