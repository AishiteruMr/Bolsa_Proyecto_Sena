@forelse($logs as $log)
    @php
        $bgColor = match($log->accion) {'crear','publicar','activar','aprobar'=>'#d1fae5','editar','cambiar_estado','asignar'=>'#eff6ff','eliminar','desactivar','rechazar','desasignar'=>'#fef2f2',default=>'#f8fafc'};
        $iconColor = match($log->accion) {'crear','publicar','activar','aprobar'=>'#10b981','editar','cambiar_estado','asignar'=>'#3b82f6','eliminar','desactivar','rechazar','desasignar'=>'#ef4444',default=>'#64748b'};
        $icon = match($log->accion) {'crear','publicar'=>'fa-plus','editar','cambiar_estado'=>'fa-pen','eliminar'=>'fa-trash','asignar'=>'fa-user-plus','activar'=>'fa-check','desactivar'=>'fa-ban','aprobar'=>'fa-thumbs-up','rechazar'=>'fa-thumbs-down','desasignar'=>'fa-user-minus',default=>'fa-circle'};
    @endphp
    <div class="actividad-item">
        <div style="width:32px; height:32px; border-radius:8px; background:{{ $bgColor }}; color:{{ $iconColor }}; display:flex; align-items:center; justify-content:center; font-size:12px; flex-shrink:0;">
            <i class="fas {{ $icon }}"></i>
        </div>
        <div style="flex:1; min-width:0; overflow:hidden;">
            <div style="font-size:12px; font-weight:700; color:var(--text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $log->descripcion }}</div>
            <div style="font-size:10px; color:var(--text-lighter); font-weight:500; margin-top:2px;">
                {{ $log->usuario->name ?? 'Sistema' }} · {{ $log->created_at ? \Carbon\Carbon::parse($log->created_at)->diffForHumans() : '' }}
            </div>
        </div>
    </div>
@empty
    <div style="text-align:center; padding:32px 16px; color:var(--text-lighter); font-size:12px; font-weight:500;">
        <i class="fas fa-inbox" style="font-size:24px; display:block; margin-bottom:8px;"></i>
        Sin actividad reciente
    </div>
@endforelse
