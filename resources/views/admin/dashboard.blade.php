@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Página Principal')

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
    <a href= "{{ route('admin.empresas') }}" class="nav-item {{ request()->routeIs('admin.empresas') ? 'active' : '' }}">
        <i class="fas fa-building"></i> Empresas Aliadas
    </a>
    <a href="{{ route('admin.proyectos') }}" class="nav-item {{ request()->routeIs('admin.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Banco Proyectos
    </a>
@endsection

@section('content')
    <div class="animate-fade-in">
        <div class="admin-header-master">
            <div class="admin-header-icon">
                <i class="fas fa-shield-halved"></i>
            </div>
            <div style="position: relative; z-index: 1;">
                <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                    <span class="admin-badge-hub">Admin Control Hub</span>
                    <span style="color: rgba(255,255,255,0.5); font-size: 13px; font-weight: 700;"><i class="far fa-calendar-alt" style="margin-right: 8px;"></i>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <h1 class="admin-header-title">Gestión Estratégica <span style="color: var(--primary);">Global</span></h1>
                <p style="color: rgba(255,255,255,0.6); font-size: 18px; max-width: 600px; font-weight: 500;">Control unificado sobre el banco de proyectos y el talento humano del ecosistema Sena.</p>
            </div>
        </div>

        <div class="admin-stats-grid">
            <div class="stat-card-premium" style="padding: 28px; background: white; border-color: var(--primary-soft);">
                <div class="admin-stat-icon" style="background: var(--primary-soft); color: var(--primary); margin-bottom: 24px;">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px;">{{ $stats['proyectos'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Banco de Proyectos</div>
                <div class="inline-pill inline-pill--warning" style="margin-top:16px; width:fit-content;">
                    <i class="fas fa-clock-rotate-left"></i> {{ $stats['pendientes'] }} Pendientes
                </div>
            </div>

            <div class="stat-card-premium" style="padding: 28px; background: white;">
                <div class="admin-stat-icon" style="background: #f8fafc; color: #64748b; margin-bottom: 24px;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px;">{{ $stats['usuarios'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Cuentas Totales</div>
            </div>

            <div class="stat-card-premium" style="padding: 28px; background: white;">
                <div class="admin-stat-icon" style="background: #eff6ff; color: #3b82f6; margin-bottom: 24px;">
                    <i class="fas fa-building"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px; color: #2563eb;">{{ $stats['empresas'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Empresas Aliadas</div>
            </div>

            <div class="stat-card-premium" style="padding: 28px; background: white;">
                <div class="admin-stat-icon" style="background: #fdf2f8; color: #db2777; margin-bottom: 24px;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px; color: #db2777;">{{ $stats['aprendices'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Aprendices</div>
            </div>

            <div class="stat-card-premium" style="padding: 28px; background: white;">
                <div class="admin-stat-icon" style="background: #fef3c7; color: #d97706; margin-bottom: 24px;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px; color: #d97706;">{{ $stats['instructores'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Instructores</div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 24px; margin-top: 24px;">
            <div class="glass-card" style="padding: 28px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text);">
                        <i class="fas fa-chart-line" style="color: var(--primary); margin-right: 8px;"></i>
                        Proyectos por Estado
                    </h3>
                </div>
                <canvas id="chartProyectosEstado" height="200"></canvas>
            </div>

            <div class="glass-card" style="padding: 28px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text);">
                        <i class="fas fa-chart-pie" style="color: #3b82f6; margin-right: 8px;"></i>
                        Usuarios por Tipo
                    </h3>
                </div>
                <canvas id="chartUsuariosTipo" height="200"></canvas>
            </div>

            <div class="glass-card" style="padding: 28px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text);">
                        <i class="fas fa-trophy" style="color: #f59e0b; margin-right: 8px;"></i>
                        Top Empresas
                    </h3>
                </div>
                <div id="rankingEmpresas"></div>
            </div>
        </div>

        <div style="margin-top: 24px;">
            <div class="glass-card" style="padding: 28px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text);">
                        <i class="fas fa-chart-bar" style="color: #10b981; margin-right: 8px;"></i>
                        Proyectos Creados (Últimos 6 Meses)
                    </h3>
                </div>
                <canvas id="chartProyectosMensual" height="100"></canvas>
            </div>
        </div>

        <div class="admin-main-grid" style="margin-top: 24px;">
            <div class="glass-card admin-table-card" style="background: white;">
                <div class="admin-table-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text);">Proyectos por Auditar</h3>
                    <a href="{{ route('admin.proyectos') }}" class="btn-premium" style="padding: 8px 16px; font-size: 11px; background: #f8fafc; color: var(--primary); border: 1px solid var(--primary-soft); box-shadow: none;">Ir al Banco</a>
                </div>
                <div class="premium-table-container">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th>Proyecto</th>
                                <th>Empresa</th>
                                <th>Estado</th>
                                <th style="text-align: right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proyectosRecientes as $p)
                                <tr>
                                    <td style="font-weight: 800; color: var(--text);">{{ Str::limit($p->titulo, 40) }}</td>
                                    <td style="color: var(--text-light); font-weight: 600;">{{ $p->nombre }}</td>
                                    <td>
                                        <span class="status-badge {{ $p->estado == 'aprobado' ? 'active' : 'inactive' }}" style="padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800;">
                                            {{ $p->estado }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('admin.proyectos.revisar', $p->id) }}" class="btn-premium" style="width: 32px; height: 32px; padding: 0; justify-content: center; background: var(--primary-soft); color: var(--primary); box-shadow: none; border-radius: 8px;">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" style="text-align:center; padding: 40px; color: var(--text-lighter); font-weight: 600;">No hay proyectos pendientes.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="glass-card" style="padding: 32px; background: white;">
                <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text); margin-bottom: 28px;">Incorporaciones</h3>
                <div class="user-incorporation-list">
                    @foreach($usuariosRecientes as $u)
                        <div class="user-incorporation-item">
                            <div style="width: 44px; height: 44px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; color: #3b82f6; font-weight: 800; font-size: 16px; border: 1px solid #dbeafe;">
                                {{ strtoupper(substr($u->correo, 0, 1)) }}
                            </div>
                            <div style="flex: 1; overflow: hidden;">
                                <p style="font-size: 13px; font-weight: 800; color: var(--text); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $u->correo }}</p>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 10px; font-weight: 800; color: var(--primary); text-transform: uppercase;">{{ $u->nombre_rol }}</span>
                                    <span style="width: 3px; height: 3px; background: #cbd5e1; border-radius: 50%;"></span>
                                    <span style="font-size: 10px; color: #94a3b8; font-weight: 600;">{{ $u->created_at ? \Carbon\Carbon::parse($u->created_at)->diffForHumans() : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('admin.usuarios') }}" class="btn-premium" style="margin-top: 32px; width: 100%; text-align: center; justify-content: center; background: #0f172a; border: none; font-size: 13px; padding: 14px;">
                    Gestionar Usuarios <i class="fas fa-arrow-right" style="margin-left: 10px;"></i>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route('api.admin.stats') }}')
                .then(r => r.json())
                .then(data => {
                    const chartColors = {
                        pendiente: '#f59e0b',
                        aprobado: '#22c55e',
                        rechazado: '#ef4444',
                        en_progreso: '#3b82f6',
                        cerrado: '#6b7280'
                    };

                    new Chart(document.getElementById('chartProyectosEstado'), {
                        type: 'doughnut',
                        data: {
                            labels: data.proyectos_por_estado.labels,
                            datasets: [{
                                data: data.proyectos_por_estado.data,
                                backgroundColor: ['#f59e0b', '#22c55e', '#ef4444', '#3b82f6', '#6b7280'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom', labels: { padding: 20, font: { size: 11 } } }
                            }
                        }
                    });

                    new Chart(document.getElementById('chartUsuariosTipo'), {
                        type: 'polarArea',
                        data: {
                            labels: data.usuarios_por_tipo.labels,
                            datasets: [{
                                data: data.usuarios_por_tipo.data,
                                backgroundColor: ['#f472b6', '#a78bfa', '#fbbf24', '#34d399'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom', labels: { padding: 15, font: { size: 11 } } }
                            }
                        }
                    });

                    const rankingContainer = document.getElementById('rankingEmpresas');
                    if (data.ranking_empresas.length > 0) {
                        rankingContainer.innerHTML = data.ranking_empresas.map((emp, i) => `
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding: 12px; background: ${i === 0 ? '#fef3c7' : '#f8fafc'}; border-radius: 12px; border: 1px solid ${i === 0 ? '#fde68a' : '#e2e8f0'};">
                                <div style="width: 32px; height: 32px; border-radius: 8px; background: ${i === 0 ? '#f59e0b' : '#94a3b8'}; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px;">
                                    ${i + 1}
                                </div>
                                <div style="flex: 1; overflow: hidden;">
                                    <div style="font-weight: 800; font-size: 13px; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${emp.nombre}</div>
                                    <div style="font-size: 11px; color: var(--text-light);">${emp.total} proyecto${emp.total !== 1 ? 's' : ''}</div>
                                </div>
                                ${i === 0 ? '<i class="fas fa-trophy" style="color: #f59e0b;"></i>' : ''}
                            </div>
                        `).join('');
                    } else {
                        rankingContainer.innerHTML = '<p style="text-align: center; color: var(--text-light); font-size: 13px; font-weight: 600;">Sin datos aún</p>';
                    }

                    new Chart(document.getElementById('chartProyectosMensual'), {
                        type: 'bar',
                        data: {
                            labels: data.metricas_mensuales.labels,
                            datasets: [{
                                label: 'Proyectos',
                                data: data.metricas_mensuales.data,
                                backgroundColor: 'rgba(62, 180, 137, 0.8)',
                                borderRadius: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                        }
                    });
                })
                .catch(err => console.error('Error cargando stats:', err));
        });
    </script>
@endsection
