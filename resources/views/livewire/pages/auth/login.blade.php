<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-6 rounded-[1.5rem] border border-stone-200 bg-stone-50/80 p-4">
        <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-stone-500">Connexion</p>
        <h1 class="mt-2 text-3xl font-semibold text-stone-900">Rebonjour.</h1>
        <p class="mt-2 text-sm text-stone-600">Rien de compliqué. On revient à ce qui compte : te sentir en sécurité.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="cj-input" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input wire:model="form.password" id="password" class="cj-input"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-3 pt-2">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="h-4 w-4 rounded border-stone-300 text-stone-900 shadow-sm focus:ring-stone-500" name="remember">
                <span class="ms-2 text-sm text-stone-600">Se souvenir de moi</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-stone-600 transition hover:text-stone-900" href="{{ route('password.request') }}" wire:navigate>
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="cj-button-primary w-full">
                {{ __('Se connecter') }}
            </button>
        </div>

        <div class="rounded-[1.25rem] border border-stone-200 bg-stone-50/80 p-3 text-center text-sm text-stone-600">
            Pas encore inscrit ?
            <a href="{{ route('register') }}" class="font-medium text-stone-900 underline-offset-4 hover:underline" wire:navigate>Créer un compte</a>
        </div>
    </form>
</div>
