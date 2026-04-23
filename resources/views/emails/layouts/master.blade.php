<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Notificación - SENA')</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 40px 20px; color: #1e293b;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f8fafc; width: 100%;">
        <tr>
            <td align="center">
                <!-- Tarjeta Principal -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01); margin: 0 auto; border: 1px solid #f1f5f9;">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #047857 0%, #10b981 100%); padding: 45px 20px; border-bottom: 3px solid #065f46;">
                            <div style="font-size: 42px; margin-bottom: 12px; line-height: 1;">@yield('header_icon', '✉️')</div>
                            <h1 style="color: #ffffff; font-size: 24px; font-weight: 700; margin: 0; padding: 0; letter-spacing: -0.5px;">@yield('header_title')</h1>
                            @hasSection('header_subtitle')
                            <p style="color: #d1fae5; font-size: 15px; margin: 8px 0 0 0; font-weight: 500;">@yield('header_subtitle')</p>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Contenido -->
                    <tr>
                        <td style="padding: 40px 35px; background-color: #ffffff;">
                            @yield('content')
                        </td>
                    </tr>
                    
                    <!-- Footer Info Box -->
                    <tr>
                        <td style="padding: 0 35px 35px 35px; background-color: #ffffff;">
                            <div style="background-color: #f8fafc; border-radius: 12px; padding: 20px; text-align: center; border: 1px solid #e2e8f0;">
                                <p style="margin: 0 0 8px 0; font-size: 13px; color: #64748b; line-height: 1.5;">
                                    Si no realizaste esta acción o desconoces este correo, ignóralo de forma segura.
                                </p>
                                <p style="margin: 0; font-size: 14px; font-weight: 600; color: #0f172a;">
                                    Equipo Bolsa de Proyecto — Inspírate SENA
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <!-- Bottom Copyright -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; width: 100%; margin: 0 auto;">
                     <tr>
                        <td align="center" style="padding: 24px 0;">
                            <p style="font-size: 12px; color: #94a3b8; margin: 0; font-weight: 500;">
                                &copy; {{ date('Y') }} SENA. Todos los derechos reservados.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
