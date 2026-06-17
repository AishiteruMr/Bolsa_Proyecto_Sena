@php $avatarColors = ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#f43f5e', '#06b6d4', '#84cc16']; @endphp
<div style="overflow-x: auto;">
    <table class="table-dash">
        <thead>
            <tr>
                <th style="padding-left: 24px;">Proyecto</th>
                <th>Categoría</th>
                <th>Oferta</th>
                <th>Estado</th>
                <th>Postulaciones</th>
                <th style="text-align:center; padding-right: 24px;">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proyectosRecientes as $i => $p)
                @php
                    $s = match($p->estado) {
                        'completado'  => ['bg' => '#065f46', 'icon' => 'fa-check'],
                        'aprobado'    => ['bg' => '#10b981', 'icon' => 'fa-check'],
                        'pendiente'   => ['bg' => '#f59e0b', 'icon' => 'fa-clock'],
                        'rechazado'   => ['bg' => '#ef4444', 'icon' => 'fa-ban'],
                        'cerrado'     => ['bg' => '#64748b', 'icon' => 'fa-lock'],
                        'en_progreso' => ['bg' => '#3b82f6', 'icon' => 'fa-spinner'],
                        default       => ['bg' => '#64748b', 'icon' => 'fa-info-circle'],
                    };
                    $initial = strtoupper(substr($p->titulo, 0, 1));
                    $avatarColor = $avatarColors[$i % count($avatarColors)];
                @endphp
                <tr>
                    <td style="padding-left: 24px;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: {{ $avatarColor }}15; color: {{ $avatarColor }}; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 14px; border: 1px solid {{ $avatarColor }}25; flex-shrink: 0;">
                                {{ $initial }}
                            </div>
                            <div>
                                <div style="font-weight: 700; color: var(--text); font-size: 13px;">{{ Str::limit($p->titulo, 42) }}</div>
                                <div style="font-size: 10px; color: var(--text-lighter); font-weight: 600; margin-top: 2px;">
                                    <i class="far fa-calendar"></i> Exp: {{ \Carbon\Carbon::parse($p->fecha_publicacion)->addDays($p->duracion_estimada_dias ?? 183)->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="background: #f1f5f9; color: var(--text-light); padding: 4px 10px; border-radius: 30px; font-size: 10px; font-weight: 700; text-transform: uppercase; white-space: nowrap;">{{ $p->categoria }}</span>
                    </td>
                    <td>
                        @if($p->oferta)
                            <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 10px; background: linear-gradient(135deg, rgba(139,92,246,0.12), rgba(124,58,237,0.08)); color: #7c3aed; padding: 3px 10px 3px 6px; border-radius: 20px; font-weight: 800; border: 1px solid rgba(139,92,246,0.15); white-space: nowrap;">
                                <i class="fas fa-gift" style="font-size: 8px;"></i>
                                @switch($p->oferta)
                                    @case('pasantias') Pasantías @break
                                    @case('contrato_aprendizaje') Contrato aprendizaje @break
                                    @case('auxilio_transporte') Auxilio transporte @break
                                    @case('otro') {{ $p->oferta_otro }} @break
                                @endswitch
                            </span>
                        @else
                            <span style="color: var(--text-lighter); font-size: 13px;">—</span>
                        @endif
                    </td>
                    <td>
                        <span style="background: {{ $s['bg'] }}15; color: {{ $s['bg'] }}; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; border: 1px solid {{ $s['bg'] }}25; white-space: nowrap;">
                            <i class="fas {{ $s['icon'] }}"></i> {{ Str::title(str_replace('_', ' ', $p->estado)) }}
                        </span>
                    </td>
                    <td>
                        @if(($p->postulaciones_count ?? 0) > 0 || $p->postulaciones->count() > 0)
                            @php $postCount = $p->postulaciones->count(); @endphp
                            <div class="avatar-stack">
                                @foreach($p->postulaciones->take(3) as $post)
                                    <div class="av-item" style="background: linear-gradient(135deg, #3eb489, #2d9d74);" title="{{ $post->aprendiz->nombres ?? '' }} {{ $post->aprendiz->apellidos ?? '' }}">
                                        {{ substr($post->aprendiz->nombres ?? 'A', 0, 1) }}
                                    </div>
                                @endforeach
                                @if($postCount > 3)
                                    <span style="font-weight: 800; color: var(--text); font-size: 12px; margin-left: 4px;">+{{ $postCount - 3 }}</span>
                                @endif
                            </div>
                        @else
                            <span style="color: var(--text-lighter); font-size: 11px; font-weight: 600;">Sin post.</span>
                        @endif
                    </td>
                    <td style="text-align:center; padding-right: 24px;">
                        <a href="{{ route('empresa.proyectos.detalle', $p->id) }}" class="btn-action btn-action-blue" style="padding: 7px 14px; font-size: 11px;">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
