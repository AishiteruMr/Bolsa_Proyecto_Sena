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
                <div class="admin-stat-value" style="font-size: 38px; color: var(--primary);">{{ $stats['proyectos'] }}</div>
                <div class="admin-stat-label" style="font-size: 11px; margin-top: 8px;">Banco de Proyectos</div>
                <div class="inline-pill inline-pill--warning" style="margin-top:16px; width:fit-content;">
                    <i class="fas fa-clock-rotate-left"></i> {{ $stats['pendientes'] }} Pendientes
                </div>
            </div>

            <div class="stat-card-premium" style="padding: 28px; background: white;">
                <div class="admin-stat-icon" style="background: #f8fafc; color: #64748b; margin-bottom: 24px;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="admin-stat-value" style="font-size: 38px; color: var(--text);">{{ $stats['usuarios'] }}</div>
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
                <div style="height: 250px; position: relative;">
                    <canvas id="chartProyectosEstado"></canvas>
                </div>
            </div>

            <div class="glass-card" style="padding: 28px; background: white;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; color: var(--text);">
                        <i class="fas fa-chart-pie" style="color: #3b82f6; margin-right: 8px;"></i>
                        Usuarios por Tipo
                    </h3>
                </div>
                <div style="height: 250px; position: relative;">
                    <canvas id="chartUsuariosTipo"></canvas>
                </div>
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
                <div style="height: 300px; position: relative;">
                    <canvas id="chartProyectosMensual"></canvas>
                </div>
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
                                    <td style="color: var(--text-light); font-weight: 600;">{{ $p->empresa_nombre }}</td>
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

    <script src="https://unpkg.com/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/admin/stats')
                .then(r => r.json())
                .then(data => {
                    // Modern Palette
                    const colors = {
                        emerald: '#10b981',
                        amber: '#f59e0b',
                        rose: '#f43f5e',
                        blue: '#3b82f6',
                        indigo: '#6366f1',
                        gray: '#64748b'
                    };

                    // Proyectos por Estado - Ultra Modern Doughnut
                    new Chart(document.getElementById('chartProyectosEstado'), {
                        type: 'doughnut',
                        data: {
                            labels: data.proyectos_por_estado.labels,
                            datasets: [{
                                data: data.proyectos_por_estado.data,
                                backgroundColor: [colors.amber, colors.emerald, colors.rose, colors.blue, colors.gray],
                                hoverOffset: 15,
                                weight: 2,
                                borderWidth: 0,
                                borderRadius: 6,
                                spacing: 4
                            }]
                        },
                        options: {
                            cutout: '78%',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 25, font: { family: 'Outfit', size: 11, weight: '600' } } },
                                tooltip: {
                                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                    titleColor: '#1e293b',
                                    bodyColor: '#1e293b',
                                    padding: 12,
                                    borderColor: '#e2e8f0',
                                    borderWidth: 1,
                                    displayColors: true,
                                    usePointStyle: true,
                                    boxPadding: 6,
                                    cornerRadius: 12
                                }
                            }
                        }
                    });

                    // Usuarios por Tipo - Polar Area
                    new Chart(document.getElementById('chartUsuariosTipo'), {
                        type: 'polarArea',
                        data: {
                            labels: data.usuarios_por_tipo.labels,
                            datasets: [{
                                data: data.usuarios_por_tipo.data,
                                backgroundColor: [
                                    'rgba(244, 114, 182, 0.65)', 
                                    'rgba(167, 139, 250, 0.65)', 
                                    'rgba(251, 191, 36, 0.65)', 
                                    'rgba(52, 211, 153, 0.65)'
                                ],
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: { r: { grid: { color: '#f1f5f9' }, ticks: { display: false } } },
                            plugins: {
                                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15, font: { family: 'Outfit', size: 11, weight: '600' } } }
                            }
                        }
                    });

                    // Top Empresas
                    const rankingContainer = document.getElementById('rankingEmpresas');
                    if (data.ranking_empresas.length > 0) {
                        rankingContainer.innerHTML = data.ranking_empresas.map((emp, i) => `
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; padding: 12px; background: ${i === 0 ? 'hsla(45, 100%, 96%, 1)' : '#f8fafc'}; border-radius: 16px; border: 1px solid ${i === 0 ? 'hsla(45, 100%, 90%, 1)' : '#e2e8f0'}; transition: all 0.3s ease; transform: scale(1);" onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.05)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'">
                                <div style="width: 36px; height: 36px; border-radius: 10px; background: ${i === 0 ? colors.amber : '#94a3b8'}; color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; box-shadow: 0 4px 10px ${i === 0 ? 'rgba(245, 158, 11, 0.3)' : 'transparent'};">
                                    ${i + 1}
                                </div>
                                <div style="flex: 1; overflow: hidden;">
                                    <div style="font-weight: 800; font-size: 13px; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${emp.nombre}</div>
                                    <div style="font-size: 11px; color: var(--text-light); font-weight: 500;">${emp.total} proyecto${emp.total !== 1 ? 's' : ''}</div>
                                </div>
                                ${i === 0 ? '<i class="fas fa-crown" style="color: #f59e0b; font-size: 14px;"></i>' : ''}
                            </div>
                        `).join('');
                    } else {
                        rankingContainer.innerHTML = '<div style="text-align: center; padding: 20px;"><i class="fas fa-inbox" style="font-size: 24px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i><p style="color: #94a3b8; font-size: 13px; font-weight: 600;">Sin datos aún</p></div>';
                    }

                    // Proyectos Creados - Gradient Area Chart
                    const ctx = document.getElementById('chartProyectosMensual').getContext('2d');
                    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
                    gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.metricas_mensuales.labels,
                            datasets: [{
                                label: 'Proyectos',
                                data: data.metricas_mensuales.data,
                                borderColor: colors.emerald,
                                borderWidth: 3,
                                fill: true,
                                backgroundColor: gradient,
                                tension: 0.45,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: colors.emerald,
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { 
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                    titleColor: '#1e293b',
                                    bodyColor: colors.emerald,
                                    padding: 12,
                                    borderColor: '#e2e8f0',
                                    borderWidth: 1,
                                    displayColors: false,
                                    cornerRadius: 12
                                }
                            },
                            scales: { 
                                y: { 
                                    beginAtZero: true, 
                                    grid: { color: '#f1f5f9', drawBorder: false },
                                    ticks: { color: '#94a3b8', font: { family: 'Outfit', size: 10 }, stepSize: 1 } 
                                },
                                x: {
                                    grid: { display: false },
                                    ticks: { color: '#94a3b8', font: { family: 'Outfit', size: 10 } }
                                }
                            }
                        }
                    });
                })
                .catch(err => console.error('Error cargando stats:', err));
        });
    </script>
@endsection
