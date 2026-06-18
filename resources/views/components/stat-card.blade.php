@props([
    'label',
    'value',
    'icon' => 'chart',
])

@php
    $iconMarkup = match ($icon) {
        'open' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12M6 12h12"/></svg>',
        'progress' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 12h6l2-5 4 10 2-5h2"/></svg>',
        'resolved' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7"/></svg>',
        'closed' => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10v10H7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.5 9.5l5 5m0-5-5 5"/></svg>',
        default => '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5m0 14h16M8 15V9m4 6V7m4 8v-4"/></svg>',
    };
@endphp

<div {{ $attributes->merge(['class' => 'surface-card p-6']) }}>
    <div class="mb-4 flex justify-start">
        <span class="stat-card-icon">{!! $iconMarkup !!}</span>
    </div>

    <p class="eyebrow-text">{{ $label }}</p>
    <p class="mt-3 text-3xl font-semibold text-[var(--color-text)]">{{ $value }}</p>
</div>
