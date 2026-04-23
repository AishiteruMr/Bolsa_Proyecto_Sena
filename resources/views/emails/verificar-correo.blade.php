@extends('emails.layouts.master')

@section('title', 'Verifica tu correo electrónico - SENA')
@section('header_icon', '✉️')
@section('header_title', 'Verifica tu correo')
@section('header_subtitle', 'Paso final para activar tu cuenta')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0;">
    Hola <strong style="color: #0f172a;">{{ $nombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0 0 16px 0;">
    Gracias por registrarte en la <strong>Bolsa de Proyecto SENA</strong>. Para proteger tu seguridad y asegurar que este correo te pertenece, necesitamos que lo verifiques.
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0 0 30px 0;">
    Haz clic en el siguiente botón para confirmar tu correo electrónico:
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 30px;">
    <tr>
        <td align="center">
            <a href="{{ $verificationUrl }}" style="display: inline-block; background: linear-gradient(135deg, #047857 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 30px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);">
                ✅ Verificar Correo Electrónico
            </a>
        </td>
    </tr>
</table>

<div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
    <p style="margin: 0; font-size: 14px; color: #b45309; line-height: 1.5;">
        <strong>Importante:</strong> Este enlace de verificación expirará en <strong>60 minutos</strong> por razones de seguridad.
    </p>
</div>

<p style="font-size: 14px; color: #64748b; line-height: 1.6; margin: 0;">
    Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:<br>
    <a href="{{ $verificationUrl }}" style="color: #047857; text-decoration: underline; word-break: break-all; margin-top: 5px; display: inline-block;">{{ $verificationUrl }}</a>
</p>
@endsection
