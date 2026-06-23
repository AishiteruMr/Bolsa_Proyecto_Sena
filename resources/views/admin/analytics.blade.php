@extends('layouts.dashboard')

@section('title', 'Analítica Avanzada')
@section('page-title', 'Analítica de Datos')

@section('styles')
@vite(['resources/css/admin.css'])
<style>
    .analytics-filter-bar {
        display: flex; align-items: end; gap: 16px; flex-wrap: wrap;
        padding: 20px 24px; background: white; border-radius: 16px;
        border: 1px solid #e2e8f0; margin-bottom: 32px;
    }
    .analytics-filter-group {
        display: flex; flex-direction: column; gap: 4px;
    }
    .analytics-filter-group label {
        font-size: 10px; font-weight: 800; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .analytics-filter-group input {
        padding: 10px 14px; border: 1.5px solid #e2e8f0;
        border-radius: 10px; font-size: 13px; font-weight: 600;
        color: #1e293b; background: #f8fafc; outline: none;
        font-family: inherit; transition: all 0.2s;
    }
    .analytics-filter-group input:focus {
        border-color: var(--primary); background: #fff;
        box-shadow: 0 0 0 3px var(--primary-soft);
    }
    .analytics-stat-card {
        padding: 20px; background: white; border-radius: 14px;
        border: 1px solid #e2e8f0; text-align: center;
        transition: all 0.2s;
    }
    .analytics-stat-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        transform: translateY(-2px);
    }
    .analytics-stat-value {
        font-size: 30px; font-weight: 900; line-height: 1.2;
    }
    .analytics-stat-label {
        font-size: 10px; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.5px;
        margin-top: 4px;
    }
    .skeleton-pulse {
        background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
        background-size: 200% 100%; animation: shimmer 1.5s infinite;
        border-radius: 8px;
    }
    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>
@endsection

@section('sidebar-nav')
@include('admin.partials.sidebar-nav')
@endsection

@section('content')
<div class="animate-fade-in">
    <div class="admin-header-master" style="padding:40px 48px;">
        <div class="admin-header-icon">
            <i class="fas fa-chart-pie"></i>
        </div>
        <div style="position:relative;z-index:1;">
            <span class="admin-badge-hub" style="background:#6366f1;box-shadow:0 8px 16px rgba(99,102,241,0.3);">
                <i class="fas fa-chart-line"></i> Analytics
            </span>
            <h1 class="admin-header-title" style="margin-top:16px;">Analítica <span style="color:#818cf8;">Avanzada</span></h1>
            <p style="color:rgba(255,255,255,0.6);font-size:16px;max-width:600px;font-weight:500;">
                Visualiza tendencias, distribuciones y proyecciones del ecosistema Sena.
            </p>
        </div>
    </div>

    <div class="analytics-filter-bar">
        <div class="analytics-filter-group">
            <label><i class="far fa-calendar-alt"></i> Fecha inicio</label>
            <input type="month" id="filterFechaInicio" value="{{ now()->subYear()->format('Y-m') }}">
        </div>
        <div class="analytics-filter-group">
            <label><i class="far fa-calendar-alt"></i> Fecha fin</label>
            <input type="month" id="filterFechaFin" value="{{ now()->format('Y-m') }}">
        </div>
        <button onclick="cargarAnalytics()" class="filter-bar-btn primary" style="height:40px;">
            <i class="fas fa-sync-alt"></i> Actualizar
        </button>
        <button onclick="exportarAnalytics()" class="filter-bar-btn outline" style="height:40px;margin-left:auto;">
            <i class="fas fa-download"></i> Exportar CSV
        </button>
    </div>

    <div id="analyticsContent">
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:32px;" id="analyticsStatsGrid">
            <div class="analytics-stat-card"><div class="skeleton-pulse" style="height:30px;width:50%;margin:0 auto 8px;"></div><div class="skeleton-pulse" style="height:12px;width:60%;margin:0 auto;"></div></div>
            <div class="analytics-stat-card"><div class="skeleton-pulse" style="height:30px;width:50%;margin:0 auto 8px;"></div><div class="skeleton-pulse" style="height:12px;width:60%;margin:0 auto;"></div></div>
            <div class="analytics-stat-card"><div class="skeleton-pulse" style="height:30px;width:50%;margin:0 auto 8px;"></div><div class="skeleton-pulse" style="height:12px;width:60%;margin:0 auto;"></div></div>
            <div class="analytics-stat-card"><div class="skeleton-pulse" style="height:30px;width:50%;margin:0 auto 8px;"></div><div class="skeleton-pulse" style="height:12px;width:60%;margin:0 auto;"></div></div>
        </div>

        <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;margin-bottom:32px;" id="analyticsRow1">
            <div class="glass-card" style="padding:24px;background:white;">
                <h3 style="font-size:0.95rem;font-weight:800;color:var(--text);margin:0 0 20px;">
                    <i class="fas fa-chart-line" style="color:var(--primary);margin-right:8px;"></i> Tendencia Mensual
                </h3>
                <div style="height:300px;position:relative;"><canvas id="chartTendencia"></canvas></div>
            </div>
            <div class="glass-card" style="padding:24px;background:white;">
                <h3 style="font-size:0.95rem;font-weight:800;color:var(--text);margin:0 0 20px;">
                    <i class="fas fa-chart-pie" style="color:#8b5cf6;margin-right:8px;"></i> Proyectos por Estado
                </h3>
                <div style="height:260px;position:relative;"><canvas id="chartEstadoPie"></canvas></div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:32px;" id="analyticsRow2">
            <div class="glass-card" style="padding:24px;background:white;">
                <h3 style="font-size:0.95rem;font-weight:800;color:var(--text);margin:0 0 20px;">
                    <i class="fas fa-filter" style="color:#f59e0b;margin-right:8px;"></i> Embudo Postulaciones
                </h3>
                <div style="height:260px;position:relative;"><canvas id="chartFunnel"></canvas></div>
            </div>
            <div class="glass-card" style="padding:24px;background:white;">
                <h3 style="font-size:0.95rem;font-weight:800;color:var(--text);margin:0 0 20px;">
                    <i class="fas fa-bullseye" style="color:#059669;margin-right:8px;"></i> Proyección
                </h3>
                <div style="height:260px;position:relative;"><canvas id="chartProyeccion"></canvas></div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;" id="analyticsRow3">
            <div class="glass-card" style="padding:24px;background:white;">
                <h3 style="font-size:0.95rem;font-weight:800;color:var(--text);margin:0 0 20px;">
                    <i class="fas fa-trophy" style="color:#f59e0b;margin-right:8px;"></i> Top Empresas
                </h3>
                <div id="topEmpresasContent" style="min-height:200px;">
                    <div class="skeleton-pulse" style="height:40px;margin-bottom:8px;"></div>
                    <div class="skeleton-pulse" style="height:40px;margin-bottom:8px;"></div>
                    <div class="skeleton-pulse" style="height:40px;margin-bottom:8px;"></div>
                </div>
            </div>
            <div class="glass-card" style="padding:24px;background:white;">
                <h3 style="font-size:0.95rem;font-weight:800;color:var(--text);margin:0 0 20px;">
                    <i class="fas fa-chalkboard-user" style="color:#6366f1;margin-right:8px;"></i> Carga de Instructores
                </h3>
                <div style="height:260px;position:relative;"><canvas id="chartInstructores"></canvas></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/chart.js"></script>
<script>
let charts = {};

function cargarAnalytics() {
    const fi = document.getElementById('filterFechaInicio').value;
    const ff = document.getElementById('filterFechaFin').value;
    const url = '/api/admin/analytics?fecha_inicio=' + fi + '&fecha_fin=' + ff;

    document.getElementById('analyticsContent').innerHTML =
        '<div style="text-align:center;padding:80px;color:#94a3b8;"><i class="fas fa-spinner fa-spin" style="font-size:24px;display:block;margin-bottom:12px;"></i>Cargando analytics...</div>';

    fetch(url)
        .then(function(r) { return r.json(); })
        .then(function(data) {
            renderAnalytics(data);
        })
        .catch(function(err) {
            console.error('Error analytics:', err);
            document.getElementById('analyticsContent').innerHTML =
                '<div style="text-align:center;padding:80px;color:#dc2626;"><i class="fas fa-exclamation-triangle" style="font-size:24px;display:block;margin-bottom:12px;"></i>Error al cargar analytics</div>';
        });
}

function renderAnalytics(data) {
    Object.values(charts).forEach(function(c) { if (c) c.destroy(); });
    charts = {};

    var totalProyectos = data.proyectos_por_estado?.data?.reduce(function(a,b) { return a+b; }, 0) || 0;
    var totalPostulaciones = data.postulaciones_funnel?.total || 0;
    var totalUsuarios = data.usuarios_mensuales?.data?.reduce(function(a,b) { return a+b; }, 0) || 0;
    var tasaExito = data.tasa_exito?.tasa_exito || 0;

    document.getElementById('analyticsContent').innerHTML =
        '<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:32px;" id="analyticsStatsGrid">\
            <div class="analytics-stat-card"><div class="analytics-stat-value" style="color:var(--primary);">' + totalProyectos + '</div><div class="analytics-stat-label">Proyectos totales</div></div>\
            <div class="analytics-stat-card"><div class="analytics-stat-value" style="color:#3b82f6;">' + totalPostulaciones + '</div><div class="analytics-stat-label">Postulaciones totales</div></div>\
            <div class="analytics-stat-card"><div class="analytics-stat-value" style="color:#8b5cf6;">' + totalUsuarios + '</div><div class="analytics-stat-label">Usuarios nuevos</div></div>\
            <div class="analytics-stat-card"><div class="analytics-stat-value" style="color:#059669;">' + tasaExito + '%</div><div class="analytics-stat-label">Tasa de éxito</div></div>\
        </div>\
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;margin-bottom:32px;" id="analyticsRow1">\
            <div class="glass-card" style="padding:24px;background:white;"><h3 style="font-size:0.95rem;font-weight:800;color:var(--text);margin:0 0 20px;"><i class="fas fa-chart-line" style="color:var(--primary);margin-right:8px;"></i> Tendencia Mensual</h3><div style="height:300px;position:relative;"><canvas id="chartTendencia"></canvas></div></div>\
            <div class="glass-card" style="padding:24px;background:white;"><h3 style="font-size:0.95rem;font-weight:800;color:var(--text);margin:0 0 20px;"><i class="fas fa-chart-pie" style="color:#8b5cf6;margin-right:8px;"></i> Proyectos por Estado</h3><div style="height:260px;position:relative;"><canvas id="chartEstadoPie"></canvas></div></div>\
        </div>\
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:32px;" id="analyticsRow2">\
            <div class="glass-card" style="padding:24px;background:white;"><h3 style="font-size:0.95rem;font-weight:800;color:var(--text);margin:0 0 20px;"><i class="fas fa-filter" style="color:#f59e0b;margin-right:8px;"></i> Embudo Postulaciones</h3><div style="height:260px;position:relative;"><canvas id="chartFunnel"></canvas></div></div>\
            <div class="glass-card" style="padding:24px;background:white;"><h3 style="font-size:0.95rem;font-weight:800;color:var(--text);margin:0 0 20px;"><i class="fas fa-bullseye" style="color:#059669;margin-right:8px;"></i> Proyección</h3><div style="height:260px;position:relative;"><canvas id="chartProyeccion"></canvas></div></div>\
        </div>\
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;" id="analyticsRow3">\
            <div class="glass-card" style="padding:24px;background:white;"><h3 style="font-size:0.95rem;font-weight:800;color:var(--text);margin:0 0 20px;"><i class="fas fa-trophy" style="color:#f59e0b;margin-right:8px;"></i> Top Empresas</h3><div id="topEmpresasContent"></div></div>\
            <div class="glass-card" style="padding:24px;background:white;"><h3 style="font-size:0.95rem;font-weight:800;color:var(--text);margin:0 0 20px;"><i class="fas fa-chalkboard-user" style="color:#6366f1;margin-right:8px;"></i> Carga de Instructores</h3><div style="height:260px;position:relative;"><canvas id="chartInstructores"></canvas></div></div>\
        </div>';

    // Trend chart
    var tendenciaData = data.proyectos_mensuales || {labels:[], data:[]};
    var postData = data.postulaciones_mensuales || {labels:[], data:[]};
    var userData = data.usuarios_mensuales || {labels:[], data:[]};
    charts.trend = new Chart(document.getElementById('chartTendencia'), {
        type: 'line',
        data: {
            labels: tendenciaData.labels,
            datasets: [
                { label: 'Proyectos', data: tendenciaData.data, borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', borderWidth: 2, fill: true, tension: 0.4, pointRadius: 3 },
                { label: 'Postulaciones', data: postData.data, borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,0.1)', borderWidth: 2, fill: true, tension: 0.4, pointRadius: 3 },
                { label: 'Usuarios', data: userData.data, borderColor: '#8b5cf6', backgroundColor: 'rgba(139,92,246,0.1)', borderWidth: 2, fill: true, tension: 0.4, pointRadius: 3 }
            ]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15, font: { size: 10, weight: '600' } } }, tooltip: { backgroundColor: 'rgba(255,255,255,0.95)', titleColor: '#1e293b', bodyColor: '#1e293b', padding: 12, borderColor: '#e2e8f0', borderWidth: 1, cornerRadius: 12 } },
            scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { size: 10 } } }, x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 10 } } } }
        }
    });

    // Estado pie
    var estado = data.proyectos_por_estado || {labels:[], data:[]};
    var estadoColors = { pendiente:'#f59e0b', aprobado:'#10b981', rechazado:'#ef4444', 'en progreso':'#3b82f6', cerrado:'#64748b', completado:'#065f46' };
    charts.estado = new Chart(document.getElementById('chartEstadoPie'), {
        type: 'doughnut',
        data: {
            labels: estado.labels,
            datasets: [{ data: estado.data, backgroundColor: estado.labels.map(function(l) { return estadoColors[l.toLowerCase()] || '#94a3b8'; }), hoverOffset: 10, borderWidth: 0, borderRadius: 4, spacing: 3 }]
        },
        options: { cutout: '70%', responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, font: { size: 10, weight: '600' } } } } }
    });

    // Funnel
    var funnel = data.postulaciones_funnel || {labels:[], data:[]};
    charts.funnel = new Chart(document.getElementById('chartFunnel'), {
        type: 'doughnut', data: { labels: funnel.labels, datasets: [{ data: funnel.data, backgroundColor: ['#f59e0b','#3b82f6','#10b981','#ef4444'], borderWidth: 0, borderRadius: 4, spacing: 3 }] },
        options: { cutout: '65%', responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, font: { size: 10, weight: '600' } } }, tooltip: { callbacks: { label: function(ctx) { var t = funnel.total || 1; return ctx.label + ': ' + ctx.parsed + ' (' + ((ctx.parsed/t)*100).toFixed(1) + '%)'; } } } } }
    });

    // Prediction
    var pred = data.predicciones || {};
    if (pred.historico && pred.historico.length) {
        var allLabels = (pred.labels_meses || []).concat(pred.labels_pred || []);
        var allData = (pred.historico || []).concat(pred.predicciones || []);
        var split = (pred.historico || []).length;
        charts.proy = new Chart(document.getElementById('chartProyeccion'), {
            type: 'line', data: { labels: allLabels, datasets: [{ label: 'Proyectos', data: allData, borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.15)', borderWidth: 2, fill: true, tension: 0.4, pointRadius: 3, segment: { borderDash: function(ctx) { return ctx.p1DataIndex >= split ? [5,5] : []; } } }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { size: 10 } } }, x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 9 } } } } }
        });
    } else {
        document.getElementById('chartProyeccion').parentElement.innerHTML = '<div style="text-align:center;padding:60px 20px;color:#94a3b8;font-size:12px;font-weight:600;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Datos insuficientes</div>';
    }

    // Top empresas
    var empContent = document.getElementById('topEmpresasContent');
    var empresas = data.top_empresas || [];
    if (empresas.length) {
        empContent.innerHTML = empresas.map(function(e, i) {
            var bg = i === 0 ? '#fef3c7' : '#f8fafc';
            var numBg = i === 0 ? '#f59e0b' : '#94a3b8';
            var crown = i === 0 ? '<i class="fas fa-crown" style="color:#f59e0b;font-size:12px;"></i>' : '';
            return '<div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;padding:10px 14px;background:' + bg + ';border-radius:12px;">\
                <div style="width:30px;height:30px;border-radius:8px;background:' + numBg + ';color:white;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:11px;flex-shrink:0;">' + (i + 1) + '</div>\
                <div style="flex:1;overflow:hidden;"><div style="font-weight:700;font-size:12px;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + e.nombre + '</div><div style="font-size:10px;color:#94a3b8;font-weight:500;">' + e.total + ' proyecto' + (e.total !== 1 ? 's' : '') + '</div></div>\
                ' + crown + '</div>';
        }).join('');
    } else {
        empContent.innerHTML = '<div style="text-align:center;padding:40px;color:#94a3b8;font-size:12px;font-weight:600;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Sin datos</div>';
    }

    // Instructores carga
    var inst = data.instructores_carga || [];
    var ctxIns = document.getElementById('chartInstructores').getContext('2d');
    if (inst.length) {
        charts.inst = new Chart(ctxIns, { type: 'bar', data: { labels: inst.map(function(i) { return i.nombre.length > 20 ? i.nombre.substring(0,18)+'..' : i.nombre; }), datasets: [{ label: 'Proyectos', data: inst.map(function(i) { return i.total; }), backgroundColor: ['rgba(99,102,241,0.7)','rgba(59,130,246,0.7)','rgba(16,185,129,0.7)','rgba(245,158,11,0.7)','rgba(244,63,94,0.7)','rgba(139,92,246,0.7)','rgba(6,182,212,0.7)','rgba(236,72,153,0.7)','rgba(168,85,247,0.7)','rgba(251,146,60,0.7)'], borderColor: ['#6366f1','#3b82f6','#10b981','#f59e0b','#f43f5e','#8b5cf6','#06b6d4','#ec4899','#a855f7','#fb923c'], borderWidth: 1, borderRadius: 4 }] }, options: { indexAxis: 'y', responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { size: 10 } } }, y: { grid: { display: false }, ticks: { color: '#64748b', font: { size: 10, weight: '600' } } } } } });
    } else {
        ctxIns.canvas.parentElement.innerHTML = '<div style="text-align:center;padding:60px 20px;color:#94a3b8;font-size:12px;font-weight:600;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Sin instructores asignados</div>';
    }
}

function exportarAnalytics() {
    var fi = document.getElementById('filterFechaInicio').value;
    var ff = document.getElementById('filterFechaFin').value;
    fetch('/api/admin/analytics?fecha_inicio=' + fi + '&fecha_fin=' + ff)
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var rows = [['Metrica','Valor']];
            if (data.proyectos_por_estado && data.proyectos_por_estado.labels) {
                data.proyectos_por_estado.labels.forEach(function(l, i) {
                    rows.push(['Proyectos ' + l, data.proyectos_por_estado.data[i] || 0]);
                });
            }
            if (data.postulaciones_funnel) {
                rows.push(['Postulaciones totales', data.postulaciones_funnel.total || 0]);
                rows.push(['Tasa conversion', data.postulaciones_funnel.tasa_conversion + '%']);
            }
            if (data.tasa_exito) {
                rows.push(['Tasa exito', data.tasa_exito.tasa_exito + '%']);
                rows.push(['Tasa rechazo', data.tasa_exito.tasa_rechazo + '%']);
            }
            if (data.predicciones) {
                rows.push(['Promedio mensual', data.predicciones.promedio_mensual || 0]);
                rows.push(['Proyectado anual', data.predicciones.proyectado_anual || 0]);
            }
            var csv = rows.map(function(r) { return r.join(','); }).join('\n');
            var blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'analytics_' + fi + '_' + ff + '.csv';
            link.click();
        });
}

document.addEventListener('DOMContentLoaded', cargarAnalytics);
</script>
@endsection
