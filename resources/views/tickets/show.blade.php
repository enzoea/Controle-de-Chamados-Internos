<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title text-xl font-semibold leading-tight">
            Detalhes do chamado
        </h2>
    </x-slot>

    <div class="space-y-6">
        <x-card class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="section-title text-lg font-semibold">{{ $ticket->title }}</h3>
                    <p class="muted-text mt-1 text-sm">
                        Dados completos do chamado selecionado.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <x-priority-badge :value="$ticket->priority->value" />
                    <x-status-badge :value="$ticket->status->value" />
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-2">
                    <p class="eyebrow-text">Solicitante</p>
                    <div class="surface-muted px-4 py-3 text-sm text-[var(--color-text-muted)]">
                        <div>{{ $ticket->requester->name }}</div>
                        <div>{{ $ticket->requester->email }}</div>
                    </div>
                </div>

                <div class="space-y-2">
                    <p class="eyebrow-text">Responsavel</p>
                    <div class="surface-muted px-4 py-3 text-sm text-[var(--color-text-muted)]">
                        <div>{{ $ticket->responsible->name }}</div>
                        <div>{{ $ticket->responsible->email }}</div>
                    </div>
                </div>

                <div class="space-y-2">
                    <p class="eyebrow-text">Data de abertura</p>
                    <div class="surface-muted px-4 py-3 text-sm text-[var(--color-text-muted)]">
                        {{ $ticket->opened_at->format('d/m/Y H:i') }}
                    </div>
                </div>

                <div class="space-y-2">
                    <p class="eyebrow-text">Ultima atualizacao</p>
                    <div class="surface-muted px-4 py-3 text-sm text-[var(--color-text-muted)]">
                        {{ $ticket->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <p class="eyebrow-text">Descricao</p>
                <div class="surface-muted px-4 py-3 text-sm leading-6 text-[var(--color-text-muted)]">
                    {{ $ticket->description }}
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a
                    href="{{ route('tickets.index') }}"
                    class="btn-secondary"
                >
                    Voltar
                </a>

                <a
                    href="{{ route('tickets.edit', $ticket) }}"
                    class="btn-primary"
                >
                    Editar chamado
                </a>
            </div>
        </x-card>
    </div>
</x-app-layout>
