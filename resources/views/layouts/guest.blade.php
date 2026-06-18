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
        <main class="auth-shell">
            <section class="auth-panel-copy">
                <a href="{{ route('home') }}" class="inline-flex w-fit">
                    <x-application-logo class="h-auto w-auto text-[var(--color-brand)]" />
                </a>

                <div class="max-w-2xl space-y-6">
                    <p class="eyebrow-text">Atendimento interno com mais clareza</p>
                    <h1 class="page-title text-4xl font-semibold leading-[1.15] lg:text-5xl">
                        <span class="block">Organize, acompanhe e</span>
                        <span class="text-brand-strong block font-semibold leading-[1.15]">
                            resolva chamados com mais agilidade.
                        </span>
                    </h1>
                    <p class="muted-text max-w-xl text-base leading-8">
                        O sistema centraliza a abertura, a atribuicao e o acompanhamento dos chamados internos, oferecendo visibilidade para o time e um fluxo simples para tratar demandas do inicio ao encerramento.
                    </p>
                </div>
            </section>

            <section class="auth-panel-login">
                <div class="surface-card auth-card overflow-hidden px-6 py-6 sm:px-8 sm:py-8">
                    {{ $slot }}
                </div>
            </section>
        </main>
    </body>
</html>
