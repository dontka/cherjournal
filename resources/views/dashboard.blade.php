<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-[1380px] space-y-5 px-2 sm:px-3 lg:px-4">
            <div class="grid gap-4 lg:grid-cols-12">
                <div class="cj-bento group bg-[linear-gradient(135deg,_#fff8f6_0%,_#fbe8e2_100%)] lg:col-span-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Entrées</p>
                    <p class="mt-4 text-4xl font-black text-stone-900">12</p>
                    <p class="mt-2 text-[10px] uppercase tracking-[0.18em] text-stone-500">ce mois</p>
                </div>

                <div class="cj-bento group bg-[linear-gradient(135deg,_#f2faf3_0%,_#dff3e7_100%)] lg:col-span-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Soutiens</p>
                    <p class="mt-4 text-4xl font-black text-stone-900">48</p>
                    <p class="mt-2 text-[10px] uppercase tracking-[0.18em] text-stone-500">messages</p>
                </div>

                <div class="cj-bento group bg-[linear-gradient(135deg,_#f8f5ff_0%,_#e9e0ff_100%)] lg:col-span-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Mood</p>
                    <p class="mt-4 text-3xl font-black text-stone-900">Calme</p>
                    <p class="mt-2 text-[10px] uppercase tracking-[0.18em] text-stone-500">stable</p>
                </div>

                <div class="cj-bento group bg-[linear-gradient(135deg,_#fbf5ef_0%,_#f1e0cf_100%)] lg:col-span-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Série</p>
                    <p class="mt-4 text-4xl font-black text-stone-900">9j</p>
                    <p class="mt-2 text-[10px] uppercase tracking-[0.18em] text-stone-500">journal régulier</p>
                </div>

                <div class="cj-shell p-5 lg:col-span-7">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-500">Aujourd’hui</p>
                            <h3 class="mt-2 text-2xl font-bold text-stone-900">Écrire une nouvelle entrée</h3>
                        </div>
                        <button class="cj-button-primary">
                            + Nouvelle note
                        </button>
                    </div>

                    <div class="mt-5 rounded-[1rem] border border-dashed border-stone-300 bg-stone-50 p-5 text-sm leading-7 text-stone-600 sm:p-6">
                        Un espace pour faire le point, exprimer ce que l’on ressent et reprendre le contrôle de son rythme sans jugement.
                    </div>
                </div>

                <div class="cj-shell p-5 lg:col-span-5">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Récapitulatif</p>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between rounded-[0.9rem] bg-stone-50 px-3 py-3 transition hover:bg-stone-100">
                            <span class="text-sm text-stone-600">Confiance</span>
                            <span class="text-sm font-semibold text-stone-900">78%</span>
                        </div>
                        <div class="flex items-center justify-between rounded-[0.9rem] bg-stone-50 px-3 py-3 transition hover:bg-stone-100">
                            <span class="text-sm text-stone-600">Énergie</span>
                            <span class="text-sm font-semibold text-stone-900">Dynamique</span>
                        </div>
                        <div class="flex items-center justify-between rounded-[0.9rem] bg-stone-50 px-3 py-3 transition hover:bg-stone-100">
                            <span class="text-sm text-stone-600">Soutien</span>
                            <span class="text-sm font-semibold text-stone-900">5 proches</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
