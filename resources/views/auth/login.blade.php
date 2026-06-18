<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 space-y-2">
        <p class="eyebrow-text">Acesso restrito</p>
        <h1 class="page-title text-2xl font-semibold">Entrar no sistema</h1>
        <p class="muted-text text-sm">
            Informe suas credenciais para acessar o painel de chamados internos.
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" value="E-mail" />
            <x-text-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <x-input-label for="password" value="Senha" />

            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox" class="checkbox-brand rounded border-[var(--color-border)]" name="remember">
                <span class="muted-text text-sm">Lembrar-me</span>
            </label>
        </div>

        <div class="flex items-center justify-end">
            <x-primary-button>
                Entrar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
