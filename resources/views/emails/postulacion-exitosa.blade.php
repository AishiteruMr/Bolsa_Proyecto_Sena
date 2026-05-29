@extends('emails.layouts.master')

@section('title', 'Postulación Recibida - SENA')
@section('header_icon', '📋')
@section('header_title', '¡Postulación Enviada!')
@section('header_subtitle', 'Tu solicitud ha sido recibida correctamente')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0; line-height: 1.6;">
    Hola <strong style="color: #065f46;">{{ $aprendizNombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px 0;">
    Hemos registrado exitosamente tu postulación al proyecto. A continuación, todos los detalles de la oferta a la que has aplicado:
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
                        <strong style="color: #334155;">Fecha de publicaci&oacute;n:</strong> {{ \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d/m/Y') }}
                    </td>
                </tr>
                @if(!empty($proyecto->fecha_finalizacion))
                <tr>
                    <td style="padding: 8px 0; color: #475569; font-size: 14px; border-bottom: 1px solid #e2e8f0;">
                        <strong style="color: #334155;">Fecha de finalizaci&oacute;n:</strong> {{ \Carbon\Carbon::parse($proyecto->fecha_finalizacion)->format('d/m/Y') }}
                    </td>
                </tr>
                @endif
                @if(!empty($proyecto->duracion_estimada_dias))
                <tr>
                    <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                        <strong style="color: #334155;">Duraci&oacute;n estimada:</strong> {{ $proyecto->duracion_estimada_dias }} d&iacute;as
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

            @if(!empty($proyecto->requisitos_especificos))
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 20px;">
                <tr>
                    <td style="font-size: 14px; color: #334155; padding-bottom: 8px;"><strong>Requisitos espec&iacute;ficos:</strong></td>
                </tr>
                <tr>
                    <td style="font-size: 14px; color: #475569; line-height: 1.6;">{{ $proyecto->requisitos_especificos }}</td>
                </tr>
            </table>
            @endif

            @if(!empty($proyecto->habilidades_requeridas))
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 16px;">
                <tr>
                    <td style="font-size: 14px; color: #334155; padding-bottom: 8px;"><strong>Habilidades requeridas:</strong></td>
                </tr>
                <tr>
                    <td style="font-size: 14px; color: #475569; line-height: 1.6;">{{ $proyecto->habilidades_requeridas }}</td>
                </tr>
            </table>
            @endif
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #fef3c7; border: 1px solid #fde68a; border-radius: 12px; margin-bottom: 28px;">
    <tr>
        <td style="padding: 16px 20px; text-align: center;">
            <p style="margin: 0; color: #92400e; font-size: 14px; font-weight: 600;">
                Estado actual:
                <span style="background-color: #f59e0b; color: #ffffff; padding: 3px 12px; border-radius: 6px; font-size: 12px; font-weight: 700; display: inline-block; margin-left: 6px;">Pendiente</span>
            </p>
            <p style="margin: 8px 0 0 0; color: #92400e; font-size: 13px;">El instructor revisar&aacute; tu postulaci&oacute;n. Recibir&aacute;s un correo cuando el estado cambie.</p>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <a href="{{ url('/aprendiz/mis-postulaciones') }}" style="display: inline-block; background: linear-gradient(135deg, #065f46 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 8px; font-weight: 700; font-size: 15px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                Ver Mis Postulaciones
            </a>
        </td>
    </tr>
</table>
@endsection
