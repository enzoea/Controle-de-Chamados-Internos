<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Sistema de Controle de Chamados Internos') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gray-100 text-gray-900">
        <main class="mx-auto flex min-h-screen max-w-7xl items-center px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid w-full gap-6 lg:grid-cols-[minmax(0,1fr)_420px]">
                <section class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-200">
                    <p class="text-sm font-semibold uppercase tracking-[0.2em] text-indigo-600">Projeto Base</p>
                    <h1 class="mt-4 text-3xl font-semibold tracking-tight text-gray-900">
                        Sistema de Controle de Chamados Internos
                    </h1>
                    <p class="mt-4 text-base leading-7 text-gray-600">
                        Base inicial em Laravel configurada para autenticacao, protecao de rotas, interface com Blade e TailwindCSS e ambiente local com SQLite.
                    </p>

                    <dl class="mt-8 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <dt class="text-sm font-medium text-gray-500">Backend</dt>
                            <dd class="mt-1 text-sm text-gray-900">Laravel 12, Eloquent ORM e autenticacao basica</dd>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <dt class="text-sm font-medium text-gray-500">Frontend</dt>
                            <dd class="mt-1 text-sm text-gray-900">Blade, TailwindCSS e Alpine.js</dd>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <dt class="text-sm font-medium text-gray-500">Banco local</dt>
                            <dd class="mt-1 text-sm text-gray-900">SQLite configurado para desenvolvimento</dd>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900">Pronto para evolucao nas proximas fases</dd>
                        </div>
                    </dl>
                </section>

                <aside class="rounded-2xl bg-slate-900 p-8 text-white shadow-sm">
                    <h2 class="text-xl font-semibold">Acesso ao sistema</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-300">
                        Nesta fase o sistema expoe apenas o fluxo de autenticacao aprovado: login, logout e protecao das rotas internas.
                    </p>

                    <div class="mt-8 space-y-3">
                        @auth
                            <a
                                href="{{ route('dashboard') }}"
                                class="inline-flex w-full items-center justify-center rounded-lg bg-indigo-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-400"
                            >
                                Ir para o dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="inline-flex w-full items-center justify-center rounded-lg bg-indigo-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-400"
                            >
                                Entrar
                            </a>
                        @endauth
                    </div>
                </aside>
            </div>
        </main>
    </body>
</html>
