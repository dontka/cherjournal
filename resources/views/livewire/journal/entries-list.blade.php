<?php

use App\Models\JournalEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Volt\Component;

new class extends Component
{
    public string $filter = 'all';
    public int $page = 1;
    public int $perPage = 4;
    public $entries = [];

    public function mount(): void
    {
        $this->entries = $this->getEntriesProperty();
    }

    public function archiveEntry(int $entryId): void
    {
        $entry = Auth::user()->journalEntries()->findOrFail($entryId);
        $entry->update(['status' => 'archived']);
        $this->page = 1;
        $this->entries = $this->getEntriesProperty();
    }

    public function editEntry(int $entryId): void
    {
        $this->dispatch('edit-journal-entry', entryId: $entryId)->to('journal.create-entry-form');
    }

    public function deleteEntry(int $entryId): void
    {
        $entry = Auth::user()->journalEntries()->findOrFail($entryId);
        $entry->delete();
        $this->page = 1;
        $this->entries = $this->getEntriesProperty();
    }

    public function updatedFilter(): void
    {
        $this->page = 1;
        $this->entries = $this->getEntriesProperty();
    }

    public function nextPage(): void
    {
        $this->page++;
        $this->entries = $this->getEntriesProperty();
    }

    public function previousPage(): void
    {
        $this->page = max(1, $this->page - 1);
        $this->entries = $this->getEntriesProperty();
    }

    public function getEntriesProperty()
    {
        $query = Auth::user()->journalEntries()->latest();

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }

        $total = $query->count();
        $lastPage = max(1, (int) ceil($total / $this->perPage));
        $this->page = max(1, min($this->page, $lastPage));

        return $query->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();
    }
}; ?>

<section class="space-y-4 lg:space-y-5">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Mes notes</p>
            <h3 class="mt-2 text-2xl font-bold text-stone-900 lg:text-[1.75rem]">Historique du journal</h3>
        </div>

        <div class="flex flex-wrap gap-2 lg:max-w-[22rem] lg:justify-end">
            <button type="button" wire:click="$set('filter', 'all')" class="rounded-full px-3 py-1.5 text-xs font-semibold {{ $filter === 'all' ? 'bg-stone-900 text-white' : 'bg-stone-100 text-stone-600' }}">
                Tout
            </button>
            <button type="button" wire:click="$set('filter', 'draft')" class="rounded-full px-3 py-1.5 text-xs font-semibold {{ $filter === 'draft' ? 'bg-stone-900 text-white' : 'bg-stone-100 text-stone-600' }}">
                Brouillons
            </button>
            <button type="button" wire:click="$set('filter', 'published')" class="rounded-full px-3 py-1.5 text-xs font-semibold {{ $filter === 'published' ? 'bg-stone-900 text-white' : 'bg-stone-100 text-stone-600' }}">
                Publiés
            </button>
            <button type="button" wire:click="$set('filter', 'archived')" class="rounded-full px-3 py-1.5 text-xs font-semibold {{ $filter === 'archived' ? 'bg-stone-900 text-white' : 'bg-stone-100 text-stone-600' }}">
                Archivés
            </button>
        </div>
    </div>

    <div class="space-y-3 lg:space-y-4">
        @forelse ($entries as $entry)
            <article class="rounded-[1.25rem] border border-stone-200 bg-stone-50 p-4 transition hover:border-stone-300 hover:bg-stone-100/80 lg:p-5">
                <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h4 class="text-base font-bold text-stone-900 lg:text-lg">{{ $entry->title ?: 'Sans titre' }}</h4>
                            <span class="rounded-full bg-white px-2 py-1 text-[10px] font-semibold uppercase tracking-[0.16em] text-stone-500">{{ $entry->status }}</span>
                        </div>
                        @php
                            $preview = trim(preg_replace('/\s+/', ' ', strip_tags($entry->content ?? '')));
                        @endphp
                        <p class="mt-2 text-sm leading-6 text-stone-600 lg:pr-3">{{ Str::limit($preview ?: 'Aucun contenu', 160) }}</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 lg:min-w-[10.5rem] lg:flex-col lg:items-stretch">
                        <button type="button" wire:click="editEntry({{ $entry->id }})" class="rounded-full border border-stone-200 bg-white px-3 py-1.5 text-xs font-semibold text-stone-700">Modifier</button>
                        @if ($entry->status !== 'archived')
                            <button type="button" wire:click="archiveEntry({{ $entry->id }})" class="rounded-full border border-stone-200 bg-white px-3 py-1.5 text-xs font-semibold text-stone-700">Archiver</button>
                        @endif
                        <button type="button" wire:click="deleteEntry({{ $entry->id }})" class="rounded-full border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700">Supprimer</button>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-[1.25rem] border border-dashed border-stone-300 bg-stone-50 p-5 text-sm text-stone-600">
                Aucune entrée pour ce filtre pour le moment.
            </div>
        @endforelse
    </div>

    @php
        $totalEntries = Auth::user()->journalEntries();
        if ($this->filter !== 'all') {
            $totalEntries = $totalEntries->where('status', $this->filter);
        }
        $totalPages = max(1, (int) ceil($totalEntries->count() / $this->perPage));
    @endphp

    @if ($totalEntries->count() > $this->perPage)
        <div class="flex items-center justify-between border-t border-stone-200 pt-4">
            <button type="button" wire:click="previousPage" @disabled($this->page <= 1) class="rounded-full border border-stone-200 bg-white px-3 py-1.5 text-xs font-semibold text-stone-700 disabled:cursor-not-allowed disabled:opacity-50">
                Précédent
            </button>

            <span class="text-xs font-medium text-stone-600">
                Page {{ $this->page }} / {{ $totalPages }}
            </span>

            <button type="button" wire:click="nextPage" @disabled($this->page >= $totalPages) class="rounded-full border border-stone-200 bg-white px-3 py-1.5 text-xs font-semibold text-stone-700 disabled:cursor-not-allowed disabled:opacity-50">
                Suivant
            </button>
        </div>
    @endif
</section>
