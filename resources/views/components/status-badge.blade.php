@props([
    'value',
])

@php
    $classes = match ((string) $value) {
        'ABERTO' => 'bg-blue-100 text-blue-700',
        'EM_ANDAMENTO' => 'bg-amber-100 text-amber-700',
        'RESOLVIDO' => 'bg-emerald-100 text-emerald-700',
        'FECHADO' => 'bg-gray-200 text-gray-700',
        default => 'bg-gray-100 text-gray-700',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex rounded-full px-3 py-1 text-xs font-semibold {$classes}"]) }}>
    {{ $value }}
</span>
