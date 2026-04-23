@extends('emails.layouts.master')

@php
    $isAceptada = strtolower($nuevoEstado) === 'aceptada';
@endphp

@section('title', ($isAceptada ? '¡Postulación Aprobada!' : 'Postulación No Aprobada') . ' - SENA')
@section('header_icon', $isAceptada ? '🎉' : '✉️')
@section('header_title', $isAceptada ? '¡Postulación Aprobada!' : 'Postulación No Aprobada')
@section('header_subtitle', $isAceptada ? '¡Felicitaciones! Has sido seleccionado' : 'Gracias por tu interés en este proyecto')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0;">
    Hola <strong style="color: #0f172a;">{{ $aprendizNombre }}</strong>,
</p>

@if($isAceptada)
    <p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px 0;">
        ¡Excelentes noticias! Tu postulación al proyecto <strong style="color: #047857;">{{ $proyectoTitulo }}</strong> ha sido <strong style="color: #047857;">aprobada</strong>.
        Ya puedes acceder a los detalles completos del proyecto, etapas y hacer seguimiento desde tu panel.
    </p>

    <!-- ¿Qué sigue? -->
    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 24px; margin-bottom: 30px;">
        <p style="font-size: 14px; color: #166534; font-weight: 700; margin: 0 0 12px 0;">📌 ¿Qué sigue ahora?</p>
        <ul style="margin: 0; padding-left: 20px; color: #14532d; font-size: 14px; line-height: 2;">
            <li>Ingresa a tu panel de aprendiz.</li>
            <li>Revisa las etapas definidas para el proyecto.</li>
            <li>Sube tus evidencias a medida que avances.</li>
            <li>El instructor asignado calificará tu progreso.</li>
        </ul>
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <a href="{{ url('/aprendiz/proyectos/aprobados') }}" style="display: inline-block; background: linear-gradient(135deg, #047857 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 30px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);">
                    🚀 Ver Mi Proyecto
                </a>
            </td>
        </tr>
    </table>
@else
    <p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px 0;">
        Lamentamos informarte que tu postulación al proyecto <strong>{{ $proyectoTitulo }}</strong> no ha sido seleccionada en esta ocasión.
    </p>

    <!-- Mensaje de motivación -->
    <div style="background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 12px; padding: 24px; margin-bottom: 30px;">
        <p style="font-size: 14px; color: #92400e; font-weight: 700; margin: 0 0 10px 0;">💪 ¡No te desanimes!</p>
        <p style="font-size: 14px; color: #78350f; line-height: 1.6; margin: 0;">
            Hay muchos proyectos disponibles esperando por talentos como el tuyo en nuestra plataforma. Te invitamos a seguir explorando nuevas oportunidades y a postularte en aquellas que se ajusten a tu perfil.
        </p>
    </div>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td align="center">
                <a href="{{ url('/aprendiz/proyectos') }}" style="display: inline-block; background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 30px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px -1px rgba(14, 165, 233, 0.3);">
                    🔍 Explorar Más Proyectos
                </a>
            </td>
        </tr>
    </table>
@endif

<div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #f1f5f9; text-align: center;">
    <p style="font-size: 13px; color: #94a3b8; margin: 0;">Proyecto: <strong>{{ $proyectoTitulo }}</strong></p>
</div>
@endsection
