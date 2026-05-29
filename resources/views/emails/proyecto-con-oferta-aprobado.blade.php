@extends('emails.layouts.master')

@section('title', 'Nueva Oferta de Proyecto - SENA')
@section('header_icon', '🎯')
@section('header_title', 'Nueva Oferta de Proyecto')
@section('header_subtitle', 'Hay una nueva oportunidad con beneficio disponible para ti')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0; line-height: 1.6;">
    Hola <strong style="color: #065f46;">{{ $aprendizNombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px 0;">
    Se ha publicado y aprobado un nuevo proyecto en la plataforma que incluye una oferta de incentivo especial. A continuaci&oacute;n todos los detalles:
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1.5px solid #bbf7d0; border-radius: 12px; margin-bottom: 24px;">
    <tr>
        <td style="padding: 20px; text-align: center;">
            <p style="font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; color: #166534; font-weight: 800; margin: 0 0 8px 0;">Beneficio de la Convocatoria</p>
            <h3 style="color: #14532d; font-size: 22px; font-weight: 800; margin: 0 0 12px 0;">
                @switch($proyecto->oferta)
                    @case('pasantias')
                        Pasant&iacute;as
                        @break
                    @case('contrato_aprendizaje')
                        Contrato de Aprendizaje
                        @break
                    @case('auxilio_transporte')
                        Auxilio de Transporte
                        @break
                    @case('otro')
                        {{ $proyecto->oferta_otro }}
                        @break
                    @default
                        Oferta Especial
                @endswitch
            </h3>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 8px; border-left: 4px solid #16a34a;">
                <tr>
                    <td style="padding: 10px 14px; font-size: 13px; color: #15803d; font-weight: 600; line-height: 1.4; text-align: left;">
                        Este beneficio se otorgar&aacute; <strong>exclusivamente al aprendiz que demuestre el mejor desempe&ntilde;o</strong> en el desarrollo del proyecto.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; margin-bottom: 28px;">
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
                        <strong style="color: #334155;">Empresa:</strong> {{ $proyecto->empresa->nombre ?? 'Empresa Registrada' }}
                    </td>
                </tr>
                @if(!empty($proyecto->ubicacion))
                <tr>
                    <td style="padding: 8px 0; color: #475569; font-size: 14px; border-bottom: 1px solid #e2e8f0;">
                        <strong style="color: #334155;">Ubicaci&oacute;n:</strong> {{ $proyecto->ubicacion }}
                    </td>
                </tr>
                @endif
                @if(!empty($proyecto->duracion_estimada_dias))
                <tr>
                    <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                        <strong style="color: #334155;">Duraci&oacute;n del proyecto:</strong> {{ $proyecto->duracion_estimada_dias }} d&iacute;as
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
                        {{ Str::limit($proyecto->descripcion, 300) }}
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
            <a href="{{ url('/aprendiz/proyectos/' . $proyecto->id . '/detalle') }}" style="display: inline-block; background: linear-gradient(135deg, #065f46 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 8px; font-weight: 700; font-size: 15px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                Ver Proyecto y Postularme
            </a>
        </td>
    </tr>
</table>
@endsection
