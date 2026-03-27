@extends('layouts.dashboard')
@section('title', 'Dashboard Empresa')
@section('page-title', 'Panel Empresa')

@section('sidebar-nav')
    <span class="nav-label">Portal Empresa</span>
    <a href="{{ route('empresa.dashboard') }}" class="nav-item {{ request()->routeIs('empresa.dashboard') ? 'active' : '' }}">
        <i class="fas fa-th-large"></i> Dashboard
    </a>
    <a href="{{ route('empresa.proyectos') }}" class="nav-item {{ request()->routeIs('empresa.proyectos') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('empresa.proyectos.crear') }}" class="nav-item {{ request()->routeIs('empresa.proyectos.crear') ? 'active' : '' }}">
        <i class="fas fa-plus-circle"></i> Publicar Proyecto
    </a>
    <span class="nav-label">Configuración</span>
    <a href="{{ route('empresa.perfil') }}" class="nav-item {{ request()->routeIs('empresa.perfil') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Perfil Empresa
    </a>
@endsection

@section('content')
    <div style="animation: fadeIn 0.8s ease-out;">
        <!-- HEADER CORPORATIVO -->
        <div style="background: linear-gradient(135deg, #0f172a, #1e293b); padding: 48px; border-radius: var(--radius-lg); margin-bottom: 40px; position: relative; overflow: hidden; box-shadow: var(--shadow-premium);">
            <div style="position: absolute; right: -30px; bottom: -30px; font-size: 240px; color: rgba(62,180,137,0.05); transform: rotate(-15deg); pointer-events: none;">
                <i class="fas fa-building"></i>
            </div>
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <span style="background: var(--primary); color: white; padding: 6px 16px; border-radius: 30px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; box-shadow: 0 4px 12px var(--primary-glow);">Portal Corporativo</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 600;"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F') }}</span>
                </div>
                <h1 style="font-size: 48px; font-weight: 800; color: white; margin-bottom: 12px; letter-spacing: -1.5px;">Panel de Control <span style="color: var(--primary);">{{ session('nombre') }}</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 18px; max-width: 650px; line-height: 1.6;">Impulsa la innovación y conecta con el mejor talento del SENA gestionando tus proyectos estratégicos.</p>
            </div>
        </div>

        <!-- BENTO STATS GRID -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 48px;">
            <div class="glass-card" style="padding: 32px; border-color: var(--primary-soft); background: rgba(255,255,255,0.95);">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 20px;">
                    <i class="fas fa-folder-plus"></i>
                </div>
                <div style="font-size: 34px; font-weight: 800; color: var(--text); line-height: 1;">{{ $totalProyectos }}</div>
                <div style="font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">Proyectos Totales</div>
            </div>

            <div class="glass-card" style="padding: 32px; background: rgba(255,255,255,0.95);">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 20px;">
                    <i class="fas fa-check-double"></i>
                </div>
                <div style="font-size: 34px; font-weight: 800; color: #10b981; line-height: 1;">{{ $proyectosActivos }}</div>
                <div style="font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">En Ejecución</div>
            </div>

            <div class="glass-card" style="padding: 32px; background: rgba(255,255,255,0.95);">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 20px;">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div style="font-size: 34px; font-weight: 800; color: #3b82f6; line-height: 1;">{{ $totalPostulaciones }}</div>
                <div style="font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 1px; margin-top: 8px;">Postulaciones</div>
            </div>

            <div class="glass-card" style="padding: 32px; background: linear-gradient(135deg, #f59e0b, #d97706); border: none; color: white;">
                <div style="width: 48px; height: 48px; border-radius: 14px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 20px;">
                    <i class="fas fa-clock"></i>
                </div>
                <div style="font-size: 34px; font-weight: 800; line-height: 1;">{{ $postulacionesPendientes }}</div>
                <div style="font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-top: 8px; opacity: 0.9;">Pendientes de Revisión</div>
            </div>
        </div>

        <!-- RECENT PROJECTS TABLE -->
        <div class="glass-card" style="padding: 0; overflow: hidden; border-radius: var(--radius); background: white;">
            <div style="padding: 32px 40px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="font-size: 22px; font-weight: 800; color: var(--text); display: flex; align-items: center; gap: 14px;">
                    <span style="width: 42px; height: 42px; border-radius: 12px; background: var(--primary-soft); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                        <i class="fas fa-list-ul"></i>
                    </span>
                    Proyectos Publicados Recientemente
                </h3>
                <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium">
                    <i class="fas fa-plus-circle"></i> Nueva Oferta
                </a>
            </div>
            
            <div class="premium-table-container" style="border: none; box-shadow: none;">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Identificador y Título</th>
                            <th>Categoría</th>
                            <th>Estado Actual</th>
                            <th>Métricas de Interés</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proyectosRecientes as $p)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 16px;">
                                        <div style="width: 48px; height: 48px; border-radius: 12px; background: #f8fafc; border: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                            @if($p->pro_evidencia_foto)
                                                <img src="{{ asset('storage/' . $p->pro_evidencia_foto) }}" style="width:100%; height:100%; object-fit:cover;">
                                            @else
                                                <i class="fas fa-briefcase" style="color: var(--text-lighter);"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div style="font-weight: 700; color: var(--text);">{{ Str::limit($p->pro_titulo_proyecto, 40) }}</div>
                                            <div style="font-size: 12px; color: var(--text-lighter); font-weight: 500;">
                                                Expira: {{ \Carbon\Carbon::parse($p->pro_fecha_finalizacion)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="background: #f1f5f9; color: var(--text-light); padding: 6px 14px; border-radius: 30px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                        {{ $p->pro_categoria }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'Activo' => 'background: #d1fae5; color: #065f46;',
                                            'Pendiente' => 'background: #fef3c7; color: #92400e;',
                                            'Finalizado' => 'background: #f1f5f9; color: var(--text-light);',
                                            'Rechazado' => 'background: #fef2f2; color: #991b1b;',
                                        ][$p->pro_estado] ?? 'background: #f1f5f9; color: var(--text-light);';
                                    @endphp
                                    <span style="{{ $statusClass }} padding: 6px 14px; border-radius: 30px; font-size: 11px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span>
                                        {{ $p->pro_estado }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="display: flex; -webkit-mask-image: linear-gradient(to right, black 70%, transparent);">
                                            @foreach($p->postulaciones->take(3) as $post)
                                                <div style="width: 28px; height: 28px; border-radius: 50%; background: var(--primary); border: 2px solid white; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; font-weight: 800; margin-left: -8px;">
                                                    {{ substr($post->aprendiz->apr_nombres, 0, 1) }}
                                                </div>
                                            @endforeach
                                        </div>
                                        <span style="font-weight: 800; color: var(--text); font-size: 14px;">{{ $p->postulaciones_count }}</span>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('empresa.proyectos') }}" style="width: 36px; height: 36px; border-radius: 10px; background: #f8fafc; color: var(--text-light); display: flex; align-items: center; justify-content: center; border: 1px solid #f1f5f9; transition: all 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='white'; this.style.borderColor='var(--primary)'" onmouseout="this.style.background='#f8fafc'; this.style.color='var(--text-light)'; this.style.borderColor='#f1f5f9'">
                                        <i class="fas fa-eye" style="font-size: 14px;"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 80px;">
                                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #f8fafc; display: flex; align-items: center; justify-content: center; font-size: 32px; color: var(--text-lighter); margin: 0 auto 24px;">
                                        <i class="fas fa-folder-open"></i>
                                    </div>
                                    <h4 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 8px;">No has publicado proyectos aún</h4>
                                    <p style="color: var(--text-light); margin-bottom: 24px; font-weight: 500;">Comienza ahora y conecta con el mejor talento técnico y tecnológico.</p>
                                    <a href="{{ route('empresa.proyectos.crear') }}" class="btn-premium">Publicar Primer Proyecto</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
    </style>
@endsection