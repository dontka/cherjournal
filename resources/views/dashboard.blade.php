<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-[1380px] space-y-6 px-2 sm:px-3 lg:px-4">
            <div class="grid gap-4 md:grid-cols-3 xl:grid-cols-4">
                <div class="cj-bento md:col-span-1 xl:col-span-1 bg-[linear-gradient(135deg,_#fff8f6_0%,_#fbe8e2_100%)]">
                    <p class="text-sm text-stone-500">Entrées ce mois</p>
                    <p class="mt-3 text-3xl font-bold text-stone-900">12</p>
                    <p class="mt-2 text-xs uppercase tracking-[0.18em] text-stone-500">+ 4 vs. le mois dernier</p>
                </div>
                <div class="cj-bento md:col-span-1 xl:col-span-1 bg-[linear-gradient(135deg,_#f1faf5_0%,_#dff4e9_100%)]">
                    <p class="text-sm text-stone-500">Soutiens reçus</p>
                    <p class="mt-3 text-3xl font-bold text-stone-900">48</p>
                    <p class="mt-2 text-xs uppercase tracking-[0.18em] text-stone-500">messages chaleureux</p>
                </div>
                <div class="cj-bento md:col-span-1 xl:col-span-1 bg-[linear-gradient(135deg,_#f5f0ff_0%,_#e7e0ff_100%)]">
                    <p class="text-sm text-stone-500">Mood moyen</p>
                    <p class="mt-3 text-3xl font-bold text-stone-900">Calme</p>
                    <p class="mt-2 text-xs uppercase tracking-[0.18em] text-stone-500">stabilité douce</p>
                </div>
                <div class="cj-bento md:col-span-1 xl:col-span-1 bg-[linear-gradient(135deg,_#f8f4ef_0%,_#efe3d9_100%)]">
                    <p class="text-sm text-stone-500">Série actuelle</p>
                    <p class="mt-3 text-3xl font-bold text-stone-900">9 jours</p>
                    <p class="mt-2 text-xs uppercase tracking-[0.18em] text-stone-500">journal régulier</p>
                </div>
            </div>

            <div class="grid gap-4 xl:grid-cols-[1.2fr_0.8fr]">
                <div class="cj-shell p-5 sm:p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm font-medium uppercase tracking-[0.18em] text-stone-500">Aujourd’hui</p>
                            <h3 class="mt-2 text-2xl font-bold text-stone-900">Écrire une nouvelle entrée</h3>
                        </div>
                        <button class="cj-button-primary">
                            + Nouvelle note
                        </button>
                    </div>

                    <div class="mt-6 rounded-[1.5rem] border border-dashed border-stone-300 bg-stone-50 p-6 text-stone-600">
                        Un espace pour faire le point, exprimer ce que l’on ressent et reprendre le contrôle de son rythme.
                    </div>
                </div>

                <div class="cj-shell p-5 sm:p-6">
                    <p class="text-sm font-medium uppercase tracking-[0.18em] text-stone-500">Récapitulatif</p>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between rounded-[1.2rem] bg-stone-50 px-3 py-3">
                            <span class="text-sm text-stone-600">Confiance</span>
                            <span class="text-sm font-semibold text-stone-900">78%</span>
                        </div>
                        <div class="flex items-center justify-between rounded-[1.2rem] bg-stone-50 px-3 py-3">
                            <span class="text-sm text-stone-600">Énergie</span>
                            <span class="text-sm font-semibold text-stone-900">Dynamique</span>
                        </div>
                        <div class="flex items-center justify-between rounded-[1.2rem] bg-stone-50 px-3 py-3">
                            <span class="text-sm text-stone-600">Soutien</span>
                            <span class="text-sm font-semibold text-stone-900">5 proches</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
