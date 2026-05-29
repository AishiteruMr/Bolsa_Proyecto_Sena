@extends('emails.layouts.master')

@section('title', 'Verifica tu correo con código - SENA')
@section('header_icon', '🔑')
@section('header_title', 'Verifica tu correo')
@section('header_subtitle', 'Paso final para activar tu cuenta')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0; line-height: 1.6;">
    Hola <strong style="color: #065f46;">{{ $nombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px 0;">
    Gracias por registrarte en la <strong>Bolsa de Proyecto SENA</strong>. Para proteger tu seguridad, verifica tu correo electrónico utilizando el siguiente código:
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 28px;">
    <tr>
        <td align="center">
            <table cellpadding="0" cellspacing="0" border="0" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 2px dashed #10b981; border-radius: 12px;">
                <tr>
                    <td align="center" style="padding: 24px 48px; letter-spacing: 12px; font-size: 38px; font-weight: 800; color: #065f46; font-family: 'Courier New', Courier, monospace;">
                        {{ $otp }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #fffbeb; border-radius: 10px; margin-bottom: 0;">
    <tr>
        <td style="padding: 16px 20px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="40" valign="top" style="font-size: 20px; color: #f59e0b; line-height: 1;">⏳</td>
                    <td style="font-size: 14px; color: #92400e; line-height: 1.5;">
                        <strong>Importante:</strong> Este c&oacute;digo expirar&aacute; en <strong>10 minutos</strong>. Si no solicitaste este registro, ignora este correo.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
