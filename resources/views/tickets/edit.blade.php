<x-app-layout>

    <div class="space-y-6">
        <x-card class="space-y-6">
            <div>
                <h3 class="section-title text-lg font-semibold">Atualizacao do chamado</h3>
                <p class="muted-text mt-1 text-sm">
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
