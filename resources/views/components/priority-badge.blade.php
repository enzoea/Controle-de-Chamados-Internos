@props([
    'value',
])

@php
    $classes = match ((string) $value) {
        'BAIXA' => 'font-semibold text-[#6c5a5f]',
        'MEDIA' => 'font-semibold text-[#9a5660]',
        'ALTA' => 'font-semibold text-[#b51f2f]',
        'URGENTE' => 'font-bold text-[#d72638]',
        default => 'font-semibold text-[#6c5a5f]',
    };
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $value }}
</span>
