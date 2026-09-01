<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-[1380px] space-y-5 px-2 sm:px-3 lg:px-4">
            <div class="grid gap-4 lg:grid-cols-12">
                <div class="cj-bento bg-[linear-gradient(135deg,_#fff7f3_0%,_#fbe3dc_100%)] lg:col-span-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Journal</p>
                    <p class="mt-4 text-4xl font-black text-stone-900">{{ auth()->user()->journalEntries()->count() }}</p>
                    <p class="mt-2 text-[10px] uppercase tracking-[0.18em] text-stone-500">entrées</p>
                </div>

                <div class="cj-bento bg-[linear-gradient(135deg,_#eefbf4_0%,_#dff3e7_100%)] lg:col-span-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Rythme</p>
                    <p class="mt-4 text-4xl font-black text-stone-900">12j</p>
                    <p class="mt-2 text-[10px] uppercase tracking-[0.18em] text-stone-500">conséquence</p>
                </div>

                <div class="cj-bento bg-[linear-gradient(135deg,_#f5f0ff_0%,_#e6dcff_100%)] lg:col-span-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Soutiens</p>
                    <p class="mt-4 text-4xl font-black text-stone-900">24</p>
                    <p class="mt-2 text-[10px] uppercase tracking-[0.18em] text-stone-500">réactions</p>
                </div>

                <div class="cj-bento bg-[linear-gradient(135deg,_#fff6eb_0%,_#f4dfc8_100%)] lg:col-span-3">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Énergie</p>
                    <p class="mt-4 text-3xl font-black text-stone-900">Calme</p>
                    <p class="mt-2 text-[10px] uppercase tracking-[0.18em] text-stone-500">stable</p>
                </div>

                <div class="cj-shell p-4 sm:p-6 lg:col-span-8">
                    <livewire:journal.create-entry-form />
                </div>

                <div class="cj-shell p-5 lg:col-span-4">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Mes dernières notes</p>
                    <div class="mt-4 space-y-3">
                        @forelse(auth()->user()->journalEntries()->latest()->limit(3)->get() as $entry)
                            <div class="rounded-[1rem] border border-stone-200 bg-stone-50 p-3">
                                <div class="flex items-center justify-between gap-3">
                                    <p class="text-sm font-semibold text-stone-800">{{ $entry->title ?: 'Sans titre' }}</p>
                                    <span class="rounded-full bg-white px-2 py-1 text-[10px] uppercase tracking-[0.12em] text-stone-500">{{ $entry->status }}</span>
                                </div>
                                <p class="mt-2 line-clamp-3 text-sm leading-6 text-stone-600">{{ Str::limit($entry->content, 120) }}</p>
                            </div>
                        @empty
                            <div class="rounded-[1rem] border border-dashed border-stone-300 bg-stone-50 p-4 text-sm text-stone-600">
                                Tes premières notes apparaîtront ici.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
