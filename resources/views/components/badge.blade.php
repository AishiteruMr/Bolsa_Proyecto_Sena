@props([
    'variant' => 'info',
])

@php
    $variants = [
        'success' => 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20',
        'error'   => 'bg-red-500 text-white shadow-lg shadow-red-500/20',
        'warning' => 'bg-amber-500 text-white shadow-lg shadow-amber-500/20',
        'info'    => 'bg-blue-500 text-white shadow-lg shadow-blue-500/20',
        'secondary' => 'bg-slate-500 text-white shadow-lg shadow-slate-500/20',
    ];

    $classes = $variants[$variant] ?? $variants['info'];
@endphp

<span {{ $attributes->merge(['class' => "$classes px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest italic flex items-center justify-center border-none"]) }}>
    {{ $slot }}
</span>
