@props([
    'ticket' => null,
    'responsibleUsers' => collect(),
    'submitLabel' => 'Salvar chamado',
    'action',
    'method' => 'POST',
    'showStatus' => false,
])

@php
    $responsibleValue = old('responsible_id');

    if ($responsibleValue === null && $ticket !== null) {
        $responsibleValue = (string) $ticket->responsible_id;
    }
@endphp

@if ($errors->has('responsible_id') && $responsibleValue === 'automatic')
    <x-alert type="error">
        {{ $errors->first('responsible_id') }}
    </x-alert>
@endif

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="space-y-2">
        <x-input-label for="title" value="Titulo" />
        <x-text-input
            id="title"
            name="title"
            type="text"
            class="block w-full"
            :value="old('title', $ticket?->title)"
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
        >{{ old('description', $ticket?->description) }}</x-textarea>
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
                    <option
                        value="{{ $priority->value }}"
                        @selected(old('priority', $ticket?->priority?->value) === $priority->value)
                    >
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
                <option value="automatic" @selected($responsibleValue === 'automatic')>
                    Distribuicao automatica
                </option>
                @foreach ($responsibleUsers as $responsibleUser)
                    <option
                        value="{{ $responsibleUser->id }}"
                        @selected($responsibleValue === (string) $responsibleUser->id)
                    >
                        {{ $responsibleUser->name }} ({{ $responsibleUser->email }})
                    </option>
                @endforeach
            </x-select>
            <x-input-error :messages="$responsibleValue === 'automatic' ? [] : $errors->get('responsible_id')" />
        </div>
    </div>

    @if ($showStatus)
        <div class="space-y-2">
            <x-input-label for="status" value="Status" />
            <x-select
                id="status"
                name="status"
                class="block w-full"
                required
            >
                <option value="">Selecione</option>
                @foreach (\App\Enums\TicketStatus::cases() as $status)
                    <option
                        value="{{ $status->value }}"
                        @selected(old('status', $ticket?->status?->value) === $status->value)
                    >
                        {{ $status->value }}
                    </option>
                @endforeach
            </x-select>
            <x-input-error :messages="$errors->get('status')" />
        </div>
    @endif

    <div class="flex items-center justify-end gap-3">
        <a
            href="{{ route('dashboard') }}"
            class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50"
        >
            Cancelar
        </a>

        <x-primary-button>
            {{ $submitLabel }}
        </x-primary-button>
    </div>
</form>
