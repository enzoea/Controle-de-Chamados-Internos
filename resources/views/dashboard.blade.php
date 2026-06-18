<x-app-layout>

    <div class="space-y-6">
        @if (session('success'))
            <x-alert>
                {{ session('success') }}
            </x-alert>
        @endif

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">
            <x-stat-card label="Total de chamados" :value="$stats['total']" icon="chart" />
            <x-stat-card label="Chamados abertos" :value="$stats['abertos']" icon="open" />
            <x-stat-card label="Chamados Em andamento" :value="$stats['em_andamento']" icon="progress" />
            <x-stat-card label="Chamados Resolvidos" :value="$stats['resolvidos']" icon="resolved" />
            <x-stat-card label="Chamados Fechados" :value="$stats['fechados']" icon="closed" />
        </div>

        <x-card class="space-y-4">
            <div>
                <h3 class="section-title text-lg font-semibold">Acoes rapidas</h3>
                <p class="muted-text mt-1 text-sm">
                    Utilize os atalhos abaixo para abrir ou consultar chamados no sistema.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ route('tickets.index') }}"
                    class="btn-secondary"
                >
                    Consultar chamados
                </a>
                <a
                    href="{{ route('tickets.create') }}"
                    class="btn-primary"
                >
                    Abrir novo chamado
                </a>
            </div>
        </x-card>
    </div>
</x-app-layout>
