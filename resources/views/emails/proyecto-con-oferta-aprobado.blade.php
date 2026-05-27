@extends('emails.layouts.master')

@section('title', 'Nueva Oferta de Proyecto - SENA')
@section('header_icon', '🎁')
@section('header_title', 'Nueva Oferta de Proyecto')
@section('header_subtitle', '¡Hay una nueva oportunidad con beneficio disponible para ti!')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0;">
    Hola <strong style="color: #047857;">{{ $aprendizNombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0 0 24px 0;">
    Se ha publicado y aprobado un nuevo proyecto en la plataforma que incluye una **oferta de incentivo especial**. A continuación encontrarás todos los detalles de esta oportunidad:
</p>

<!-- Tarjeta de la Oferta -->
<div style="background-color: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 12px; padding: 20px; margin-bottom: 24px; text-align: center;">
    <span style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: #166534; font-weight: 800; display: block; margin-bottom: 6px;">Beneficio de la Convocatoria</span>
    <h3 style="color: #14532d; font-size: 22px; font-weight: 800; margin: 0;">
        @switch($proyecto->oferta)
            @case('pasantias')
                💼 Pasantías
                @break
            @case('contrato_aprendizaje')
                📜 Contrato de Aprendizaje
                @break
            @case('auxilio_transporte')
                🚌 Auxilio de Transporte
                @break
            @case('otro')
                ✨ {{ $proyecto->oferta_otro }}
                @break
            @default
                🎁 Oferta Especial
        @endswitch
    </h3>
    <div style="margin-top: 12px; padding: 10px; background-color: #ffffff; border-radius: 8px; border-left: 4px solid #16a34a; font-size: 13px; color: #15803d; font-weight: 600; line-height: 1.4; text-align: left;">
        ⚠️ <strong>Nota importante:</strong> Este beneficio se otorgará <strong>únicamente al aprendiz que demuestre el mejor desempeño</strong> en el desarrollo del proyecto.
    </div>
</div>

<!-- Tarjeta del Proyecto -->
<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-bottom: 28px;">
    <h2 style="color: #0f172a; font-size: 18px; margin: 0 0 16px 0; border-bottom: 2px solid #047857; padding-bottom: 10px;">
        📁 {{ $proyecto->titulo }}
    </h2>

    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td style="padding: 6px 0; vertical-align: top;">
                <span style="display: inline-block; background-color: #047857; color: #ffffff; border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 600; letter-spacing: 0.5px;">{{ $proyecto->categoria }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                🏢 <strong style="color: #334155;">Empresa:</strong> {{ $proyecto->empresa->nombre ?? 'Empresa Registrada' }}
            </td>
        </tr>
        @if(!empty($proyecto->ubicacion))
        <tr>
            <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                📍 <strong style="color: #334155;">Ubicación:</strong> {{ $proyecto->ubicacion }}
            </td>
        </tr>
        @endif
        @if(!empty($proyecto->duracion_estimada_dias))
        <tr>
            <td style="padding: 8px 0; color: #475569; font-size: 14px;">
                ⏳ <strong style="color: #334155;">Duración del Proyecto:</strong> {{ $proyecto->duracion_estimada_dias }} días
            </td>
        </tr>
        @endif
    </table>

    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
        <p style="font-size: 14px; color: #334155; margin: 0 0 10px 0;"><strong>📝 Descripción del Proyecto:</strong></p>
        <div style="background-color: #ffffff; padding: 16px; border-radius: 8px; border-left: 4px solid #047857; color: #475569; font-size: 14px; line-height: 1.6;">
            {{ Str::limit($proyecto->descripcion, 300) }}
        </div>
    </div>
</div>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center" style="padding-bottom: 20px;">
            <a href="{{ url('/aprendiz/proyectos/' . $proyecto->id . '/detalle') }}" style="display: inline-block; background: linear-gradient(135deg, #047857 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 30px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);">
                🔍 Ver Proyecto y Postularme
            </a>
        </td>
    </tr>
</table>
@endsection
