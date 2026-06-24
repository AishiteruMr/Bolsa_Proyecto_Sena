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
        transition: all 0.2s; position: relative; overflow: hidden;
    }
    .analytics-stat-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        transform: translateY(-2px);
    }
    .analytics-stat-card .stat-icon {
        position: absolute; top: 12px; right: 12px;
        width: 36px; height: 36px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px; opacity: 1; color: #fff !important;
    }
    .analytics-stat-value {
        font-size: 30px; font-weight: 900; line-height: 1.2;
    }
    .analytics-stat-label {
        font-size: 10px; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.5px;
        margin-top: 4px;
    }
    .analytics-stat-change {
        font-size: 10px; font-weight: 700; margin-top: 6px;
    }
    .analytics-stat-change.up { color: #10b981; }
    .analytics-stat-change.down { color: #ef4444; }
    .analytics-stat-change.flat { color: #94a3b8; }
    .skeleton-pulse {
        background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
        background-size: 200% 100%; animation: shimmer 1.5s infinite;
        border-radius: 8px;
    }
    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    .health-gauge {
        width: 140px; height: 140px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-direction: column; margin: 0 auto;
        font-weight: 900; font-size: 32px; position: relative;
    }
    .health-gauge svg { position: absolute; top: 0; left: 0; }
    .health-gauge .label {
        font-size: 10px; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.5px; margin-top: 4px;
    }
    .trend-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 20px;
        font-size: 10px; font-weight: 700;
    }
    .trend-badge.up { background: #d1fae5; color: #065f46; }
    .trend-badge.down { background: #fee2e2; color: #991b1b; }
    .trend-badge.flat { background: #f1f5f9; color: #475569; }
    .chart-card {
        background: white; border-radius: 16px; border: 1px solid #e2e8f0;
        padding: 24px; transition: all 0.2s;
    }
    .chart-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.04); }
    .chart-card h3 {
        font-size: 0.85rem; font-weight: 800; color: var(--text);
        margin: 0 0 16px; display: flex; align-items: center; gap: 8px;
    }
    .chart-card h3 i { font-size: 14px; }
    .chart-card .chart-container {
        height: 260px; position: relative;
    }
    .chart-card.tall .chart-container { height: 300px; }
    .evidencia-stat {
        display: flex; align-items: center; gap: 12px; padding: 12px 16px;
        border-radius: 12px; background: #f8fafc;
    }
    .evidencia-stat .dot {
        width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
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
        @include('admin.partials.analytics-skeleton')
    </div>
</div>

<script src="https://unpkg.com/chart.js"></script>
<script>
let charts = {};

const COLORS = {
    primary: '#6366f1', success: '#10b981', warning: '#f59e0b',
    danger: '#ef4444', info: '#3b82f6', purple: '#8b5cf6',
    teal: '#14b8a6', pink: '#ec4899', slate: '#64748b',
    orange: '#f97316', indigo: '#6366f1',
};

const palette = ['#6366f1','#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#14b8a6','#ec4899','#f97316','#64748b'];

const estadoColors = {
    pendiente: '#f59e0b', aprobado: '#10b981', rechazado: '#ef4444',
    'en progreso': '#3b82f6', cerrado: '#64748b', completado: '#065f46'
};

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

function calcularTotal(arr) {
    return (arr && arr.data ? arr.data.reduce(function(a,b) { return a+b; }, 0) : 0);
}

function safeVal(obj, key, def) {
    return (obj && obj[key] !== undefined && obj[key] !== null) ? obj[key] : def;
}

function renderAnalytics(data) {
    Object.values(charts).forEach(function(c) { if (c) c.destroy(); });
    charts = {};

    // ── Stat totals ──
    var totalProyectos = calcularTotal(data.proyectos_mensuales);
    var totalPostulaciones = calcularTotal(data.postulaciones_mensuales);
    var totalUsuarios = calcularTotal(data.usuarios_mensuales);
    var tasaExito = safeVal(data.tasa_exito, 'tasa_exito', 0);
    var tasaRechazo = safeVal(data.tasa_exito, 'tasa_rechazo', 0);
    var completados = safeVal(data.tasa_exito, 'completados', 0);
    var enProgreso = safeVal(data.tasa_exito, 'en_progreso', 0);
    var pendientes = data.proyectos_por_estado?.data?.[0] || 0;

    var tendencias = data.tendencias || {};
    var tProy = tendencias.proyectos || {};
    var tUser = tendencias.usuarios || {};

    var metricasGlobales = data.metricas_globales || {};
    var puntajeSalud = safeVal(metricasGlobales, 'puntaje', 0);

    var html = '';

    // ── KPI Cards (8) ──
    html += '<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">';

    html += statCard(totalProyectos, 'Proyectos totales', COLORS.primary, 'fas fa-folder', tProy.change, tProy.direction);
    html += statCard(totalPostulaciones, 'Postulaciones', COLORS.info, 'fas fa-file-alt', null, null);
    html += statCard(totalUsuarios, 'Usuarios nuevos', COLORS.purple, 'fas fa-user-plus', tUser.change, tUser.direction);
    html += statCard(tasaExito + '%', 'Tasa de éxito', COLORS.success, 'fas fa-bullseye', null, null);

    html += '</div><div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:32px;">';

    html += statCard(completados, 'Completados', COLORS.success, 'fas fa-check-circle', null, null);
    html += statCard(enProgreso, 'En progreso', COLORS.teal, 'fas fa-play-circle', null, null);
    html += statCard(pendientes, 'Pendientes', COLORS.warning, 'fas fa-hourglass-half', null, null);
    html += statCard(puntajeSalud + '%', 'Salud plataforma', COLORS.indigo, 'fas fa-heartbeat', null, null);

    html += '</div>';

    // ── Row 1: Tendencia + Proyeccion Proyectos ──
    html += '<div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;margin-bottom:24px;">';
    html += chartCard('chartTendencia', 'Tendencia Mensual', 'fa-chart-line', COLORS.primary, true);
    html += chartCard('chartProyeccion', 'Proyección Proyectos', 'fa-bullseye', COLORS.success);
    html += '</div>';

    // ── Row 2: Proyeccion Postulaciones + Proyeccion Usuarios ──
    html += '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">';
    html += chartCard('chartProyeccionPost', 'Proyección Postulaciones', 'fa-chart-bar', COLORS.info);
    html += chartCard('chartProyeccionUser', 'Proyección Usuarios', 'fa-chart-bar', COLORS.purple);
    html += '</div>';

    // ── Row 3: Estado Pie + Funnel ──
    html += '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">';
    html += chartCard('chartEstadoPie', 'Proyectos por Estado', 'fa-chart-pie', COLORS.purple);
    html += chartCard('chartFunnel', 'Embudo Postulaciones', 'fa-filter', COLORS.warning);
    html += '</div>';

    // ── Row 4: Registro detalle (stacked) + Calidad Proyectos ──
    html += '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">';
    html += chartCard('chartRegistroDetalle', 'Registro Usuarios por Tipo', 'fa-users', COLORS.info);
    html += chartCard('chartCalidad', 'Calidad de Proyectos', 'fa-star', COLORS.warning);
    html += '</div>';

    // ── Row 5: Categorias Rendimiento + Programas ──
    html += '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">';
    html += chartCard('chartCategorias', 'Rendimiento por Categoría', 'fa-layer-group', COLORS.success);
    html += chartCard('chartProgramas', 'Distribución Programas', 'fa-graduation-cap', COLORS.primary);
    html += '</div>';

    // ── Row 6: Top Empresas + Instructores Carga ──
    html += '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-bottom:24px;">';
    html += '<div class="chart-card"><h3><i class="fas fa-trophy" style="color:' + COLORS.warning + ';"></i> Top Empresas</h3><div id="topEmpresasContent" style="min-height:200px;"></div></div>';
    html += chartCard('chartInstructores', 'Carga de Instructores', 'fa-chalkboard-user', COLORS.indigo);
    html += '</div>';

    // ── Row 7: Compromiso Empresarial + Ofertas + Metricas ──
    html += '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:24px;margin-bottom:24px;">';
    html += chartCard('chartCompromiso', 'Compromiso Empresarial', 'fa-building', COLORS.orange);
    html += chartCard('chartOfertas', 'Distribución Ofertas', 'fa-briefcase', COLORS.pink);
    html += '<div class="chart-card"><h3><i class="fas fa-heartbeat" style="color:' + COLORS.primary + ';"></i> Salud de la Plataforma</h3><div id="saludContent" style="min-height:200px;display:flex;align-items:center;justify-content:center;"></div></div>';
    html += '</div>';

    // ── Row 8: Evidencias + Duración ──
    html += '<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">';
    html += '<div class="chart-card"><h3><i class="fas fa-file-alt" style="color:' + COLORS.teal + ';"></i> Estado de Evidencias</h3><div id="evidenciasContent" style="min-height:200px;"></div></div>';
    html += '<div class="chart-card"><h3><i class="fas fa-clock" style="color:' + COLORS.orange + ';"></i> Duración de Proyectos</h3><div id="duracionContent" style="min-height:200px;"></div></div>';
    html += '</div>';

    document.getElementById('analyticsContent').innerHTML = html;

    // ── Charts ──

    // 1. Tendencia Mensual
    var tendenciaData = data.proyectos_mensuales || {labels:[], data:[]};
    var postData = data.postulaciones_mensuales || {labels:[], data:[]};
    var userData = data.usuarios_mensuales || {labels:[], data:[]};
    charts.trend = new Chart(document.getElementById('chartTendencia'), {
        type: 'line',
        data: {
            labels: tendenciaData.labels,
            datasets: [
                { label: 'Proyectos', data: tendenciaData.data, borderColor: COLORS.success, backgroundColor: 'rgba(16,185,129,0.08)', borderWidth: 2.5, fill: true, tension: 0.4, pointRadius: 3, pointBackgroundColor: COLORS.success },
                { label: 'Postulaciones', data: postData.data, borderColor: COLORS.info, backgroundColor: 'rgba(59,130,246,0.08)', borderWidth: 2.5, fill: true, tension: 0.4, pointRadius: 3, pointBackgroundColor: COLORS.info },
                { label: 'Usuarios', data: userData.data, borderColor: COLORS.purple, backgroundColor: 'rgba(139,92,246,0.08)', borderWidth: 2.5, fill: true, tension: 0.4, pointRadius: 3, pointBackgroundColor: COLORS.purple }
            ]
        },
        options: chartOpts({ legend: true, yBeginZero: true })
    });

    // 2. Proyeccion Proyectos
    renderProyeccion('chartProyeccion', data.predicciones, COLORS.success, 'Proyectos');

    // 3. Proyeccion Postulaciones
    renderProyeccion('chartProyeccionPost', data.predicciones_postulaciones, COLORS.info, 'Postulaciones');

    // 4. Proyeccion Usuarios
    renderProyeccion('chartProyeccionUser', data.predicciones_usuarios, COLORS.purple, 'Usuarios');

    // 5. Estado Pie
    var estado = data.proyectos_por_estado || {labels:[], data:[]};
    charts.estado = new Chart(document.getElementById('chartEstadoPie'), {
        type: 'doughnut',
        data: {
            labels: estado.labels,
            datasets: [{ data: estado.data, backgroundColor: estado.labels.map(function(l) { return estadoColors[l.toLowerCase()] || '#94a3b8'; }), hoverOffset: 10, borderWidth: 0, borderRadius: 4, spacing: 3 }]
        },
        options: { cutout: '70%', responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, font: { size: 10, weight: '600' } } } } }
    });

    // 6. Funnel
    var funnel = data.postulaciones_funnel || {labels:[], data:[]};
    charts.funnel = new Chart(document.getElementById('chartFunnel'), {
        type: 'doughnut', data: { labels: funnel.labels, datasets: [{ data: funnel.data, backgroundColor: ['#f59e0b','#3b82f6','#10b981','#ef4444'], borderWidth: 0, borderRadius: 4, spacing: 3 }] },
        options: { cutout: '65%', responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, font: { size: 10, weight: '600' } } }, tooltip: { callbacks: { label: function(ctx) { var t = funnel.total || 1; return ctx.label + ': ' + ctx.parsed + ' (' + ((ctx.parsed/t)*100).toFixed(1) + '%)'; } } } } }
    });

    // 7. Registro detalle (stacked bar)
    var regDet = data.registro_mensual_detalle || {labels:[], aprendices:[], empresas:[]};
    if (regDet.labels && regDet.labels.length) {
        charts.regDet = new Chart(document.getElementById('chartRegistroDetalle'), {
            type: 'bar',
            data: {
                labels: regDet.labels,
                datasets: [
                    { label: 'Aprendices', data: regDet.aprendices, backgroundColor: 'rgba(99,102,241,0.75)', borderColor: '#6366f1', borderWidth: 1, borderRadius: 3 },
                    { label: 'Empresas', data: regDet.empresas, backgroundColor: 'rgba(16,185,129,0.75)', borderColor: '#10b981', borderWidth: 1, borderRadius: 3 },
                ]
            },
            options: chartOpts({ legend: true, stacked: true, yBeginZero: true })
        });
    } else {
        showEmpty('chartRegistroDetalle');
    }

    // 8. Calidad Proyectos
    var calidad = data.calidad_proyectos || {labels:[], data:[]};
    if (calidad.labels && calidad.labels.length) {
        var calidadColors = ['#ef4444','#f59e0b','#f97316','#3b82f6','#10b981'];
        charts.calidad = new Chart(document.getElementById('chartCalidad'), {
            type: 'bar',
            data: {
                labels: calidad.labels,
                datasets: [{ label: 'Proyectos', data: calidad.data, backgroundColor: calidad.labels.map(function(_,i) { return calidadColors[i] || '#94a3b8'; }), borderRadius: 4 }]
            },
            options: chartOpts({ legend: false, yBeginZero: true })
        });
    } else {
        showEmpty('chartCalidad');
    }

    // 9. Categorias Rendimiento
    var cats = data.categorias_rendimiento || [];
    if (cats.length) {
        var catLabels = cats.map(function(c) { return c.categoria.length > 18 ? c.categoria.substring(0,16)+'..' : c.categoria; });
        charts.cats = new Chart(document.getElementById('chartCategorias'), {
            type: 'bar',
            data: {
                labels: catLabels,
                datasets: [
                    { label: 'Total', data: cats.map(function(c) { return c.total; }), backgroundColor: 'rgba(99,102,241,0.5)', borderRadius: 4 },
                    { label: 'Completados', data: cats.map(function(c) { return c.completados; }), backgroundColor: 'rgba(16,185,129,0.8)', borderRadius: 4 },
                ]
            },
            options: chartOpts({ legend: true, stacked: false, yBeginZero: true, indexAxis: 'y' })
        });
    } else {
        showEmpty('chartCategorias');
    }

    // 10. Programas Distribution
    var progs = data.programas_distribucion || [];
    if (progs.length) {
        charts.progs = new Chart(document.getElementById('chartProgramas'), {
            type: 'bar',
            data: {
                labels: progs.map(function(p) { return p.label; }),
                datasets: [{ label: 'Aprendices', data: progs.map(function(p) { return p.total; }), backgroundColor: palette.slice(0, progs.length), borderRadius: 4 }]
            },
            options: chartOpts({ legend: false, yBeginZero: true, indexAxis: 'y' })
        });
    } else {
        showEmpty('chartProgramas');
    }

    // 11. Top Empresas
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
        empContent.innerHTML = '<div style="text-align:center;padding:60px;color:#94a3b8;font-size:12px;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Sin datos</div>';
    }

    // 12. Instructores Carga
    var inst = data.instructores_carga || [];
    var ctxIns = document.getElementById('chartInstructores');
    if (ctxIns && inst.length) {
        charts.inst = new Chart(ctxIns, {
            type: 'bar', data: { labels: inst.map(function(i) { return i.nombre.length > 20 ? i.nombre.substring(0,18)+'..' : i.nombre; }), datasets: [{ label: 'Proyectos', data: inst.map(function(i) { return i.total; }), backgroundColor: ['rgba(99,102,241,0.7)','rgba(59,130,246,0.7)','rgba(16,185,129,0.7)','rgba(245,158,11,0.7)','rgba(244,63,94,0.7)','rgba(139,92,246,0.7)','rgba(6,182,212,0.7)','rgba(236,72,153,0.7)','rgba(168,85,247,0.7)','rgba(251,146,60,0.7)'], borderWidth: 0, borderRadius: 4 }] },
            options: chartOpts({ legend: false, yBeginZero: true, indexAxis: 'y' })
        });
    } else if (ctxIns) {
        showEmpty('chartInstructores');
    }

    // 13. Compromiso Empresarial
    var comp = data.empresas_compromiso || {};
    var compTotal = (comp.activas || 0) + (comp.inactivas || 0) || 1;
    var compData = [comp.activas || 0, comp.inactivas || 0, comp.con_proyectos || 0, comp.sin_proyectos || 0];
    charts.compromiso = new Chart(document.getElementById('chartCompromiso'), {
        type: 'doughnut',
        data: {
            labels: ['Activas', 'Inactivas', 'Con Proyectos', 'Sin Proyectos'],
            datasets: [{ data: compData, backgroundColor: ['#10b981','#ef4444','#6366f1','#94a3b8'], borderWidth: 0, borderRadius: 4, spacing: 3 }]
        },
        options: { cutout: '65%', responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 10, font: { size: 9, weight: '600' } } } } }
    });

    // 14. Ofertas
    var ofertas = data.ofertas_distribucion || {labels:[], data:[]};
    if (ofertas.labels && ofertas.labels.length) {
        charts.ofertas = new Chart(document.getElementById('chartOfertas'), {
            type: 'doughnut', data: { labels: ofertas.labels, datasets: [{ data: ofertas.data, backgroundColor: ['#6366f1','#10b981','#f59e0b','#ef4444','#8b5cf6'], borderWidth: 0, borderRadius: 4, spacing: 3 }] },
            options: { cutout: '65%', responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 10, font: { size: 9, weight: '600' } } } } }
        });
    } else {
        showEmpty('chartOfertas');
    }

    // 15. Salud Plataforma
    renderSalud(puntajeSalud, metricasGlobales);

    // 16. Evidencias stats
    renderEvidencias(data.evidencias_stats);

    // 17. Duracion proyectos
    renderDuracion(data.duracion_promedio);
}

function statCard(val, label, color, icon, change, direction) {
    var changeHtml = '';
    if (change !== null && change !== undefined) {
        var dirClass = direction === 'up' ? 'up' : (direction === 'down' ? 'down' : 'flat');
        var arrow = direction === 'up' ? '▲' : (direction === 'down' ? '▼' : '―');
        changeHtml = '<div class="analytics-stat-change ' + dirClass + '">' + arrow + ' ' + Math.abs(change) + '% vs mes ant.</div>';
    }
    return '<div class="analytics-stat-card">\
        <div class="stat-icon" style="background:' + color + ';"><i class="' + icon + '"></i></div>\
        <div class="analytics-stat-value" style="color:' + color + ';">' + val + '</div>\
        <div class="analytics-stat-label">' + label + '</div>\
        ' + changeHtml + '</div>';
}

function chartCard(canvasId, title, icon, color, tall) {
    var cls = tall ? 'chart-card tall' : 'chart-card';
    return '<div class="' + cls + '"><h3><i class="fas ' + icon + '" style="color:' + color + ';"></i> ' + title + '</h3><div class="chart-container"><canvas id="' + canvasId + '"></canvas></div></div>';
}

function chartOpts(opts) {
    return {
        responsive: true, maintainAspectRatio: false,
        indexAxis: opts.indexAxis || 'x',
        plugins: {
            legend: opts.legend ? { position: 'bottom', labels: { usePointStyle: true, padding: 15, font: { size: 10, weight: '600' } } } : { display: false },
            tooltip: { backgroundColor: 'rgba(255,255,255,0.95)', titleColor: '#1e293b', bodyColor: '#1e293b', padding: 12, borderColor: '#e2e8f0', borderWidth: 1, cornerRadius: 12 }
        },
        scales: {
            y: { beginAtZero: opts.yBeginZero !== false, stacked: opts.stacked || false, grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { size: 10 } } },
            x: { stacked: opts.stacked || false, grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 10 } } }
        }
    };
}

function renderProyeccion(canvasId, pred, color, label) {
    var canvas = document.getElementById(canvasId);
    if (!canvas) return;
    if (pred && pred.historico && pred.historico.length) {
        var allLabels = (pred.labels_meses || []).concat(pred.labels_pred || []);
        var allData = (pred.historico || []).concat(pred.predicciones || []);
        var split = (pred.historico || []).length;
        charts[canvasId] = new Chart(canvas, {
            type: 'line',
            data: {
                labels: allLabels,
                datasets: [{
                    label: label, data: allData,
                    borderColor: color, backgroundColor: hexToRgba(color, 0.12),
                    borderWidth: 2, fill: true, tension: 0.4, pointRadius: 3,
                    segment: { borderDash: function(ctx) { return ctx.p1DataIndex >= split ? [5,5] : []; } }
                }]
            },
            options: chartOpts({ yBeginZero: true })
        });
    } else {
        var parent = canvas.parentElement;
        if (parent) parent.innerHTML = '<div style="text-align:center;padding:60px 20px;color:#94a3b8;font-size:12px;font-weight:600;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Datos insuficientes</div>';
    }
}

function renderSalud(puntaje, metricas) {
    var el = document.getElementById('saludContent');
    if (!el) return;
    var color = puntaje >= 80 ? '#10b981' : (puntaje >= 60 ? '#f59e0b' : (puntaje >= 40 ? '#f97316' : '#ef4444'));
    var nivel = puntaje >= 80 ? 'Excelente' : (puntaje >= 60 ? 'Bueno' : (puntaje >= 40 ? 'Regular' : 'Crítico'));

    var circumference = 2 * Math.PI * 55;
    var offset = circumference - (puntaje / 100) * circumference;

    el.innerHTML = '<div style="text-align:center;">\
        <div class="health-gauge" style="margin-bottom:16px;">\
            <svg width="140" height="140" viewBox="0 0 140 140">\
                <circle cx="70" cy="70" r="55" fill="none" stroke="#f1f5f9" stroke-width="10"/>\
                <circle cx="70" cy="70" r="55" fill="none" stroke="' + color + '" stroke-width="10" stroke-linecap="round"\
                    stroke-dasharray="' + circumference + '" stroke-dashoffset="' + offset + '" transform="rotate(-90 70 70)" style="transition: stroke-dashoffset 1s ease;"/>\
            </svg>\
            <div style="position:absolute;top:0;left:0;width:100%;height:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;">\
                <span style="font-size:32px;font-weight:900;color:' + color + ';">' + puntaje + '%</span>\
            </div>\
        </div>\
        <div style="font-size:12px;font-weight:800;color:' + color + ';text-transform:uppercase;letter-spacing:0.5px;margin-bottom:16px;">' + nivel + '</div>\
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;text-align:center;">\
            <div style="padding:8px;background:#f8fafc;border-radius:8px;"><div style="font-size:16px;font-weight:800;color:var(--text);">' + (metricas.completados || 0) + '</div><div style="font-size:9px;color:#94a3b8;font-weight:600;">Completados</div></div>\
            <div style="padding:8px;background:#f8fafc;border-radius:8px;"><div style="font-size:16px;font-weight:800;color:var(--text);">' + (metricas.tasa_completados || 0) + '%</div><div style="font-size:9px;color:#94a3b8;font-weight:600;">Tasa Comp.</div></div>\
            <div style="padding:8px;background:#f8fafc;border-radius:8px;"><div style="font-size:16px;font-weight:800;color:var(--text);">' + (metricas.activos || 0) + '</div><div style="font-size:9px;color:#94a3b8;font-weight:600;">Activos</div></div>\
            <div style="padding:8px;background:#f8fafc;border-radius:8px;"><div style="font-size:16px;font-weight:800;color:var(--text);">' + (metricas.tasa_actividad || 0) + '%</div><div style="font-size:9px;color:#94a3b8;font-weight:600;">Actividad</div></div>\
        </div>\
    </div>';
    el.style.display = 'flex';
    el.style.alignItems = 'center';
    el.style.justifyContent = 'center';
}

function renderEvidencias(ev) {
    var el = document.getElementById('evidenciasContent');
    if (!el) return;
    ev = ev || {};
    var total = ev.total || 0;
    if (!total) {
        el.innerHTML = '<div style="text-align:center;padding:60px;color:#94a3b8;font-size:12px;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Sin evidencias</div>';
        return;
    }
    var pctAce = total > 0 ? ((ev.aceptadas||0)/total*100).toFixed(0) : 0;
    var pctPen = total > 0 ? ((ev.pendientes||0)/total*100).toFixed(0) : 0;
    var pctRech = total > 0 ? ((ev.rechazadas||0)/total*100).toFixed(0) : 0;

    el.innerHTML = '<div style="display:flex;flex-direction:column;gap:12px;">\
        <div class="evidencia-stat"><div class="dot" style="background:#10b981;"></div>\
            <div style="flex:1;"><div style="font-weight:700;font-size:12px;color:var(--text);">' + (ev.aceptadas||0) + ' Aprobadas</div>\
            <div style="height:6px;background:#f1f5f9;border-radius:3px;margin-top:4px;"><div style="height:100%;width:' + pctAce + '%;background:#10b981;border-radius:3px;transition:width 0.8s;"></div></div></div>\
            <span style="font-size:10px;font-weight:700;color:#10b981;">' + pctAce + '%</span></div>\
        <div class="evidencia-stat"><div class="dot" style="background:#f59e0b;"></div>\
            <div style="flex:1;"><div style="font-weight:700;font-size:12px;color:var(--text);">' + (ev.pendientes||0) + ' Pendientes</div>\
            <div style="height:6px;background:#f1f5f9;border-radius:3px;margin-top:4px;"><div style="height:100%;width:' + pctPen + '%;background:#f59e0b;border-radius:3px;transition:width 0.8s;"></div></div></div>\
            <span style="font-size:10px;font-weight:700;color:#f59e0b;">' + pctPen + '%</span></div>\
        <div class="evidencia-stat"><div class="dot" style="background:#ef4444;"></div>\
            <div style="flex:1;"><div style="font-weight:700;font-size:12px;color:var(--text);">' + (ev.rechazadas||0) + ' Rechazadas</div>\
            <div style="height:6px;background:#f1f5f9;border-radius:3px;margin-top:4px;"><div style="height:100%;width:' + pctRech + '%;background:#ef4444;border-radius:3px;transition:width 0.8s;"></div></div></div>\
            <span style="font-size:10px;font-weight:700;color:#ef4444;">' + pctRech + '%</span></div>\
        <div style="margin-top:8px;text-align:center;font-size:10px;color:#94a3b8;font-weight:600;">Total: ' + total + ' evidencias</div>\
    </div>';
}

function renderDuracion(dur) {
    var el = document.getElementById('duracionContent');
    if (!el) return;
    dur = dur || {};
    if (!dur.promedio_dias) {
        el.innerHTML = '<div style="text-align:center;padding:60px;color:#94a3b8;font-size:12px;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Sin datos de duración</div>';
        return;
    }
    el.innerHTML = '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">\
        <div style="text-align:center;padding:20px 12px;background:linear-gradient(135deg,#6366f1,#818cf8);border-radius:14px;">\
            <div style="font-size:28px;font-weight:900;color:white;">' + dur.promedio_dias + '</div>\
            <div style="font-size:10px;color:rgba(255,255,255,0.8);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Promedio (días)</div></div>\
        <div style="text-align:center;padding:20px 12px;background:linear-gradient(135deg,#10b981,#34d399);border-radius:14px;">\
            <div style="font-size:28px;font-weight:900;color:white;">' + (dur.minimo_dias || 0) + '</div>\
            <div style="font-size:10px;color:rgba(255,255,255,0.8);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Mínimo (días)</div></div>\
        <div style="text-align:center;padding:20px 12px;background:linear-gradient(135deg,#f59e0b,#fbbf24);border-radius:14px;">\
            <div style="font-size:28px;font-weight:900;color:white;">' + (dur.maximo_dias || 0) + '</div>\
            <div style="font-size:10px;color:rgba(255,255,255,0.8);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Máximo (días)</div></div>\
        <div style="text-align:center;padding:20px 12px;background:linear-gradient(135deg,#8b5cf6,#a78bfa);border-radius:14px;">\
            <div style="font-size:28px;font-weight:900;color:white;">' + (dur.con_duracion || 0) + '</div>\
            <div style="font-size:10px;color:rgba(255,255,255,0.8);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Con duración</div></div>\
    </div>';
}

function showEmpty(canvasId) {
    var canvas = document.getElementById(canvasId);
    if (canvas) {
        var parent = canvas.parentElement;
        if (parent) parent.innerHTML = '<div style="text-align:center;padding:60px 20px;color:#94a3b8;font-size:12px;font-weight:600;"><i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>Sin datos</div>';
    }
}

function hexToRgba(hex, alpha) {
    var r = parseInt(hex.slice(1,3), 16);
    var g = parseInt(hex.slice(3,5), 16);
    var b = parseInt(hex.slice(5,7), 16);
    return 'rgba(' + r + ',' + g + ',' + b + ',' + alpha + ')';
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
                rows.push(['Promedio mensual proyectos', data.predicciones.promedio_mensual || 0]);
                rows.push(['Proyectado anual proyectos', data.predicciones.proyectado_anual || 0]);
            }
            if (data.predicciones_postulaciones) {
                rows.push(['Promedio mensual postulaciones', data.predicciones_postulaciones.promedio_mensual || 0]);
                rows.push(['Proyectado anual postulaciones', data.predicciones_postulaciones.proyectado_anual || 0]);
            }
            if (data.metricas_globales) {
                rows.push(['Salud plataforma', data.metricas_globales.puntaje + '%']);
            }
            if (data.evidencias_stats) {
                rows.push(['Evidencias totales', data.evidencias_stats.total || 0]);
                rows.push(['Evidencias aprobadas', data.evidencias_stats.aceptadas || 0]);
            }
            if (data.empresas_compromiso) {
                rows.push(['Empresas activas', data.empresas_compromiso.activas || 0]);
                rows.push(['Empresas con proyectos', data.empresas_compromiso.con_proyectos || 0]);
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
