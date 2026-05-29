@extends('emails.layouts.master')

@section('title', 'Nuevo mensaje de soporte - SENA')
@section('header_icon', '💬')
@section('header_title', 'Nuevo mensaje de soporte')
@section('header_subtitle', 'Un usuario ha enviado una solicitud de soporte')

@section('content')
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
    <tr>
        <td style="padding: 20px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e2e8f0;">
                        <span style="font-size: 13px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Nombre</span>
                        <p style="margin: 4px 0 0; font-size: 15px; color: #1e293b; font-weight: 600;">{{ $data['nombre'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e2e8f0;">
                        <span style="font-size: 13px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Correo electr&oacute;nico</span>
                        <p style="margin: 4px 0 0; font-size: 15px; color: #065f46;">{{ $data['email'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0; border-bottom: 1px solid #e2e8f0;">
                        <span style="font-size: 13px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600;">Motivo</span>
                        <p style="margin: 4px 0 0;"><span style="display: inline-block; background-color: #065f46; color: #ffffff; border-radius: 6px; padding: 3px 10px; font-size: 13px; font-weight: 600;">{{ $data['motivo'] }}</span></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px;">
    <tr>
        <td style="font-size: 13px; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; padding-bottom: 8px;">Mensaje</td>
    </tr>
    <tr>
        <td style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; color: #334155; font-size: 14px; line-height: 1.7;">
            {{ $data['mensaje'] }}
        </td>
    </tr>
</table>
@endsection
