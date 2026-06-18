<x-app-layout>
    @php
        $hasActiveFilters = filled($filters['status'] ?? null)
            || filled($filters['priority'] ?? null)
            || filled($filters['responsible_id'] ?? null)
            || $errors->isNotEmpty();
    @endphp

    <div class="space-y-6">
        <x-card class="space-y-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h3 class="section-title text-lg font-semibold">Listagem de chamados</h3>
                    <p class="muted-text mt-1 text-sm">
                        Ordenacao padrao por data de abertura mais recente.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <button
                        type="button"
                        class="btn-secondary"
                        aria-controls="ticket-filters-panel"
                        aria-expanded="{{ $hasActiveFilters ? 'true' : 'false' }}"
                        onclick="
                            const panel = document.getElementById('ticket-filters-panel');
                            const label = this.querySelector('[data-filter-label]');
                            panel.classList.toggle('hidden');
                            const isOpen = !panel.classList.contains('hidden');
                            this.setAttribute('aria-expanded', String(isOpen));
                            label.textContent = isOpen ? 'Ocultar filtros' : 'Filtros';
                        "
                    >
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M7 12h10m-7 6h4" />
                            </svg>
                            <span data-filter-label>{{ $hasActiveFilters ? 'Ocultar filtros' : 'Filtros' }}</span>
                        </span>
                    </button>

                    <a
                        href="{{ route('tickets.create') }}"
                        class="btn-primary"
                    >
                        <span class="inline-flex items-center gap-2">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                            </svg>
                            <span>Abrir chamado</span>
                        </span>
                    </a>
                </div>
            </div>

            <div id="ticket-filters-panel" class="surface-muted p-5 {{ $hasActiveFilters ? '' : 'hidden' }}">
                <div>
                    <h4 class="section-title text-base font-semibold">Filtros</h4>
                    <p class="muted-text mt-1 text-sm">
                        Consulte os chamados aplicando os filtros documentados do sistema.
                    </p>
                </div>

                <form method="GET" action="{{ route('tickets.index') }}" class="mt-5 grid gap-6 md:grid-cols-4">
                    <div class="space-y-2">
                        <x-input-label for="status" value="Status" />
                        <x-select id="status" name="status" class="block w-full">
                            <option value="">Todos</option>
                            @foreach (\App\Enums\TicketStatus::cases() as $status)
                                <option value="{{ $status->value }}" @selected(($filters['status'] ?? null) === $status->value)>
                                    {{ $status->value }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error :messages="$errors->get('status')" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="priority" value="Prioridade" />
                        <x-select id="priority" name="priority" class="block w-full">
                            <option value="">Todas</option>
                            @foreach (\App\Enums\TicketPriority::cases() as $priority)
                                <option value="{{ $priority->value }}" @selected(($filters['priority'] ?? null) === $priority->value)>
                                    {{ $priority->value }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error :messages="$errors->get('priority')" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="responsible_id" value="Responsavel" />
                        <x-select id="responsible_id" name="responsible_id" class="block w-full">
                            <option value="">Todos</option>
                            @foreach ($responsibleUsers as $responsibleUser)
                                <option
                                    value="{{ $responsibleUser->id }}"
                                    @selected((string) ($filters['responsible_id'] ?? '') === (string) $responsibleUser->id)
                                >
                                    {{ $responsibleUser->name }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error :messages="$errors->get('responsible_id')" />
                    </div>

                    <div class="flex items-end gap-3">
                        <x-primary-button>
                            Filtrar
                        </x-primary-button>

                        <a
                            href="{{ route('tickets.index') }}"
                            class="btn-secondary"
                        >
                            Limpar
                        </a>
                    </div>
                </form>
            </div>

            <x-table>
                <thead class="table-head">
                    <tr>
                        <th class="table-head-text px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Titulo</th>
                        <th class="table-head-text px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Prioridade</th>
                        <th class="table-head-text px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Status</th>
                        <th class="table-head-text px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Solicitante</th>
                        <th class="table-head-text px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Responsavel</th>
                        <th class="table-head-text px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Abertura</th>
                        <th class="table-head-text px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide">Acoes</th>
                    </tr>
                </thead>
                <tbody class="divide-y table-row-border bg-[var(--color-surface)]">
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td class="px-4 py-4 text-sm font-medium text-[var(--color-text)]">
                                {{ $ticket->title }}
                            </td>
                            <td class="px-4 py-4 text-sm text-[var(--color-text-muted)]">
                                <x-priority-badge :value="$ticket->priority->value" />
                            </td>
                            <td class="px-4 py-4 text-sm text-[var(--color-text-muted)]">
                                <x-status-badge :value="$ticket->status->value" />
                            </td>
                            <td class="px-4 py-4 text-sm text-[var(--color-text-muted)]">
                                {{ $ticket->requester->name }}
                            </td>
                            <td class="px-4 py-4 text-sm text-[var(--color-text-muted)]">
                                {{ $ticket->responsible->name }}
                            </td>
                            <td class="px-4 py-4 text-sm text-[var(--color-text-muted)]">
                                {{ $ticket->opened_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-4 text-right text-sm">
                                <a href="{{ route('tickets.show', $ticket) }}" class="link-brand">
                                    Ver
                                </a>
                                <a href="{{ route('tickets.edit', $ticket) }}" class="ml-4 font-medium text-[var(--color-text-muted)] transition hover:text-[var(--color-text)]">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-[var(--color-text-muted)]">
                                Nenhum chamado encontrado para os filtros informados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-table>

            <div>
                {{ $tickets->links() }}
            </div>
        </x-card>
    </div>
</x-app-layout>
