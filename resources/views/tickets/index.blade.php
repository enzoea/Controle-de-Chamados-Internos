<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Chamados
        </h2>
    </x-slot>

    <div class="space-y-6">
        <x-card class="space-y-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Filtros</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Consulte os chamados aplicando os filtros documentados do sistema.
                </p>
            </div>

            <form method="GET" action="{{ route('tickets.index') }}" class="grid gap-6 md:grid-cols-4">
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
                        class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50"
                    >
                        Limpar
                    </a>
                </div>
            </form>
        </x-card>

        <x-card class="space-y-4">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Listagem de chamados</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Ordenacao padrao por data de abertura mais recente.
                    </p>
                </div>

                <a
                    href="{{ route('tickets.create') }}"
                    class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700"
                >
                    Abrir chamado
                </a>
            </div>

            <x-table>
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Titulo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Prioridade</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Solicitante</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Responsavel</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Abertura</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide text-gray-500">Acoes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                {{ $ticket->title }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                <x-priority-badge :value="$ticket->priority->value" />
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                <x-status-badge :value="$ticket->status->value" />
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ $ticket->requester->name }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ $ticket->responsible->name }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700">
                                {{ $ticket->opened_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-4 text-right text-sm">
                                <a href="{{ route('tickets.show', $ticket) }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                    Ver
                                </a>
                                <a href="{{ route('tickets.edit', $ticket) }}" class="ml-4 font-medium text-gray-700 hover:text-gray-900">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">
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
