@extends('layouts.dashboard')

@section('title', 'Banco de Proyectos - Admin')
@section('page-title', 'Banco de Proyectos')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection
@section('sidebar-nav')
    <span class="nav-label">Administración</span>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Principal
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

@section('content')
    <div class="animate-fade-in" style="margin-bottom: 40px;">
        <!-- Header tipo dashboard (icono + degradado suave) -->
        <div class="admin-header-master" style="margin-bottom:18px;">
            <div class="admin-header-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
            <div style="position: relative; z-index: 1;">
                <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                    <span class="admin-badge-hub">Banco Proyectos</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 700;">Panel de administración</span>
                </div>
                <h1 class="admin-header-title">Control Central de <span style="color: var(--primary);">Proyectos</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 16px; max-width: 700px; font-weight: 500;">Monitoreo global y asignación estratégica de instructores.</p>
            </div>
        </div>

        <div class="admin-project-grid">
            @forelse($proyectos as $p)
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 20px -5px rgba(0,0,0,0.05)'" onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
                <div style="padding: 24px; border-bottom: 1px solid #f8fafc;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                        @php
                            $statusStyles = match($p->estado) {
                                'aprobado' => ['bg' => '#ecfdf5', 'color' => '#059669', 'icon' => 'fa-check-circle', 'label' => 'Aprobado'],
                                'pendiente' => ['bg' => '#fff7ed', 'color' => '#ea580c', 'icon' => 'fa-clock', 'label' => 'Revisión Pendiente'],
                                'rechazado' => ['bg' => '#fef2f2', 'color' => '#dc2626', 'icon' => 'fa-times-circle', 'label' => 'Rechazado'],
                                default => ['bg' => '#f8fafc', 'color' => '#475569', 'icon' => 'fa-info-circle', 'label' => ucfirst($p->estado)]
                            };
                        @endphp
                        <span style="background: {{ $statusStyles['bg'] }}; color: {{ $statusStyles['color'] }}; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fas {{ $statusStyles['icon'] }}"></i> {{ $statusStyles['label'] }}
                        </span>
                        
                        <div style="width: 36px; height: 36px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                            <i class="fas fa-building" style="font-size: 14px;"></i>
                        </div>
                    </div>
                    
                    <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 6px 0; line-height: 1.4; letter-spacing: -0.3px;">{{ Str::limit($p->titulo, 55) }}</h3>
                    <p style="font-size: 13px; color: #64748b; margin: 0; font-weight: 500; display: flex; align-items: center; gap: 6px;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #cbd5e1;"></span>
                        {{ $p->empresa_nombre }}
                    </p>
                </div>

                <div style="padding: 24px; flex: 1; display: flex; flex-direction: column;">
                    
                    <div style="margin-bottom: 24px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <label style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">Mentor Asignado</label>
                            @if($p->instructor_nombre)
                                <span style="font-size: 10px; color: var(--primary); font-weight: 700; background: var(--primary-soft); padding: 2px 8px; border-radius: 10px;">Asignado</span>
                            @else
                                <span style="font-size: 10px; color: #f97316; font-weight: 700; background: #fff7ed; padding: 2px 8px; border-radius: 10px;">Pendiente</span>
                            @endif
                        </div>
                        
                        <form action="{{ route('admin.proyectos.asignar', $p->id) }}" method="POST">
                            @csrf
                            <div style="display: flex; gap: 8px;">
                                <select name="instructor_usuario_id" style="flex: 1; padding: 10px 12px; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 13px; font-weight: 600; color: #334155; background: #f8fafc; outline: none; transition: border-color 0.2s; cursor: pointer;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='#e2e8f0'" required>
                                    <option value="" disabled selected>Seleccionar Instructor...</option>
                                    @foreach($instructores as $ins)
                                        <option value="{{ $ins->usuario->id ?? '' }}" {{ $p->instructor_usuario_id == ($ins->usuario->id ?? '') ? 'selected' : '' }}>
                                            {{ $ins->nombres }} {{ $ins->apellidos }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" style="width: 42px; border: 1px solid #e2e8f0; border-radius: 10px; background: white; color: var(--primary); cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 2px rgba(0,0,0,0.02);" onmouseover="this.style.background='var(--primary-soft)'; this.style.borderColor='var(--primary-soft)';" onmouseout="this.style.background='white'; this.style.borderColor='#e2e8f0';" title="Actualizar">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div style="margin-top: auto; display: grid; grid-template-columns: {{ $p->estado == 'aprobado' ? '1fr 1fr' : '1fr' }}; gap: 10px;">
                        <a href="{{ route('admin.proyectos.revisar', $p->id) }}" style="text-align: center; padding: 10px; background: white; color: #334155; border: 1px solid #e2e8f0; border-radius: 10px; font-size: 12px; font-weight: 700; text-decoration: none; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.02);" onmouseover="this.style.background='#f8fafc'; this.style.color='#0f172a';" onmouseout="this.style.background='white'; this.style.color='#334155';">
                            Ver Detalles <i class="fas fa-arrow-right" style="margin-left: 4px; font-size: 10px; opacity: 0.7;"></i>
                        </a>

                        @if($p->estado == 'aprobado')
                        <form action="{{ route('admin.proyectos.estado', $p->id) }}" method="POST" style="width: 100%; margin: 0;">
                            @csrf
                            <input type="hidden" name="estado" value="cerrado">
                            <button type="submit" style="width: 100%; text-align: center; padding: 10px; background: white; color: #dc2626; border: 1px solid #fee2e2; border-radius: 10px; font-size: 12px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.02);" onmouseover="this.style.background='#fef2f2';" onmouseout="this.style.background='white';">
                                Pausar Proyecto <i class="fas fa-ban" style="margin-left: 4px; font-size: 10px; opacity: 0.7;"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="glass-card admin-empty-state">
                <div style="width: 90px; height: 90px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: #cbd5e1; border: 1px solid var(--border);">
                    <i class="fas fa-folder-open" style="font-size:36px;"></i>
                </div>
                <h3 style="font-size:22px; font-weight:800; color:var(--text); margin-bottom: 8px;">No hay registros</h3>
                <p style="color: var(--text-light); font-size:16px; font-weight: 500;">Aún no se han recibido propuestas de proyectos en la plataforma.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection
