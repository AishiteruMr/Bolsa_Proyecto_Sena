@extends('emails.layouts.master')

@section('title', 'Recuperar Contraseña - SENA')
@section('header_icon', '🔐')
@section('header_title', 'Recuperar Contraseña')
@section('header_subtitle', 'Bolsa de Proyectos SENA')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0;">
    ¡Hola <strong style="color: #0f172a;">{{ $nombre }}</strong>!
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0 0 16px 0;">
    Recibimos una solicitud para recuperar la contraseña de tu cuenta. Si no realizaste esta solicitud, puedes ignorar este correo con seguridad y tu contraseña no cambiará.
</p>

<div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
    <p style="margin: 0; font-size: 14px; color: #b45309; line-height: 1.5;">
        ⏳ Este enlace de recuperación expirará en <strong>30 minutos</strong>. Asegúrate de actuar rápidamente.
    </p>
</div>

<p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0 0 30px 0;">
    Para restablecer tu contraseña nueva, haz clic en el botón de abajo:
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 30px;">
    <tr>
        <td align="center">
            <a href="{{ $enlaceRecuperacion }}" style="display: inline-block; background: linear-gradient(135deg, #047857 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 30px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);">
                🔑 Recuperar Contraseña
            </a>
        </td>
    </tr>
</table>

<div style="background-color: #f8fafc; padding: 20px; border-radius: 12px; margin-bottom: 24px;">
    <p style="font-size: 13px; color: #64748b; margin: 0 0 8px 0; font-weight: 600;">O copia y pega este enlace en tu navegador:</p>
    <a href="{{ $enlaceRecuperacion }}" style="color: #047857; text-decoration: underline; word-break: break-all; display: inline-block; font-size: 13px;">{{ $enlaceRecuperacion }}</a>
</div>

<div style="border-top: 1px solid #f1f5f9; padding-top: 20px;">
    <p style="font-size: 14px; font-weight: 600; color: #334155; margin: 0 0 12px 0;">🛡️ Consejos de seguridad:</p>
    <ul style="margin: 0 0 0 20px; padding: 0; color: #64748b; font-size: 13px; line-height: 1.6;">
        <li style="margin-bottom: 4px;">Nunca compartas este correo o el enlace con nadie.</li>
        <li style="margin-bottom: 4px;">Los enlaces de recuperación son de un solo uso y expiran en 30 minutos.</li>
        <li style="margin-bottom: 4px;">✅ Nota de seguridad: Este enlace no incluye tu correo en la URL para mayor seguridad.</li>
        <li>Si tuviste problemas, contáctanos a <a href="mailto:bolsadeproyectossena@gmail.com" style="color: #047857;">bolsadeproyectossena@gmail.com</a>.</li>
    </ul>
</div>
@endsection
