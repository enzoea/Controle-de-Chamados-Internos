<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Editar chamado
        </h2>
    </x-slot>

    <div class="space-y-6">
        <x-card class="space-y-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Atualizacao do chamado</h3>
                <p class="mt-1 text-sm text-gray-600">
                    Altere os dados necessarios, incluindo status e atribuicao do chamado.
                </p>
            </div>

            @include('tickets.form', [
                'ticket' => $ticket,
                'action' => route('tickets.update', $ticket),
                'method' => 'PUT',
                'responsibleUsers' => $responsibleUsers,
                'submitLabel' => 'Atualizar chamado',
                'showStatus' => true,
            ])
        </x-card>
    </div>
</x-app-layout>
