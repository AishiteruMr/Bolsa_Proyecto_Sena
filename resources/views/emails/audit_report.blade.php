<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Seguridad - SENA</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 0; color: #1e293b;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f1f5f9; width: 100%;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06); margin: 0 auto;">

                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); padding: 40px 30px 36px;">
                            <h1 style="color: #ffffff; font-size: 22px; font-weight: 800; margin: 0 0 6px; letter-spacing: -0.3px;">Reporte de Auditor&iacute;a</h1>
                            <p style="color: #94a3b8; font-size: 15px; margin: 0; font-weight: 400;">Bolsa de Proyectos SENA</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 36px 32px 32px; background-color: #ffffff;">
                            <p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px 0;">
                                Se ha generado un nuevo reporte de auditor&iacute;a de seguridad para la plataforma.
                            </p>

                            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; font-family: 'Courier New', Courier, monospace; font-size: 13px; color: #334155; line-height: 1.5; white-space: pre-wrap; word-break: break-word;">{{ json_encode($report, JSON_PRETTY_PRINT) }}</div>
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
