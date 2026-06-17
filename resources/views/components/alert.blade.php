@props([
    'type' => 'success',
])

@php
    $classes = $type === 'error'
        ? 'border-red-200 bg-red-50 text-red-700'
        : 'border-green-200 bg-green-50 text-green-700';
@endphp

<div {{ $attributes->merge(['class' => "rounded-lg border px-4 py-3 text-sm {$classes}"]) }}>
    {{ $slot }}
</div>
