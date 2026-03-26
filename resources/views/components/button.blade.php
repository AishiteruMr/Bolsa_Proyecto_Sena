@props([
    'variant' => 'primary', // primary, secondary, outline, danger
    'size' => 'md',      // sm, md, lg
    'type' => 'button'
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variants = [
        'primary' => 'bg-[#E65100] text-white hover:bg-orange-700 focus:ring-[#FF6B00] shadow-sm',
        'secondary' => 'bg-slate-700 text-white hover:bg-slate-800 focus:ring-slate-500 shadow-sm',
        'outline' => 'border-2 border-[#E65100] text-[#E65100] hover:bg-orange-50 bg-transparent focus:ring-[#FF6B00]',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 shadow-sm',
        'ghost' => 'text-[#E65100] hover:bg-orange-50 focus:ring-[#FF6B00]',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-6 py-3 text-lg',
    ];

    $classes = "{$baseClasses} {$variants[$variant]} {$sizes[$size]}";
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
