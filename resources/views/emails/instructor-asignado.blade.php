@extends('emails.layouts.master')

@section('title', 'Nuevo Proyecto Asignado - SENA')
@section('header_icon', '🎓')
@section('header_title', 'Nuevo Proyecto Asignado')
@section('header_subtitle', 'Se te ha asignado un proyecto para supervisar')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0; line-height: 1.6;">
    Hola <strong style="color: #065f46;">{{ $instructorNombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px 0;">
    El administrador te ha asignado como instructor responsable del siguiente proyecto:
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 24px;">
    <tr>
        <td style="padding: 24px;">
            <h2 style="color: #065f46; font-size: 18px; margin: 0 0 16px 0; border-bottom: 2px solid #10b981; padding-bottom: 10px;">
                {{ $proyecto->titulo }}
            </h2>

            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="padding: 6px 0;">
                        <span style="display: inline-block; background-color: #065f46; color: #ffffff; border-radius: 6px; padding: 4px 12px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">{{ $proyecto->categoria }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #475569; font-size: 14px; border-bottom: 1px solid #e2e8f0;">
                        <strong style="color: #334155;">Empresa:</strong> {{ $proyecto->nombre }}
                    </td>
                </tr>
                @if(!empty($proyecto->pro_ubicacion))
                <tr>
                    <td style="padding: 8px 0; color: #475569; font-size: 14px; border-bottom: 1px solid #e2e8f0;">
                        <strong style="color: #334155;">Ubicaci&oacute;n:</strong> {{ $proyecto->pro_ubicacion }}
                    </td>
                </tr>
                @endif
                <tr>
                    <td style="padding: 8px 0; color: #475569; font-size: 14px; border-bottom: 1px solid #e2e8f0;">
                        <strong style="color: #334155;">Publicado:</strong> {{ \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d/m/Y') }}
                    </td>
                </tr>
                @if(!empty($proyecto->fecha_finalizacion))
                <tr>
                    <td style="padding: 8px 0; color: #475569; font-size: 14px; border-bottom: 1px solid #e2e8f0;">
                        <strong style="color: #334155;">Finalizaci&oacute;n estimada:</strong> {{ \Carbon\Carbon::parse($proyecto->fecha_finalizacion)->format('d/m/Y') }}
                    </td>
                </tr>
                @endif
                @if(!empty($proyecto->duracion_estimada_dias))
                <tr>
                    <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                        <strong style="color: #334155;">Duraci&oacute;n:</strong> {{ $proyecto->duracion_estimada_dias }} d&iacute;as
                    </td>
                </tr>
                @endif
            </table>

            @if(!empty($proyecto->descripcion))
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <tr>
                    <td style="font-size: 14px; color: #334155; padding-bottom: 8px;"><strong>Descripci&oacute;n:</strong></td>
                </tr>
                <tr>
                    <td style="background-color: #ffffff; padding: 16px; border-radius: 8px; border-left: 4px solid #10b981; color: #475569; font-size: 14px; line-height: 1.6;">
                        {{ $proyecto->descripcion }}
                    </td>
                </tr>
            </table>
            @endif

            @if(!empty($proyecto->habilidades_requeridas))
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px;">
                <tr>
                    <td style="font-size: 14px; color: #334155; padding-bottom: 8px;"><strong>Habilidades que supervisa:</strong></td>
                </tr>
                <tr>
                    <td style="font-size: 14px; color: #475569; line-height: 1.6;">{{ $proyecto->habilidades_requeridas }}</td>
                </tr>
            </table>
            @endif
        </td>
    </tr>
</table>

@if($totalPostulaciones > 0)
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f0fdf4; border: 1px solid #10b981; border-radius: 12px; margin-bottom: 28px;">
    <tr>
        <td style="padding: 16px 20px; text-align: center;">
            <p style="margin: 0; color: #065f46; font-size: 15px; font-weight: 700;">
                {{ $totalPostulaciones }} {{ $totalPostulaciones === 1 ? 'postulaci&oacute;n pendiente' : 'postulaciones pendientes' }} de revisi&oacute;n
            </p>
            <p style="margin: 6px 0 0 0; color: #065f46; font-size: 13px;">Ingresa a tu panel para revisar y aprobar o rechazar candidatos.</p>
        </td>
    </tr>
</table>
@endif

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <a href="{{ url('/instructor/dashboard') }}" style="display: inline-block; background: linear-gradient(135deg, #065f46 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 8px; font-weight: 700; font-size: 15px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                Ir a Mi Panel
            </a>
        </td>
    </tr>
</table>
@endsection
