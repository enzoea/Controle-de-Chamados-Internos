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
    <body class="font-sans antialiased bg-gray-100 text-gray-900">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-6 sm:px-6 lg:flex-row lg:px-8">
                <aside class="w-full shrink-0 rounded-lg border border-gray-200 bg-white p-4 shadow-sm lg:w-64">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Navegacao</p>
                    <nav class="mt-4 space-y-2">
                        <a
                            href="{{ route('dashboard') }}"
                            class="block rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }}"
                        >
                            Dashboard
                        </a>
                    </nav>
                </aside>

                <div class="flex-1 space-y-6">
                    @isset($header)
                        <header class="rounded-lg border border-gray-200 bg-white px-6 py-4 shadow-sm">
                            {{ $header }}
                        </header>
                    @endisset

                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>

            <footer class="border-t border-gray-200 bg-white">
                <div class="mx-auto max-w-7xl px-4 py-4 text-sm text-gray-500 sm:px-6 lg:px-8">
                    Sistema de Controle de Chamados Internos
                </div>
            </footer>
        </div>
    </body>
</html>
