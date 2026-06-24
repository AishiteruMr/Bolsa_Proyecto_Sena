@extends('layouts.dashboard')

@section('title', 'Gestión de Usuarios')
@section('page-title', 'Administración de Cuentas')

@section('sidebar-nav')
    @include('admin.partials.sidebar-nav')
@endsection

@section('styles')
    @vite(['resources/css/admin.css'])
@endsection

@php $breadcrumbs = [['label' => 'Inicio', 'url' => route('admin.dashboard')], ['label' => 'Usuarios']]; @endphp
@section('content')
    <div class="animate-fade-in" style="margin-bottom: 40px;">
        <div class="admin-header-master">
            <div class="admin-header-icon"><i class="fas fa-users"></i></div>
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <span class="admin-badge-hub">Admin Control Hub</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 700;"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <h1 class="admin-header-title">Gestión de <span style="color: var(--primary);">Usuarios</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 18px; max-width: 720px; font-weight: 500;">Administra y supervisa los perfiles de aprendices e instructores desde un panel centralizado.</p>
            </div>
        </div>

        {{-- KPI STAT CARDS --}}
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-top: 24px;">
            <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #db2777;">
                <div class="admin-stat-icon" style="background: #fdf2f8; color: #db2777; width: 44px; height: 44px;"><i class="fas fa-graduation-cap"></i></div>
                <div><div class="admin-stat-label">Total Aprendices</div><div class="admin-stat-value" style="color: #db2777;">{{ $totalAprendices }}</div></div>
            </div>
            <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #6366f1;">
                <div class="admin-stat-icon" style="background: #eef2ff; color: #6366f1; width: 44px; height: 44px;"><i class="fas fa-chalkboard-teacher"></i></div>
                <div><div class="admin-stat-label">Total Instructores</div><div class="admin-stat-value" style="color: #6366f1;">{{ $totalInstructores }}</div></div>
            </div>
            <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #10b981;">
                <div class="admin-stat-icon" style="background: #f0fdf4; color: #10b981; width: 44px; height: 44px;"><i class="fas fa-user-check"></i></div>
                <div><div class="admin-stat-label">Aprendices Activos</div><div class="admin-stat-value" style="color: #10b981;">{{ $aprendicesActivos }}</div></div>
            </div>
            <div class="glass-card" style="padding: 20px; display: flex; align-items: center; gap: 16px; border-left: 4px solid #f59e0b;">
                <div class="admin-stat-icon" style="background: #fef3c7; color: #f59e0b; width: 44px; height: 44px;"><i class="fas fa-user-cog"></i></div>
                <div><div class="admin-stat-label">Instructores Activos</div><div class="admin-stat-value" style="color: #f59e0b;">{{ $instructoresActivos }}</div></div>
            </div>
        </div>

        {{-- PROGRAMS BAR CHART --}}
        @if($aprendicesProgramas->count() > 0)
        <div class="glass-card" style="padding: 20px; background: white; margin-top: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h3 style="font-size: 0.95rem; font-weight: 800; color: var(--text);">
                    <i class="fas fa-chart-bar" style="color: #db2777; margin-right: 8px;"></i>
                    Top Programas de Formación
                </h3>
            </div>
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @php $maxProg = $aprendicesProgramas->max('total'); @endphp
                @foreach($aprendicesProgramas as $prog)
                <div>
                    <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 600; margin-bottom: 4px;">
                        <span style="color: var(--text);">{{ $prog->programa_formacion }}</span>
                        <span style="color: #db2777;">{{ $prog->total }}</span>
                    </div>
                    <div style="height: 8px; background: #f1f5f9; border-radius: 4px; overflow: hidden;">
                        <div style="height: 100%; width: {{ $maxProg > 0 ? ($prog->total / $maxProg) * 100 : 0 }}%; background: linear-gradient(90deg, #db2777, #f472b6); border-radius: 4px; transition: width 0.6s ease;"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="users-tab-container" style="display:flex; flex-wrap: wrap; gap:12px; margin:24px 0; position: relative; z-index: 10;">
            <button id="btn-aprendices" onclick="mostrarTabla('aprendices')" class="user-tab-btn active-tab" style="display:flex;align-items:center;justify-content:center;flex:1;min-width:200px;gap:10px;padding:14px 28px;border:none;border-radius:14px;background:linear-gradient(135deg,#2e7d46,#1a5c30);color:white;font-weight:700;font-size:14px;cursor:pointer;box-shadow:0 6px 20px rgba(46,125,70,0.4);transition:all 0.3s; z-index: 11;">
                <i class="fas fa-user-graduate"></i> Aprendices
                <span style="background:rgba(255,255,255,0.25);padding:2px 10px;border-radius:20px;font-size:12px;">{{ $aprendices->count() }}</span>
            </button>
            <button id="btn-instructores" onclick="mostrarTabla('instructores')" class="user-tab-btn" style="display:flex;align-items:center;justify-content:center;flex:1;min-width:200px;gap:10px;padding:14px 28px;border:2px solid #2e7d46;color:#2e7d46;border-radius:14px;background:transparent;font-weight:700;font-size:14px;cursor:pointer;transition:all 0.3s; z-index: 11;">
                <i class="fas fa-chalkboard-teacher"></i> Instructores
                <span style="background:#2e7d46;color:white;padding:2px 10px;border-radius:20px;font-size:12px;">{{ $instructores->count() }}</span>
            </button>
        </div>

        <div id="tabla-aprendices" style="display:block;">
            <div class="glass-card" style="background:white;border-radius:20px;box-shadow:0 8px 30px rgba(46,125,70,0.12);overflow:hidden;border:1px solid rgba(46,125,70,0.1); padding:0;">
                <div class="admin-table-header" style="padding: 24px 28px; border-bottom: 1px solid rgba(46,125,70,0.1);">
                    <h3 style="margin:0;font-size:18px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:12px;">
                        <span class="admin-stat-icon" style="width:36px;height:36px;background:var(--primary-soft);color:var(--primary);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;">
                            <i class="fas fa-graduation-cap"></i>
                        </span>
                        Comunidad de Aprendices
                    </h3>
                </div>
                <div class="premium-table-container" style="border-radius: 0; border: none; box-shadow: none;">
                    <table class="premium-table" style="width:100%;border-collapse:collapse; min-width: 600px;">
                        <thead>
                            <tr style="background:#f0f5f2;">
                                <th style="text-align:left;padding:16px 20px;color:#1a5c30;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #2e7d46;">Documento</th>
                                <th style="text-align:left;padding:16px 20px;color:#1a5c30;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #2e7d46;">Nombre Completo</th>
                                <th style="text-align:left;padding:16px 20px;color:#1a5c30;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #2e7d46;">Programa</th>
                                <th style="text-align:left;padding:16px 20px;color:#1a5c30;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #2e7d46;">Correo</th>
                                <th style="text-align:left;padding:16px 20px;color:#1a5c30;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #2e7d46;">Estado</th>
                                <th style="text-align:right;padding:16px 20px;color:#1a5c30;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #2e7d46;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aprendices as $a)
                            <tr style="transition:background 0.2s;" onmouseover="this.style.background='#f0f5f2'" onmouseout="this.style.background='white'">
                                <td style="padding:18px 20px;font-weight:700;color:#0a3d2a;border-bottom:1px solid #e8f5e9;">{{ $a->usuario->numero_documento ?? '-' }}</td>
                                <td style="padding:18px 20px;border-bottom:1px solid #e8f5e9;">
                                    <div style="display:flex;align-items:center;gap:12px;">
                                        <div class="user-avatar-mini" style="width:38px;height:38px;background:linear-gradient(135deg,#2e7d46,#4caf50);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:800;color:white;font-size:13px;flex-shrink:0;">{{ strtoupper(substr($a->nombres,0,1)) }}</div>
                                        <span style="font-weight:600;color:#0a3d2a;">{{ $a->nombres }} {{ $a->apellidos }}</span>
                                    </div>
                                </td>
                                <td style="padding:18px 20px;border-bottom:1px solid #e8f5e9;">
                                    <span style="background:#e8f5e9;color:#1a5c30;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:700;border:1px solid #a5d6a7;">{{ $a->programa_formacion }}</span>
                                </td>
                                <td style="padding:18px 20px;color:#1a5c30;font-size:13px;border-bottom:1px solid #e8f5e9;">{{ $a->usuario->correo ?? '-' }}</td>
                                <td style="padding:18px 20px;border-bottom:1px solid #e8f5e9;">
                                    <span class="estado-badge" style="display:inline-flex;align-items:center;gap:6px;background:{{ $a->activo == 1 ? '#e8f5e9' : '#ffebee' }};color:{{ $a->activo == 1 ? '#1a5c30' : '#c62828' }};padding:6px 14px;border-radius:20px;font-size:11px;font-weight:700;border:1px solid {{ $a->activo == 1 ? '#a5d6a7' : '#ef9a9a' }};">
                                        <span class="estado-dot" style="width:6px;height:6px;border-radius:50%;background:{{ $a->activo == 1 ? '#2e7d46' : '#e53935' }};"></span>
                                        {{ $a->activo == 1 ? 'aprobado' : 'cerrado' }}
                                    </span>
                                </td>
                                <td class="acciones-cell" style="padding:18px 20px;text-align:right;border-bottom:1px solid #e8f5e9;">
                                    <button type="button" class="btn-estado-usuario-ajax" data-id="{{ $a->id }}" data-tipo="aprendiz" data-activo="{{ $a->activo }}" style="display:inline-flex;align-items:center;gap:6px;padding:10px 18px;border:{{ $a->activo == 1 ? '2px solid #2e7d46' : 'none' }};background:{{ $a->activo == 1 ? 'transparent' : '#2e7d46' }};color:{{ $a->activo == 1 ? '#2e7d46' : 'white' }};border-radius:10px;font-size:12px;font-weight:700;cursor:pointer;">
                                        <i class="fas {{ $a->activo == 1 ? 'fa-user-minus' : 'fa-user-check' }}"></i>
                                        {{ $a->activo == 1 ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" style="padding:60px;text-align:center;"><div style="color:#2e7d46;"><i class="fas fa-user-graduate" style="font-size:48px;margin-bottom:16px;display:block;opacity:0.3;"></i><h4 style="font-size:1.2rem;font-weight:800;margin-bottom:8px;color:#1a5c30;">No hay aprendices registrados</h4><p style="color:#64748b;font-size:14px;">Los aprendices aparecerán aquí cuando se registren en la plataforma.</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="tabla-instructores" style="display:none;">
            <div class="glass-card" style="background:white;border-radius:20px;box-shadow:0 8px 30px rgba(46,125,70,0.12);overflow:hidden;border:1px solid rgba(46,125,70,0.1); padding:0;">
                <div class="admin-table-header" style="padding: 24px 28px; border-bottom: 1px solid rgba(46,125,70,0.1);">
                    <h3 style="margin:0;font-size:18px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:12px;">
                        <span class="admin-stat-icon" style="width:36px;height:36px;background:var(--primary-soft);color:var(--primary);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:16px;">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </span>
                        Cuerpo de Instructores
                    </h3>
                </div>
                <div class="premium-table-container" style="border-radius: 0; border: none; box-shadow: none;">
                    <table class="premium-table" style="width:100%;border-collapse:collapse; min-width: 600px;">
                        <thead>
                            <tr style="background:#f0f5f2;">
                                <th style="text-align:left;padding:16px 20px;color:#1a5c30;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #2e7d46;">Documento</th>
                                <th style="text-align:left;padding:16px 20px;color:#1a5c30;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #2e7d46;">Nombre Completo</th>
                                <th style="text-align:left;padding:16px 20px;color:#1a5c30;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #2e7d46;">Especialidad</th>
                                <th style="text-align:left;padding:16px 20px;color:#1a5c30;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #2e7d46;">Correo</th>
                                <th style="text-align:left;padding:16px 20px;color:#1a5c30;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #2e7d46;">Estado</th>
                                <th style="text-align:right;padding:16px 20px;color:#1a5c30;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border-bottom:2px solid #2e7d46;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($instructores as $i)
                            <tr style="transition:background 0.2s;" onmouseover="this.style.background='#f0f5f2'" onmouseout="this.style.background='white'">
                                <td style="padding:18px 20px;font-weight:700;color:#0a3d2a;border-bottom:1px solid #e8f5e9;">{{ $i->usuario->numero_documento ?? '-' }}</td>
                                <td style="padding:18px 20px;border-bottom:1px solid #e8f5e9;">
                                    <div style="display:flex;align-items:center;gap:12px;">
                                        <div class="user-avatar-mini" style="width:38px;height:38px;background:linear-gradient(135deg,#2e7d46,#4caf50);border-radius:10px;display:flex;align-items:center;justify-content:center;font-weight:800;color:white;font-size:13px;flex-shrink:0;">{{ strtoupper(substr($i->nombres,0,1)) }}</div>
                                        <span style="font-weight:600;color:#0a3d2a;">{{ $i->nombres }} {{ $i->apellidos }}</span>
                                    </div>
                                </td>
                                <td style="padding:18px 20px;border-bottom:1px solid #e8f5e9;">
                                    <span style="background:#e8f5e9;color:#1a5c30;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:700;border:1px solid #a5d6a7;">{{ $i->especialidad }}</span>
                                </td>
                                <td style="padding:18px 20px;color:#1a5c30;font-size:13px;border-bottom:1px solid #e8f5e9;">{{ $i->usuario->correo ?? '-' }}</td>
                                <td style="padding:18px 20px;border-bottom:1px solid #e8f5e9;">
                                    <span class="estado-badge" style="display:inline-flex;align-items:center;gap:6px;background:{{ $i->activo == 1 ? '#e8f5e9' : '#ffebee' }};color:{{ $i->activo == 1 ? '#1a5c30' : '#c62828' }};padding:6px 14px;border-radius:20px;font-size:11px;font-weight:700;border:1px solid {{ $i->activo == 1 ? '#a5d6a7' : '#ef9a9a' }};">
                                        <span class="estado-dot" style="width:6px;height:6px;border-radius:50%;background:{{ $i->activo == 1 ? '#2e7d46' : '#e53935' }};"></span>
                                        {{ $i->activo == 1 ? 'aprobado' : 'cerrado' }}
                                    </span>
                                </td>
                                <td class="acciones-cell" style="padding:18px 20px;text-align:right;border-bottom:1px solid #e8f5e9;">
                                    <button type="button" class="btn-estado-usuario-ajax" data-id="{{ $i->id }}" data-tipo="instructor" data-activo="{{ $i->activo }}" style="display:inline-flex;align-items:center;gap:6px;padding:10px 18px;border:{{ $i->activo == 1 ? '2px solid #2e7d46' : 'none' }};background:{{ $i->activo == 1 ? 'transparent' : '#2e7d46' }};color:{{ $i->activo == 1 ? '#2e7d46' : 'white' }};border-radius:10px;font-size:12px;font-weight:700;cursor:pointer;">
                                        <i class="fas {{ $i->activo == 1 ? 'fa-user-minus' : 'fa-user-check' }}"></i>
                                        {{ $i->activo == 1 ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" style="padding:60px;text-align:center;"><div style="color:#2e7d46;"><i class="fas fa-chalkboard-teacher" style="font-size:48px;margin-bottom:16px;display:block;opacity:0.3;"></i><h4 style="font-size:1.2rem;font-weight:800;margin-bottom:8px;color:#1a5c30;">No hay instructores registrados</h4><p style="color:#64748b;font-size:14px;">Los instructores aparecerán aquí cuando se registren en la plataforma.</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
function mostrarTabla(tab) {
    const tablaA = document.getElementById('tabla-aprendices');
    const tablaI = document.getElementById('tabla-instructores');
    const btnA = document.getElementById('btn-aprendices');
    const btnI = document.getElementById('btn-instructores');

    if (!tablaA || !tablaI || !btnA || !btnI) return;

    tablaA.style.display = (tab === 'aprendices') ? 'block' : 'none';
    tablaI.style.display = (tab === 'instructores') ? 'block' : 'none';
    
    if (tab === 'aprendices') {
        btnA.style.background = 'linear-gradient(135deg,#2e7d46,#1a5c30)';
        btnA.style.color = 'white';
        btnA.style.boxShadow = '0 6px 20px rgba(46,125,70,0.4)';
        btnA.style.border = 'none';
        const spanA = btnA.querySelector('span');
        if (spanA) spanA.style.background = 'rgba(255,255,255,0.25)';
        
        btnI.style.background = 'transparent';
        btnI.style.color = '#2e7d46';
        btnI.style.border = '2px solid #2e7d46';
        btnI.style.boxShadow = 'none';
        const spanI = btnI.querySelector('span');
        if (spanI) {
            spanI.style.background = '#2e7d46';
            spanI.style.color = 'white';
        }
    } else {
        btnI.style.background = 'linear-gradient(135deg,#2e7d46,#1a5c30)';
        btnI.style.color = 'white';
        btnI.style.boxShadow = '0 6px 20px rgba(46,125,70,0.4)';
        btnI.style.border = 'none';
        const spanI = btnI.querySelector('span');
        if (spanI) spanI.style.background = 'rgba(255,255,255,0.25)';
        
        btnA.style.background = 'transparent';
        btnA.style.color = '#2e7d46';
        btnA.style.border = '2px solid #2e7d46';
        btnA.style.boxShadow = 'none';
        const spanA = btnA.querySelector('span');
        if (spanA) {
            spanA.style.background = '#2e7d46';
            spanA.style.color = 'white';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-estado-usuario-ajax').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const tipo = this.dataset.tipo;
            const activo = parseInt(this.dataset.activo);
            const nuevoEstado = activo === 1 ? 0 : 1;
            const label = activo === 1 ? 'Desactivar' : 'Activar';

            ajax.confirm('¿Estás seguro de ' + label.toLowerCase() + ' este usuario?').then(confirmed => {
                if (!confirmed) return;

                ajax.disableButton(this, label + '...');
                const url = '{{ route('admin.usuarios.estado', ['id' => '__ID__']) }}'.replace('__ID__', id);

                ajax.post(url, { tipo: tipo, estado: nuevoEstado }).then(res => {
                    ajax.showToast('success', res.data.message);

                    const tr = this.closest('tr');
                    if (tr) {
                        const badge = tr.querySelector('.estado-badge');
                        if (badge) {
                            const esActivo = res.data.activo == 1;
                            badge.style.background = esActivo ? '#e8f5e9' : '#ffebee';
                            badge.style.color = esActivo ? '#1a5c30' : '#c62828';
                            badge.style.border = esActivo ? '1px solid #a5d6a7' : '1px solid #ef9a9a';
                            const dot = badge.querySelector('.estado-dot');
                            if (dot) {
                                dot.style.background = esActivo ? '#2e7d46' : '#e53935';
                            }
                            badge.childNodes.forEach(n => {
                                if (n.nodeType === 3) n.textContent = esActivo ? 'aprobado' : 'cerrado';
                            });
                        }
                    }

                    this.dataset.activo = res.data.activo;
                    this.innerHTML = res.data.activo == 1
                        ? '<i class="fas fa-user-minus"></i> Desactivar'
                        : '<i class="fas fa-user-check"></i> Activar';
                    this.style.border = res.data.activo == 1 ? '2px solid #2e7d46' : 'none';
                    this.style.background = res.data.activo == 1 ? 'transparent' : '#2e7d46';
                    this.style.color = res.data.activo == 1 ? '#2e7d46' : 'white';
                }).catch(err => {
                    ajax.enableButton(this);
                    ajax.showToast('error', err.response?.data?.message || 'Error al cambiar estado.');
                });
            });
        });
    });
});
</script>
@endsection
