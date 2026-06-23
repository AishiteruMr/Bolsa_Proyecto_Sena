@extends('layouts.app')

@section('title', 'Términos y Condiciones')
@section('meta_description', 'Términos y condiciones de uso de la plataforma Inspírate SENA, conforme a la legislación colombiana.')

@section('styles')
<style>
    .tc-hero {
        background: linear-gradient(135deg, #0a1f0a 0%, #1a3a1a 100%);
        padding: 80px 20px 60px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .tc-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 30% 50%, rgba(62,180,137,0.08) 0%, transparent 50%);
    }
    .tc-hero h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: #fff;
        position: relative;
    }
    .tc-hero p {
        color: rgba(255,255,255,0.7);
        max-width: 600px;
        margin: 12px auto 0;
        position: relative;
    }
    .tc-container {
        max-width: 860px;
        margin: 0 auto;
        padding: 50px 24px 80px;
    }
    .tc-section {
        margin-bottom: 36px;
    }
    .tc-section h2 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a2e1a;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid #3eb489;
        display: inline-block;
    }
    .tc-section h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1a2e1a;
        margin-top: 20px;
        margin-bottom: 8px;
    }
    .tc-section p, .tc-section li {
        font-size: 0.95rem;
        line-height: 1.7;
        color: #374151;
    }
    .tc-section ul {
        padding-left: 24px;
        margin-top: 8px;
    }
    .tc-section li {
        margin-bottom: 6px;
    }
    .tc-section li strong {
        color: #1a2e1a;
    }
    .tc-badge {
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
        .tc-hero h1 { font-size: 1.5rem; }
        .tc-container { padding: 30px 16px 60px; }
    }
</style>
@endsection

@section('content')
<section class="tc-hero">
    <h1>Términos y Condiciones</h1>
    <p>Condiciones generales de uso de la plataforma Inspírate SENA.</p>
</section>

<div class="tc-container">
    <a href="{{ route('home') }}" style="display:inline-flex; align-items:center; gap:8px; margin-bottom:24px; font-size:14px; font-weight:700; color:#3eb489; text-decoration:none;">
        <i class="fas fa-arrow-left"></i> Volver al inicio
    </a>

    <div class="tc-section">
        <span class="tc-badge">Ley 1581 de 2012</span>
        <h2>1. Aceptación de los Términos</h2>
        <p>Al registrarse y hacer uso de la plataforma <strong>Inspírate SENA</strong>, usted declara haber leído, entendido y aceptado los presentes Términos y Condiciones. Si no está de acuerdo con alguno de ellos, deberá abstenerse de utilizar la plataforma.</p>
        <p>Estos términos se rigen por la legislación colombiana, en especial por la Ley 1581 de 2012, el Decreto 1377 de 2013, el Código de Comercio y las demás disposiciones aplicables.</p>
    </div>

    <div class="tc-section">
        <h2>2. Descripción del Servicio</h2>
        <p>Inspírate SENA es una plataforma tecnológica que conecta a <strong>aprendices, instructores y empresas</strong> para facilitar la ejecución de proyectos formativos y la vinculación laboral. A través de la plataforma, los usuarios pueden:</p>
        <ul>
            <li>Crear y gestionar perfiles profesionales.</li>
            <li>Publicar y postularse a proyectos.</li>
            <li>Realizar seguimiento académico y evaluaciones.</li>
            <li>Generar evidencias de aprendizaje.</li>
            <li>Comunicarse a través de la mensajería interna.</li>
        </ul>
    </div>

    <div class="tc-section">
        <h2>3. Registro y Responsabilidades del Usuario</h2>
        <h3>3.1. Veracidad de la Información</h3>
        <p>El usuario se obliga a proporcionar información veraz, completa y actualizada durante el proceso de registro y durante el uso de la plataforma. La suplantación de identidad o el suministro de información falsa será causal de suspensión inmediata de la cuenta.</p>

        <h3>3.2. Confidencialidad de Credenciales</h3>
        <p>El usuario es el único responsable de la custodia de su contraseña y de todas las actividades que se realicen desde su cuenta. Deberá notificar de inmediato al administrador cualquier uso no autorizado de su cuenta a través del <a href="{{ route('soporte') }}">canal de soporte</a>.</p>

        <h3>3.3. Uso Aceptable</h3>
        <p>El usuario se compromete a utilizar la plataforma de manera ética y responsable, absteniéndose de:</p>
        <ul>
            <li>Publicar contenido falso, ofensivo, discriminatorio o ilegal.</li>
            <li>Realizar actividades que vulneren derechos de propiedad intelectual.</li>
            <li>Intentar acceder a datos de otros usuarios sin autorización.</li>
            <li>Utilizar la plataforma para fines distintos a los previstos.</li>
        </ul>
    </div>

    <div class="tc-section">
        <h2>4. Activación de Cuentas</h2>
        <p>Una vez realizado el registro, la cuenta del usuario quedará en estado <strong>pendiente de activación</strong>. Un administrador del SENA validará la información suministrada y procederá a la activación. Durante este periodo, el usuario no podrá acceder a las funcionalidades de la plataforma.</p>
        <p>El SENA se reserva el derecho de denegar la activación de cualquier cuenta que no cumpla con los requisitos establecidos o que represente un riesgo para la plataforma.</p>
    </div>

    <div class="tc-section">
        <h2>5. Propiedad Intelectual</h2>
        <p>Los contenidos, diseños, logos, imágenes y código fuente de la plataforma Inspírate SENA son propiedad del <strong>Servicio Nacional de Aprendizaje (SENA)</strong> o cuentan con las licencias correspondientes. Queda prohibida su reproducción, modificación o distribución sin autorización expresa.</p>
        <p>Los proyectos, evidencias y demás contenidos subidos por los usuarios son de su autoría y estos conservan sus derechos de propiedad intelectual. Al publicarlos en la plataforma, el usuario otorga al SENA una licencia no exclusiva para su visualización y evaluación dentro del ámbito del servicio.</p>
    </div>

    <div class="tc-section">
        <h2>6. Limitación de Responsabilidad</h2>
        <p>El SENA no se hace responsable por:</p>
        <ul>
            <li>Daños o perjuicios derivados del uso indebido de la plataforma por parte de los usuarios.</li>
            <li>Interrupciones del servicio por causas de fuerza mayor o mantenimiento técnico.</li>
            <li>Contenido publicado por terceros que pueda resultar ofensivo o inexacto.</li>
            <li>Pérdida de datos por incumplimiento del usuario en la realización de copias de seguridad.</li>
        </ul>
    </div>

    <div class="tc-section">
        <h2>7. Privacidad y Tratamiento de Datos</h2>
        <p>El tratamiento de los datos personales recopilados a través de la plataforma se rige por nuestra <a href="{{ route('politica.datos') }}">Política de Tratamiento de Datos Personales</a>, elaborada conforme a la Ley 1581 de 2012 y el Decreto 1377 de 2013. Lo invitamos a consultarla para conocer detalles sobre la recopilación, uso y protección de su información personal.</p>
    </div>

    <div class="tc-section">
        <h2>8. Suspensión y Cancelación</h2>
        <p>El SENA se reserva el derecho de suspender o cancelar cuentas que:</p>
        <ul>
            <li>Incumplan los presentes Términos y Condiciones.</li>
            <li>Realicen actividades fraudulentas o ilegales.</li>
            <li>Permanentemente inactivas por más de 12 meses.</li>
            <li>A solicitud expresa del usuario o de una autoridad competente.</li>
        </ul>
        <p>En caso de cancelación, los datos personales serán tratados conforme a lo establecido en la Política de Tratamiento de Datos Personales.</p>
    </div>

    <div class="tc-section">
        <h2>9. Modificaciones</h2>
        <p>El SENA se reserva el derecho de modificar los presentes Términos y Condiciones en cualquier momento. Las modificaciones serán notificadas a través de la plataforma y, cuando sea necesario, mediante comunicación directa al correo electrónico registrado por el usuario. El uso continuado de la plataforma después de dichas modificaciones constituye la aceptación de los nuevos términos.</p>
    </div>

    <div class="tc-section">
        <h2>10. Legislación Aplicable y Jurisdicción</h2>
        <p>Estos Términos y Condiciones se rigen por las leyes de la República de Colombia. Cualquier controversia que surja en relación con estos términos será sometida a los jueces y tribunales de la ciudad de Malambo, Atlántico, Colombia.</p>
        <ul>
            <li>Ley 1581 de 2012 - Protección de Datos Personales.</li>
            <li>Decreto 1377 de 2013 - Reglamentario de la Ley 1581 de 2012.</li>
            <li>Ley 527 de 1999 - Comercio Electrónico y Mensajes de Datos.</li>
            <li>Ley 1480 de 2011 - Estatuto del Consumidor.</li>
            <li>Sentencia C-748 de 2011 - Corte Constitucional.</li>
        </ul>
    </div>

    <div class="tc-section">
        <h2>11. Contacto</h2>
        <p>Para cualquier inquietud relacionada con estos Términos y Condiciones, puede contactarnos a través de:</p>
        <ul>
            <li><strong>Correo electrónico:</strong> <a href="mailto:atencionalciudadano@sena.edu.co">atencionalciudadano@sena.edu.co</a></li>
            <li><strong>Plataforma:</strong> <a href="{{ route('soporte') }}">Centro de Soporte</a></li>
            <li><strong>Dirección:</strong> #16- a 16-123, Dg. 18 #111, Malambo, Atlántico, Colombia.</li>
        </ul>
        <p><em>Última actualización: {{ date('d/m/Y') }}</em></p>
    </div>
</div>
@endsection
