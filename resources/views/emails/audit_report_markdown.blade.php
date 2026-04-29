@component('mail::message')
# Auditoría de Seguridad: Bolsa SENA

## 📊 Resumen Ejecutivo
@php
    $total = 0;
    $failed = 0;
    foreach($report as $role => $results) {
        $total += count($results);
        foreach($results as $res) if($res['result'] === '❌ FALLO') $failed++;
    }
@endphp
- **Rutas escaneadas:** {{ $total }}
- **Vulnerabilidades detectadas:** {{ $failed }}

@if($failed > 0)
@foreach($report as $role => $results)
@php
    $roleFailed = array_filter($results, fn($r) => $r['result'] === '❌ FALLO');
@endphp
@if(count($roleFailed) > 0)
## 🛡️ Hallazgos: Rol {{ $role ?? 'Invitado' }}

| URI | Estado | Sugerencia |
| :--- | :--- | :--- |
@foreach($roleFailed as $res)
| {{ $res['uri'] }} | ❌ {{ $res['status'] }} | `{{ $res['remediation'] }}` |
@endforeach
@endif
@endforeach
@else
✅ No se detectaron fallos de seguridad en esta ejecución.
@endif

@component('mail::button', ['url' => config('app.url')])
Ver Sistema
@endcomponent
@endcomponent
