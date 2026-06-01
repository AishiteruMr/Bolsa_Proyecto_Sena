@extends('layouts.dashboard')

@section('title', 'Detalle del Proyecto')
@section('page-title', 'Gestión de Proyecto')

@section('sidebar-nav')
    <span class="nav-label">Principal</span>
    <a href="{{ route('aprendiz.dashboard') }}" class="nav-item {{ request()->routeIs('aprendiz.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('aprendiz.proyectos') }}" class="nav-item {{ request()->routeIs('aprendiz.proyectos') ? 'active' : '' }}">
        <i class="fas fa-briefcase"></i> Explorar Proyectos
    </a>
    <a href="{{ route('aprendiz.postulaciones') }}" class="nav-item {{ request()->routeIs('aprendiz.postulaciones') ? 'active' : '' }}">
        <i class="fas fa-paper-plane"></i> Mis Postulaciones
    </a>
    <a href="{{ route('aprendiz.historial') }}" class="nav-item {{ request()->routeIs('aprendiz.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="{{ route('aprendiz.entregas') }}" class="nav-item {{ request()->routeIs('aprendiz.entregas') ? 'active' : '' }}">
        <i class="fas fa-tasks"></i> Mis Entregas
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('aprendiz.perfil') }}" class="nav-item {{ request()->routeIs('aprendiz.perfil') ? 'active' : '' }}">
        <i class="fas fa-user"></i> Mi Perfil
    </a>
@endsection

@section('styles')
    @vite(['resources/css/aprendiz.css'])
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('aprendiz.dashboard')], ['label' => 'Explorar Proyectos', 'url' => route('aprendiz.proyectos')], ['label' => 'Detalle']]; @endphp
@section('content')
<div class="animate-fade-in" style="padding-bottom: 40px;">
    
    <!-- Hero Header -->
    <div class="instructor-hero" style="padding: 40px 48px; margin-bottom: 32px;">
        <div class="instructor-hero-bg-icon"><i class="fas fa-project-diagram"></i></div>
        <div style="position: relative; z-index: 1;">
            <a href="{{ route('aprendiz.postulaciones') }}" style="display: inline-flex; align-items: center; gap: 8px; color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px; font-weight: 600; margin-bottom: 16px; transition: color 0.3s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='rgba(255,255,255,0.6)'">
                <i class="fas fa-arrow-left"></i> Volver a mis postulaciones
            </a>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                <span class="instructor-tag">Gestión</span>
                <span style="background: rgba(59,130,246,0.2); border: 1px solid rgba(59,130,246,0.3); color: #93c5fd; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 700;">{{ $proyecto->categoria }}</span>
            </div>
            <h1 class="instructor-title">{{ $proyecto->titulo }}</h1>
            <p style="color: rgba(255,255,255,0.7); font-size: 15px; font-weight: 500;">Panel de seguimiento y entrega de productos del proyecto.</p>
        </div>
    </div>

    <!-- Stat Grid Compact -->
    <div class="instructor-stat-grid" style="margin-bottom: 32px;">
        <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #3eb489;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(62,180,137,0.1); color: #3eb489; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                <i class="fas fa-flag-checkered"></i>
            </div>
            <div style="min-width: 0;">
                <div style="font-size: 11px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px;">Estado</div>
                @php
                    $statusStyles = match($proyecto->estado) {
                        'completado' => ['bg' => '#065f46', 'icon' => 'fa-check'],
                        'aprobado' => ['bg' => '#10b981', 'icon' => 'fa-check'],
                        'pendiente' => ['bg' => '#f59e0b', 'icon' => 'fa-clock'],
                        'rechazado' => ['bg' => '#ef4444', 'icon' => 'fa-ban'],
                        'cerrado' => ['bg' => '#64748b', 'icon' => 'fa-lock'],
                        'en_progreso' => ['bg' => '#3b82f6', 'icon' => 'fa-spinner'],
                        default => ['bg' => '#64748b', 'icon' => 'fa-info-circle'],
                    };
                @endphp
                <span style="background: {{ $statusStyles['bg'] }}; color: #ffffff; padding: 4px 12px; border-radius: 20px; display: inline-flex; align-items: center; gap: 5px; font-size: 12px;">
                    <i class="fas {{ $statusStyles['icon'] }}"></i> {{ Str::title(str_replace('_', ' ', $proyecto->estado)) }}
                </span>
            </div>
        </div>
        
        <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #3b82f6;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                <i class="fas fa-building"></i>
            </div>
            <div style="min-width: 0;">
                <div style="font-size: 11px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px;">Empresa</div>
                <div style="font-size: 15px; font-weight: 800; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $proyecto->emp_nombre ?? $proyecto->empresa->nombre ?? 'No asignada' }}</div>
            </div>
        </div>

        <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #f59e0b;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #fffbeb; color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div style="min-width: 0;">
                <div style="font-size: 11px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px;">Instructor</div>
                <div style="font-size: 15px; font-weight: 800; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $proyecto->instructor_nombre }}</div>
            </div>
        </div>

        <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #ef4444;">
            <div style="width: 44px; height: 44px; border-radius: 12px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div style="min-width: 0;">
                <div style="font-size: 11px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px;">Límite</div>
                <div style="font-size: 15px; font-weight: 800; color: var(--text);">{{ \Carbon\Carbon::parse($proyecto->fecha_finalizacion)->format('d M, Y') }}</div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 28px; align-items: start;">
        <!-- Main Info & Stages -->
        <div style="display: grid; gap: 28px;">
            
            <!-- Descripción y Detalles -->
            <div class="glass-card" style="padding: 28px;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                    <div style="width: 32px; height: 32px; border-radius: 10px; background: rgba(62,180,137,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-info-circle" style="color: #3eb489; font-size: 15px;"></i>
                    </div>
                    <h3 style="font-size: 18px; font-weight: 800; color: var(--text); margin: 0;">Sobre el Proyecto</h3>
                </div>
                
                <div style="background: #f8fafc; border-radius: 14px; padding: 20px; margin-bottom: 20px; border: 1px solid #eef2f6;">
                    <p style="color: var(--text-light); line-height: 1.8; margin: 0; font-weight: 500;">
                        {{ $proyecto->descripcion }}
                    </p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div style="background: #ffffff; padding: 18px; border-radius: 14px; border: 1px solid #eef2f6; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                            <div style="width: 28px; height: 28px; border-radius: 8px; background: rgba(62,180,137,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-list-check" style="color: #3eb489; font-size: 12px;"></i>
                            </div>
                            <h4 style="font-size: 12px; font-weight: 800; color: var(--text); margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Requisitos</h4>
                        </div>
                        <p style="font-size: 13px; color: var(--text-light); font-weight: 500; line-height: 1.6; margin: 0;">{{ $proyecto->requisitos_especificos }}</p>
                    </div>
                    <div style="background: #ffffff; padding: 18px; border-radius: 14px; border: 1px solid #eef2f6; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 10px;">
                            <div style="width: 28px; height: 28px; border-radius: 8px; background: rgba(245,158,11,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-star" style="color: #f59e0b; font-size: 12px;"></i>
                            </div>
                            <h4 style="font-size: 12px; font-weight: 800; color: var(--text); margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Habilidades</h4>
                        </div>
                        <p style="font-size: 13px; color: var(--text-light); font-weight: 500; line-height: 1.6; margin: 0;">{{ $proyecto->habilidades_requeridas }}</p>
                    </div>
                </div>
            </div>

            <!-- Etapas y Seguimiento -->
            <div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text); margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                    <div style="width: 30px; height: 30px; border-radius: 9px; background: rgba(62,180,137,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-tasks" style="color: #3eb489; font-size: 14px;"></i>
                    </div>
                    Plan de Trabajo y Entregas
                    @if(count($etapas) > 0)
                        <span style="font-size: 11px; font-weight: 700; color: var(--text-light); background: #f1f5f9; padding: 3px 10px; border-radius: 20px; margin-left: auto;">{{ count($etapas) }} etapa(s)</span>
                    @endif
                </h3>

                <div style="display: grid; gap: 0;">
                    @forelse($etapas as $etapa)
                        @php
                            $evidenciasEtapa = $evidencias->where('etapa_id', $etapa->id);
                            $evidenciaCerrada = $evidenciasEtapa->first(function ($e) {
                                return in_array($e->estado, ['aceptada', 'rechazada']);
                            });
                        @endphp
                        <div style="position: relative; padding-left: 52px; padding-bottom: 28px;">
                            @if(!$loop->last)
                                <div style="position: absolute; left: 24px; top: 40px; bottom: 0; width: 2px; background: linear-gradient(to bottom, rgba(62,180,137,0.25), rgba(62,180,137,0.05));"></div>
                            @endif
                            <div style="position: absolute; left: 14px; top: 0; width: 22px; height: 22px; background: linear-gradient(135deg, #3eb489, #2d9d74); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 11px; box-shadow: 0 3px 8px rgba(62,180,137,0.3); z-index: 2;">{{ $etapa->orden }}</div>

                            <div class="glass-card" style="padding: 20px;">

                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <h4 style="font-size: 15px; font-weight: 800; color: var(--text); margin: 0;">{{ $etapa->nombre }}</h4>
                                    @if($evidenciasEtapa->count())
                                        <span style="background: rgba(62,180,137,0.1); color: #3eb489; padding: 3px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; white-space: nowrap;">
                                            {{ $evidenciasEtapa->count() }} entrega(s)
                                        </span>
                                    @endif
                                </div>

                                <p style="color: var(--text-light); font-size: 13px; margin-bottom: 16px; font-weight: 500; line-height: 1.6;">{{ $etapa->descripcion }}</p>

                                @if($etapa->url_documento)
                                <div style="background: rgba(62,180,137,0.06); border: 1px solid rgba(62,180,137,0.15); border-radius: 10px; padding: 10px 14px; margin-bottom: 16px; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-book-open" style="color: #3eb489; font-size: 16px; flex-shrink: 0;"></i>
                                    <span style="flex: 1; font-size: 12px; font-weight: 700; color: var(--text);">Documento Guía</span>
                                    <a href="{{ asset('storage/' . $etapa->url_documento) }}" target="_blank" class="btn-premium" style="padding: 6px 14px; font-size: 11px;">
                                        <i class="fas fa-download"></i> Descargar
                                    </a>
                                </div>
                                @endif

                                @if($evidenciasEtapa->count())
                                    <div style="background: #f8fafc; border-radius: 10px; padding: 12px; margin-bottom: 16px; border: 1px solid #e2e8f0;">
                                        <p style="font-size: 10px; font-weight: 800; color: var(--text-light); margin-bottom: 10px; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px;">
                                            <i class="fas fa-history"></i>Tus Entregas
                                        </p>
                                        <div style="display: grid; gap: 6px;">
                                        @foreach($evidenciasEtapa as $evid)
                                            @php
                                                $stateColor = match($evid->estado) {
                                                    'aceptada'  => ['bg' => '#10b981', 'border' => '#bbf7d0', 'text' => '#ffffff', 'icon' => 'fa-check'],
                                                    'rechazada' => ['bg' => '#ef4444', 'border' => '#fecaca', 'text' => '#ffffff', 'icon' => 'fa-ban'],
                                                    'pendiente' => ['bg' => '#f59e0b', 'border' => '#fde68a', 'text' => '#ffffff', 'icon' => 'fa-clock'],
                                                    'en_progreso' => ['bg' => '#3b82f6', 'border' => '#bfdbfe', 'text' => '#ffffff', 'icon' => 'fa-spinner'],
                                                    default     => ['bg' => '#64748b', 'border' => '#e2e8f0', 'text' => '#ffffff', 'icon' => 'fa-info-circle'],
                                                };
                                            @endphp
                                            <div style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: white; border-radius: 8px; border: 1px solid #e2e8f0;">
                                                <div style="width: 30px; height: 30px; background: {{ $stateColor['bg'] }}; color: white; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0;">
                                                    <i class="fas {{ $stateColor['icon'] }}"></i>
                                                </div>
                                                <div style="flex: 1; min-width: 0;">
                                                    <p style="font-size: 11px; font-weight: 700; color: var(--text); margin: 0;">{{ $evid->fecha_envio->format('d M, Y - h:i A') }}</p>
                                                    @if($evid->comentario_instructor)
                                                        <p style="font-size: 10px; color: var(--text-light); margin: 1px 0 0;"><i class="fas fa-comment" style="margin-right: 4px;"></i>{{ $evid->comentario_instructor }}</p>
                                                    @endif
                                                </div>
                                                <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                                                    <span style="background: {{ $stateColor['bg'] }}; color: white; padding: 3px 8px; border-radius: 20px; font-size: 9px; font-weight: 700;">{{ Str::title(str_replace('_', ' ', $evid->estado)) }}</span>
                                                    @if($evid->ruta_archivo)
                                                        <a href="{{ asset('storage/' . $evid->ruta_archivo) }}" target="_blank" style="width: 28px; height: 28px; background: #f1f5f9; border-radius: 7px; display: flex; align-items: center; justify-content: center; color: #475569; text-decoration: none; font-size: 12px;"><i class="fas fa-download"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if($evidenciaCerrada)
                                    <div style="border-top: 1px solid #e2e8f0; padding-top: 16px;">
                                        <div style="background: #f8fafc; border-radius: 10px; padding: 16px; text-align: center; border: 1px solid #e2e8f0;">
                                            <i class="fas fa-lock" style="color: #94a3b8; font-size: 1.2rem; margin-bottom: 6px; display: block;"></i>
                                            <p style="font-size: 12px; font-weight: 700; color: #94a3b8; margin: 0;">
                                                @if($evidenciaCerrada->estado === 'aceptada')
                                                    Evidencia aprobada — No se requieren más entregas
                                                @elseif($evidenciaCerrada->estado === 'rechazada')
                                                    Evidencia evaluada — Opción de entrega cerrada
                                                @else
                                                    Opción de entrega cerrada
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <div style="border-top: 1px solid #e2e8f0; padding-top: 16px;">
                                        <p style="font-size: 12px; font-weight: 700; color: var(--text); margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                                            <i class="fas fa-paper-plane" style="color: #3eb489; font-size: 12px;"></i> Enviar Nueva Evidencia
                                        </p>
                                        <form action="{{ route('aprendiz.evidencia.enviar', [$proyecto->id, $etapa->id]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div style="display: flex; flex-direction: column; gap: 10px;">
                                                <textarea name="descripcion" required placeholder="Comentario sobre tu entrega..." style="width: 100%; padding: 10px 12px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-family: inherit; font-size: 12px; font-weight: 500; min-height: 48px; outline: none; transition: border-color 0.3s; resize: vertical;" onfocus="this.style.borderColor='#3eb489'" onblur="this.style.borderColor='#e2e8f0'"></textarea>
                                                <div style="display: flex; gap: 10px; align-items: center;">
                                                    <div style="flex: 1; border: 2px dashed rgba(62,180,137,0.25); padding: 10px; border-radius: 8px; background: #fafcff; text-align: center; color: var(--text-light); cursor: pointer; font-size: 11px; font-weight: 600; position: relative; transition: all 0.3s;" onmouseover="this.style.borderColor='#3eb489'; this.style.background='rgba(62,180,137,0.04)'" onmouseout="this.style.borderColor='rgba(62,180,137,0.25)'; this.style.background='#fafcff'">
                                                        <i class="fas fa-cloud-arrow-up" style="margin-right: 4px; color: #3eb489;"></i> Seleccionar archivo
                                                        <input type="file" name="archivo" required style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                                    </div>
                                                    <button type="submit" class="btn-premium" style="padding: 10px 18px; white-space: nowrap; font-size: 12px;">
                                                        <i class="fas fa-paper-plane"></i> Entregar
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="glass-card" style="padding: 48px 32px; text-align: center;">
                            <div style="width: 64px; height: 64px; background: rgba(62,180,137,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 26px; color: #3eb489;">
                                <i class="fas fa-hourglass-start"></i>
                            </div>
                            <h4 style="color: var(--text); font-size: 16px; font-weight: 800; margin-bottom: 6px;">Planificación en Progreso</h4>
                            <p style="color: var(--text-light); font-size: 13px; margin: 0;">El instructor aún no ha definido las etapas para este proyecto.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar: Imagen y Info -->
        <div style="display: grid; gap: 24px;">
            
            <!-- Imagen del Proyecto + Datos clave -->
            <div class="glass-card" style="padding: 20px;">
                @if($proyecto->imagen_url)
                    <img src="{{ $proyecto->imagen_url }}" loading="lazy" style="width: 100%; border-radius: 12px; box-shadow: 0 6px 16px rgba(0,0,0,0.06); margin-bottom: 14px;">
                @else
                    <div style="width: 100%; aspect-ratio: 16/9; background: linear-gradient(135deg, #3eb489, #2d9d74); border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; margin-bottom: 14px;">
                        <i class="fas fa-image" style="font-size: 28px; margin-bottom: 8px; opacity: 0.6;"></i>
                        <p style="font-size: 12px; font-weight: 700;">Proyecto Sin Imagen</p>
                    </div>
                @endif
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                    <div style="background: #f8fafc; padding: 10px; border-radius: 8px; text-align: center; border: 1px solid #eef2f6;">
                        <p style="font-size: 9px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 3px;">Categoría</p>
                        <p style="font-size: 12px; font-weight: 800; color: var(--text); margin: 0;">{{ $proyecto->categoria }}</p>
                    </div>
                    <div style="background: #f8fafc; padding: 10px; border-radius: 8px; text-align: center; border: 1px solid #eef2f6;">
                        <p style="font-size: 9px; font-weight: 700; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.3px; margin-bottom: 3px;">Duración</p>
                        <p style="font-size: 12px; font-weight: 800; color: var(--text); margin: 0;">{{ $proyecto->duracion_estimada_dias ?? '—' }} días</p>
                    </div>
                </div>
            </div>

            <!-- Oferta / Beneficio -->
            @if($proyecto->oferta)
            <div class="glass-card" style="padding: 0; overflow: hidden; border: 1.5px solid rgba(139,92,246,0.2);">
                <div style="height: 3px; background: linear-gradient(90deg, #8b5cf6, #6d28d9, #8b5cf6);"></div>
                <div style="padding: 16px 18px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: linear-gradient(135deg, #8b5cf6, #6d28d9); color: white; display: flex; align-items: center; justify-content: center; font-size: 14px; box-shadow: 0 3px 8px rgba(139,92,246,0.25); flex-shrink: 0;">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div>
                            <p style="font-size: 9px; font-weight: 800; color: #6d28d9; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">Beneficio</p>
                            <p style="font-size: 13px; font-weight: 800; color: #4c1d95; margin: 1px 0 0 0;">
                                @switch($proyecto->oferta)
                                    @case('pasantias') Pasantías @break
                                    @case('contrato_aprendizaje') Contrato de aprendizaje @break
                                    @case('auxilio_transporte') Auxilio de transporte @break
                                    @case('otro') {{ $proyecto->oferta_otro }} @break
                                @endswitch
                            </p>
                        </div>
                    </div>
                    <div style="background: rgba(139,92,246,0.06); border-radius: 6px; padding: 6px 10px; border: 1px solid rgba(139,92,246,0.1);">
                        <p style="font-size: 10px; color: #7c3aed; margin: 0; font-weight: 600; display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-star" style="font-size: 8px;"></i> Solo al aprendiz con mejor desempeño.
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Método de Trabajo -->
            <div class="glass-card" style="padding: 20px;">
                <h4 style="font-size: 13px; font-weight: 800; color: var(--text); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                    <div style="width: 28px; height: 28px; border-radius: 8px; background: rgba(62,180,137,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-file-alt" style="color: #3eb489; font-size: 13px;"></i>
                    </div>
                    Método de Trabajo
                </h4>
                <div style="display: grid; gap: 8px;">
                    @if($proyecto->url_estructura)
                    <a href="{{ asset('storage/' . $proyecto->url_estructura) }}" target="_blank" style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: rgba(62,180,137,0.05); border-radius: 10px; border: 1px solid rgba(62,180,137,0.15); text-decoration: none; transition: background 0.2s; font-size: 12px;" onmouseover="this.style.background='rgba(62,180,137,0.1)'" onmouseout="this.style.background='rgba(62,180,137,0.05)'">
                        <i class="fas fa-file-pdf" style="color: #3eb489; font-size: 15px;"></i>
                        <span style="flex: 1; font-weight: 700; color: var(--text);">Estructura Personalizada</span>
                        <i class="fas fa-download" style="color: #3eb489; font-size: 12px;"></i>
                    </a>
                    @endif
                    <a href="{{ asset('assets/default-estructura.pdf') }}" target="_blank" style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; text-decoration: none; transition: background 0.2s; font-size: 12px;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                        <i class="fas fa-book" style="color: #64748b; font-size: 15px;"></i>
                        <span style="flex: 1; font-weight: 700; color: var(--text);">Estructura Predeterminada</span>
                        <i class="fas fa-download" style="color: #64748b; font-size: 12px;"></i>
                    </a>
                </div>
            </div>

            <!-- Cronograma -->
            <div class="glass-card" style="padding: 20px;">
                <h4 style="font-size: 13px; font-weight: 800; color: var(--text); margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                    <div style="width: 28px; height: 28px; border-radius: 8px; background: rgba(62,180,137,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-calendar-alt" style="color: #3eb489; font-size: 13px;"></i>
                    </div>
                    Cronograma
                </h4>
                <div style="display: grid; gap: 8px;">
                    <div style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: #f8fafc; border-radius: 10px;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-rocket" style="font-size: 12px;"></i>
                        </div>
                        <div>
                            <p style="font-size: 9px; color: var(--text-light); margin-bottom: 1px; text-transform: uppercase; font-weight: 700;">Inicio</p>
                            <p style="font-size: 12px; font-weight: 800; color: var(--text); margin: 0;">{{ \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d M, Y') }}</p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; padding: 10px 12px; background: #fef2f2; border-radius: 10px;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-flag-checkered" style="font-size: 12px;"></i>
                        </div>
                        <div>
                            <p style="font-size: 9px; color: var(--text-light); margin-bottom: 1px; text-transform: uppercase; font-weight: 700;">Límite</p>
                            <p style="font-size: 12px; font-weight: 800; color: #ef4444; margin: 0;">{{ \Carbon\Carbon::parse($proyecto->fecha_finalizacion)->format('d M, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Ubicación -->
            @if($proyecto->latitud && $proyecto->longitud)
            <div class="glass-card" style="padding: 20px;">
                <h4 style="font-size: 12px; font-weight: 800; color: var(--text); margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <div style="width: 26px; height: 26px; border-radius: 7px; background: rgba(239,68,68,0.1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-map-marker-alt" style="color: #ef4444; font-size: 12px;"></i>
                    </div>
                    Ubicación
                </h4>
                <div style="border-radius: 8px; overflow: hidden; border: 1px solid var(--border);">
                    <div id="ubicacion-map" style="width: 100%; height: 160px;"></div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if($proyecto->latitud && $proyecto->longitud)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@vite(['resources/js/maps.js'])
<script>
document.addEventListener('DOMContentLoaded', function() {
    initViewMap('ubicacion-map', {{ $proyecto->latitud }}, {{ $proyecto->longitud }}, '{{ $proyecto->nombre }}');
});
</script>
@endif
@endsection
