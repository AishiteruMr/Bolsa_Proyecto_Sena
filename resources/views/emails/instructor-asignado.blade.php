@extends('emails.layouts.master')

@section('title', 'Nuevo Proyecto Asignado - SENA')
@section('header_icon', '🎓')
@section('header_title', 'Nuevo Proyecto Asignado')
@section('header_subtitle', 'Se te ha asignado un proyecto para supervisar')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0;">
    Hola <strong style="color: #047857;">{{ $instructorNombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0 0 24px 0;">
    El administrador te ha asignado como instructor responsable del siguiente proyecto. A continuación encontrarás los detalles:
</p>

<!-- Tarjeta del Proyecto -->
<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-bottom: 24px;">
    <h2 style="color: #0f172a; font-size: 18px; margin: 0 0 16px 0; border-bottom: 2px solid #047857; padding-bottom: 10px;">
        📁 {{ $proyecto->titulo }}
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
                📅 <strong style="color: #334155;">Publicado:</strong> {{ \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d/m/Y') }}
            </td>
        </tr>
        @if(!empty($proyecto->fecha_finalizacion))
        <tr>
            <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                🏁 <strong style="color: #334155;">Finalización estimada:</strong> {{ \Carbon\Carbon::parse($proyecto->fecha_finalizacion)->format('d/m/Y') }}
            </td>
        </tr>
        @endif
        @if(!empty($proyecto->duracion_estimada_dias))
        <tr>
            <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                ⏳ <strong style="color: #334155;">Duración:</strong> {{ $proyecto->duracion_estimada_dias }} días
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

    @if(!empty($proyecto->habilidades_requeridas))
    <div style="margin-top: 20px;">
        <p style="font-size: 14px; color: #334155; margin: 0 0 8px 0;"><strong>💡 Habilidades que supervisa:</strong></p>
        <p style="font-size: 14px; color: #475569; margin: 0; line-height: 1.5;">{{ $proyecto->habilidades_requeridas }}</p>
    </div>
    @endif
</div>

<!-- Postulaciones Badge -->
@if($totalPostulaciones > 0)
<div style="background-color: #ecfdf5; border: 1px solid #10b981; border-radius: 12px; padding: 16px 20px; margin-bottom: 30px; text-align: center;">
    <p style="margin: 0; color: #065f46; font-size: 15px; font-weight: 600;">
        👥 {{ $totalPostulaciones }} {{ $totalPostulaciones === 1 ? 'postulación pendiente' : 'postulaciones pendientes' }} de revisión
    </p>
    <p style="margin: 8px 0 0 0; color: #065f46; opacity: 0.8; font-size: 13px;">Ingresa a tu panel para revisar y aprobar/rechazar candidatos.</p>
</div>
@endif

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <a href="{{ url('/instructor/dashboard') }}" style="display: inline-block; background: linear-gradient(135deg, #047857 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 30px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);">
                🚀 Ir a Mi Panel
            </a>
        </td>
    </tr>
</table>
@endsection
