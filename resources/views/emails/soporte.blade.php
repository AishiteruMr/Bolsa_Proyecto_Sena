@extends('emails.layouts.master')

@section('title', 'Nuevo mensaje de soporte - SENA')
@section('header_icon', '🆘')
@section('header_title', 'Nuevo mensaje de soporte')
@section('header_subtitle', 'Un usuario ha enviado una solicitud de soporte')

@section('content')
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td style="padding: 8px 0;">
            <strong style="color: #0f172a;">Nombre:</strong>
            <span style="color: #475569; margin-left: 8px;">{{ $data['nombre'] }}</span>
        </td>
    </tr>
    <tr>
        <td style="padding: 8px 0;">
            <strong style="color: #0f172a;">Email:</strong>
            <span style="color: #475569; margin-left: 8px;">{{ $data['email'] }}</span>
        </td>
    </tr>
    <tr>
        <td style="padding: 8px 0;">
            <strong style="color: #0f172a;">Motivo:</strong>
            <span style="color: #475569; margin-left: 8px;">{{ $data['motivo'] }}</span>
        </td>
    </tr>
    <tr>
        <td style="padding: 8px 0;">
            <strong style="color: #0f172a;">Mensaje:</strong>
        </td>
    </tr>
    <tr>
        <td style="padding: 12px; background-color: #f1f5f9; border-radius: 8px; color: #334155; line-height: 1.6;">
            {{ $data['mensaje'] }}
        </td>
    </tr>
</table>
@endsection
