@props([
    'value',
])

@php
    $classes = match ((string) $value) {
        'ABERTO' => 'font-semibold text-[#b51f2f]',
        'EM_ANDAMENTO' => 'font-semibold text-[#9a4c3f]',
        'RESOLVIDO' => 'font-semibold text-[#35624b]',
        'FECHADO' => 'font-semibold text-[#6c5a5f]',
        default => 'font-semibold text-[#6c5a5f]',
    };
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $value }}
</span>
