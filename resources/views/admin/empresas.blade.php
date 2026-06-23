@extends('layouts.dashboard')

@section('title', 'Empresas Aliadas - Admin')
@section('page-title', 'Directorio de Empresas')

@section('sidebar-nav')
    @include('admin.partials.sidebar-nav')
@endsection

@section('styles')
    @vite(['resources/css/admin.css'])
@endsection
@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('admin.dashboard')], ['label' => 'Empresas']]; @endphp
@section('content')
    <div class="animate-fade-in" style="margin-bottom: 40px;">
        <div class="admin-header-master">
            <div class="admin-header-icon"><i class="fas fa-building"></i></div>
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <span class="admin-badge-hub">Admin Control Hub</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 700;"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <h1 class="admin-header-title">Ecosistema de <span style="color: var(--primary);">Empresas</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 18px; max-width: 720px; font-weight: 500;">Gestión y supervisión de organizaciones aliadas al SENA desde una vista centralizada.</p>
            </div>
        </div>

        {{-- KPI STAT CARDS --}}
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-top: 24px; margin-bottom: 24px;">
            <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid var(--primary);">
                <div class="admin-stat-icon" style="background: var(--primary-soft); color: var(--primary); width: 44px; height: 44px;"><i class="fas fa-building"></i></div>
                <div><div class="admin-stat-label">Total Aliados</div><div class="admin-stat-value">{{ $totalEmpresas }}</div></div>
            </div>
            <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #10b981;">
                <div class="admin-stat-icon" style="background: #f0fdf4; color: #10b981; width: 44px; height: 44px;"><i class="fas fa-check-circle"></i></div>
                <div><div class="admin-stat-label">Empresas Activas</div><div class="admin-stat-value" style="color: #10b981;">{{ $empresasActivas }}</div></div>
            </div>
            <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #3b82f6;">
                <div class="admin-stat-icon" style="background: #eff6ff; color: #3b82f6; width: 44px; height: 44px;"><i class="fas fa-file-invoice"></i></div>
                <div><div class="admin-stat-label">Con Proyectos</div><div class="admin-stat-value" style="color: #3b82f6;">{{ $empresasConProyectos }}</div></div>
            </div>
            <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #f59e0b;">
                <div class="admin-stat-icon" style="background: #fef3c7; color: #f59e0b; width: 44px; height: 44px;"><i class="fas fa-clock"></i></div>
                <div><div class="admin-stat-label">Sin Proyectos</div><div class="admin-stat-value" style="color: #f59e0b;">{{ $empresasSinProyectos }}</div></div>
            </div>
        </div>

        {{-- TOP EMPRESAS BAR CHART --}}
        @if($topEmpresas->count() > 0)
        <div class="glass-card" style="padding: 20px; background: white; margin-bottom: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text);">
                    <i class="fas fa-trophy" style="color: #f59e0b; margin-right: 8px;"></i>
                    Top Empresas con Más Proyectos
                </h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @php $maxEmp = $topEmpresas->max('proyectos_count'); @endphp
                @foreach($topEmpresas as $i => $emp)
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 600; margin-bottom: 4px;">
                        <span style="color: var(--text);"><span style="color: #94a3b8; margin-right: 6px;">#{{ $i + 1 }}</span>{{ $emp->nombre }}</span>
                        <span style="color: #3b82f6;">{{ $emp->proyectos_count }} proyectos</span>
                    </div>
                    <div style="height: 8px; background: #f1f5f9; border-radius: 4px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $maxEmp > 0 ? ($emp->proyectos_count / $maxEmp) * 100 : 0 }}%; background: linear-gradient(90deg, #3b82f6, #60a5fa); border-radius: 4px; transition: width 0.6s ease;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="glass-card admin-table-card">
            <div class="admin-table-header">
                <h3 style="font-size:18px; font-weight:800; color: var(--text); display: flex; align-items: center; gap: 12px;">
                    <span class="admin-stat-icon" style="width: 36px; height: 36px; background: var(--primary-soft); color: var(--primary); font-size: 16px;">
                        <i class="fas fa-list-check"></i>
                    </span>
                    Directorio Corporativo
                </h3>
            </div>
            
            <div class="premium-table-container">
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
                                <td style="font-weight: 800; color: var(--primary);">{{ $e->nit }}</td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-building" style="color: var(--text-light); font-size: 14px;"></i>
                                        </div>
                                        <div class="admin-company-name">{{ $e->nombre }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-company-rep"><i class="far fa-user-circle" style="margin-right: 6px; opacity: 0.5;"></i>{{ $e->representante }}</div>
                                </td>
                                <td class="admin-contact">
                                    <i class="far fa-envelope" style="margin-right: 6px; opacity: 0.5;"></i>
                                    {{ $e->correo_contacto }}
                                </td>
                                <td>
                                    <span class="status-badge {{ $e->activo == 1 ? 'active' : 'inactive' }}" style="padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 800; white-space: nowrap;">
                                        {{ $e->activo == 1 ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('admin.empresas.estado', $e->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="estado" value="{{ $e->activo == 1 ? 0 : 1 }}">
                                        <button type="submit" class="btn-premium" style="padding: 10px 16px; font-size: 11px; background: {{ $e->activo == 1 ? '#f8fafc' : 'var(--primary)' }}; color: {{ $e->activo == 1 ? '#64748b' : 'white' }}; border: {{ $e->activo == 1 ? '1px solid #e2e8f0' : 'none' }}; box-shadow: none;">
                                            <i class="fas {{ $e->activo == 1 ? 'fa-ban' : 'fa-check-circle' }}"></i>
                                            {{ $e->activo == 1 ? 'Inhabilitar' : 'Habilitar' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 80px;">
                                    <div style="color: var(--text-light);">
                                        <i class="fas fa-building-circle-exclamation" style="font-size: 48px; margin-bottom: 16px; opacity: 0.2;"></i>
                                        <div style="font-size: 16px; font-weight: 800; color: var(--text);">Sin empresas registradas</div>
                                        <div style="font-size: 14px; margin-top: 8px; font-weight: 500;">Las nuevas inscripciones aparecerán en esta tabla automáticamente.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
