<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen flex-col">
            @include('layouts.navigation')

            <div class="flex-1">
                <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-6 sm:px-6 lg:flex-row lg:px-8">
                    <aside class="surface-card w-full shrink-0 p-5 lg:w-64">
                        <p class="eyebrow-text">Navegacao</p>
                        <nav class="mt-4 flex flex-col gap-2">
                            <a
                                href="{{ route('dashboard') }}"
                                class="{{ request()->routeIs('dashboard') ? 'nav-link-base nav-link-active' : 'nav-link-base nav-link-inactive' }}"
                            >
                                Dashboard
                            </a>
                            <a
                                href="{{ route('tickets.index') }}"
                                class="{{ request()->routeIs('tickets.index') || request()->routeIs('tickets.show') || request()->routeIs('tickets.edit') ? 'nav-link-base nav-link-active' : 'nav-link-base nav-link-inactive' }}"
                            >
                                Chamados
                            </a>
                            <a
                                href="{{ route('tickets.create') }}"
                                class="{{ request()->routeIs('tickets.create') ? 'nav-link-base nav-link-active' : 'nav-link-base nav-link-inactive' }}"
                            >
                                Abrir chamado
                            </a>
                        </nav>
                    </aside>

                    <div class="flex-1 space-y-6">
                        @isset($header)
                            <header class="surface-card px-6 py-5">
                                {{ $header }}
                            </header>
                        @endisset

                        <main>
                            {{ $slot }}
                        </main>
                    </div>
                </div>
            </div>

            <footer class="border-t border-[var(--color-border)] bg-[var(--color-surface)]">
                <div class="mx-auto max-w-7xl px-4 py-4 text-sm text-[var(--color-text-muted)] sm:px-6 lg:px-8">
                    Sistema de Controle de Chamados Internos
                </div>
            </footer>
        </div>
    </body>
</html>
