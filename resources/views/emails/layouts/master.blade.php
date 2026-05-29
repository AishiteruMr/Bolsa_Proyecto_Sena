<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bolsa de Proyecto - SENA')</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 0; color: #1e293b;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f1f5f9; width: 100%;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06); margin: 0 auto;">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #065f46 0%, #047857 40%, #10b981 100%); padding: 40px 30px 36px;">
                            <div style="margin-bottom: 16px;">
                                <span style="display: inline-block; background: rgba(255,255,255,0.15); border-radius: 50%; width: 64px; height: 64px; line-height: 64px; font-size: 30px;">@yield('header_icon', '📬')</span>
                            </div>
                            <h1 style="color: #ffffff; font-size: 22px; font-weight: 800; margin: 0 0 6px; letter-spacing: -0.3px;">@yield('header_title')</h1>
                            @hasSection('header_subtitle')
                            <p style="color: #a7f3d0; font-size: 15px; margin: 0; font-weight: 400; opacity: 0.95;">@yield('header_subtitle')</p>
                            @endif
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 36px 32px 32px; background-color: #ffffff;">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 24px 32px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 16px;">
                                        <span style="font-size: 13px; color: #94a3b8; line-height: 1.5; display: block;">
                                            Si no realizaste esta acci&oacute;n, ignora este correo de forma segura.
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="background-color: #065f46; border-radius: 6px; padding: 10px 24px;">
                                                    <span style="color: #ffffff; font-size: 14px; font-weight: 700; letter-spacing: 0.3px;">SENA</span>
                                                    <span style="color: #6ee7b7; font-size: 13px; margin-left: 8px;">Bolsa de Proyecto</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding-top: 14px;">
                                        <span style="font-size: 12px; color: #cbd5e1; margin: 0;">
                                            &copy; {{ date('Y') }} Servicio Nacional de Aprendizaje
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
