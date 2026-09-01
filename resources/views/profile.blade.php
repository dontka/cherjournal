<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-stone-800">
            {{ __('Mon profil') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div class="cj-shell px-6 py-5 sm:px-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-500">Compte</p>
                        <h3 class="mt-2 text-2xl font-bold text-stone-900">Personnalise ton identité</h3>
                    </div>
                    <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-medium text-rose-700">Espace personnel sécurisé</span>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[1.3fr_0.7fr]">
                <div class="cj-shell p-4 sm:p-8">
                    <div class="max-w-2xl">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="cj-shell p-4 sm:p-8">
                        <div class="max-w-xl">
                            <livewire:profile.update-password-form />
                        </div>
                    </div>

                    <div class="cj-shell p-4 sm:p-8">
                        <div class="max-w-xl">
                            <livewire:profile.delete-user-form />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
