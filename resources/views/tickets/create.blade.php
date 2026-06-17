<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Abrir chamado
        </h2>
    </x-slot>

    <div class="space-y-6">
        <x-card class="space-y-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Novo chamado</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Preencha os dados abaixo para registrar um novo chamado interno.
                </p>
            </div>

            @if ($errors->has('responsible_id') && old('responsible_id') === 'automatic')
                <x-alert type="error">
                    {{ $errors->first('responsible_id') }}
                </x-alert>
            @endif

            <form method="POST" action="{{ route('tickets.store') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <x-input-label for="title" value="Titulo" />
                    <x-text-input
                        id="title"
                        name="title"
                        type="text"
                        class="block w-full"
                        :value="old('title')"
                        required
                    />
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                <div class="space-y-2">
                    <x-input-label for="description" value="Descricao" />
                    <x-textarea
                        id="description"
                        name="description"
                        rows="5"
                        class="block w-full"
                        required
                    >{{ old('description') }}</x-textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-2">
                        <x-input-label for="priority" value="Prioridade" />
                        <x-select
                            id="priority"
                            name="priority"
                            class="block w-full"
                            required
                        >
                            <option value="">Selecione</option>
                            @foreach (\App\Enums\TicketPriority::cases() as $priority)
                                <option value="{{ $priority->value }}" @selected(old('priority') === $priority->value)>
                                    {{ $priority->value }}
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error :messages="$errors->get('priority')" />
                    </div>

                    <div class="space-y-2">
                        <x-input-label for="responsible_id" value="Atribuicao" />
                        <x-select
                            id="responsible_id"
                            name="responsible_id"
                            class="block w-full"
                            required
                        >
                            <option value="">Selecione</option>
                            <option
                                value="automatic"
                                @selected(old('responsible_id') === 'automatic')
                            >
                                Distribuicao automatica
                            </option>
                            @foreach ($responsibleUsers as $responsibleUser)
                                <option
                                    value="{{ $responsibleUser->id }}"
                                    @selected(old('responsible_id') === (string) $responsibleUser->id)
                                >
                                    {{ $responsibleUser->name }} ({{ $responsibleUser->email }})
                                </option>
                            @endforeach
                        </x-select>
                        <x-input-error
                            :messages="old('responsible_id') === 'automatic' ? [] : $errors->get('responsible_id')"
                        />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50"
                    >
                        Cancelar
                    </a>

                    <x-primary-button>
                        Salvar chamado
                    </x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
