<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-[1380px] space-y-6 px-2 sm:px-3 lg:px-4">
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
