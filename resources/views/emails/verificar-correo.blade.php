@extends('emails.layouts.master')

@section('title', 'Verifica tu correo electrónico - SENA')
@section('header_icon', '✉️')
@section('header_title', 'Verifica tu correo')
@section('header_subtitle', 'Paso final para activar tu cuenta')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0; line-height: 1.6;">
    Hola <strong style="color: #065f46;">{{ $nombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 16px 0;">
    Gracias por registrarte en la <strong>Bolsa de Proyecto SENA</strong>. Para proteger tu seguridad y asegurar que este correo te pertenece, necesitamos que lo verifiques.
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 28px 0;">
    Haz clic en el siguiente botón para confirmar tu correo electrónico:
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
    <tr>
        <td align="center">
            <a href="{{ $verificationUrl }}" style="display: inline-block; background: linear-gradient(135deg, #065f46 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 8px; font-weight: 700; font-size: 15px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                Verificar Correo Electrónico
            </a>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #fffbeb; border-radius: 10px; margin-bottom: 24px;">
    <tr>
        <td style="padding: 16px 20px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="40" valign="top" style="font-size: 20px; color: #f59e0b; line-height: 1;">⚠️</td>
                    <td style="font-size: 14px; color: #92400e; line-height: 1.5;">
                        <strong>Importante:</strong> Este enlace de verificaci&oacute;n expirar&aacute; en <strong>60 minutos</strong> por razones de seguridad.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f8fafc; border-radius: 10px; margin-bottom: 0;">
    <tr>
        <td style="padding: 16px 20px;">
            <p style="font-size: 13px; color: #64748b; margin: 0 0 8px 0; font-weight: 600;">O copia y pega este enlace en tu navegador:</p>
            <a href="{{ $verificationUrl }}" style="color: #065f46; text-decoration: underline; word-break: break-all; font-size: 13px; display: inline-block;">{{ $verificationUrl }}</a>
        </td>
    </tr>
</table>
@endsection
