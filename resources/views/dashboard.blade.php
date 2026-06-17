<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <x-alert>
                {{ session('success') }}
            </x-alert>
        @endif

        <x-card class="space-y-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Cadastro de chamados</h3>
                <p class="mt-1 text-sm text-gray-600">
                    O fluxo de abertura de chamados ja esta disponivel para usuarios autenticados.
                </p>
            </div>

            <div>
                <a
                    href="{{ route('tickets.index') }}"
                    class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition hover:bg-gray-50"
                >
                    Consultar chamados
                </a>
                <a
                    href="{{ route('tickets.create') }}"
                    class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700"
                >
                    Abrir novo chamado
                </a>
            </div>
        </x-card>
    </div>
</x-app-layout>
