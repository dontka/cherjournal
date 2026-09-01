<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-[1380px] space-y-5 px-2 sm:px-3 lg:px-4">
            <div class="grid gap-4 lg:grid-cols-12">
                <div class="cj-bento bg-[linear-gradient(135deg,_#fffaf7_0%,_#f5eae4_100%)] lg:col-span-12">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Compte</p>
                            <h3 class="mt-2 text-2xl font-bold text-stone-900">Personnalise ton identité</h3>
                        </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="rounded-full bg-amber-50 px-3 py-1 text-[11px] font-semibold text-amber-700">{{ auth()->user()->profile?->points ?? 0 }} points</span>
                                <a href="{{ route('onboarding') }}" wire:navigate class="rounded-full bg-stone-900 px-3 py-2 text-[11px] font-semibold text-white transition hover:bg-stone-700">Personnaliser mon espace</a>
                            </div>
                    </div>
                </div>

                <div class="cj-shell p-4 sm:p-6 lg:col-span-8">
                    <div class="max-w-2xl">
                        <livewire:profile.update-profile-information-form />
                    </div>
                </div>

                <div class="space-y-4 lg:col-span-4">
                    <div class="cj-bento bg-[linear-gradient(135deg,_#f0f9f5_0%,_#dff3e7_100%)]">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-stone-500">Confidentialité</p>
                        <h4 class="mt-3 text-xl font-bold text-stone-900">Anonymat actif</h4>
                        <p class="mt-2 text-sm leading-6 text-stone-600">Ton profil reste protégé et ton espace est pensé pour une présence rassurante.</p>
                    </div>

                    <div class="cj-shell p-4 sm:p-5">
                        <div class="max-w-xl">
                            <livewire:profile.update-password-form />
                        </div>
                    </div>

                    <div class="cj-shell p-4 sm:p-5">
                        <div class="max-w-xl">
                            <livewire:profile.delete-user-form />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
