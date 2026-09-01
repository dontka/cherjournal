<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-[1380px] space-y-6 px-2 sm:px-3 lg:px-4">
            <div class="grid gap-4 md:grid-cols-12">
                <div class="cj-bento md:col-span-4 bg-[linear-gradient(135deg,_#fff7f3_0%,_#f9e4dc_100%)]">
                    <p class="text-sm text-stone-500">Entrées ce mois</p>
                    <div class="mt-5 flex items-end justify-between gap-3">
                        <p class="text-4xl font-bold text-stone-900">12</p>
                        <span class="rounded-full bg-white/70 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-stone-600">+ 4%</span>
                    </div>
                    <p class="mt-3 text-xs uppercase tracking-[0.18em] text-stone-500">Mois précédent</p>
                </div>

                <div class="cj-bento md:col-span-3 bg-[linear-gradient(135deg,_#edf9f2_0%,_#d9f3e4_100%)]">
                    <p class="text-sm text-stone-500">Soutiens</p>
                    <p class="mt-5 text-3xl font-bold text-stone-900">48</p>
                    <p class="mt-3 text-xs uppercase tracking-[0.18em] text-stone-500">Messages</p>
                </div>

                <div class="cj-bento md:col-span-3 bg-[linear-gradient(135deg,_#f5f1ff_0%,_#e5dcff_100%)]">
                    <p class="text-sm text-stone-500">Mood</p>
                    <p class="mt-5 text-3xl font-bold text-stone-900">Calme</p>
                    <p class="mt-3 text-xs uppercase tracking-[0.18em] text-stone-500">stable</p>
                </div>

                <div class="cj-bento md:col-span-2 bg-[linear-gradient(135deg,_#f5f0ea_0%,_#eadfce_100%)]">
                    <p class="text-sm text-stone-500">Série</p>
                    <p class="mt-5 text-3xl font-bold text-stone-900">9j</p>
                    <p class="mt-3 text-xs uppercase tracking-[0.18em] text-stone-500">suite</p>
                </div>
            </div>

            <div class="grid gap-4 xl:grid-cols-12">
                <div class="cj-shell p-5 sm:p-6 xl:col-span-8">
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

                <div class="cj-shell p-5 sm:p-6 xl:col-span-4">
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
