<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-[1380px] space-y-5 px-2 sm:px-3 lg:px-4">
            @php
                $entries = auth()->user()->journalEntries();
                $total = $entries->count();
                $drafts = $entries->where('status', 'draft')->count();
                $published = $entries->where('status', 'published')->count();
                $archived = $entries->where('status', 'archived')->count();
                $latestEntry = auth()->user()->journalEntries()->latest()->first();
            @endphp

            <div class="grid grid-cols-4 gap-2 sm:gap-3 lg:gap-4">
                <div class="cj-bento group min-w-0 overflow-hidden bg-[linear-gradient(135deg,_#fff8f6_0%,_#fbe8e2_100%)]">
                    <p class="whitespace-nowrap text-[7px] font-semibold uppercase tracking-[0.18em] text-stone-500 sm:text-[8px] lg:text-[10px]">Total</p>
                    <p class="mt-1 text-xl font-black leading-none text-stone-900 sm:text-2xl lg:mt-2 lg:text-4xl">{{ $total }}</p>
                    <p class="mt-1 whitespace-nowrap text-[7px] uppercase tracking-[0.14em] text-stone-500 sm:text-[8px] lg:text-[10px]">entrées</p>
                </div>

                <div class="cj-bento group min-w-0 overflow-hidden bg-[linear-gradient(135deg,_#f2faf3_0%,_#dff3e7_100%)]">
                    <p class="whitespace-nowrap text-[7px] font-semibold uppercase tracking-[0.18em] text-stone-500 sm:text-[8px] lg:text-[10px]">Publiees</p>
                    <p class="mt-1 text-xl font-black leading-none text-stone-900 sm:text-2xl lg:mt-2 lg:text-4xl">{{ $published }}</p>
                    <p class="mt-1 whitespace-nowrap text-[7px] uppercase tracking-[0.14em] text-stone-500 sm:text-[8px] lg:text-[10px]">flux</p>
                </div>

                <div class="cj-bento group min-w-0 overflow-hidden bg-[linear-gradient(135deg,_#f8f5ff_0%,_#e9e0ff_100%)]">
                    <p class="whitespace-nowrap text-[7px] font-semibold uppercase tracking-[0.18em] text-stone-500 sm:text-[8px] lg:text-[10px]">Brouillons</p>
                    <p class="mt-1 text-xl font-black leading-none text-stone-900 sm:text-2xl lg:mt-2 lg:text-4xl">{{ $drafts }}</p>
                    <p class="mt-1 whitespace-nowrap text-[7px] uppercase tracking-[0.14em] text-stone-500 sm:text-[8px] lg:text-[10px]">attente</p>
                </div>

                <div class="cj-bento group min-w-0 overflow-hidden bg-[linear-gradient(135deg,_#fbf5ef_0%,_#f1e0cf_100%)]">
                    <p class="whitespace-nowrap text-[7px] font-semibold uppercase tracking-[0.18em] text-stone-500 sm:text-[8px] lg:text-[10px]">Archives</p>
                    <p class="mt-1 text-xl font-black leading-none text-stone-900 sm:text-2xl lg:mt-2 lg:text-4xl">{{ $archived }}</p>
                    <p class="mt-1 whitespace-nowrap text-[7px] uppercase tracking-[0.14em] text-stone-500 sm:text-[8px] lg:text-[10px]">sauvegardées</p>
                </div>
            </div>

            <div class="grid gap-5 lg:grid-cols-12">
                <div class="cj-shell p-5 lg:col-span-7">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-stone-500">Tableau de bord</p>
                            <h3 class="mt-2 text-2xl font-bold text-stone-900">Mon tableau de bord</h3>
                        </div>
                        <a href="{{ route('journal') }}" class="cj-button-primary">
                            + Nouvelle entrée
                        </a>
                    </div>

                    <div class="mt-5 rounded-[1rem] border border-dashed border-stone-300 bg-stone-50 p-5 text-sm leading-7 text-stone-600 sm:p-6">
                        @if ($latestEntry)
                            <p class="font-medium text-stone-800">Dernière note :</p>
                            <p class="mt-2 text-stone-700">{{ $latestEntry->title ?: 'Sans titre' }}</p>
                            <p class="mt-2 text-stone-600">{{ \Illuminate\Support\Str::limit($latestEntry->content, 180) }}</p>
                        @else
                            Un espace pour faire le point, exprimer ce que l’on ressent et reprendre le contrôle de son rythme sans jugement.
                        @endif
                    </div>

                    <div class="mt-5 grid gap-3 sm:grid-cols-3">
                        <a href="{{ route('journal') }}" class="rounded-[1rem] border border-stone-200 bg-stone-50 p-3 text-left transition hover:bg-stone-100">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-stone-500">Écrire</p>
                            <p class="mt-2 text-sm font-semibold text-stone-900">Nouvelle entrée</p>
                        </a>
                        <a href="{{ route('journal') }}" class="rounded-[1rem] border border-stone-200 bg-stone-50 p-3 text-left transition hover:bg-stone-100">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-stone-500">Brouillons</p>
                            <p class="mt-2 text-sm font-semibold text-stone-900">{{ $drafts }} en cours</p>
                        </a>
                        <a href="{{ route('journal') }}" class="rounded-[1rem] border border-stone-200 bg-stone-50 p-3 text-left transition hover:bg-stone-100">
                            <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-stone-500">Archives</p>
                            <p class="mt-2 text-sm font-semibold text-stone-900">{{ $archived }} conservées</p>
                        </a>
                    </div>
                </div>

                <div class="cj-shell p-5 lg:col-span-5">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Récapitulatif</p>
                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between rounded-[0.9rem] bg-stone-50 px-3 py-3 transition hover:bg-stone-100">
                            <span class="text-sm text-stone-600">Entrées publiées</span>
                            <span class="text-sm font-semibold text-stone-900">{{ $published }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-[0.9rem] bg-stone-50 px-3 py-3 transition hover:bg-stone-100">
                            <span class="text-sm text-stone-600">Brouillons</span>
                            <span class="text-sm font-semibold text-stone-900">{{ $drafts }}</span>
                        </div>
                        <div class="flex items-center justify-between rounded-[0.9rem] bg-stone-50 px-3 py-3 transition hover:bg-stone-100">
                            <span class="text-sm text-stone-600">Archives</span>
                            <span class="text-sm font-semibold text-stone-900">{{ $archived }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
