@php
    $collection = $notificaciones->getCollection();
    $groups = [];
    $today = now()->startOfDay();
    $yesterday = now()->subDay()->startOfDay();
    $weekStart = now()->subWeek()->startOfDay();
    $oneHourAgo = now()->subHour();
    foreach ($collection as $n) {
        $date = $n->created_at ? $n->created_at->startOfDay() : $today;
        if ($date->eq($today)) $key = 'Hoy';
        elseif ($date->eq($yesterday)) $key = 'Ayer';
        elseif ($date->gte($weekStart)) $key = 'Esta semana';
        else $key = 'Anteriores';
        $groups[$key][] = $n;
    }
@endphp

@if($collection->isEmpty())
    <div class="notif-empty-new">
        <i class="fas fa-bell-slash"></i>
        <h4>Bandeja vacía</h4>
        <p>No tienes notificaciones por ahora. ¡Todo está bajo control!</p>
    </div>
@else
    @foreach($groups as $groupLabel => $groupNotifs)
        @if($groupNotifs)
            <div class="date-divider-new">{{ $groupLabel }}</div>
            @foreach($groupNotifs as $i => $notificacion)
                @php
                    $leida = !is_null($notificacion->read_at);
                    $icon = $notificacion->data['icono'] ?? 'fa-bell';
                    $typeColor = match($icon) {
                        'fa-check-circle' => '#10b981',
                        'fa-exclamation-triangle' => '#f59e0b',
                        'fa-times-circle' => '#ef4444',
                        'fa-user-plus' => '#8b5cf6',
                        default => '#3b82f6',
                    };
                @endphp
                <div class="notif-card-new {{ $leida ? 'read' : 'unread' }} notif-animate" data-id="{{ $notificacion->id }}" style="--anim-delay: {{ $i * 0.05 }}s">
                    <div class="notif-icon-box" style="--icon-color: {{ $typeColor }}; --icon-bg: {{ $leida ? '#f1f5f9' : $typeColor . '15' }}">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                    <div class="notif-content-new">
                        <div class="notif-title-new">
                            <span>
                                @if(!$leida)<span class="unread-indicator"></span>@endif
                                {{ $notificacion->data['titulo'] ?? 'Aviso del Sistema' }}
                            </span>
                            <span class="notif-time-new">{{ $notificacion->created_at ? $notificacion->created_at->diffForHumans() : '' }}</span>
                        </div>
                        <p class="notif-desc-new">{{ $notificacion->data['mensaje'] ?? '' }}</p>
                        <div class="notif-actions-new">
                            @if(isset($notificacion->data['url']))
                                <a href="{{ $notificacion->data['url'] }}" class="btn-action btn-action-primary">
                                    <i class="fas fa-eye"></i> Ver ahora
                                </a>
                            @endif
                            @if(!$leida)
                                <button onclick="markAsRead('{{ $notificacion->id }}')" class="btn-action btn-action-secondary">
                                    <i class="fas fa-check"></i> Listo
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endforeach

    <div class="mt-4">
        {{ $notificaciones->links() }}
    </div>
@endif
