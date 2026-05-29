@extends('emails.layouts.master')

@php
    $isAceptada = strtolower($nuevoEstado) === 'aceptada';
@endphp

@section('title', ($isAceptada ? '¡Postulación Aprobada!' : 'Postulación No Aprobada') . ' - SENA')
@section('header_icon', $isAceptada ? '🎉' : '💬')
@section('header_title', $isAceptada ? '¡Postulación Aprobada!' : 'Postulación No Aprobada')
@section('header_subtitle', $isAceptada ? '¡Felicitaciones! Has sido seleccionado' : 'Gracias por tu interés en este proyecto')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0; line-height: 1.6;">
    Hola <strong style="color: #065f46;">{{ $aprendizNombre }}</strong>,
</p>

@if($isAceptada)
    <p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px 0;">
        &iexcl;Excelentes noticias! Tu postulaci&oacute;n al proyecto <strong style="color: #065f46;">{{ $proyectoTitulo }}</strong> ha sido <strong style="color: #065f46;">aprobada</strong>.
        Ya puedes acceder a los detalles completos, etapas y hacer seguimiento desde tu panel.
    </p>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; margin-bottom: 28px;">
        <tr>
            <td style="padding: 24px;">
                <p style="font-size: 14px; color: #166534; font-weight: 700; margin: 0 0 12px 0;">¿Qu&eacute; sigue ahora?</p>
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="padding: 4px 0; font-size: 14px; color: #14532d; line-height: 1.6;">&bull; Ingresa a tu panel de aprendiz.</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; font-size: 14px; color: #14532d; line-height: 1.6;">&bull; Revisa las etapas definidas para el proyecto.</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; font-size: 14px; color: #14532d; line-height: 1.6;">&bull; Sube tus evidencias a medida que avances.</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; font-size: 14px; color: #14532d; line-height: 1.6;">&bull; El instructor asignado calificar&aacute; tu progreso.</td>
                    </tr>
                </table>

                @if($otrasPendientes > 0)
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 16px; padding: 16px; background-color: #fef3c7; border: 1px solid #fde68a; border-radius: 10px;">
                    <tr>
                        <td style="font-size: 13px; color: #92400e; line-height: 1.6;">
                            <strong>📌 Recuerda:</strong> Puedes postularte a varios proyectos, pero solo puedes pertenecer a uno a la vez. Tienes <strong>{{ $otrasPendientes }} postulaci&oacute;n(es) pendiente(s)</strong> en otros proyectos. Cuando aceptes este proyecto, las dem&aacute;s postulaciones quedar&aacute;n autom&aacute;ticamente en espera.
                        </td>
                    </tr>
                </table>
                @endif
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <a href="{{ url('/aprendiz/proyectos/aprobados') }}" style="display: inline-block; background: linear-gradient(135deg, #065f46 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 8px; font-weight: 700; font-size: 15px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                    Ver Mi Proyecto
                </a>
            </td>
        </tr>
    </table>
@else
    <p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px 0;">
        Lamentamos informarte que tu postulaci&oacute;n al proyecto <strong>{{ $proyectoTitulo }}</strong> no ha sido seleccionada en esta ocasi&oacute;n.
    </p>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 12px; margin-bottom: 28px;">
        <tr>
            <td style="padding: 24px;">
                <p style="font-size: 14px; color: #92400e; font-weight: 700; margin: 0 0 10px 0;">No te desanimes</p>
                <p style="font-size: 14px; color: #78350f; line-height: 1.6; margin: 0;">
                    Hay muchos proyectos disponibles esperando por talentos como el tuyo. Te invitamos a seguir explorando nuevas oportunidades y a postularte en aquellas que se ajusten a tu perfil.
                </p>
            </td>
        </tr>
    </table>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <a href="{{ url('/aprendiz/proyectos') }}" style="display: inline-block; background: linear-gradient(135deg, #0369a1 0%, #0ea5e9 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 8px; font-weight: 700; font-size: 15px; box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);">
                    Explorar M&aacute;s Proyectos
                </a>
            </td>
        </tr>
    </table>
@endif

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 28px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
    <tr>
        <td align="center" style="font-size: 13px; color: #94a3b8;">
            Proyecto: <strong style="color: #64748b;">{{ $proyectoTitulo }}</strong>
        </td>
    </tr>
</table>
@endsection
