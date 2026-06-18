<x-app-layout>

    <div class="space-y-6">
        <x-card class="space-y-6">
            <div>
                <h3 class="section-title text-lg font-semibold">Novo chamado</h3>
                <p class="muted-text mt-1 text-sm">
                    Preencha os dados abaixo para registrar um novo chamado interno.
                </p>
            </div>

            @include('tickets.form', [
                'action' => route('tickets.store'),
                'responsibleUsers' => $responsibleUsers,
                'submitLabel' => 'Salvar chamado',
            ])
        </x-card>
    </div>
</x-app-layout>
