@props([
    'value',
])

@php
    $classes = match ((string) $value) {
        'BAIXA' => 'bg-slate-100 text-slate-700',
        'MEDIA' => 'bg-sky-100 text-sky-700',
        'ALTA' => 'bg-orange-100 text-orange-700',
        'URGENTE' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex rounded-full px-3 py-1 text-xs font-semibold {$classes}"]) }}>
    {{ $value }}
</span>
