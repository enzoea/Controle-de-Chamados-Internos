<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Detalhes do chamado
        </h2>
    </x-slot>

    <div class="space-y-6">
        <x-card class="space-y-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $ticket->title }}</h3>
                    <p class="mt-1 text-sm text-gray-600">
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
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Solicitante</p>
                    <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                        <div>{{ $ticket->requester->name }}</div>
                        <div>{{ $ticket->requester->email }}</div>
                    </div>
                </div>

                <div class="space-y-2">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Responsavel</p>
                    <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                        <div>{{ $ticket->responsible->name }}</div>
                        <div>{{ $ticket->responsible->email }}</div>
                    </div>
                </div>

                <div class="space-y-2">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Data de abertura</p>
                    <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                        {{ $ticket->opened_at->format('d/m/Y H:i') }}
                    </div>
                </div>

                <div class="space-y-2">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Ultima atualizacao</p>
                    <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-700">
                        {{ $ticket->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Descricao</p>
                <div class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm leading-6 text-gray-700">
                    {{ $ticket->description }}
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a
                    href="{{ route('tickets.index') }}"
                    class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50"
                >
                    Voltar
                </a>

                <a
                    href="{{ route('tickets.edit', $ticket) }}"
                    class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700"
                >
                    Editar chamado
                </a>
            </div>
        </x-card>
    </div>
</x-app-layout>
