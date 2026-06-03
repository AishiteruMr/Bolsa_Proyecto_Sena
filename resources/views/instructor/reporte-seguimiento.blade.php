@extends('layouts.dashboard')

@section('title', 'Reporte de Seguimiento | ' . $proyecto->titulo)
@section('page-title', 'Reporte de Seguimiento')

@section('sidebar-nav')
    <a href="{{ route('instructor.dashboard') }}" class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Principal
    </a>
    <a href="{{ route('instructor.proyectos') }}" class="nav-item {{ request()->routeIs('instructor.proyectos*') ? 'active' : '' }}">
        <i class="fas fa-project-diagram"></i> Mis Proyectos
    </a>
    <a href="{{ route('instructor.historial') }}" class="nav-item {{ request()->routeIs('instructor.historial') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Historial
    </a>
    <a href="{{ route('instructor.aprendices') }}" class="nav-item {{ request()->routeIs('instructor.aprendices') ? 'active' : '' }}">
        <i class="fas fa-users"></i> Aprendices
    </a>
    <span class="nav-label">Cuenta</span>
    <a href="{{ route('instructor.perfil') }}" class="nav-item {{ request()->routeIs('instructor.perfil') ? 'active' : '' }}">
        <i class="fas fa-user-circle"></i> Mi Perfil
    </a>
@endsection

@php
    $breadcrumbs = [
        ['label' => 'Inicio', 'url' => route('instructor.dashboard')],
        ['label' => 'Reporte']
    ];

    $totalAprobados = $evidencias->where('estado', 'aceptada')->count();
    $totalPendientes = $evidencias->where('estado', 'pendiente')->count();
    $totalRechazados = $evidencias->where('estado', 'rechazada')->count();
    $totalEvidencias = $evidencias->count();
    $tasaAprobacion = $totalEvidencias > 0 ? round(($totalAprobados / $totalEvidencias) * 100) : 0;
    $tasaCompletitud = $etapas->count() > 0 && $aprendices->count() > 0
        ? round(($totalAprobados / ($etapas->count() * $aprendices->count())) * 100)
        : 0;
    $diasTranscurridos = $proyecto->fecha_publicacion
        ? (int) \Carbon\Carbon::parse($proyecto->fecha_publicacion)->diffInDays(now())
        : 0;
    $duracionTotal = $proyecto->duracion_estimada_dias ?? 1;
    $porcentajeTiempo = min(100, round(($diasTranscurridos / $duracionTotal) * 100));

    $puntajeCalidad = min(100, max(0,
        ($tasaAprobacion * 0.4) +
        ($tasaCompletitud * 0.35) +
        (($etapas->count() > 0 ? min(100, ($totalAprobados / $etapas->count()) * 20) : 0) * 0.25)
    ));

    $letraCalidad = $puntajeCalidad >= 90 ? 'A+' : ($puntajeCalidad >= 80 ? 'A' : ($puntajeCalidad >= 70 ? 'B+' : ($puntajeCalidad >= 60 ? 'B' : ($puntajeCalidad >= 50 ? 'C' : 'D'))));
@endphp

@section('content')
<div class="rp-container">

    {{-- ═══ HEADER ═══ --}}
    <div class="rp-header">
        <div>
            <a href="{{ route('instructor.proyecto.detalle', $proyecto->id) }}" class="rp-back">
                <i class="fas fa-arrow-left"></i> Volver a la Gestión
            </a>
            <h2 class="rp-title">Auditoría de Progreso</h2>
            <p class="rp-desc">{{ $proyecto->titulo }} @if($proyecto->categoria)<span class="rp-tag">{{ $proyecto->categoria }}</span>@endif</p>
        </div>
        <button id="btnExportarPDF" class="btn-premium" style="flex-shrink:0;padding:10px 24px;font-size:0.85rem;">
            <i class="fas fa-file-pdf"></i> Exportar PDF
        </button>
    </div>

    {{-- ═══ STATS ═══ --}}
    <div class="rp-stats">
        <div class="rp-stat">
            <div class="rp-stat-icon" style="color:#3b82f6;"><i class="fas fa-user-graduate"></i></div>
            <div>
                <div class="rp-stat-num">{{ $aprendices->count() }}</div>
                <div class="rp-stat-lbl">Aprendices</div>
            </div>
        </div>
        <div class="rp-stat">
            <div class="rp-stat-icon" style="color:#10b981;"><i class="fas fa-cloud-upload-alt"></i></div>
            <div>
                <div class="rp-stat-num">{{ $totalEvidencias }}</div>
                <div class="rp-stat-lbl">Entregables</div>
            </div>
        </div>
        <div class="rp-stat">
            <div class="rp-stat-icon" style="color:#22c55e;"><i class="fas fa-award"></i></div>
            <div>
                <div class="rp-stat-num">{{ $totalAprobados }}</div>
                <div class="rp-stat-lbl">Aprobados</div>
            </div>
        </div>
        <div class="rp-stat">
            <div class="rp-stat-icon" style="color:#f59e0b;"><i class="fas fa-clock"></i></div>
            <div>
                <div class="rp-stat-num">{{ $totalPendientes }}</div>
                <div class="rp-stat-lbl">Pendientes</div>
            </div>
        </div>
        <div class="rp-stat">
            <div class="rp-stat-icon" style="color:#ef4444;"><i class="fas fa-ban"></i></div>
            <div>
                <div class="rp-stat-num">{{ $totalRechazados }}</div>
                <div class="rp-stat-lbl">Rechazados</div>
            </div>
        </div>
        <div class="rp-stat">
            <div class="rp-stat-icon" style="color:#8b5cf6;"><i class="fas fa-tasks"></i></div>
            <div>
                <div class="rp-stat-num">{{ $etapas->count() }}</div>
                <div class="rp-stat-lbl">Etapas</div>
            </div>
        </div>
    </div>

    {{-- ═══ PROGRESS BAR ═══ --}}
    @if($totalEvidencias > 0)
    <div class="rp-progress">
        <div class="rp-progress-bar">
            <div class="rp-progress-seg" style="width:{{ ($totalAprobados/$totalEvidencias)*100 }}%;background:#22c55e;" title="Aprobados {{ $totalAprobados }}"></div>
            <div class="rp-progress-seg" style="width:{{ ($totalPendientes/$totalEvidencias)*100 }}%;background:#f59e0b;" title="Pendientes {{ $totalPendientes }}"></div>
            <div class="rp-progress-seg" style="width:{{ ($totalRechazados/$totalEvidencias)*100 }}%;background:#ef4444;" title="Rechazados {{ $totalRechazados }}"></div>
        </div>
        <div class="rp-progress-lbl">
            <span><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#22c55e;margin-right:4px;"></span>{{ round(($totalAprobados/$totalEvidencias)*100) }}% aprobado</span>
            <span><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#f59e0b;margin-right:4px;"></span>{{ round(($totalPendientes/$totalEvidencias)*100) }}% pendiente</span>
            <span><span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#ef4444;margin-right:4px;"></span>{{ round(($totalRechazados/$totalEvidencias)*100) }}% rechazado</span>
        </div>
    </div>
    @endif

    {{-- ═══ MAIN LAYOUT ═══ --}}
    <div class="rp-grid">

        {{-- LEFT --}}
        <div class="rp-left">

            {{-- ─── MATRIZ DE RENDIMIENTO ─── --}}
            <div class="rp-card">
                <div class="rp-card-hd">
                    <i class="fas fa-chart-line" style="color:#3b82f6;"></i>
                    <h3>Rendimiento por Aprendiz</h3>
                </div>

                @if($aprendices->count() > 0)
                <div class="rp-tbl-wrap">
                    <table class="rp-tbl">
                        <thead>
                            <tr>
                                <th>Aprendiz</th>
                                <th class="rp-tc">Entregas</th>
                                <th class="rp-tc">Aprob.</th>
                                <th class="rp-tc">Pend.</th>
                                <th class="rp-tc">Rech.</th>
                                <th>Progreso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aprendices as $aprendiz)
                                @php
                                    $e_count = $entregas->where('aprendiz_id', $aprendiz->id)->count();
                                    $a_count = $evidencias->where('aprendiz_id', $aprendiz->id)->where('estado', 'aceptada')->count();
                                    $p_count = $evidencias->where('aprendiz_id', $aprendiz->id)->where('estado', 'pendiente')->count();
                                    $r_count = $evidencias->where('aprendiz_id', $aprendiz->id)->where('estado', 'rechazada')->count();
                                    $progreso = $etapas->count() > 0 ? min(100, round(($a_count / $etapas->count()) * 100)) : 0;
                                    $correo = $aprendiz->usuario ? $aprendiz->usuario->correo : 'N/A';
                                @endphp
                                <tr class="rp-row" onclick="toggleRow(this)">
                                    <td>
                                        <div class="rp-user">
                                            <div class="rp-avatar">{{ strtoupper(substr($aprendiz->nombres,0,1).substr($aprendiz->apellidos,0,1)) }}</div>
                                            <div>
                                                <div class="rp-name">{{ $aprendiz->nombres }} {{ $aprendiz->apellidos }}</div>
                                                <div class="rp-sub">{{ $correo }}</div>
                                                @if($aprendiz->programa_formacion)<div class="rp-sub" style="color:var(--primary);font-weight:600;">{{ $aprendiz->programa_formacion }}</div>@endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="rp-tc">{{ $e_count }}</td>
                                    <td class="rp-tc"><span class="rp-bdg rp-bdg-ok">{{ $a_count }}</span></td>
                                    <td class="rp-tc"><span class="rp-bdg rp-bdg-warn">{{ $p_count }}</span></td>
                                    <td class="rp-tc"><span class="rp-bdg rp-bdg-err">{{ $r_count }}</span></td>
                                    <td>
                                        <div class="rp-prog">
                                            <div class="rp-prog-track"><div class="rp-prog-fill" style="width:{{ $progreso }}%;"></div></div>
                                            <span class="rp-prog-pct">{{ $progreso }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="rp-detail" style="display:none;">
                                    <td colspan="6">
                                        <div class="rp-detail-inner">
                                            @foreach($etapas as $etapa)
                                                @php $evStage = $evidencias->where('aprendiz_id', $aprendiz->id)->where('etapa_id', $etapa->id)->first(); @endphp
                                                <div class="rp-etapa-mini">
                                                    <div class="rp-em-header">
                                                        <span class="rp-em-num">{{ $etapa->orden }}</span>
                                                        <span>{{ $etapa->nombre }}</span>
                                                    </div>
                                                    @if($evStage)
                                                        <div class="rp-em-status" style="color:{{ match($evStage->estado){'aceptada'=>'#22c55e','rechazada'=>'#ef4444','pendiente'=>'#f59e0b',default=>'#94a3b8'} }};">
                                                            <i class="fas {{ match($evStage->estado){'aceptada'=>'fa-check-circle','rechazada'=>'fa-times-circle','pendiente'=>'fa-hourglass-half',default=>'fa-circle'} }}"></i>
                                                            {{ Str::title($evStage->estado) }}
                                                        </div>
                                                        @if($evStage->fecha_envio)
                                                            <div class="rp-em-date"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($evStage->fecha_envio)->format('d/m/Y') }}</div>
                                                        @endif
                                                    @else
                                                        <div class="rp-em-empty"><i class="fas fa-minus-circle"></i> Sin entrega</div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="rp-empty">No hay aprendices asignados a este proyecto.</div>
                @endif
            </div>

            {{-- ─── BITÁCORA POR ETAPAS ─── --}}
            <div class="rp-card">
                <div class="rp-card-hd">
                    <i class="fas fa-layer-group" style="color:#8b5cf6;"></i>
                    <h3>Bitácora por Etapas</h3>
                </div>

                @if($etapas->count() > 0)
                <div class="rp-accs">
                    @foreach($etapas as $etapa)
                        @php
                            $etapaEntregas = $entregas->where('etapa_id', $etapa->id);
                            $etapaEvidencias = $evidencias->where('etapa_id', $etapa->id);
                            $etapaAprobadas = $etapaEvidencias->where('estado', 'aceptada')->count();
                        @endphp
                        <div class="rp-acc">
                            <div class="rp-acc-hd" onclick="toggleAcc(this)">
                                <div class="rp-acc-hd-l">
                                    <span class="rp-acc-num">{{ $etapa->orden }}</span>
                                    <div>
                                        <div class="rp-acc-title">{{ $etapa->nombre }}</div>
                                        <div class="rp-acc-meta">{{ $etapaEntregas->count() }} entregas @if($etapaAprobadas > 0)&middot; {{ $etapaAprobadas }} aprobadas @endif</div>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-down rp-acc-chev"></i>
                            </div>
                            <div class="rp-acc-body">
                                <div class="rp-acc-inner">
                                    @if($etapa->descripcion)
                                        <div class="rp-acc-desc">{{ $etapa->descripcion }}</div>
                                    @endif

                                    @if($etapa->documentos_requeridos && count($etapa->documentos_requeridos) > 0)
                                        <div class="rp-docs">
                                            <strong>Documentos requeridos:</strong>
                                            @foreach($etapa->documentos_requeridos as $doc)
                                                <span class="rp-doc">{{ $doc }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($etapa->url_documento)
                                        <div style="margin-bottom:16px;">
                                            <a href="{{ asset('storage/'.$etapa->url_documento) }}" target="_blank" class="rp-link"><i class="fas fa-download"></i> Descargar guía de la etapa</a>
                                        </div>
                                    @endif

                                    @if($etapaEntregas->count() > 0)
                                        <div class="rp-subs">
                                            <div class="rp-subs-label">Entregas por aprendiz</div>
                                            @foreach($etapaEntregas as $e)
                                                @php
                                                    $ev = $evidencias->where('etapa_id', $etapa->id)->where('aprendiz_id', $e->aprendiz_id)->first();
                                                    $st = $ev ? match($ev->estado) {
                                                        'aceptada' => ['c'=>'#22c55e','bg'=>'#f0fdf4','i'=>'fa-check-circle'],
                                                        'rechazada' => ['c'=>'#ef4444','bg'=>'#fef2f2','i'=>'fa-times-circle'],
                                                        'pendiente' => ['c'=>'#f59e0b','bg'=>'#fffbeb','i'=>'fa-hourglass-half'],
                                                        default => ['c'=>'#94a3b8','bg'=>'#f8fafc','i'=>'fa-circle'],
                                                    } : null;
                                                @endphp
                                                <div class="rp-sub">
                                                    <div class="rp-sub-top">
                                                        <div class="rp-sub-av">{{ strtoupper(substr($e->aprendiz_nombres ?? '?',0,1)) }}</div>
                                                        <div class="rp-sub-info">
                                                            <span class="rp-sub-name">{{ $e->aprendiz_nombres ?? '' }} {{ $e->aprendiz_apellidos ?? '' }}</span>
                                                            @if($ev && $ev->fecha_envio)
                                                                <span class="rp-sub-date"><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($ev->fecha_envio)->format('d/m/Y H:i') }}</span>
                                                            @endif
                                                        </div>
                                                        @if($st)
                                                            <span class="rp-sub-bdg" style="color:{{ $st['c'] }};background:{{ $st['bg'] }};"><i class="fas {{ $st['i'] }}"></i> {{ Str::title(str_replace('_',' ',$ev->estado)) }}</span>
                                                        @else
                                                            <span class="rp-sub-bdg" style="color:#94a3b8;background:#f8fafc;"><i class="fas fa-circle"></i> Sin evaluar</span>
                                                        @endif
                                                    </div>
                                                    <div class="rp-sub-bot">
                                                        @if($ev && $ev->ruta_archivo)
                                                            <a href="{{ asset('storage/'.$ev->ruta_archivo) }}" target="_blank" class="rp-file"><i class="fas fa-paperclip"></i> Ver archivo</a>
                                                        @endif
                                                        @if($ev && $ev->comentario_instructor)
                                                            <span class="rp-cmt"><i class="fas fa-comment"></i> {{ $ev->comentario_instructor }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="rp-empty" style="padding:20px;">Sin entregas en esta etapa.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                    <div class="rp-empty">No se han definido etapas.</div>
                @endif
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="rp-right">
            <div class="rp-sticky">

                <div class="rp-card">
                    <div class="rp-card-hd">
                        <i class="fas fa-clipboard-list" style="color:var(--primary);"></i>
                        <h3>Ficha Técnica</h3>
                    </div>
                    <div class="rp-sb-body">

                        <div class="rp-sb-field">
                            <div class="rp-sb-lbl">Estado</div>
                            @php
                                $sS = match($proyecto->estado) {
                                    'completado' => ['bg'=>'#065f46','i'=>'fa-check-double'],
                                    'aprobado' => ['bg'=>'#10b981','i'=>'fa-check'],
                                    'pendiente' => ['bg'=>'#f59e0b','i'=>'fa-clock'],
                                    'rechazado' => ['bg'=>'#ef4444','i'=>'fa-ban'],
                                    'cerrado' => ['bg'=>'#64748b','i'=>'fa-lock'],
                                    'en_progreso' => ['bg'=>'#3b82f6','i'=>'fa-spinner fa-spin'],
                                    default => ['bg'=>'#64748b','i'=>'fa-info-circle'],
                                };
                            @endphp
                            <span class="rp-bdg-status" style="background:{{ $sS['bg'] }};"><i class="fas {{ $sS['i'] }}"></i> {{ Str::title(str_replace('_',' ',$proyecto->estado)) }}</span>
                        </div>

                        <div class="rp-div"></div>

                        @if($proyecto->empresa)
                        <div class="rp-sb-field">
                            <div class="rp-sb-lbl">Empresa</div>
                            <div class="rp-sb-val"><i class="fas fa-building"></i> {{ $proyecto->empresa->nombre }}</div>
                            @if($proyecto->empresa->correo_contacto)<div class="rp-sb-sub"><i class="fas fa-envelope"></i> {{ $proyecto->empresa->correo_contacto }}</div>@endif
                        </div>
                        <div class="rp-div"></div>
                        @endif

                        @if($proyecto->instructor)
                        <div class="rp-sb-field">
                            <div class="rp-sb-lbl">Instructor</div>
                            <div class="rp-sb-val"><i class="fas fa-chalkboard-teacher"></i> {{ $proyecto->instructor->nombres }} {{ $proyecto->instructor->apellidos }}</div>
                            @if($proyecto->instructor->especialidad)<div class="rp-sb-sub"><i class="fas fa-microchip"></i> {{ $proyecto->instructor->especialidad }}</div>@endif
                        </div>
                        <div class="rp-div"></div>
                        @endif

                        <div class="rp-sb-field">
                            <div class="rp-sb-lbl">Categoría</div>
                            <div class="rp-sb-val">{{ $proyecto->categoria ?? 'General' }}</div>
                        </div>

                        @if($proyecto->ubicacion)
                        <div class="rp-div"></div>
                        <div class="rp-sb-field">
                            <div class="rp-sb-lbl">Ubicación</div>
                            <div class="rp-sb-val"><i class="fas fa-map-marker-alt"></i> {{ $proyecto->ubicacion }}</div>
                        </div>
                        @endif

                        @if($proyecto->oferta)
                        <div class="rp-div"></div>
                        <div class="rp-sb-field">
                            <div class="rp-sb-lbl">Beneficio</div>
                            <span class="rp-offer"><i class="fas fa-gift"></i>
                                @switch($proyecto->oferta)
                                    @case('pasantias') Pasantías @break
                                    @case('contrato_aprendizaje') Contrato aprendizaje @break
                                    @case('auxilio_transporte') Auxilio transporte @break
                                    @case('otro') {{ $proyecto->oferta_otro }} @break
                                @endswitch
                            </span>
                        </div>
                        @endif

                        <div class="rp-div"></div>
                        <div class="rp-sb-field">
                            <div class="rp-sb-lbl">Cronograma</div>
                            <div class="rp-crono">
                                <div class="rp-crono-row"><span>Inicio:</span><strong>{{ $proyecto->fecha_publicacion ? \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d/m/Y') : 'Por definir' }}</strong></div>
                                <div class="rp-crono-row"><span>Cierre:</span><strong>{{ $proyecto->fecha_publicacion && $proyecto->duracion_estimada_dias ? \Carbon\Carbon::parse($proyecto->fecha_publicacion)->addDays($proyecto->duracion_estimada_dias)->format('d/m/Y') : 'Por definir' }}</strong></div>
                                <div class="rp-crono-row"><span>Duración:</span><strong>{{ $proyecto->duracion_estimada_dias ?? 0 }} días</strong></div>
                                @if($diasTranscurridos > 0)<div class="rp-crono-row"><span>Transcurrido:</span><strong>{{ $diasTranscurridos }} días ({{ $porcentajeTiempo }}%)</strong></div>@endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rp-card">
                    <div class="rp-card-hd">
                        <i class="fas fa-chart-bar" style="color:var(--primary);"></i>
                        <h3>Métricas</h3>
                    </div>
                    <div class="rp-sb-body">
                        <div class="rp-mtr">
                            <div class="rp-mtr-hd"><span>Aprobación</span><strong>{{ $tasaAprobacion }}%</strong></div>
                            <div class="rp-mtr-bar"><div class="rp-mtr-fill" style="width:{{ $tasaAprobacion }}%;background:#22c55e;"></div></div>
                        </div>
                        <div class="rp-mtr">
                            <div class="rp-mtr-hd"><span>Completitud</span><strong>{{ $tasaCompletitud }}%</strong></div>
                            <div class="rp-mtr-bar"><div class="rp-mtr-fill" style="width:{{ $tasaCompletitud }}%;background:#3b82f6;"></div></div>
                        </div>
                        <div class="rp-mtr">
                            <div class="rp-mtr-hd"><span>Tiempo</span><strong>{{ $porcentajeTiempo }}%</strong></div>
                            <div class="rp-mtr-bar"><div class="rp-mtr-fill" style="width:{{ $porcentajeTiempo }}%;background:#8b5cf6;"></div></div>
                        </div>
                    </div>
                </div>

                <div class="rp-card" style="border-left:4px solid {{ $puntajeCalidad >= 80 ? '#22c55e' : ($puntajeCalidad >= 60 ? '#f59e0b' : '#ef4444') }};">
                    <div class="rp-card-hd">
                        <i class="fas fa-medal" style="color:{{ $puntajeCalidad >= 80 ? '#22c55e' : ($puntajeCalidad >= 60 ? '#f59e0b' : '#ef4444') }};"></i>
                        <h3>Calidad de Seguimiento</h3>
                    </div>
                    <div class="rp-sb-body" style="text-align:center;">
                        <div style="font-size:2.2rem;font-weight:900;color:{{ $puntajeCalidad >= 80 ? '#22c55e' : ($puntajeCalidad >= 60 ? '#f59e0b' : '#ef4444') }};">{{ $letraCalidad }}</div>
                        <div style="font-size:0.75rem;color:var(--text-light);margin-top:4px;">{{ round($puntajeCalidad) }}% &middot; Basado en entregas y aprobaciones</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* ── REPORTE - PALETA SISTEMA ── */
.rp-container { max-width: 1280px; margin: 0 auto; }

/* Header */
.rp-header { margin-bottom: 28px; display: flex; justify-content: space-between; align-items: flex-end; gap: 20px; }
.rp-back { color: var(--primary); text-decoration: none; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 8px; }
.rp-back:hover { gap: 10px; }
.rp-title { font-size: 26px; font-weight: 900; color: var(--text); }
.rp-desc { font-size: 14px; color: var(--text-light); margin-top: 2px; }
.rp-tag { display: inline-block; padding: 2px 10px; background: var(--primary-soft); color: var(--primary); border-radius: 12px; font-size: 0.7rem; font-weight: 700; margin-left: 8px; vertical-align: middle; }

/* Stats */
.rp-stats { display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px; margin-bottom: 24px; }
.rp-stat { background: white; border-radius: 14px; padding: 18px; display: flex; align-items: center; gap: 14px; border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.03); transition: all 0.2s; }
.rp-stat:hover { border-color: var(--primary-glow); box-shadow: 0 4px 16px var(--primary-soft); }
.rp-stat-icon { width: 40px; height: 40px; border-radius: 10px; background: var(--primary-soft); display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; border: 1px solid var(--border); }
.rp-stat-num { font-size: 1.4rem; font-weight: 900; color: var(--text); line-height: 1; }
.rp-stat-lbl { font-size: 0.68rem; font-weight: 700; color: var(--text-light); text-transform: uppercase; margin-top: 2px; }

/* Progress */
.rp-progress { background: white; border-radius: 14px; padding: 16px 20px; margin-bottom: 24px; border: 1px solid var(--border); }
.rp-progress-bar { height: 8px; background: #e8f0ec; border-radius: 4px; overflow: hidden; display: flex; margin-bottom: 8px; }
.rp-progress-seg { height: 100%; transition: width 0.5s; }
.rp-progress-lbl { display: flex; gap: 16px; font-size: 0.72rem; font-weight: 600; color: var(--text-light); flex-wrap: wrap; }

/* Grid */
.rp-grid { display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start; }
.rp-left { display: flex; flex-direction: column; gap: 24px; }
.rp-right { display: flex; flex-direction: column; gap: 20px; }
.rp-sticky { position: sticky; top: 110px; display: flex; flex-direction: column; gap: 20px; }

/* Cards */
.rp-card { background: white; border-radius: 16px; border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.03); overflow: hidden; transition: all 0.2s; }
.rp-card:hover { border-color: var(--primary-glow); }
.rp-card-hd { display: flex; align-items: center; gap: 10px; padding: 18px 22px 0; }
.rp-card-hd i { font-size: 1.1rem; width: 22px; text-align: center; color: var(--primary); }
.rp-card-hd h3 { font-size: 1rem; font-weight: 800; color: var(--text); }

/* Table */
.rp-tbl-wrap { overflow-x: auto; padding: 16px 22px 22px; }
.rp-tbl { width: 100%; border-collapse: collapse; }
.rp-tbl th { padding: 8px 10px; font-size: 0.68rem; font-weight: 800; color: var(--primary); text-transform: uppercase; letter-spacing: 0.3px; text-align: left; border-bottom: 2px solid var(--primary-soft); }
.rp-tc { text-align: center !important; }
.rp-tbl td { padding: 12px 10px; border-bottom: 1px solid rgba(0,0,0,0.04); font-size: 0.85rem; transition: background 0.15s; }
.rp-row { cursor: pointer; }
.rp-row:hover td { background: var(--primary-soft); }
.rp-row:last-child td { border-bottom: none; }

.rp-user { display: flex; align-items: center; gap: 10px; }
.rp-avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-hover)); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.7rem; flex-shrink: 0; }
.rp-name { font-weight: 700; color: var(--text); font-size: 0.85rem; }
.rp-sub { font-size: 0.7rem; color: var(--text-light); }

.rp-bdg { display: inline-block; padding: 2px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 800; min-width: 28px; }
.rp-bdg-ok { background: #f0fdf4; color: #22c55e; }
.rp-bdg-warn { background: #fffbeb; color: #f59e0b; }
.rp-bdg-err { background: #fef2f2; color: #ef4444; }

.rp-prog { display: flex; align-items: center; gap: 8px; }
.rp-prog-track { flex: 1; height: 6px; background: #e8f0ec; border-radius: 3px; overflow: hidden; max-width: 100px; }
.rp-prog-fill { height: 100%; background: linear-gradient(90deg, var(--primary), var(--primary-hover)); border-radius: 3px; transition: width 0.4s; }
.rp-prog-pct { font-size: 0.78rem; font-weight: 800; color: var(--primary); min-width: 32px; }

/* Detail row */
.rp-detail td { padding: 0 10px 16px; }
.rp-detail-inner { display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 10px; padding: 12px; background: var(--primary-soft); border-radius: 12px; border: 1px solid var(--border); }
.rp-etapa-mini { background: white; border: 1px solid var(--border); border-radius: 10px; padding: 10px 12px; }
.rp-em-header { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; font-size: 0.78rem; font-weight: 700; color: var(--text); }
.rp-em-num { width: 22px; height: 22px; background: linear-gradient(135deg, var(--primary), var(--primary-hover)); color: white; border-radius: 5px; display: flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 800; flex-shrink: 0; }
.rp-em-status { font-size: 0.72rem; font-weight: 700; display: flex; align-items: center; gap: 4px; }
.rp-em-date { font-size: 0.65rem; color: var(--text-light); margin-top: 2px; }
.rp-em-empty { font-size: 0.7rem; color: var(--text-light); font-style: italic; display: flex; align-items: center; gap: 4px; }

/* Empty */
.rp-empty { text-align: center; padding: 40px 20px; color: var(--text-light); font-size: 0.85rem; }

/* Accordion */
.rp-accs { padding: 16px 22px 22px; display: flex; flex-direction: column; gap: 10px; }
.rp-acc { border: 1px solid var(--border); border-radius: 12px; overflow: hidden; background: white; transition: all 0.2s; }
.rp-acc:hover { border-color: var(--primary-glow); }
.rp-acc-hd { display: flex; justify-content: space-between; align-items: center; padding: 14px 18px; cursor: pointer; user-select: none; transition: background 0.15s; }
.rp-acc-hd:hover { background: var(--primary-soft); }
.rp-acc-hd-l { display: flex; align-items: center; gap: 12px; }
.rp-acc-num { width: 26px; height: 26px; background: linear-gradient(135deg, var(--primary), var(--primary-hover)); color: white; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.75rem; flex-shrink: 0; }
.rp-acc-title { font-weight: 700; font-size: 0.9rem; color: var(--text); }
.rp-acc-meta { font-size: 0.68rem; color: var(--text-light); }
.rp-acc-chev { color: var(--text-light); font-size: 0.75rem; transition: transform 0.25s; }
.rp-acc.open .rp-acc-chev { transform: rotate(180deg); }
.rp-acc-body { display: none; }
.rp-acc.open .rp-acc-body { display: block; }
.rp-acc-inner { padding: 0 18px 18px; border-top: 1px solid var(--primary-soft); padding-top: 14px; }

.rp-acc-desc { font-size: 0.82rem; color: var(--text-light); line-height: 1.5; margin-bottom: 14px; padding: 10px 14px; background: var(--primary-soft); border-radius: 8px; border-left: 3px solid var(--primary); }

.rp-docs { margin-bottom: 14px; font-size: 0.78rem; }
.rp-docs strong { display: block; margin-bottom: 4px; color: var(--text); }
.rp-doc { display: inline-block; padding: 2px 10px; background: var(--primary-soft); color: var(--primary); border-radius: 6px; font-size: 0.7rem; font-weight: 700; margin: 2px; }
.rp-link { display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; background: var(--primary-soft); color: var(--primary); border-radius: 8px; font-size: 0.72rem; font-weight: 700; text-decoration: none; }
.rp-link:hover { background: rgba(62,180,137,0.15); }

/* Submissions */
.rp-subs { margin-top: 4px; }
.rp-subs-label { font-size: 0.72rem; font-weight: 800; color: var(--primary); text-transform: uppercase; margin-bottom: 10px; }
.rp-sub { background: var(--primary-soft); border: 1px solid var(--border); border-radius: 10px; padding: 12px; margin-bottom: 8px; transition: all 0.15s; }
.rp-sub:hover { background: white; border-color: var(--primary-glow); }
.rp-sub:last-child { margin-bottom: 0; }
.rp-sub-top { display: flex; align-items: center; gap: 10px; }
.rp-sub-av { width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-hover)); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.65rem; flex-shrink: 0; }
.rp-sub-info { flex: 1; min-width: 0; }
.rp-sub-name { display: block; font-size: 0.82rem; font-weight: 700; color: var(--text); }
.rp-sub-date { display: block; font-size: 0.65rem; color: var(--text-light); }
.rp-sub-bdg { display: inline-flex; align-items: center; gap: 3px; padding: 2px 8px; border-radius: 8px; font-size: 0.62rem; font-weight: 800; white-space: nowrap; }
.rp-sub-bot { display: flex; align-items: center; gap: 12px; margin-top: 6px; padding-top: 6px; border-top: 1px solid rgba(0,0,0,0.04); flex-wrap: wrap; }
.rp-file { display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; font-weight: 700; color: var(--primary); text-decoration: none; }
.rp-file:hover { text-decoration: underline; }
.rp-cmt { font-size: 0.72rem; color: var(--text-light); display: inline-flex; align-items: flex-start; gap: 4px; }
.rp-cmt i { color: var(--primary); font-size: 0.65rem; margin-top: 2px; }

/* Sidebar */
.rp-sb-body { padding: 14px 20px 18px; }
.rp-sb-field { margin-bottom: 2px; }
.rp-sb-lbl { font-size: 0.65rem; font-weight: 800; color: var(--text-light); text-transform: uppercase; margin-bottom: 4px; }
.rp-sb-val { font-weight: 700; color: var(--text); font-size: 0.85rem; }
.rp-sb-val i { color: var(--primary); margin-right: 6px; width: 14px; text-align: center; }
.rp-sb-sub { font-size: 0.72rem; color: var(--text-light); margin-top: 1px; }
.rp-sb-sub i { color: var(--primary); margin-right: 6px; width: 14px; text-align: center; }
.rp-bdg-status { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 16px; color: white; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; }
.rp-offer { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; background: var(--primary-soft); color: var(--primary); border-radius: 12px; font-size: 0.75rem; font-weight: 800; }
.rp-div { height: 1px; background: var(--primary-soft); margin: 12px 0; }

.rp-crono { background: var(--primary-soft); padding: 12px; border-radius: 10px; border: 1px solid var(--border); }
.rp-crono-row { display: flex; justify-content: space-between; align-items: center; padding: 3px 0; font-size: 0.75rem; }
.rp-crono-row span { color: var(--text-light); font-weight: 600; }
.rp-crono-row span i { margin-right: 4px; }
.rp-crono-row strong { font-weight: 800; color: var(--text); }

/* Metrics */
.rp-mtr { margin-bottom: 14px; }
.rp-mtr:last-child { margin-bottom: 0; }
.rp-mtr-hd { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; font-size: 0.75rem; }
.rp-mtr-hd span { color: var(--text-light); font-weight: 600; }
.rp-mtr-hd strong { color: var(--text); font-weight: 900; }
.rp-mtr-bar { height: 5px; background: #e8f0ec; border-radius: 3px; overflow: hidden; }
.rp-mtr-fill { height: 100%; border-radius: 3px; transition: width 0.5s; }

/* Responsive */
@media (max-width: 1200px) {
    .rp-stats { grid-template-columns: repeat(3, 1fr); }
    .rp-grid { grid-template-columns: 1fr; }
    .rp-sticky { position: static; }
}
@media (max-width: 1024px) {
    .rp-header { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 768px) {
    .rp-stats { grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .rp-stat { padding: 14px; }
    .rp-stat-num { font-size: 1.1rem; }
    .rp-detail-inner { grid-template-columns: repeat(2, 1fr); }
    .rp-tbl-wrap { padding: 12px 14px 16px; }
    .rp-accs { padding: 12px 14px 16px; }
    .rp-card-hd { padding: 14px 14px 0; }
    .rp-card-hd h3 { font-size: 0.9rem; }
}
@media (max-width: 640px) {
    .rp-stats { grid-template-columns: repeat(3, 1fr); gap: 8px; }
    .rp-stat { flex-direction: column; text-align: center; gap: 6px; padding: 10px; }
    .rp-stat-icon { width: 32px; height: 32px; font-size: 0.8rem; }
    .rp-stat-num { font-size: 0.95rem; }
    .rp-stat-lbl { font-size: 0.6rem; }
    .rp-title { font-size: 20px; }
    .rp-progress { padding: 12px 14px; }
    .rp-detail-inner { grid-template-columns: 1fr; }
    .rp-tbl th, .rp-tbl td { padding: 8px 6px; font-size: 0.72rem; }
    .rp-name { font-size: 0.78rem; }
    .rp-sub-top { flex-wrap: wrap; }
    .rp-sb-body { padding: 10px 14px 14px; }
}
@media (max-width: 480px) {
    .rp-stats { grid-template-columns: repeat(2, 1fr); gap: 6px; }
    .rp-grid { gap: 16px; }
    .rp-accs { gap: 8px; }
}

@media print {
    .sidebar, .topbar, #btnExportarPDF, .nav-item, .sidebar-overlay, .sidebar-toggle, .notification-bell { display: none !important; }
    .main { margin-left: 0 !important; }
    body { background: white !important; }
    .rp-card, .rp-stat, .rp-progress { box-shadow: none !important; border: 1px solid #ddd !important; background: white !important; }
    .rp-acc-body { display: block !important; }
    .rp-acc-hd { cursor: default !important; }
    .rp-acc { page-break-inside: avoid; border: 1px solid #ddd !important; }
    .rp-bdg-status, .rp-bdg-ok, .rp-bdg-warn, .rp-bdg-err, .rp-progress-seg, .rp-prog-fill, .rp-mtr-fill, .rp-sub-bdg { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('btnExportarPDF').addEventListener('click', function() {
        document.querySelectorAll('.rp-acc').forEach(function(el) { el.classList.add('open'); });
        document.querySelectorAll('.rp-detail').forEach(function(el) { el.style.display = 'table-row'; });
        requestAnimationFrame(function() { window.print(); });
        window.onafterprint = function() {
            document.querySelectorAll('.rp-acc').forEach(function(el) { el.classList.remove('open'); });
            document.querySelectorAll('.rp-detail').forEach(function(el) { el.style.display = 'none'; });
        };
    });
});
function toggleAcc(el) { el.parentElement.classList.toggle('open'); }
function toggleRow(row) {
    var detail = row.nextElementSibling;
    if (detail && detail.classList.contains('rp-detail')) {
        detail.style.display = detail.style.display === 'table-row' ? 'none' : 'table-row';
    }
}
</script>
@endsection
