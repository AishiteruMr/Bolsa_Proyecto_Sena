<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postulación Recibida</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background:#f0f7ee; padding:40px 20px; margin:0;">
    <div style="max-width:620px; margin:auto; background:#ffffff; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.08); overflow:hidden;">

        <!-- Header -->
        <div style="background:linear-gradient(135deg,#39a900,#2d8500); padding:36px 40px; text-align:center;">
            <div style="font-size:48px; margin-bottom:12px;">📋</div>
            <h1 style="color:#ffffff; margin:0; font-size:22px; font-weight:700; letter-spacing:-0.3px;">¡Postulación Enviada!</h1>
            <p style="color:rgba(255,255,255,0.85); margin:8px 0 0; font-size:14px;">Tu solicitud ha sido recibida correctamente</p>
        </div>

        <!-- Body -->
        <div style="padding:36px 40px;">
            <p style="font-size:16px; color:#2c3e50; margin:0 0 20px;">
                Hola <strong style="color:#39a900;">{{ $aprendizNombre }}</strong>,
            </p>
            <p style="font-size:15px; color:#555; line-height:1.7; margin:0 0 24px;">
                Hemos registrado tu postulación al siguiente proyecto. A continuación encontrarás todos los detalles:
            </p>

            <!-- Project Card -->
            <div style="background:#f8fbf5; border:1px solid #d4edcc; border-radius:12px; padding:24px; margin-bottom:24px;">
                <h2 style="color:#2c3e50; font-size:18px; margin:0 0 16px; border-bottom:2px solid #39a900; padding-bottom:10px;">
                    {{ $proyecto->pro_titulo_proyecto }}
                </h2>

                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="padding:7px 0; vertical-align:top;">
                            <span style="display:inline-block; background:#39a900; color:#fff; border-radius:20px; padding:3px 12px; font-size:12px; font-weight:600;">{{ $proyecto->pro_categoria }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:7px 0; color:#555; font-size:14px;">
                            🏢 <strong>Empresa:</strong> {{ $proyecto->emp_nombre }}
                        </td>
                    </tr>
                    @if(!empty($proyecto->pro_ubicacion))
                    <tr>
                        <td style="padding:7px 0; color:#555; font-size:14px;">
                            📍 <strong>Ubicación:</strong> {{ $proyecto->pro_ubicacion }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding:7px 0; color:#555; font-size:14px;">
                            📅 <strong>Fecha de publicación:</strong> {{ \Carbon\Carbon::parse($proyecto->pro_fecha_publi)->format('d/m/Y') }}
                        </td>
                    </tr>
                    @if(!empty($proyecto->pro_fecha_finalizacion))
                    <tr>
                        <td style="padding:7px 0; color:#555; font-size:14px;">
                            🏁 <strong>Fecha de finalización:</strong> {{ \Carbon\Carbon::parse($proyecto->pro_fecha_finalizacion)->format('d/m/Y') }}
                        </td>
                    </tr>
                    @endif
                    @if(!empty($proyecto->pro_duracion_estimada))
                    <tr>
                        <td style="padding:7px 0; color:#555; font-size:14px;">
                            ⏳ <strong>Duración estimada:</strong> {{ $proyecto->pro_duracion_estimada }} días
                        </td>
                    </tr>
                    @endif
                </table>

                <div style="margin-top:16px; padding-top:16px; border-top:1px solid #d4edcc;">
                    <p style="font-size:13px; color:#555; margin:0 0 10px;"><strong>📝 Descripción:</strong></p>
                    <p style="font-size:13px; color:#666; line-height:1.6; margin:0; background:#fff; padding:12px; border-radius:8px; border-left:3px solid #39a900;">{{ $proyecto->pro_descripcion }}</p>
                </div>

                @if(!empty($proyecto->pro_requisitos_especificos))
                <div style="margin-top:14px;">
                    <p style="font-size:13px; color:#555; margin:0 0 6px;"><strong>📌 Requisitos:</strong></p>
                    <p style="font-size:13px; color:#666; margin:0;">{{ $proyecto->pro_requisitos_especificos }}</p>
                </div>
                @endif

                @if(!empty($proyecto->pro_habilidades_requerida))
                <div style="margin-top:14px;">
                    <p style="font-size:13px; color:#555; margin:0 0 6px;"><strong>💡 Habilidades requeridas:</strong></p>
                    <p style="font-size:13px; color:#666; margin:0;">{{ $proyecto->pro_habilidades_requerida }}</p>
                </div>
                @endif
            </div>

            <!-- Status Badge -->
            <div style="background:#fff8e1; border:1px solid #ffe082; border-radius:10px; padding:14px 18px; margin-bottom:24px; text-align:center;">
                <p style="margin:0; color:#b67c00; font-size:14px; font-weight:600;">
                    🕐 Estado actual: <span style="background:#ffc107; color:#fff; padding:3px 10px; border-radius:20px; font-size:12px;">Pendiente</span>
                </p>
                <p style="margin:8px 0 0; color:#888; font-size:13px;">El instructor revisará tu postulación y recibirás un correo cuando cambie el estado.</p>
            </div>

            <!-- CTA Button -->
            <div style="text-align:center; margin:28px 0 10px;">
                <a href="{{ url('/aprendiz/postulaciones') }}"
                   style="background:linear-gradient(135deg,#39a900,#2d8500);
                          color:#ffffff;
                          padding:14px 32px;
                          text-decoration:none;
                          border-radius:30px;
                          font-size:15px;
                          font-weight:bold;
                          display:inline-block;
                          letter-spacing:0.3px;">
                    📋 Ver Mis Postulaciones
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background:#f8fbf5; padding:20px 40px; border-top:1px solid #e9f5e1; text-align:center;">
            <p style="font-size:13px; color:#95a5a6; margin:0 0 6px;">Si no realizaste esta acción, puedes ignorar este mensaje.</p>
            <p style="font-size:14px; color:#39a900; margin:0; font-weight:600;">Equipo Bolsa de Proyecto — Inspírate SENA</p>
        </div>
    </div>
</body>
</html>
