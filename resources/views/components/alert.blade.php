@props([
    'type' => 'success',
])

@php
    $classes = $type === 'error'
        ? 'border-[#d72638]/20 bg-[#fbe2e5] text-[#b51f2f]'
        : 'border-[#d72638]/15 bg-white text-[#6c5a5f]';
@endphp

<div {{ $attributes->merge(['class' => "rounded-2xl border px-4 py-3 text-sm {$classes}"]) }}>
    {{ $slot }}
</div>
