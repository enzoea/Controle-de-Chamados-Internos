@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-2xl border border-[#ead9d5] bg-white px-4 py-3 text-sm font-medium text-[var(--color-text-muted)]']) }}>
        {{ $status }}
    </div>
@endif
