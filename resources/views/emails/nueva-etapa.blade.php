@extends('emails.layouts.master')

@section('title', 'Nueva Etapa Agregada - SENA')
@section('header_icon', '📌')
@section('header_title', 'Nueva Etapa Agregada')
@section('header_subtitle', 'Se ha agregado una nueva etapa a tu proyecto')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0;">
    Hola <strong style="color: #0f172a;">{{ $aprendizNombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px 0;">
    El instructor ha agregado una nueva etapa al proyecto <strong>{{ $proyectoTitulo }}</strong>.
</p>

<div style="background-color: #f1f5f9; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
    <p style="font-size: 14px; color: #1e293b; font-weight: 700; margin: 0 0 10px 0;">Nueva Etapa: {{ $etapaNombre }}</p>
    <p style="font-size: 14px; color: #475569; margin: 0;">{{ $etapaDescripcion }}</p>
</div>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <a href="{{ url('/aprendiz/proyectos/aprobados') }}" style="display: inline-block; background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 30px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px -1px rgba(14, 165, 233, 0.3);">
                👀 Ver Detalles del Proyecto
            </a>
        </td>
    </tr>
</table>
@endsection
