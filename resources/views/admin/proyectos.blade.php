@extends('layouts.dashboard')

@section('title', 'Gestión Global de Proyectos')
@section('page-title', 'Centro de Control de Proyectos')

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

@section('content')
    <div style="margin-bottom: 40px; animation: fadeIn 0.8s ease-out;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
            <div>
                <h2 style="font-size:32px; font-weight:800; letter-spacing: -1px; color: var(--text);">Control Central de <span style="color: var(--primary);">Proyectos</span></h2>
                <p style="color:var(--text-light); font-size:16px; margin-top:6px;">Monitoreo global y asignación estratégica de instructores.</p>
            </div>
        </div>

        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(420px, 1fr)); gap:28px;">
            @forelse($proyectos as $p)
            <div class="glass-card" style="display:flex; flex-direction:column; padding:0; overflow:hidden; border-radius: var(--radius); transition: transform 0.3s ease;">
                {{-- Header Decorativo --}}
                <div style="height:120px; background: linear-gradient(135deg, var(--secondary) 0%, #1e293b 100%); position:relative; overflow:hidden; display:flex; align-items:center; padding:0 28px;">
                    <div style="position:relative; z-index:1;">
                        <div style="display: flex; gap: 8px; margin-bottom: 10px;">
                            @php
                                $statusStyles = match($p->pro_estado) {
                                    'Activo' => ['bg' => '#d1fae5', 'color' => '#065f46', 'icon' => 'fa-check-circle'],
                                    'Pendiente' => ['bg' => '#fef3c7', 'color' => '#92400e', 'icon' => 'fa-clock'],
                                    'Rechazado' => ['bg' => '#fee2e2', 'color' => '#991b1b', 'icon' => 'fa-times-circle'],
                                    default => ['bg' => '#f1f5f9', 'color' => '#475569', 'icon' => 'fa-info-circle']
                                };
                            @endphp
                            <span style="background: {{ $statusStyles['bg'] }}; color: {{ $statusStyles['color'] }}; padding: 6px 14px; border-radius: 30px; font-size: 11px; font-weight: 800; text-transform: uppercase; display: flex; align-items: center; gap: 6px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                                <i class="fas {{ $statusStyles['icon'] }}"></i>
                                {{ $p->pro_estado }}
                            </span>
                        </div>
                        <h3 style="color:#fff; font-size:20px; font-weight:800; line-height:1.2; letter-spacing: -0.5px;">{{ Str::limit($p->pro_titulo_proyecto, 45) }}</h3>
                    </div>
                    <i class="fas fa-rocket" style="position:absolute; right:-20px; bottom:-20px; font-size:120px; color:rgba(255,255,255,0.03); transform: rotate(-15deg);"></i>
                </div>

                <div style="padding:28px; flex:1; display:flex; flex-direction:column; gap:20px;">
                    <div style="display:flex; align-items:center; gap:16px;">
                        <div style="width:48px; height:48px; background:var(--bg); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; border: 1px solid var(--border);">
                            <i class="fas fa-building" style="color:var(--primary); font-size: 1.2rem;"></i>
                        </div>
                        <div>
                            <span style="display:block; font-size:11px; font-weight:800; color:var(--text-lighter); text-transform:uppercase; letter-spacing: 1px;">Empresa Proponente</span>
                            <span style="font-size:16px; font-weight:700; color: var(--text);">{{ $p->emp_nombre }}</span>
                        </div>
                    </div>

                    <div style="padding:20px; background:rgba(248, 250, 252, 0.5); border-radius:16px; border:1px solid #f1f5f9;">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                            <span style="font-size:12px; font-weight:700; color:var(--text-light);"><i class="fas fa-user-shield" style="margin-right:6px; color:var(--primary);"></i> Mentor Asignado</span>
                            @if($p->ins_nombre)
                                <span style="font-size:11px; font-weight:800; color:var(--primary); background: var(--primary-soft); padding: 4px 12px; border-radius: 20px;">{{ $p->ins_nombre }}</span>
                            @else
                                <span style="font-size:11px; font-weight:800; color:#f97316; background: #fff7ed; padding: 4px 12px; border-radius: 20px;">SIN ASIGNAR</span>
                            @endif
                        </div>

                        <form action="{{ route('admin.proyectos.asignar', $p->pro_id) }}" method="POST">
                            @csrf
                            <div style="display:flex; gap:10px;">
                                <select name="ins_usr_documento" style="font-size:14px; flex:1; padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; color: var(--text); font-weight: 600;" required>
                                    <option value="" disabled selected>Seleccionar Instructor...</option>
                                    @foreach($instructores as $ins)
                                        <option value="{{ $ins->usuario->usr_documento ?? '' }}" {{ $p->ins_usr_documento == ($ins->usuario->usr_documento ?? '') ? 'selected' : '' }}>
                                            {{ $ins->ins_nombre }} {{ $ins->ins_apellido }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn-premium" style="padding: 12px; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; background: white; color: var(--primary); border: 2px solid var(--primary-soft); box-shadow: none;" title="Actualizar Asignación">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div style="margin-top:auto; display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                        <a href="{{ route('admin.proyectos.revisar', $p->pro_id) }}" class="btn-premium" style="justify-content:center; padding: 12px; background: white; color: var(--text); border: 1px solid #e2e8f0; font-size: 13px; box-shadow: none;">
                            <i class="fas fa-magnifying-glass" style="color: var(--primary);"></i> Revisión
                        </a>

                        @if($p->pro_estado == 'Activo')
                        <form action="{{ route('admin.proyectos.estado', $p->pro_id) }}" method="POST" style="width: 100%;">
                            @csrf
                            <input type="hidden" name="estado" value="Inactivo">
                            <button type="submit" class="btn-premium" style="width:100%; justify-content:center; background:#fee2e2; color: #991b1b; box-shadow: none; font-size: 13px;">
                                <i class="fas fa-ban"></i> Inactivar
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="glass-card" style="grid-column: 1 / -1; text-align:center; padding: 100px 40px;">
                <div style="width: 80px; height: 80px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: #cbd5e1;">
                    <i class="fas fa-folder-open" style="font-size:32px;"></i>
                </div>
                <h3 style="font-size:20px; font-weight:800; color:var(--text); margin-bottom: 8px;">No hay registros</h3>
                <p style="color: var(--text-light); font-size:15px;">Aún no se han recibido propuestas de proyectos en la plataforma.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection