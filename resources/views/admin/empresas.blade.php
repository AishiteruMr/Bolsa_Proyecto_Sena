@extends('layouts.dashboard')

@section('title', 'Empresas')
@section('page-title', 'Gestión de Empresas')

@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
    </a>
    <a href="{{ route('admin.usuarios') }}" class="nav-item {{ request()->routeIs('admin.usuarios') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Gestión Usuarios
    </a>
    <a href="{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas Aliadas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
@endsection

@section('content')    <div style="margin-bottom: 40px; animation: fadeIn 0.8s ease-out;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
            <div>
                <h2 style="font-size:32px; font-weight:800; letter-spacing: -1px; color: var(--text);">Ecosistema de <span style="color: var(--primary);">Empresas</span></h2>
                <p style="color:var(--text-light); font-size:16px; margin-top:6px;">Gestión y supervisión de organizaciones aliadas al SENA.</p>
            </div>
        </div>

        <!-- BENTO STATS -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 40px;">
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-left: 4px solid var(--primary);">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 700; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 0.5px;">Total Aliados</div>
                    <div style="font-size: 28px; font-weight: 800; color: var(--text);">{{ $empresas->count() }}</div>
                </div>
            </div>
            
            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-left: 4px solid #10b981;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 700; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 0.5px;">Empresas Activas</div>
                    <div style="font-size: 28px; font-weight: 800; color: #10b981;">{{ $empresas->where('emp_estado', 1)->count() }}</div>
                </div>
            </div>

            <div class="glass-card" style="padding: 24px; display: flex; align-items: center; gap: 20px; border-left: 4px solid #f97316;">
                <div style="width: 50px; height: 50px; border-radius: 12px; background: #fff7ed; color: #f97316; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div style="font-size: 13px; font-weight: 700; color: var(--text-lighter); text-transform: uppercase; letter-spacing: 0.5px;">En Espera</div>
                    <div style="font-size: 28px; font-weight: 800; color: #f97316;">{{ $empresas->where('emp_estado', 0)->count() }}</div>
                </div>
            </div>
        </div>

        <div class="glass-card" style="padding: 0; overflow: hidden; border-radius: var(--radius);">
            <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; background: rgba(248, 250, 252, 0.5); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size:18px; font-weight:800; color: var(--text); display: flex; align-items: center; gap: 12px;">
                    <span style="width: 36px; height: 36px; border-radius: 10px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 16px;">
                        <i class="fas fa-list-check"></i>
                    </span>
                    Directorio Corporativo
                </h3>
            </div>
            
            <div class="premium-table-container" style="border: none; box-shadow: none;">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Identificación (NIT)</th>
                            <th>Razón Social</th>
                            <th>Representante Legal</th>
                            <th>Contacto</th>
                            <th>Estado</th>
                            <th style="text-align: right;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($empresas as $e)
                            <tr>
                                <td style="font-weight: 700; color: var(--primary);">{{ $e->emp_nit }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #f8fafc; border: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-building" style="color: var(--text-lighter); font-size: 14px;"></i>
                                        </div>
                                        <div style="font-weight: 700; color: var(--text);">{{ $e->emp_nombre }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--text-light); font-size: 14px;">
                                        <i class="far fa-user-circle" style="margin-right: 6px; opacity: 0.5;"></i>
                                        {{ $e->emp_representante }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 13px; color: var(--text-light);">
                                        <i class="far fa-envelope" style="margin-right: 6px; opacity: 0.5;"></i>
                                        {{ $e->emp_correo }}
                                    </div>
                                </td>
                                <td>
                                    <span style="background: {{ $e->emp_estado == 1 ? '#d1fae5' : '#fee2e2' }}; color: {{ $e->emp_estado == 1 ? '#065f46' : '#991b1b' }}; padding: 6px 14px; border-radius: 30px; font-size: 11px; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 6px;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span>
                                        {{ $e->emp_estado == 1 ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.empresas.estado', $e->emp_id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="estado" value="{{ $e->emp_estado == 1 ? 0 : 1 }}">
                                        <button type="submit" class="btn-premium" style="padding: 8px 16px; font-size: 11px; background: {{ $e->emp_estado == 1 ? '#f1f5f9' : 'var(--primary)' }}; color: {{ $e->emp_estado == 1 ? 'var(--text-light)' : 'white' }}; box-shadow: none;">
                                            <i class="fas {{ $e->emp_estado == 1 ? 'fa-ban' : 'fa-check-circle' }}"></i>
                                            {{ $e->emp_estado == 1 ? 'Inhabilitar' : 'Habilitar' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 80px; color: var(--text-lighter);">
                                    <i class="fas fa-building-circle-exclamation" style="font-size: 48px; margin-bottom: 16px; opacity: 0.2;"></i>
                                    <div style="font-size: 16px; font-weight: 700;">No se han encontrado empresas registradas</div>
                                    <div style="font-size: 14px; margin-top: 4px;">Las nuevas inscripciones aparecerán en esta tabla automáticamente.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
@endsection
