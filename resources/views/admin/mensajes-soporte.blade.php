@extends('layouts.dashboard')

@section('title', 'Admin - Mensajes de Soporte')
@section('page-title', 'Mensajes de Soporte')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item">
        <i class="fas fa-th-large"></i> Principal
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item">
        <i class="fas fa-users"></i> Gestión Usuarios
    </a>
    <a href= "{{ route('admin.empresas') }}" class="nav-item">
        <i class="fas fa-building"></i> Empresas Aliadas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
    <span class="nav-label" style="margin-top: 16px;">Soporte</span>
    <a href="{{ route('admin.mensajes.soporte') }}" class="nav-item active">
        <i class="fas fa-envelope"></i> Mensajes Soporte
    </a>
    <span class="nav-label" style="margin-top: 16px;">Herramientas</span>
    <a href="{{ route('admin.backup') }}" class="nav-item">
        <i class="fas fa-database"></i> Backup
    </a>
    <a href="{{ route('admin.audit') }}" class="nav-item">
        <i class="fas fa-clipboard-list"></i> Auditoría
    </a>
@endsection

@section('content')
    <div class="glass-card" style="padding: 28px; background: white;">
        <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text); margin-bottom: 24px;">Mensajes Recibidos</h3>
        
        <div class="premium-table-container">
            <table class="premium-table">
                <thead>
                    <tr>
                        <th>Remitente</th>
                        <th>Email</th>
                        <th>Motivo</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                        <th style="text-align: right;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mensajes as $m)
                        <tr>
                            <td style="font-weight: 700;">{{ $m->nombre }}</td>
                            <td>{{ $m->email }}</td>
                            <td>
                                <span class="status-badge" style="padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; background: #e0e7ff; color: #4338ca;">
                                    {{ $m->motivo }}
                                </span>
                            </td>
                            <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $m->mensaje }}</td>
                            <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                            <td style="text-align: right;">
                                <a href="mailto:{{ $m->email }}?subject=Respuesta a su mensaje de soporte: {{ $m->motivo }}" class="btn-premium" style="padding: 6px 12px; font-size: 11px; background: var(--primary-soft); color: var(--primary); text-decoration: none; border-radius: 6px;">
                                    <i class="fas fa-reply"></i> Responder
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center; padding: 40px;">No hay mensajes nuevos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 20px;">
            {{ $mensajes->links() }}
        </div>
    </div>
@endsection
