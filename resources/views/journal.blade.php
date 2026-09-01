<x-app-layout>
    <div class="py-8">
        <div class="mx-auto max-w-[1380px] space-y-5 px-2 sm:px-3 lg:px-4">
            <div class="grid grid-cols-4 gap-2 sm:gap-3 lg:gap-4">
                <div class="cj-bento min-w-0 overflow-hidden bg-[linear-gradient(135deg,_#fff7f3_0%,_#fbe3dc_100%)]">
                    <p class="whitespace-nowrap text-[7px] font-semibold uppercase tracking-[0.18em] text-stone-500 sm:text-[8px] lg:text-[10px]">Journal</p>
                    <p class="mt-1 text-xl font-black leading-none text-stone-900 sm:text-2xl lg:mt-2 lg:text-4xl">{{ auth()->user()->journalEntries()->count() }}</p>
                    <p class="mt-1 whitespace-nowrap text-[7px] uppercase tracking-[0.14em] text-stone-500 sm:text-[8px] lg:text-[10px]">entrées</p>
                </div>

                <div class="cj-bento min-w-0 overflow-hidden bg-[linear-gradient(135deg,_#eefbf4_0%,_#dff3e7_100%)]">
                    <p class="whitespace-nowrap text-[7px] font-semibold uppercase tracking-[0.18em] text-stone-500 sm:text-[8px] lg:text-[10px]">Rythme</p>
                    <p class="mt-1 text-xl font-black leading-none text-stone-900 sm:text-2xl lg:mt-2 lg:text-4xl">12j</p>
                    <p class="mt-1 whitespace-nowrap text-[7px] uppercase tracking-[0.14em] text-stone-500 sm:text-[8px] lg:text-[10px]">conséquence</p>
                </div>

                <div class="cj-bento min-w-0 overflow-hidden bg-[linear-gradient(135deg,_#f5f0ff_0%,_#e6dcff_100%)]">
                    <p class="whitespace-nowrap text-[7px] font-semibold uppercase tracking-[0.18em] text-stone-500 sm:text-[8px] lg:text-[10px]">Soutiens</p>
                    <p class="mt-1 text-xl font-black leading-none text-stone-900 sm:text-2xl lg:mt-2 lg:text-4xl">24</p>
                    <p class="mt-1 whitespace-nowrap text-[7px] uppercase tracking-[0.14em] text-stone-500 sm:text-[8px] lg:text-[10px]">réactions</p>
                </div>

                <div class="cj-bento min-w-0 overflow-hidden bg-[linear-gradient(135deg,_#fff6eb_0%,_#f4dfc8_100%)]">
                    <p class="whitespace-nowrap text-[7px] font-semibold uppercase tracking-[0.18em] text-stone-500 sm:text-[8px] lg:text-[10px]">Énergie</p>
                    <p class="mt-1 text-lg font-black leading-none text-stone-900 sm:text-xl lg:mt-2 lg:text-3xl">Calme</p>
                    <p class="mt-1 whitespace-nowrap text-[7px] uppercase tracking-[0.14em] text-stone-500 sm:text-[8px] lg:text-[10px]">stable</p>
                </div>
            </div>

            <div class="grid gap-5 lg:grid-cols-12">
                <div class="cj-shell p-4 sm:p-6 lg:col-span-7">
                    <livewire:journal.create-entry-form x-on:edit-journal-entry.window="$wire.loadEntry($event.detail.entryId)" />
                </div>

                <div class="cj-shell p-5 lg:col-span-5">
                    <livewire:journal.entries-list x-on:journal-entry-saved.window="$wire.$refresh()" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
