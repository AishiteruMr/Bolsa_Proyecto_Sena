@extends('emails.layouts.master')

@section('title', 'Desasignado de Proyecto - SENA')
@section('header_icon', '📋')
@section('header_title', 'Desasignado de Proyecto')
@section('header_subtitle', 'El proyecto ha sido desactivado o reasignado')

@section('content')
<p style="font-size: 16px; color: #334155; margin: 0 0 20px 0; line-height: 1.6;">
    Hola <strong style="color: #065f46;">{{ $instructorNombre }}</strong>,
</p>

<p style="font-size: 15px; color: #475569; line-height: 1.7; margin: 0 0 24px 0;">
    Te informamos que has sido <strong style="color: #dc2626;">desasignado</strong> del siguiente proyecto:
</p>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #fffaf0; border: 1px solid #fbd38d; border-radius: 12px; margin-bottom: 24px;">
    <tr>
        <td style="padding: 24px;">
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="padding-bottom: 12px;">
                        <h2 style="color: #1e293b; font-size: 17px; margin: 0 0 4px 0;">{{ $proyectoTitulo }}</h2>
                        <p style="color: #64748b; font-size: 14px; margin: 0;">{{ $empresaNombre }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="background-color: #ffffff; border-radius: 8px; padding: 14px 16px; border-left: 4px solid #f6ad55;">
                        <p style="font-size: 13px; color: #9c4221; margin: 0; line-height: 1.5;">
                            Este proyecto ha sido <strong>desactivado</strong> o fue reasignado a otro instructor por decisi&oacute;n del administrador.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px; margin-bottom: 28px;">
    <tr>
        <td style="padding: 20px;">
            <p style="font-size: 14px; color: #0369a1; font-weight: 700; margin: 0 0 10px 0;">¿Qu&eacute; significa esto?</p>
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="padding: 3px 0; font-size: 13px; color: #0c4a6e; line-height: 1.6;">&bull; Ya no tienes acceso a gestionar este proyecto.</td>
                </tr>
                <tr>
                    <td style="padding: 3px 0; font-size: 13px; color: #0c4a6e; line-height: 1.6;">&bull; Tu historial de actividad en &eacute;l se conserva en la plataforma.</td>
                </tr>
                <tr>
                    <td style="padding: 3px 0; font-size: 13px; color: #0c4a6e; line-height: 1.6;">&bull; Puedes seguir gestionando tus otros proyectos asignados normalmente.</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td align="center">
            <a href="{{ url('/instructor/dashboard') }}" style="display: inline-block; background: linear-gradient(135deg, #065f46 0%, #10b981 100%); color: #ffffff; text-decoration: none; padding: 14px 36px; border-radius: 8px; font-weight: 700; font-size: 15px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                Ver Mis Proyectos
            </a>
        </td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top: 24px;">
    <tr>
        <td align="center" style="font-size: 13px; color: #94a3b8;">
            Si tienes alguna duda sobre esta decisi&oacute;n, contacta al administrador.
        </td>
    </tr>
</table>
@endsection
