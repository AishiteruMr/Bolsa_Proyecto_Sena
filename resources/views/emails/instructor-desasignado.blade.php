@extends('emails.layouts.master')

@section('title', 'Desasignado de Proyecto - SENA')
@section('header_icon', '⚠️')
@section('header_title', 'Desasignado de Proyecto')
@section('header_subtitle', 'El proyecto ha sido desactivado o reasignado')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0;">
    Hola <strong style="color: #0f172a;">{{ $instructorNombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.6; margin: 0 0 24px 0;">
    Te informamos que has sido <strong style="color: #ea580c;">desasignado</strong> del siguiente proyecto:
</p>

<!-- Tarjeta del Proyecto -->
<div style="background-color: #fffaf0; border: 1px solid #fbd38d; border-radius: 12px; padding: 24px; margin-bottom: 24px;">
    <div style="margin-bottom: 12px;">
        <h2 style="color: #0f172a; font-size: 17px; margin: 0 0 4px 0;">📁 {{ $proyectoTitulo }}</h2>
        <p style="color: #64748b; font-size: 14px; margin: 0;">🏢 {{ $empresaNombre }}</p>
    </div>
    
    <div style="background-color: #fff; border-radius: 8px; padding: 12px 16px; border-left: 4px solid #f6ad55;">
        <p style="font-size: 13px; color: #9c4221; margin: 0; line-height: 1.5;">
            Este proyecto ha sido <strong>desactivado</strong> o fue reasignado a otro instructor por decisión del administrador.
        </p>
    </div>
</div>

<!-- Info box -->
<div style="background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px; padding: 20px; margin-bottom: 30px;">
    <p style="font-size: 14px; color: #0369a1; font-weight: 700; margin: 0 0 10px 0;">ℹ️ ¿Qué significa esto?</p>
    <ul style="margin: 0; padding-left: 20px; color: #0c4a6e; font-size: 13px; line-height: 1.8;">
        <li>Ya no tienes acceso a gestionar este proyecto.</li>
        <li>Tu historial de actividad en él se conserva en la plataforma.</li>
        <li>Puedes seguir gestionando tus otros proyectos asignados normalmente.</li>
    </ul>
</div>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <a href="{{ url('/instructor/dashboard') }}" style="display: inline-block; background: linear-gradient(135deg, #047857 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 30px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.3);">
                📊 Ver Mis Proyectos
            </a>
        </td>
    </tr>
</table>

<p style="font-size: 13px; color: #94a3b8; text-align: center; margin: 24px 0 0 0;">
    Si tienes alguna duda sobre esta decisión, por favor contacta al administrador.
</p>
@endsection
