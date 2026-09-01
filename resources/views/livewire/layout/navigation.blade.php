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

@php
    $menu = auth()->user()->profile?->menu ?: ['journal', 'dashboard', 'profile'];
@endphp

<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-stone-200/80 bg-white/80 backdrop-blur-sm shadow-[0_10px_30px_rgba(70,58,52,0.04)]">
    <div class="mx-auto max-w-[1400px] px-3 sm:px-4 lg:px-5">
        <div class="flex h-20 items-center justify-between gap-3">
            <div class="flex min-w-0 items-center gap-2 sm:gap-3">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex shrink-0 items-center gap-2 sm:gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-gradient-to-br from-stone-900 via-stone-700 to-stone-500 text-sm font-bold text-white shadow-[0_12px_24px_rgba(28,25,23,0.18)] sm:h-11 sm:w-11">C</div>
                    <div class="hidden min-w-0 leading-tight sm:block">
                        <div class="truncate text-[10px] font-semibold uppercase tracking-[0.24em] text-stone-500">Cher Journal</div>
                        <div class="truncate text-sm font-semibold text-stone-800">Espace utilisateur</div>
                    </div>
                </a>

                <div class="hidden items-center gap-2 md:flex">
                    @if (in_array('dashboard', $menu, true))
                        <a href="{{ route('dashboard') }}" wire:navigate class="rounded-full px-3.5 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900 {{ request()->routeIs('dashboard') ? 'bg-stone-900 text-white' : '' }}">
                            {{ __('Dashboard') }}
                        </a>
                    @endif
                    @if (in_array('journal', $menu, true))
                        <a href="{{ route('journal') }}" wire:navigate class="rounded-full px-3.5 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900 {{ request()->routeIs('journal') ? 'bg-stone-900 text-white' : '' }}">
                            {{ __('Mon journal') }}
                        </a>
                    @endif
                    @if (in_array('profile', $menu, true))
                        <a href="{{ route('profile') }}" wire:navigate class="rounded-full px-3.5 py-2 text-sm font-medium text-stone-600 transition hover:bg-stone-100 hover:text-stone-900 {{ request()->routeIs('profile') ? 'bg-stone-900 text-white' : '' }}">
                            {{ __('Mon profil') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="hidden items-center gap-2 sm:flex">
                <div class="flex items-center gap-2 rounded-full border border-stone-200 bg-stone-50 px-2 py-1.5 shadow-[0_8px_20px_rgba(70,58,52,0.03)]">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-rose-200 to-orange-100 text-[11px] font-bold text-stone-700">
                        {{ strtoupper(substr(auth()->user()->name ?? 'C', 0, 1)) }}
                    </div>
                    <div class="hidden text-left leading-tight xl:block">
                        <div class="text-sm font-semibold text-stone-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                        <div class="text-[11px] text-stone-500">{{ auth()->user()->username ?: 'Compte' }}</div>
                    </div>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center rounded-full border border-stone-200 bg-white px-3 py-1.5 text-sm font-medium text-stone-600 transition hover:border-stone-300 hover:text-stone-900 focus:outline-none">
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

            <button @click="open = ! open" class="inline-flex items-center justify-center rounded-full bg-stone-900 p-2.5 text-white transition hover:bg-stone-700 focus:outline-none sm:hidden">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-stone-200 bg-white sm:hidden">
        <div class="space-y-1 px-3 py-3">
            @if (in_array('dashboard', $menu, true))
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endif
            @if (in_array('journal', $menu, true))
                <x-responsive-nav-link :href="route('journal')" :active="request()->routeIs('journal')" wire:navigate>
                    {{ __('Mon journal') }}
                </x-responsive-nav-link>
            @endif
            @if (in_array('profile', $menu, true))
                <x-responsive-nav-link :href="route('profile')" :active="request()->routeIs('profile')" wire:navigate>
                    {{ __('Mon profil') }}
                </x-responsive-nav-link>
            @endif
            <button wire:click="logout" class="w-full text-start">
                <x-responsive-nav-link>
                    {{ __('Se déconnecter') }}
                </x-responsive-nav-link>
            </button>
        </div>
    </div>
</nav>
