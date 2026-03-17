<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .container { max-width: 600px; margin: 20px auto; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #005a87 0%, #003d5c 100%); padding: 30px 20px; text-align: center; color: white; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .header p { font-size: 14px; opacity: 0.9; }
        .content { padding: 30px 20px; }
        .greeting { font-size: 16px; color: #333; margin-bottom: 15px; }
        .message { font-size: 14px; color: #666; line-height: 1.6; margin-bottom: 20px; }
        .warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 12px; margin: 20px 0; border-radius: 4px; font-size: 13px; color: #856404; }
        .button-container { text-align: center; margin: 30px 0; }
        .button { display: inline-block; background: #005a87; color: white; text-decoration: none; padding: 12px 30px; border-radius: 5px; font-weight: 600; font-size: 14px; transition: background 0.3s; }
        .button:hover { background: #003d5c; }
        .code { background: #f5f5f5; padding: 15px; border-radius: 4px; text-align: center; margin: 20px 0; }
        .code p { font-size: 12px; color: #999; margin-bottom: 5px; }
        .code-text { font-family: monospace; font-size: 14px; color: #005a87; font-weight: bold; word-break: break-all; }
        .link { background: #f5f5f5; padding: 15px; border-radius: 4px; margin: 20px 0; }
        .link p { font-size: 12px; color: #999; margin-bottom: 5px; }
        .link-text { font-size: 12px; color: #005a87; word-break: break-all; }
        .footer { background: #f9f9f9; padding: 20px; text-align: center; border-top: 1px solid #eee; font-size: 12px; color: #999; }
        .footer a { color: #005a87; text-decoration: none; }
        .expiry { color: #dc3545; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🔐 Recuperar Contraseña</h1>
            <p>Bolsa de Proyectos SENA</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p class="greeting">¡Hola <strong>{{ $nombre }}</strong>!</p>

            <p class="message">
                Recibimos una solicitud para recuperar la contraseña de tu cuenta. Si no realizaste esta solicitud, puedes ignorar este correo con seguridad.
            </p>

            <div class="warning">
                ⏳ Este enlace de recuperación expirará en <strong>30 minutos</strong>. Asegúrate de actuar rápidamente.
            </div>

            <p class="message">
                Para restablecer tu contraseña, haz clic en el botón de abajo:
            </p>

            <div class="button-container">
                <a href="{{ $enlaceRecuperacion }}" class="button">Recuperar Contraseña</a>
            </div>

            <p class="message">
                O copia y pega este enlace en tu navegador:
            </p>

            <div class="link">
                <p>Enlace:</p>
                <p class="link-text">{{ $enlaceRecuperacion }}</p>
            </div>

            <div class="code">
                <p>Código de recuperación:</p>
                <p class="code-text">{{ $token }}</p>
            </div>

            <div style="border-top: 1px solid #eee; padding-top: 20px; margin-top: 20px; font-size: 13px; color: #666; line-height: 1.6;">
                <p><strong>Consejos de seguridad:</strong></p>
                <ul style="margin-left: 20px; margin-top: 8px;">
                    <li>Nunca compartas este correo o el enlace con nadie</li>
                    <li>Los enlaces de recuperación son de un solo uso</li>
                    <li>Si tuviste problemas para recuperar tu contraseña, <a href="mailto:bolsadeproyectossena@gmail.com" style="color: #005a87;">contacta al administrador</a></li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© 2026 Bolsa de Proyectos SENA. Todos los derechos reservados.</p>
            <p style="margin-top: 10px;">
                Este es un correo automático. Por favor no respondas a este mensaje.
            </p>
        </div>
    </div>
</body>
</html>
