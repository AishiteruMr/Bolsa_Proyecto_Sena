<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respuesta a tu solicitud - SENA</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 0; color: #1e293b;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f1f5f9; width: 100%;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06); margin: 0 auto;">

                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #065f46 0%, #047857 40%, #10b981 100%); padding: 40px 30px 36px;">
                            <div style="margin-bottom: 16px;">
                                <span style="display: inline-block; background: rgba(255,255,255,0.15); border-radius: 50%; width: 64px; height: 64px; line-height: 64px; font-size: 30px;">💬</span>
                            </div>
                            <h1 style="color: #ffffff; font-size: 22px; font-weight: 800; margin: 0 0 6px; letter-spacing: -0.3px;">Respuesta a tu Solicitud</h1>
                            <p style="color: #a7f3d0; font-size: 15px; margin: 0; font-weight: 400; opacity: 0.95;">Hemos procesado tu consulta</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 36px 32px 32px; background-color: #ffffff;">
                            <p style="font-size: 16px; color: #334155; margin: 0 0 20px 0; line-height: 1.6;">
                                Hola <strong style="color: #065f46;">{{ $nombre }}</strong>,
                            </p>
                            <p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 28px 0;">
                                Hemos procesado tu consulta sobre <strong>{{ $motivo }}</strong> y tenemos una respuesta para ti.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; margin-bottom: 20px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <p style="font-size: 12px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; margin: 0 0 8px 0;">Tu consulta original</p>
                                        <p style="font-size: 14px; color: #334155; margin: 0; line-height: 1.6; font-style: italic;">&ldquo;{{ $mensaje }}&rdquo;</p>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-left: 5px solid #2563eb; border-radius: 10px; margin-bottom: 28px;">
                                <tr>
                                    <td style="padding: 16px 20px;">
                                        <p style="font-size: 12px; color: #1d4ed8; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; margin: 0 0 8px 0;">Nuestra respuesta</p>
                                        <p style="font-size: 15px; color: #1e293b; margin: 0; line-height: 1.6; font-weight: 500;">{{ $respuesta }}</p>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 14px; color: #475569; line-height: 1.6; margin: 0 0 4px 0;">Gracias por tu paciencia y por confiar en nosotros.</p>
                            <p style="font-size: 14px; color: #475569; margin: 0;">Atentamente,</p>
                            <p style="font-size: 15px; color: #065f46; font-weight: 700; margin: 4px 0 0 0;">Equipo Bolsa de Proyecto SENA</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 32px; text-align: center;">
                            <table cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto;">
                                <tr>
                                    <td style="background-color: #065f46; border-radius: 6px; padding: 10px 24px;">
                                        <span style="color: #ffffff; font-size: 14px; font-weight: 700; letter-spacing: 0.3px;">SENA</span>
                                        <span style="color: #6ee7b7; font-size: 13px; margin-left: 8px;">Bolsa de Proyecto</span>
                                    </td>
                                </tr>
                            </table>
                            <p style="font-size: 12px; color: #cbd5e1; margin: 14px 0 0 0;">&copy; {{ date('Y') }} Servicio Nacional de Aprendizaje</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
