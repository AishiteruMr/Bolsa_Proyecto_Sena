<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Asignado</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background:#f0f3ff; padding:40px 20px; margin:0;">
    <div style="max-width:620px; margin:auto; background:#ffffff; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.08); overflow:hidden;">

        <!-- Header -->
        <div style="background:linear-gradient(135deg,#39a900,#2d8500); padding:36px 40px; text-align:center;">
            <div style="font-size:52px; margin-bottom:12px;">🎓</div>
            <h1 style="color:#ffffff; margin:0; font-size:22px; font-weight:700;">Nuevo Proyecto Asignado</h1>
            <p style="color:rgba(255,255,255,0.85); margin:8px 0 0; font-size:14px;">Se te ha asignado un proyecto para supervisar</p>
        </div>

        <!-- Body -->
        <div style="padding:36px 40px;">
            <p style="font-size:16px; color:#2c3e50; margin:0 0 20px;">
                Hola <strong style="color:#39a900;">{{ $instructorNombre }}</strong>,
            </p>
            <p style="font-size:15px; color:#555; line-height:1.7; margin:0 0 24px;">
                El administrador te ha asignado como instructor responsable del siguiente proyecto. A continuación encontrarás los detalles:
            </p>

            <!-- Project Card -->
            <div style="background:#f8fbf5; border:1px solid #d4edcc; border-radius:12px; padding:24px; margin-bottom:24px;">
                <h2 style="color:#2c3e50; font-size:18px; margin:0 0 16px; border-bottom:2px solid #39a900; padding-bottom:10px;">
                    📁 {{ $proyecto->titulo }}
                </h2>

                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="padding:8px 0; color:#555; font-size:14px;">
                            <span style="display:inline-block; background:#39a900; color:#fff; border-radius:20px; padding:3px 12px; font-size:12px; font-weight:600;">{{ $proyecto->categoria }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#555; font-size:14px;">
                            🏢 <strong>Empresa:</strong> {{ $proyecto->nombre }}
                        </td>
                    </tr>
                    @if(!empty($proyecto->pro_ubicacion))
                    <tr>
                        <td style="padding:8px 0; color:#555; font-size:14px;">
                            📍 <strong>Ubicación:</strong> {{ $proyecto->pro_ubicacion }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td style="padding:8px 0; color:#555; font-size:14px;">
                            📅 <strong>Publicado:</strong> {{ \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d/m/Y') }}
                        </td>
                    </tr>
                    @if(!empty($proyecto->fecha_finalizacion))
                    <tr>
                        <td style="padding:8px 0; color:#555; font-size:14px;">
                            🏁 <strong>Finalización estimada:</strong> {{ \Carbon\Carbon::parse($proyecto->fecha_finalizacion)->format('d/m/Y') }}
                        </td>
                    </tr>
                    @endif
                    @if(!empty($proyecto->duracion_estimada_dias))
                    <tr>
                        <td style="padding:8px 0; color:#555; font-size:14px;">
                            ⏳ <strong>Duración:</strong> {{ $proyecto->duracion_estimada_dias }} días
                        </td>
                    </tr>
                    @endif
                </table>

                <div style="margin-top:16px; padding-top:16px; border-top:1px solid #d4edcc;">
                    <p style="font-size:13px; color:#555; margin:0 0 8px;"><strong>📝 Descripción:</strong></p>
                    <p style="font-size:13px; color:#666; margin:0; line-height:1.6; background:#fff; padding:12px; border-radius:8px; border-left:3px solid #39a900;">
                        {{ $proyecto->descripcion }}
                    </p>
                </div>

                @if(!empty($proyecto->habilidades_requeridas))
                <div style="margin-top:14px;">
                    <p style="font-size:13px; color:#555; margin:0 0 6px;"><strong>💡 Habilidades que supervisa:</strong></p>
                    <p style="font-size:13px; color:#666; margin:0;">{{ $proyecto->habilidades_requeridas }}</p>
                </div>
                @endif
            </div>

            <!-- Postulaciones Badge -->
            @if($totalPostulaciones > 0)
            <div style="background:#e8f4fd; border:1px solid #bee3f8; border-radius:10px; padding:16px 20px; margin-bottom:24px; text-align:center;">
                <p style="margin:0; color:#2b6cb0; font-size:15px; font-weight:600;">
                    👥 {{ $totalPostulaciones }} {{ $totalPostulaciones === 1 ? 'postulación pendiente' : 'postulaciones pendientes' }} de revisión
                </p>
                <p style="margin:8px 0 0; color:#4a90c4; font-size:13px;">Ingresa para revisar y aprobar/rechazar candidatos.</p>
            </div>
            @endif

            <!-- CTA Button -->
            <div style="text-align:center; margin:24px 0 10px;">
                <a href="{{ url('/instructor/dashboard') }}"
                   style="background:linear-gradient(135deg,#39a900,#2d8500);
                          color:#ffffff;
                          padding:14px 32px;
                          text-decoration:none;
                          border-radius:30px;
                          font-size:15px;
                          font-weight:bold;
                          display:inline-block;">
                    🚀 Ir a Mi Panel
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="background:#f8fbf5; padding:20px 40px; border-top:1px solid #e9f5e1; text-align:center;">
            <p style="font-size:13px; color:#95a5a6; margin:0 0 6px;">Si tienes dudas, contacta al administrador.</p>
            <p style="font-size:14px; color:#39a900; margin:0; font-weight:600;">Equipo Bolsa de Proyecto — Inspírate SENA</p>
        </div>
    </div>
</body>
</html>
