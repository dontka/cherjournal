<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-[1380px] space-y-6 px-2 sm:px-3 lg:px-4">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-3xl border border-rose-100 bg-gradient-to-br from-rose-50 to-white p-5 shadow-sm">
                    <p class="text-sm text-stone-500">Entrées ce mois</p>
                    <p class="mt-3 text-3xl font-bold text-stone-900">12</p>
                </div>
                <div class="rounded-3xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white p-5 shadow-sm">
                    <p class="text-sm text-stone-500">Soutiens reçus</p>
                    <p class="mt-3 text-3xl font-bold text-stone-900">48</p>
                </div>
                <div class="rounded-3xl border border-violet-100 bg-gradient-to-br from-violet-50 to-white p-5 shadow-sm">
                    <p class="text-sm text-stone-500">Mood moyen</p>
                    <p class="mt-3 text-3xl font-bold text-stone-900">Calme</p>
                </div>
            </div>

            <div class="rounded-3xl border border-stone-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium uppercase tracking-[0.18em] text-stone-500">Aujourd’hui</p>
                        <h3 class="mt-2 text-2xl font-bold text-stone-900">Écrire une nouvelle entrée</h3>
                    </div>
                    <button class="rounded-full bg-stone-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-stone-700">
                        + Nouvelle note
                    </button>
                </div>

                <div class="mt-6 rounded-2xl border border-dashed border-stone-300 bg-stone-50 p-6 text-stone-600">
                    Un espace pour faire le point, exprimer ce que l’on ressent et reprendre le contrôle de son rythme.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
