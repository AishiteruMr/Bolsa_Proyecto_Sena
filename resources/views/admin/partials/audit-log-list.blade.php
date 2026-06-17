@forelse($logs as $log)
    @include('admin.partials.audit-log-row')
@empty
    <div class="audit-timeline-empty">
        <i class="fas fa-inbox"></i>
        <p>No hay actividad reciente</p>
    </div>
@endforelse
