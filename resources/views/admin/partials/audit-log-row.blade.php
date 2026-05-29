@php
    $actionMeta = [
        'crear' => ['color' => '#059669', 'bg' => '#ecfdf5', 'label' => 'Registro', 'icon' => 'fa-plus'],
        'editar' => ['color' => '#d97706', 'bg' => '#fffbeb', 'label' => 'Actualización', 'icon' => 'fa-pen'],
        'cambiar_estado' => ['color' => '#d97706', 'bg' => '#fffbeb', 'label' => 'Actualización', 'icon' => 'fa-pen'],
        'eliminar' => ['color' => '#dc2626', 'bg' => '#fef2f2', 'label' => 'Eliminación', 'icon' => 'fa-trash-can'],
        'login' => ['color' => '#2563eb', 'bg' => '#eff6ff', 'label' => 'Inicio Sesión', 'icon' => 'fa-right-to-bracket'],
        'logout' => ['color' => '#475569', 'bg' => '#f8fafc', 'label' => 'Cierre Sesión', 'icon' => 'fa-right-from-bracket'],
        'exportar' => ['color' => '#7c3aed', 'bg' => '#f5f3ff', 'label' => 'Exportación', 'icon' => 'fa-file-export'],
        'asignar' => ['color' => '#8b5cf6', 'bg' => '#f5f3ff', 'label' => 'Asignación', 'icon' => 'fa-user-plus'],
        'postularse' => ['color' => '#0ea5e9', 'bg' => '#f0f9ff', 'label' => 'Postulación', 'icon' => 'fa-paper-plane'],
        'publicar' => ['color' => '#10b981', 'bg' => '#ecfdf5', 'label' => 'Publicación', 'icon' => 'fa-upload'],
        'desasignar' => ['color' => '#ef4444', 'bg' => '#fef2f2', 'label' => 'Destitución', 'icon' => 'fa-user-minus'],
    ];
    $actionMeta = $actionMeta[$log->accion] ?? ['color' => '#64748b', 'bg' => '#f1f5f9', 'label' => ucfirst($log->accion), 'icon' => 'fa-circle-dot'];
    $hasChanges = !empty($log->datos_anteriores) || !empty($log->datos_nuevos);
    $nombreEntidad = $log->datos_nuevos['nombre_objetivo'] ?? $log->datos_anteriores['nombre_objetivo'] ?? $log->datos_nuevos['instructor'] ?? $log->datos_anteriores['instructor'] ?? null;
@endphp
<div class="audit-timeline-row">
    <div class="audit-timeline-dot">
        <div class="audit-timeline-circle" style="background: {{ $actionMeta['bg'] }}; color: {{ $actionMeta['color'] }}; border-color: {{ $actionMeta['color'] }}20;">
            <i class="fas {{ $actionMeta['icon'] }}"></i>
        </div>
        <div class="audit-timeline-line"></div>
    </div>
    <div class="audit-timeline-content">
        <div class="audit-timeline-meta">
            <span class="audit-action-badge" style="background: {{ $actionMeta['bg'] }}; color: {{ $actionMeta['color'] }};">
                <i class="fas {{ $actionMeta['icon'] }}"></i>{{ $actionMeta['label'] }}
            </span>
            @if($nombreEntidad)
                <span class="audit-entity-name">
                    <i class="fas fa-user"></i>{{ $nombreEntidad }}
                </span>
            @endif
            <span class="audit-timestamp">
                <i class="far fa-clock"></i>{{ $log->created_at->format('d/m/Y H:i') }} · {{ $log->created_at->diffForHumans() }}
            </span>
        </div>
        <p class="audit-description">{{ $log->descripcion }}</p>
        <div class="audit-footer">
            <span class="audit-user-badge">
                <i class="fas fa-user-shield"></i>{{ $log->usuario->nombre_rol ?? 'Sistema' }}
            </span>
            @if($hasChanges)
                <button onclick="verDetalles({{ $log->id }})" class="audit-detail-btn">
                    <i class="fas fa-eye"></i>Ver detalles
                </button>
                <div id="data-{{ $log->id }}" style="display: none;">{{ json_encode([
                    'anterior' => $log->datos_anteriores,
                    'nuevo' => $log->datos_nuevos,
                    'usuario' => $log->usuario->nombre_rol ?? 'Sistema',
                    'fecha' => $log->created_at->format('d/m/Y H:i:s'),
                    'accion' => $actionMeta['label'],
                    'modulo' => ucfirst($log->modulo),
                    'registro_id' => (string)$log->registro_id,
                ]) }}</div>
            @endif
        </div>
    </div>
</div>