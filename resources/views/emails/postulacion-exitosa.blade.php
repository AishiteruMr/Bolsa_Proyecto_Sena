@extends('emails.layouts.master')

@section('title', 'Postulación Recibida - SENA')
@section('header_icon', '📋')
@section('header_title', '¡Postulación Enviada!')
@section('header_subtitle', 'Tu solicitud ha sido recibida correctamente')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0;">
    Hola <strong style="color: #047857;">{{ $aprendizNombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0 0 24px 0;">
    Hemos registrado exitosamente tu postulación al proyecto. A continuación, encontrarás todos los detalles de la oferta a la que has aplicado:
</p>

<!-- Tarjeta del Proyecto -->
<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-bottom: 24px;">
    <h2 style="color: #0f172a; font-size: 18px; margin: 0 0 16px 0; border-bottom: 2px solid #047857; padding-bottom: 10px;">
        {{ $proyecto->titulo }}
    </h2>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="padding: 8px 0; vertical-align: top;">
                <span style="display: inline-block; background-color: #047857; color: #ffffff; border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 600; letter-spacing: 0.5px;">{{ $proyecto->categoria }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                🏢 <strong style="color: #334155;">Empresa:</strong> {{ $proyecto->nombre }}
            </td>
        </tr>
        @if(!empty($proyecto->pro_ubicacion))
        <tr>
            <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                📍 <strong style="color: #334155;">Ubicación:</strong> {{ $proyecto->pro_ubicacion }}
            </td>
        </tr>
        @endif
        <tr>
            <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                📅 <strong style="color: #334155;">Fecha de publicación:</strong> {{ \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d/m/Y') }}
            </td>
        </tr>
        @if(!empty($proyecto->fecha_finalizacion))
        <tr>
            <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                🏁 <strong style="color: #334155;">Fecha de finalización:</strong> {{ \Carbon\Carbon::parse($proyecto->fecha_finalizacion)->format('d/m/Y') }}
            </td>
        </tr>
        @endif
        @if(!empty($proyecto->duracion_estimada_dias))
        <tr>
            <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                ⏳ <strong style="color: #334155;">Duración estimada:</strong> {{ $proyecto->duracion_estimada_dias }} días
            </td>
        </tr>
        @endif
    </table>

    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
        <p style="font-size: 14px; color: #334155; margin: 0 0 12px 0;"><strong>📝 Descripción:</strong></p>
        <div style="background-color: #ffffff; padding: 16px; border-radius: 8px; border-left: 4px solid #047857; color: #475569; font-size: 14px; line-height: 1.6;">
            {{ $proyecto->descripcion }}
        </div>
    </div>

    @if(!empty($proyecto->requisitos_especificos))
    <div style="margin-top: 20px;">
        <p style="font-size: 14px; color: #334155; margin: 0 0 8px 0;"><strong>📌 Requisitos Específicos:</strong></p>
        <p style="font-size: 14px; color: #475569; margin: 0; line-height: 1.5;">{{ $proyecto->requisitos_especificos }}</p>
    </div>
    @endif

    @if(!empty($proyecto->habilidades_requeridas))
    <div style="margin-top: 16px;">
        <p style="font-size: 14px; color: #334155; margin: 0 0 8px 0;"><strong>💡 Habilidades requeridas:</strong></p>
        <p style="font-size: 14px; color: #475569; margin: 0; line-height: 1.5;">{{ $proyecto->habilidades_requeridas }}</p>
    </div>
    @endif
</div>

<!-- Etiqueta de Estado -->
<div style="background-color: #fef3c7; border: 1px solid #fde68a; border-radius: 12px; padding: 16px 20px; margin-bottom: 30px; text-align: center;">
    <p style="margin: 0; color: #92400e; font-size: 15px; font-weight: 600;">
        🕐 Estado actual: <span style="background-color: #f59e0b; color: #ffffff; padding: 4px 12px; border-radius: 20px; font-size: 12px; display: inline-block; margin-left: 8px;">Pendiente</span>
    </p>
    <p style="margin: 8px 0 0 0; color: #92400e; opacity: 0.8; font-size: 13px;">El instructor revisará tu postulación. Recibirás un correo cuando el estado cambie.</p>
</div>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <a href="{{ url('/aprendiz/mis-postulaciones') }}" style="display: inline-block; background: linear-gradient(135deg, #047857 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 30px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);">
                👀 Ver Mis Postulaciones
            </a>
        </td>
    </tr>
</table>
@endsection
