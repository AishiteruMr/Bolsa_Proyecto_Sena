@php $avatarColors = ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#f43f5e', '#06b6d4', '#84cc16']; @endphp
<table class="premium-table">
    <thead>
        <tr>
            <th style="padding-left: 24px;">Proyecto</th>
            <th>Empresa</th>
            <th>Estado</th>
            <th style="text-align: right; padding-right: 24px;">Acción</th>
        </tr>
    </thead>
    <tbody>
        @forelse($proyectosRecientes as $i => $p)
            @php
                $statusStyles = match($p->estado) {
                    'completado' => ['bg' => '#065f46', 'icon' => 'fa-check'],
                    'aprobado' => ['bg' => '#10b981', 'icon' => 'fa-check'],
                    'pendiente' => ['bg' => '#f59e0b', 'icon' => 'fa-clock'],
                    'rechazado' => ['bg' => '#ef4444', 'icon' => 'fa-ban'],
                    'cerrado' => ['bg' => '#64748b', 'icon' => 'fa-lock'],
                    'en_progreso' => ['bg' => '#3b82f6', 'icon' => 'fa-spinner'],
                    default => ['bg' => '#64748b', 'icon' => 'fa-info-circle'],
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
                            <div style="font-weight: 700; color: var(--text); font-size: 13px; line-height: 1.5;">{{ $p->titulo }}</div>
                            @if($p->categoria)
                                <span style="font-size: 10px; color: var(--text-lighter); font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px;">{{ $p->categoria }}</span>
                            @endif
                            @if($p->oferta)
                                <span style="display: inline-flex; align-items: center; gap: 4px; margin-top: 4px; font-size: 10px; background: linear-gradient(135deg, rgba(139,92,246,0.12), rgba(124,58,237,0.08)); color: #7c3aed; padding: 2px 10px 2px 6px; border-radius: 20px; font-weight: 800; border: 1px solid rgba(139,92,246,0.15); box-shadow: 0 2px 4px rgba(139,92,246,0.06);">
                                    <i class="fas fa-gift" style="font-size: 8px;"></i>
                                    @switch($p->oferta)
                                        @case('pasantias') Pasantías @break
                                        @case('contrato_aprendizaje') Contrato aprendizaje @break
                                        @case('auxilio_transporte') Auxilio transporte @break
                                        @case('otro') {{ $p->oferta_otro }} @break
                                    @endswitch
                                </span>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <div style="display: flex; align-items: center; gap: 8px; color: var(--text-light); font-weight: 600; font-size: 13px;">
                        <i class="fas fa-building" style="font-size: 11px; opacity: 0.4;"></i>
                        {{ $p->empresa_nombre }}
                    </div>
                </td>
                <td>
                    <span style="background: {{ $statusStyles['bg'] }}15; color: {{ $statusStyles['bg'] }}; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; border: 1px solid {{ $statusStyles['bg'] }}25;">
                        <i class="fas {{ $statusStyles['icon'] }}"></i> {{ Str::title(str_replace('_', ' ', $p->estado)) }}
                    </span>
                </td>
                <td style="text-align: right; padding-right: 24px;">
                    <a href="{{ route('admin.proyectos.revisar', $p->id) }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; background: var(--primary-soft); color: var(--primary); border-radius: 8px; font-size: 11px; font-weight: 700; text-decoration: none; transition: all 0.2s; white-space: nowrap;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff'" onmouseout="this.style.background='var(--primary-soft)'; this.style.color='var(--primary)'">
                        Revisar <i class="fas fa-arrow-right" style="font-size: 10px;"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 60px 24px;">
                    <div style="width: 64px; height: 64px; background: #f8fafc; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; color: #cbd5e1;">
                        <i class="fas fa-inbox" style="font-size: 28px;"></i>
                    </div>
                    <div style="font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 4px;">Todo al día</div>
                    <div style="font-size: 13px; color: var(--text-lighter); font-weight: 500;">No hay proyectos pendientes de revisión.</div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
