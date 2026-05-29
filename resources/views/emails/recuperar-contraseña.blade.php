@extends('emails.layouts.master')

@section('title', 'Recuperar Contraseña - SENA')
@section('header_icon', '🔐')
@section('header_title', 'Recuperar Contraseña')
@section('header_subtitle', 'Bolsa de Proyectos SENA')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0; line-height: 1.6;">
    Hola <strong style="color: #065f46;">{{ $nombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 16px 0;">
    Recibimos una solicitud para recuperar la contraseña de tu cuenta. Si no realizaste esta solicitud, puedes ignorar este correo con seguridad y tu contraseña no cambiará.
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #fffbeb; border-radius: 10px; margin-bottom: 24px;">
    <tr>
        <td style="padding: 16px 20px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="40" valign="top" style="font-size: 20px; color: #f59e0b; line-height: 1;">⏳</td>
                    <td style="font-size: 14px; color: #92400e; line-height: 1.5;">
                        Este enlace de recuperaci&oacute;n expirar&aacute; en <strong>30 minutos</strong>. Act&uacute;a r&aacute;pidamente.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 28px 0;">
    Para restablecer tu contraseña nueva, haz clic en el botón de abajo:
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
    <tr>
        <td align="center">
            <a href="{{ $enlaceRecuperacion }}" style="display: inline-block; background: linear-gradient(135deg, #065f46 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 8px; font-weight: 700; font-size: 15px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                Recuperar Contraseña
            </a>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f8fafc; border-radius: 10px; margin-bottom: 24px;">
    <tr>
        <td style="padding: 16px 20px;">
            <p style="font-size: 13px; color: #64748b; margin: 0 0 8px 0; font-weight: 600;">O copia y pega este enlace en tu navegador:</p>
            <a href="{{ $enlaceRecuperacion }}" style="color: #065f46; text-decoration: underline; word-break: break-all; font-size: 13px; display: inline-block;">{{ $enlaceRecuperacion }}</a>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-top: 1px solid #e2e8f0; margin-top: 24px;">
    <tr>
        <td style="padding-top: 24px;">
            <p style="font-size: 14px; font-weight: 700; color: #1e293b; margin: 0 0 12px 0;">Consejos de seguridad:</p>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="padding: 4px 0 4px 20px; font-size: 13px; color: #64748b; line-height: 1.6;">
                        &bull; Nunca compartas este correo o el enlace con nadie.
                    </td>
                </tr>
                <tr>
                    <td style="padding: 4px 0 4px 20px; font-size: 13px; color: #64748b; line-height: 1.6;">
                        &bull; Los enlaces de recuperaci&oacute;n son de un solo uso y expiran en 30 minutos.
                    </td>
                </tr>
                <tr>
                    <td style="padding: 4px 0 4px 20px; font-size: 13px; color: #64748b; line-height: 1.6;">
                        &bull; Si tuviste problemas, cont&aacute;ctanos a <a href="mailto:bolsadeproyectossena@gmail.com" style="color: #065f46; text-decoration: underline;">bolsadeproyectossena@gmail.com</a>.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
