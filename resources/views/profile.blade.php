<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-[1380px] space-y-6 px-2 sm:px-3 lg:px-4">
            <div class="cj-shell px-5 py-5 sm:px-8">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-500">Compte</p>
                        <h3 class="mt-2 text-2xl font-bold text-stone-900">Personnalise ton identité</h3>
                    </div>
                    <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-medium text-rose-700">Espace personnel sécurisé</span>
                </div>
            </div>

            <div class="grid gap-4 xl:grid-cols-12">
                <div class="cj-bento xl:col-span-7 bg-[linear-gradient(135deg,_#fffaf8_0%,_#f3e7e3_100%)] p-4 sm:p-6">
                    <div class="max-w-2xl">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>

                <div class="space-y-4 xl:col-span-5">
                    <div class="cj-bento bg-[linear-gradient(135deg,_#f4faf6_0%,_#ddefe3_100%)] p-4 sm:p-6">
                        <div class="max-w-xl">
                            <livewire:profile.update-password-form />
                        </div>
                    </div>

                    <div class="cj-bento bg-[linear-gradient(135deg,_#fff5f5_0%,_#f8e3e6_100%)] p-4 sm:p-6">
                        <div class="max-w-xl">
                            <livewire:profile.delete-user-form />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
