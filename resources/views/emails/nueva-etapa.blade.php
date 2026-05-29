@extends('emails.layouts.master')

@section('title', 'Nueva Etapa Agregada - SENA')
@section('header_icon', '📌')
@section('header_title', 'Nueva Etapa Agregada')
@section('header_subtitle', 'Se ha agregado una nueva etapa a tu proyecto')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0; line-height: 1.6;">
    Hola <strong style="color: #065f46;">{{ $aprendizNombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px 0;">
    El instructor ha agregado una nueva etapa al proyecto <strong>{{ $proyectoTitulo }}</strong>.
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 28px;">
    <tr>
        <td style="padding: 24px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="48" valign="top" style="background-color: #065f46; border-radius: 10px; width: 48px; height: 48px; text-align: center; color: #ffffff; font-size: 22px; font-weight: 800; line-height: 48px;">+</td>
                    <td style="padding-left: 16px;">
                        <p style="font-size: 16px; color: #1e293b; font-weight: 700; margin: 0 0 6px 0;">{{ $etapaNombre }}</p>
                        <p style="font-size: 14px; color: #475569; margin: 0; line-height: 1.6;">{{ $etapaDescripcion }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <a href="{{ url('/aprendiz/proyectos/aprobados') }}" style="display: inline-block; background: linear-gradient(135deg, #065f46 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 8px; font-weight: 700; font-size: 15px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                Ver Detalles del Proyecto
            </a>
        </td>
    </tr>
</table>
@endsection
