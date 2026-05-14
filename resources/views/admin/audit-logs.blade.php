@extends('layouts.dashboard')

@section('title', 'Historial del Sistema')
@section('page-title', 'Historial de Actividades')

@section('styles')
    @vite(['resources/css/admin.css'])
@endsection

@section('sidebar-nav')
    @include('admin.partials.sidebar-nav')
@endsection

@section('content')
<div class="animate-fade-in">
    <div class="admin-header-master">
        <div class="admin-header-icon">
            <i class="fas fa-history"></i>
        </div>
        <div style="position: relative; z-index: 1;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                <span class="admin-badge-hub">Sistema de Auditoría</span>
                <span style="color: rgba(255,255,255,0.6); font-size: 14px; font-weight: 600;"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <h1 class="admin-header-title">Historial de <span style="color: var(--primary);">Actividades</span></h1>
            <p style="color: rgba(255,255,255,0.5); font-size: 18px; max-width: 600px; line-height: 1.6; margin: 0;">Registro cronológico y detallado de todas las operaciones administrativas realizadas en la plataforma.</p>
        </div>
    </div>
</div><div class="admin-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 40px;">
    <!-- Card 1: Última Acción Crítica -->
    @php $lastLog = $stats['recent_logs'][0] ?? null; @endphp
    <div class="stat-card-premium" style="background: white; border-left: 5px solid #10b981; min-height: 160px; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                <span style="font-size: 10px; font-weight: 900; color: #10b981; text-transform: uppercase; letter-spacing: 1px;">Última Acción Crítica</span>
                <span style="font-size: 10px; font-weight: 700; color: #94a3b8;">{{ $lastLog ? $lastLog->created_at->diffForHumans() : 'N/A' }}</span>
            </div>
            @if($lastLog)
                <h4 style="margin: 0; font-size: 14px; font-weight: 800; color: #1e293b; line-height: 1.4;">{{ Str::limit($lastLog->descripcion, 85) }}</h4>
            @else
                <p style="margin: 0; font-size: 13px; color: #94a3b8; font-style: italic;">Sin actividad reciente.</p>
            @endif
        </div>
        <div style="margin-top: 10px; display: flex; align-items: center; gap: 8px;">
            <div style="width: 24px; height: 24px; border-radius: 8px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 900;">
                <i class="fas fa-user-shield"></i>
            </div>
            <span style="font-size: 11px; font-weight: 700; color: #475569;">{{ $lastLog->usuario->nombre_rol ?? 'Sistema' }}</span>
        </div>
    </div>

    <!-- Card 2: Estado de Aprobaciones -->
    <div class="stat-card-premium" style="background: white; border-left: 5px solid #f59e0b; min-height: 160px; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <span style="font-size: 10px; font-weight: 900; color: #f59e0b; text-transform: uppercase; letter-spacing: 1px;">Pendientes de Revisión</span>
            <div style="margin-top: 15px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                <div>
                    <h3 style="margin: 0; font-size: 20px; font-weight: 950; color: #1e293b;">{{ $stats['pending_projects'] }}</h3>
                    <p style="margin: 2px 0 0 0; font-size: 9px; font-weight: 700; color: #64748b; text-transform: uppercase;">Proyectos</p>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 20px; font-weight: 950; color: #1e293b;">{{ $stats['pending_users'] }}</h3>
                    <p style="margin: 2px 0 0 0; font-size: 9px; font-weight: 700; color: #64748b; text-transform: uppercase;">Cuentas</p>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 20px; font-weight: 950; color: #1e293b;">{{ $stats['pending_postulations'] }}</h3>
                    <p style="margin: 2px 0 0 0; font-size: 9px; font-weight: 700; color: #64748b; text-transform: uppercase;">Postulac.</p>
                </div>
            </div>
        </div>
        <div style="margin-top: 10px; font-size: 10px; font-weight: 600; color: #94a3b8; display: flex; align-items: center; gap: 6px;">
            <i class="fas fa-exclamation-triangle" style="color: #f59e0b;"></i> Requiere atención inmediata
        </div>
    </div>

    <!-- Card 3: Módulo Dominante -->
    <div class="stat-card-premium" style="background: white; border-left: 5px solid #3b82f6; min-height: 160px; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <span style="font-size: 10px; font-weight: 900; color: #3b82f6; text-transform: uppercase; letter-spacing: 1px;">Módulo más Operativo</span>
            <div style="margin-top: 12px; display: flex; align-items: center; gap: 15px;">
                <div style="width: 42px; height: 42px; border-radius: 12px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                    <i class="fas fa-microchip"></i>
                </div>
                <div>
                    <h4 style="margin: 0; font-size: 15px; font-weight: 900; color: #1e293b; text-transform: capitalize;">{{ str_replace('_', ' ', $stats['most_active_module']) }}</h4>
                    <p style="margin: 2px 0 0 0; font-size: 11px; font-weight: 600; color: #64748b;">Alto flujo de logs</p>
                </div>
            </div>
        </div>
        <div style="margin-top: 10px; font-size: 11px; font-weight: 700; color: #3b82f6; background: #eff6ff; padding: 6px 12px; border-radius: 10px; display: inline-block; width: fit-content;">
            {{ $stats['most_active_user'] ? 'Líder: ' . $stats['most_active_user']->nombre_rol : 'Admin Destacado' }}
        </div>
    </div>

    <!-- Card 4: Resumen Operacional 24h -->
    <div class="stat-card-premium" style="background: linear-gradient(135deg, #064e3b 0%, #065f46 100%); color: white; border: none; box-shadow: 0 10px 25px -5px rgba(6, 78, 59, 0.4); min-height: 160px; display: flex; flex-direction: column; justify-content: space-between;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 10px; font-weight: 900; opacity: 0.8; text-transform: uppercase; letter-spacing: 1px;">Operaciones Hoy</span>
            <div style="width: 28px; height: 28px; background: rgba(255,255,255,0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                <i class="fas fa-bolt"></i>
            </div>
        </div>
        <div style="text-align: center; margin: 5px 0;">
            <h3 style="margin: 0; font-size: 32px; font-weight: 950; letter-spacing: -1px;">{{ $stats['total_24h'] }}</h3>
            <p style="margin: 0; font-size: 10px; font-weight: 800; opacity: 0.7; text-transform: uppercase;">Total Registrado</p>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 5px; font-size: 9px; font-weight: 900; text-align: center;">
            <div style="flex: 1; background: rgba(255,255,255,0.1); padding: 6px; border-radius: 8px;">{{ $stats['action_distribution']['crear'] }} <br> <span style="opacity: 0.6; font-size: 8px;">ALTAS</span></div>
            <div style="flex: 1; background: rgba(255,255,255,0.1); padding: 6px; border-radius: 8px;">{{ $stats['action_distribution']['editar'] }} <br> <span style="opacity: 0.6; font-size: 8px;">MODS</span></div>
            <div style="flex: 1; background: rgba(255,255,255,0.1); padding: 6px; border-radius: 8px;">{{ $stats['action_distribution']['eliminar'] }} <br> <span style="opacity: 0.6; font-size: 8px;">BAJAS</span></div>
        </div>
    </div>
</div>

<div class="admin-filter-section" style="border: 1px solid #e8f5e9; background: linear-gradient(to bottom, #ffffff, #fcfdfc); box-shadow: 0 12px 30px -10px rgba(46, 125, 70, 0.08); margin-bottom: 40px; border-radius: 28px;">
    <div style="padding: 20px 32px; border-bottom: 1px solid #f0f7f2; display: flex; align-items: center; gap: 12px;">
        <span style="width: 8px; height: 24px; background: var(--primary); border-radius: 4px;"></span>
        <h3 style="margin: 0; font-size: 15px; font-weight: 800; color: #064e3b; text-transform: uppercase; letter-spacing: 0.5px;">Buscador Inteligente de Logs</h3>
    </div>
    <form method="GET" action="{{ route('admin.historial') }}" style="padding: 32px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 28px;">
            <div class="admin-filter-group">
                <label class="admin-filter-label" style="color: #1a5c30; font-weight: 800;">Módulo o Área</label>
                <div class="admin-filter-input-wrap">
                    <select name="modulo" class="admin-filter-select" style="border-radius: 14px; border: 1.5px solid #e2e8f0; padding-left: 44px; height: 50px;">
                        <option value="">Todos los módulos</option>
                        @foreach($modulos ?? [] as $modulo)
                            <option value="{{ $modulo }}" {{ request('modulo') == $modulo ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $modulo)) }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-cubes" style="position: absolute; left: 16px; color: #2e7d46; opacity: 0.6;"></i>
                </div>
            </div>
            <div class="admin-filter-group">
                <label class="admin-filter-label" style="color: #1a5c30; font-weight: 800;">Tipo de Registro</label>
                <div class="admin-filter-input-wrap">
                    <select name="accion" class="admin-filter-select" style="border-radius: 14px; border: 1.5px solid #e2e8f0; padding-left: 44px; height: 50px;">
                        <option value="">Cualquier acción</option>
                        @foreach($acciones ?? [] as $accion)
                            <option value="{{ $accion }}" {{ request('accion') == $accion ? 'selected' : '' }}>{{ ucfirst($accion) }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-filter" style="position: absolute; left: 16px; color: #2e7d46; opacity: 0.6;"></i>
                </div>
            </div>
            <div class="admin-filter-group">
                <label class="admin-filter-label" style="color: #1a5c30; font-weight: 800;">Rango de Auditoría</label>
                <div style="display: flex; gap: 10px;">
                    <div style="position: relative; flex: 1;">
                        <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}" class="admin-filter-input" style="border-radius: 14px; border: 1.5px solid #e2e8f0; height: 50px; font-size: 13px;">
                    </div>
                    <div style="position: relative; flex: 1;">
                        <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}" class="admin-filter-input" style="border-radius: 14px; border: 1.5px solid #e2e8f0; height: 50px; font-size: 13px;">
                    </div>
                </div>
            </div>
        </div>
        <div style="display: flex; gap: 14px; margin-top: 32px; justify-content: flex-end;">
            @if(request()->anyFilled(['modulo', 'accion', 'fecha_inicio', 'fecha_fin']))
                <a href="{{ route('admin.historial') }}" class="admin-filter-footer-btn clear" style="height: 46px; display: flex; align-items: center; border-radius: 12px; padding: 0 24px; font-weight: 700;">
                    <i class="fas fa-rotate-left"></i> Limpiar
                </a>
            @endif
            <button type="submit" class="admin-filter-footer-btn apply" style="height: 46px; border-radius: 12px; padding: 0 32px; font-weight: 800; background: #2e7d46; box-shadow: 0 8px 20px -6px rgba(46, 125, 70, 0.4);">
                <i class="fas fa-search"></i> Consultar Historial
            </button>
        </div>
    </form>
</div>

<div class="glass-card" style="border-radius: 32px; border: 1px solid rgba(0,0,0,0.05); background: white; box-shadow: 0 30px 60px -20px rgba(0,0,0,0.05); overflow: hidden;">
    <div class="premium-table-container">
        <table class="premium-table" style="width: 100%; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr style="background: #f8fafc;">
                    <th style="padding: 24px 32px; border-bottom: 2px solid #edf2f7; color: #1e293b; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px;">Fecha y Hora</th>
                    <th style="padding: 24px 32px; border-bottom: 2px solid #edf2f7; color: #1e293b; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px;">Responsable</th>
                    <th style="padding: 24px 32px; border-bottom: 2px solid #edf2f7; color: #1e293b; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px;">Tipo de Acción</th>
                    <th style="padding: 24px 32px; border-bottom: 2px solid #edf2f7; color: #1e293b; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px;">Descripción Natural</th>
                    <th style="padding: 24px 32px; border-bottom: 2px solid #edf2f7; color: #1e293b; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; text-align: center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    @php
                        $actionMeta = match($log->accion) {
                            'crear' => ['color' => '#059669', 'bg' => '#ecfdf5', 'label' => 'Nuevo Registro', 'icon' => 'fa-plus'],
                            'editar', 'cambiar_estado' => ['color' => '#d97706', 'bg' => '#fffbeb', 'label' => 'Actualización', 'icon' => 'fa-pen'],
                            'eliminar' => ['color' => '#dc2626', 'bg' => '#fef2f2', 'label' => 'Eliminación', 'icon' => 'fa-trash-can'],
                            'login' => ['color' => '#2563eb', 'bg' => '#eff6ff', 'label' => 'Inicio Sesión', 'icon' => 'fa-right-to-bracket'],
                            'logout' => ['color' => '#475569', 'bg' => '#f8fafc', 'label' => 'Cierre Sesión', 'icon' => 'fa-right-from-bracket'],
                            'exportar' => ['color' => '#7c3aed', 'bg' => '#f5f3ff', 'label' => 'Exportación', 'icon' => 'fa-file-export'],
                            default => ['color' => '#64748b', 'bg' => '#f1f5f9', 'label' => ucfirst($log->accion), 'icon' => 'fa-circle-dot']
                        };
                        $hasChanges = !empty($log->datos_anteriores) || !empty($log->datos_nuevos);
                    @endphp
                    <tr style="transition: all 0.2s;" onmouseover="this.style.background='#fcfdfd'" onmouseout="this.style.background='white'">
                                <td style="padding: 28px 32px; border-bottom: 1px solid #f1f5f9;">
                                    <div style="display: flex; align-items: center; gap: 14px;">
                                        <div style="width: 38px; height: 38px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 14px;">
                                            <i class="far fa-clock"></i>
                                        </div>
                                        <div>
                                            <p style="margin: 0; font-weight: 800; font-size: 14px; color: #0f172a;">{{ $log->created_at->format('d/m/Y') }}</p>
                                            <span style="font-size: 11px; color: #94a3b8; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                                <span style="width: 4px; height: 4px; border-radius: 50%; background: #10b981;"></span>
                                                Hace {{ $log->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 28px 32px; border-bottom: 1px solid #f1f5f9;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 14px; background: #2e7d46; color: white; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 14px; box-shadow: 0 6px 12px -3px rgba(46, 125, 70, 0.3);">
                                            {{ strtoupper(substr($log->usuario->nombre_rol ?? 'S', 0, 1)) }}
                                        </div>
                                        <div style="min-width: 0;">
                                            <p style="margin: 0; font-weight: 800; font-size: 13px; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $log->usuario->nombre_rol ?? 'Sistema' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 28px 32px; border-bottom: 1px solid #f1f5f9;">
                                    <span style="background: {{ $actionMeta['bg'] }}; color: {{ $actionMeta['color'] }}; padding: 8px 14px; border-radius: 12px; font-size: 10px; font-weight: 900; display: inline-flex; align-items: center; gap: 8px; text-transform: uppercase; letter-spacing: 0.5px; border: 1px solid rgba(0,0,0,0.02);">
                                        <i class="fas {{ $actionMeta['icon'] }}" style="font-size: 12px;"></i>
                                        {{ $actionMeta['label'] }}
                                    </span>
                                </td>
                                <td style="padding: 28px 32px; border-bottom: 1px solid #f1f5f9;">
                                    <div style="display: flex; flex-direction: column; gap: 6px; max-width: 400px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span style="font-size: 9px; font-weight: 800; color: #2e7d46; background: #ecfdf5; padding: 2px 8px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px;">{{ str_replace('_', ' ', $log->modulo) }}</span>
                                        </div>
                                        <p style="margin: 0; font-size: 13.5px; color: #334155; line-height: 1.5; font-weight: 600;">
                                            {{ $log->descripcion }}
                                        </p>
                                    </div>
                                </td>
                                <td style="padding: 28px 32px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                    @if($hasChanges)
                                        <button onclick="verDetalles({{ $log->id }})" class="btn-premium" style="width: 46px; height: 46px; background: #ffffff; color: #2e7d46; border: 2px solid #f1f5f9; border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                                            <i class="fas fa-eye" style="font-size: 16px;"></i>
                                        </button>
                                        <div id="data-{{ $log->id }}" style="display: none;">
                                            {
                                                "anterior": @json($log->datos_anteriores),
                                                "nuevo": @json($log->datos_nuevos),
                                                "usuario": "{{ $log->usuario->nombre_rol ?? 'Sistema' }}",
                                                "fecha": "{{ $log->created_at->format('d/m/Y H:i:s') }}",
                                                "accion": "{{ $actionMeta['label'] }}",
                                                "modulo": "{{ ucfirst($log->modulo) }}",
                                                "registro_id": "{{ $log->registro_id }}"
                                            }
                                        </div>
                                    @else
                                        <div style="width: 46px; height: 46px; margin: 0 auto; display: flex; align-items: center; justify-content: center; color: #e2e8f0; font-size: 16px;">
                                            <i class="fas fa-circle-minus"></i>
                                        </div>
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 100px 32px;">
                                    <div style="width: 80px; height: 80px; background: #f1f5f9; color: #94a3b8; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 32px;">
                                        <i class="fas fa-ghost"></i>
                                    </div>
                                    <h4 style="margin: 0; font-size: 18px; font-weight: 900; color: #1e293b;">Sin registros encontrados</h4>
                                    <p style="margin: 8px 0 0 0; font-size: 14px; color: #64748b; font-weight: 600;">Ajusta los filtros para encontrar lo que buscas.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
            <div style="padding: 20px 28px; border-top: 1px solid var(--border); display: flex; justify-content: center;">
                {{ $logs->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Modal de Detalles -->
    <div id="modalDetalles" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 10000; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: white; width: 100%; max-width: 700px; border-radius: 20px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); display: flex; flex-direction: column; max-height: 90vh;">
            <div style="padding: 24px; background: linear-gradient(to right, #f8fafc, #fff); border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: #0f172a;" id="modalTitle">Detalles del Cambio</h3>
                    <p style="margin: 4px 0 0 0; font-size: 12px; color: #64748b;" id="modalSubtitle"></p>
                </div>
                <button onclick="cerrarModal()" style="width: 36px; height: 36px; border-radius: 10px; border: none; background: #f1f5f9; color: #64748b; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="modalContent" style="padding: 24px; overflow-y: auto; flex-grow: 1;">
                <!-- El contenido se cargará dinámicamente -->
            </div>
            <div style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
                <button onclick="cerrarModal()" class="btn-premium" style="padding: 10px 24px; background: var(--primary); color: white; border: none; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer;">Entendido</button>
            </div>
        </div>
    </div>

    <script>
        const fieldMapper = {
            'usr_correo': 'Correo Electrónico',
            'usr_nombre': 'Nombre Personal',
            'usr_apellido': 'Apellidos',
            'usr_rol': 'Perfil del Usuario',
            'usr_estado': 'Estado de Cuenta',
            'prj_nombre': 'Título del Proyecto',
            'prj_descripcion': 'Descripción Detallada',
            'prj_estado': 'Estado de Aprobación',
            'emp_nombre': 'Razón Social',
            'emp_nit': 'Identificación NIT',
            'password': 'Clave de Seguridad',
            'remember_token': 'Token de Sesión',
            'created_at': 'Fecha de Registro',
            'updated_at': 'Última Modificación',
            'email_verified_at': 'Verificación de Email',
            'activo': 'Estado Operativo',
            'rol_id': 'Tipo de Acceso',
            'instructor_usuario_id': 'Instructor Responsable',
            'aprendiz_id': 'Aprendiz Vinculado',
            'numero_documento': 'Documento de Identidad',
            'nombres': 'Nombres Reales',
            'apellidos': 'Apellidos Reales',
            'especialidad': 'Área de Especialidad',
            'telefono': 'Número de Contacto',
            'empresa_nit': 'NIT de Empresa'
        };

        function translateField(field) {
            return fieldMapper[field] || field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        }

        function formatValue(key, val) {
            if (val === null || val === undefined) return '<span style="opacity: 0.5; font-style: italic;">Sin asignar</span>';
            
            // Lógica natural para estados
            if (['usr_estado', 'activo', 'estado', 'prj_estado', 'calidad_aprobada'].includes(key)) {
                if (val == 1 || val === '1' || val === true || val === 'aprobado') 
                    return '<span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 11px; text-transform: uppercase; border: 1px solid #bbf7d0;">Habilitado / Aprobado</span>';
                if (val == 0 || val === '0' || val === false || val === 'rechazado' || val === 'cerrado') 
                    return '<span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 6px; font-weight: 800; font-size: 11px; text-transform: uppercase; border: 1px solid #fecaca;">Inactivo / No Aprobado</span>';
            }

            if (key === 'rol_id') {
                const roles = {1: 'Aprendiz', 2: 'Instructor', 3: 'Empresa', 4: 'Administrador'};
                return roles[val] || val;
            }

            if (typeof val === 'boolean') return val ? 'Sí' : 'No';
            if (typeof val === 'object') return '<pre style="margin:0; font-size:11px; background: #f8fafc; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0;">' + JSON.stringify(val, null, 2) + '</pre>';
            
            if (key === 'password') return '•••••••• (Protegida por seguridad)';
            
            return val;
        }

        function verDetalles(id) {
            const dataRaw = document.getElementById('data-' + id).textContent;
            const data = JSON.parse(dataRaw);
            
            document.getElementById('modalSubtitle').textContent = `Acción por ${data.usuario} • ${data.fecha}`;
            
            let html = '<div style="display: grid; gap: 24px;">';
            
            const anterior = data.anterior || {};
            const nuevo = data.nuevo || {};
            const keys = [...new Set([...Object.keys(anterior), ...Object.keys(nuevo)])];
            
            const changedKeys = keys.filter(key => JSON.stringify(anterior[key]) !== JSON.stringify(nuevo[key]));

            if (changedKeys.length > 0) {
                html += `
                    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #bbf7d0; padding: 24px; border-radius: 20px; display: flex; align-items: flex-start; gap: 20px; box-shadow: 0 4px 15px -5px rgba(34, 197, 94, 0.1);">
                        <div style="width: 48px; height: 48px; background: #22c55e; color: white; border-radius: 14px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 10px 20px -5px rgba(34, 197, 94, 0.4); font-size: 20px;">
                            <i class="fas fa-microscope"></i>
                        </div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 8px;">
                                <span style="background: #064e3b; color: white; padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">${data.modulo}</span>
                                ${data.nuevos && data.nuevos.nombre_objetivo ? 
                                    `<span style="background: #f0fdf4; color: #166534; border: 1.5px solid #bbf7d0; padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 900; box-shadow: 0 2px 4px rgba(0,0,0,0.05);"><i class="fas fa-bullseye" style="margin-right: 4px;"></i>${data.nuevos.nombre_objetivo}</span>` : 
                                    `<span style="background: #f8fafc; color: #64748b; border: 1.5px solid #e2e8f0; padding: 4px 10px; border-radius: 8px; font-size: 10px; font-weight: 800;">ID: #${data.registro_id}</span>`
                                }
                                <h5 style="margin: 0; font-size: 18px; font-weight: 900; color: #064e3b; margin-left: auto;">Análisis de Actividad</h5>
                            </div>
                            <p style="margin: 0; font-size: 13.5px; color: #166534; font-weight: 600; line-height: 1.6;">
                                Se han identificado <strong>${changedKeys.length}</strong> cambios detallados en el módulo de <strong>${data.modulo}</strong>. 
                                <span style="display: block; margin-top: 4px; font-size: 12px; opacity: 0.8; font-weight: 500;">Esta auditoría garantiza la integridad de la operación realizada.</span>
                            </p>
                        </div>
                    </div>
                `;

                changedKeys.forEach(key => {
                    const valAnt = anterior[key];
                    const valNue = nuevo[key];
                    
                    html += `
                        <div style="border: 1.5px solid #f1f5f9; border-radius: 24px; overflow: hidden; background: white; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.02);">
                            <div style="padding: 16px 28px; background: #f8fafc; border-bottom: 1.5px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span style="width: 6px; height: 6px; background: #10b981; border-radius: 50%;"></span>
                                    <span style="font-weight: 900; font-size: 13px; color: #0f172a; text-transform: uppercase; letter-spacing: 1.5px;">
                                        ${translateField(key)}
                                    </span>
                                </div>
                                <span style="font-size: 10px; background: #ffffff; border: 1px solid #e2e8f0; padding: 5px 12px; border-radius: 10px; color: #64748b; font-weight: 800; font-family: monospace;">${key}</span>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0;">
                                <div style="padding: 24px 28px; border-right: 1.5px solid #f1f5f9; background: #fff;">
                                    <div style="font-size: 10px; font-weight: 900; color: #94a3b8; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1.2px; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-history" style="font-size: 12px;"></i> Estado Previo
                                    </div>
                                    <div style="color: #64748b; font-size: 14.5px; line-height: 1.6; font-weight: 600; padding: 12px; background: #f8fafc; border-radius: 12px; border: 1px dashed #e2e8f0;">
                                        ${formatValue(key, valAnt)}
                                    </div>
                                </div>
                                <div style="padding: 24px 28px; background: rgba(16, 185, 129, 0.03);">
                                    <div style="font-size: 10px; font-weight: 900; color: #10b981; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1.2px; display: flex; align-items: center; gap: 8px;">
                                        <i class="fas fa-arrow-right" style="font-size: 12px;"></i> Nuevo Estado
                                    </div>
                                    <div style="color: #064e3b; font-size: 15px; line-height: 1.6; font-weight: 800; padding: 12px; background: rgba(16, 185, 129, 0.08); border-radius: 12px; border: 1px solid rgba(16, 185, 129, 0.2); box-shadow: 0 4px 12px rgba(16, 185, 129, 0.05);">
                                        ${formatValue(key, valNue)}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            } else {
                html += `
                    <div style="text-align: center; padding: 100px 40px; background: #fcfdfd; border-radius: 32px; border: 2px dashed #f1f5f9;">
                        <div style="width: 100px; height: 100px; background: #ffffff; color: #cbd5e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 32px; font-size: 40px; box-shadow: 0 15px 30px -10px rgba(0,0,0,0.05);">
                            <i class="fas fa-fingerprint"></i>
                        </div>
                        <h4 style="margin: 0 0 12px 0; font-size: 22px; font-weight: 950; color: #1e293b;">Sin cambios atómicos</h4>
                        <p style="margin: 0; font-size: 16px; color: #64748b; line-height: 1.8; font-weight: 500; max-width: 400px; margin: 0 auto;">La operación de <strong>${data.accion}</strong> se registró exitosamente como un evento de sistema sin mutación de campos específicos.</p>
                    </div>
                `;
            }
            
            html += '</div>';
            
            document.getElementById('modalContent').innerHTML = html;
            document.getElementById('modalDetalles').style.display = 'flex';
        }
            
        function cerrarModal() {
            document.getElementById('modalDetalles').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('modalDetalles');
            if (event.target == modal) cerrarModal();
        }
    </script>
@endsection

