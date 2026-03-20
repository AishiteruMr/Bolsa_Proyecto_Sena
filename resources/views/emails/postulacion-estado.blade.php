<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Postulación</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background:#f4f6f9; padding:40px 20px; margin:0;">
    <div style="max-width:600px; margin:auto; background:#ffffff; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.08); overflow:hidden;">

        @if($nuevoEstado === 'Aprobada')
        <!-- Aprobada Header -->
        <div style="background:linear-gradient(135deg,#39a900,#2d8500); padding:36px 40px; text-align:center;">
            <div style="font-size:56px; margin-bottom:12px;">🎉</div>
            <h1 style="color:#ffffff; margin:0; font-size:22px; font-weight:700;">¡Postulación Aprobada!</h1>
            <p style="color:rgba(255,255,255,0.85); margin:8px 0 0; font-size:14px;">¡Felicitaciones! Has sido seleccionado</p>
        </div>
        @else
        <!-- Rechazada Header -->
        <div style="background:linear-gradient(135deg,#e74c3c,#c0392b); padding:36px 40px; text-align:center;">
            <div style="font-size:56px; margin-bottom:12px;">😔</div>
            <h1 style="color:#ffffff; margin:0; font-size:22px; font-weight:700;">Postulación No Aprobada</h1>
            <p style="color:rgba(255,255,255,0.85); margin:8px 0 0; font-size:14px;">Gracias por tu interés en este proyecto</p>
        </div>
        @endif

        <!-- Body -->
        <div style="padding:36px 40px;">
            <p style="font-size:16px; color:#2c3e50; margin:0 0 20px;">
                Hola <strong>{{ $aprendizNombre }}</strong>,
            </p>

            @if($nuevoEstado === 'Aprobada')
            <p style="font-size:15px; color:#555; line-height:1.7; margin:0 0 24px;">
                ¡Excelentes noticias! Tu postulación al proyecto <strong style="color:#39a900;">{{ $proyectoTitulo }}</strong> ha sido <strong style="color:#39a900;">aprobada</strong>.
                Ya puedes acceder a los detalles completos del proyecto, etapas y hacer seguimiento desde tu panel.
            </p>

            <!-- What's next box -->
            <div style="background:#f8fbf5; border:1px solid #d4edcc; border-radius:12px; padding:20px 24px; margin-bottom:24px;">
                <p style="font-size:14px; color:#2c3e50; font-weight:700; margin:0 0 12px;">📌 ¿Qué sigue?</p>
                <ul style="margin:0; padding-left:18px; color:#555; font-size:14px; line-height:2;">
                    <li>Ingresa a tu panel de aprendiz</li>
                    <li>Revisa las etapas del proyecto</li>
                    <li>Sube tus evidencias en cada etapa</li>
                    <li>El instructor hará seguimiento de tu progreso</li>
                </ul>
            </div>

            <div style="text-align:center; margin:24px 0 10px;">
                <a href="{{ url('/aprendiz/proyectos/aprobados') }}"
                   style="background:linear-gradient(135deg,#39a900,#2d8500);
                          color:#ffffff;
                          padding:14px 32px;
                          text-decoration:none;
                          border-radius:30px;
                          font-size:15px;
                          font-weight:bold;
                          display:inline-block;">
                    🚀 Ver Mi Proyecto
                </a>
            </div>

            @else
            <p style="font-size:15px; color:#555; line-height:1.7; margin:0 0 24px;">
                Lamentamos informarte que tu postulación al proyecto <strong>{{ $proyectoTitulo }}</strong> ha sido <strong style="color:#e74c3c;">rechazada</strong> en esta ocasión.
            </p>

            <!-- Encouragement box -->
            <div style="background:#fef9f0; border:1px solid #fde68a; border-radius:12px; padding:20px 24px; margin-bottom:24px;">
                <p style="font-size:14px; color:#b45309; font-weight:700; margin:0 0 10px;">💪 ¡No te desanimes!</p>
                <p style="font-size:14px; color:#555; line-height:1.6; margin:0;">
                    Hay muchos proyectos disponibles esperando por talentos como el tuyo. Explora las demás oportunidades y sigue intentándolo.
                </p>
            </div>

            <div style="text-align:center; margin:24px 0 10px;">
                <a href="{{ url('/aprendiz/proyectos') }}"
                   style="background:linear-gradient(135deg,#3498db,#2980b9);
                          color:#ffffff;
                          padding:14px 32px;
                          text-decoration:none;
                          border-radius:30px;
                          font-size:15px;
                          font-weight:bold;
                          display:inline-block;">
                    🔍 Explorar Proyectos
                </a>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div style="background:#f8f9fa; padding:20px 40px; border-top:1px solid #ecf0f1; text-align:center;">
            <p style="font-size:13px; color:#95a5a6; margin:0 0 6px;">Proyecto: <strong>{{ $proyectoTitulo }}</strong></p>
            <p style="font-size:14px; color:#39a900; margin:0; font-weight:600;">Equipo Bolsa de Proyecto — Inspírate SENA</p>
        </div>
    </div>
</body>
</html>
