<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-stone-200/80 bg-white/80 backdrop-blur-sm shadow-[0_10px_30px_rgba(70,58,52,0.04)]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-18 items-center justify-between gap-4 py-3">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-rose-200 via-orange-100 to-emerald-100 text-base font-bold text-stone-700 shadow-inner">C</div>
                    <div class="leading-tight">
                        <div class="text-[10px] font-semibold uppercase tracking-[0.24em] text-stone-500">Cher Journal</div>
                        <div class="text-sm font-semibold text-stone-800">Espace utilisateur</div>
                    </div>
                </a>

                <div class="hidden items-center gap-2 sm:flex">
                    <a href="{{ route('dashboard') }}" wire:navigate class="rounded-full px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900 {{ request()->routeIs('dashboard') ? 'bg-stone-900 text-white' : '' }}">
                        {{ __('Mon journal') }}
                    </a>
                    <a href="{{ route('profile') }}" wire:navigate class="rounded-full px-3 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900 {{ request()->routeIs('profile') ? 'bg-stone-900 text-white' : '' }}">
                        {{ __('Mon profil') }}
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <div class="flex items-center gap-3 rounded-full border border-stone-200 bg-stone-50 px-2 py-1.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-rose-200 to-orange-100 text-xs font-bold text-stone-700">
                        {{ strtoupper(substr(auth()->user()->name ?? 'C', 0, 1)) }}
                    </div>
                    <div class="text-left leading-tight">
                        <div class="text-sm font-semibold text-stone-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                        <div class="text-[11px] text-stone-500">{{ auth()->user()->username ?: 'Compte personnel' }}</div>
                    </div>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-full border border-stone-200 bg-white px-3 py-2 text-sm font-medium text-stone-600 transition hover:border-stone-300 hover:text-stone-900 focus:outline-none">
                            Menu
                            <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Se déconnecter') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-full bg-stone-900 p-2.5 text-white transition hover:bg-stone-700 focus:outline-none">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-stone-200 bg-white sm:hidden">
        <div class="space-y-1 px-4 py-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Mon journal') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('profile')" :active="request()->routeIs('profile')" wire:navigate>
                {{ __('Mon profil') }}
            </x-responsive-nav-link>
            <button wire:click="logout" class="w-full text-start">
                <x-responsive-nav-link>
                    {{ __('Se déconnecter') }}
                </x-responsive-nav-link>
            </button>
        </div>
    </div>
</nav>
