@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginacao" class="flex items-center justify-between gap-4">
        <div class="text-sm text-[var(--color-text-muted)]">
            Mostrando
            <span class="font-semibold text-[var(--color-text)]">{{ $paginator->firstItem() }}</span>
            ate
            <span class="font-semibold text-[var(--color-text)]">{{ $paginator->lastItem() }}</span>
            de
            <span class="font-semibold text-[var(--color-text)]">{{ $paginator->total() }}</span>
            resultados
        </div>

        <div class="flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="btn-secondary cursor-not-allowed opacity-60">Anterior</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="btn-secondary">Anterior</a>
            @endif

            <div class="hidden items-center gap-2 md:flex">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="px-2 text-sm text-[var(--color-text-muted)]">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="inline-flex min-w-10 items-center justify-center rounded-full bg-[var(--color-brand)] px-4 py-2 text-xs font-bold uppercase tracking-[0.08em] text-white">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="btn-secondary min-w-10 px-4" aria-label="Ir para pagina {{ $page }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn-primary">Proxima</a>
            @else
                <span class="btn-primary cursor-not-allowed opacity-60">Proxima</span>
            @endif
        </div>
    </nav>
@endif
