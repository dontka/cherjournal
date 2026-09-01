<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9._-]+$/', 'unique:'.User::class.',username'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="mb-8 text-center lg:text-left">
        <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-stone-500">Créer un compte</p>
        <h1 class="mt-2 text-3xl font-semibold text-stone-900">Bienvenue.</h1>
    </div>

    <form wire:submit="register" class="space-y-5">
        <div>
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input wire:model="name" id="name" class="cj-input" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Pseudonyme')" />
            <x-text-input wire:model="username" id="username" class="cj-input" type="text" name="username" required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="cj-input" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input wire:model="password" id="password" class="cj-input"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="cj-input"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center rounded-xl bg-stone-900 px-4 py-3 text-sm font-medium text-white shadow-sm hover:bg-stone-700">
                {{ __('Créer mon compte') }}
            </x-primary-button>
        </div>

        <div class="pt-2 text-center text-sm text-stone-600">
            Déjà inscrit ?
            <a href="{{ route('login') }}" class="font-medium text-stone-900 underline-offset-4 hover:underline" wire:navigate>Se connecter</a>
        </div>
    </form>
</div>
