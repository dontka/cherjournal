<?php

use App\Models\JournalEntry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Volt\Component;

new class extends Component
{
    public ?int $entryId = null;
    public string $title = '';
    public string $content = '';
    public string $status = 'draft';
    public string $visibility = 'private';
    public bool $is_anonymous = false;
    public string $statusMessage = '';

    public function mount(): void
    {
        $this->status = 'draft';
        $this->visibility = 'private';
        $this->is_anonymous = false;
    }

    public function loadEntry(int $entryId): void
    {
        $entry = Auth::user()->journalEntries()->findOrFail($entryId);

        $this->entryId = $entry->id;
        $this->title = $entry->title;
        $this->content = $entry->content;
        $this->status = $entry->status;
        $this->visibility = $entry->visibility;
        $this->is_anonymous = (bool) $entry->is_anonymous;
        $this->statusMessage = '';
    }

    public function saveEntry(): void
    {
        $validated = $this->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'min:20', 'max:12000'],
            'status' => ['required', 'in:draft,published'],
            'visibility' => ['required', 'in:private,public'],
            'is_anonymous' => ['required', 'boolean'],
        ]);

        $user = Auth::user();

        if ($this->entryId) {
            $entry = $user->journalEntries()->findOrFail($this->entryId);
            $entry->update([
                'title' => $validated['title'] ?: 'Sans titre',
                'content' => $validated['content'],
                'excerpt' => Str::limit(strip_tags($validated['content']), 180),
                'status' => $validated['status'],
                'visibility' => $validated['visibility'],
                'is_anonymous' => $validated['is_anonymous'],
            ]);

            $this->statusMessage = 'Publication mise à jour.';
        } else {
            JournalEntry::create([
                'user_id' => $user->id,
                'title' => $validated['title'] ?: 'Sans titre',
                'slug' => Str::slug($validated['title'] ?: 'sans-titre').'-'.time(),
                'content' => $validated['content'],
                'excerpt' => Str::limit(strip_tags($validated['content']), 180),
                'status' => $validated['status'],
                'visibility' => $validated['visibility'],
                'is_anonymous' => $validated['is_anonymous'],
            ]);

            $this->statusMessage = $validated['status'] === 'published' ? 'Publication créée.' : 'Brouillon enregistré.';
        }

        $this->reset(['entryId', 'title', 'content', 'status', 'visibility', 'is_anonymous']);
        $this->status = 'draft';
        $this->visibility = 'private';
        $this->is_anonymous = false;
        $this->dispatch('journal-entry-saved');
    }
};
?>

<section x-data="journalNoteEditor()" x-init="init()" x-on:beforeunload="destroy()" class="space-y-5">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Mon journal</p>
            <h3 class="mt-2 text-2xl font-bold text-stone-900">{{ $entryId ? 'Modifier une entrée' : 'Écrire une nouvelle entrée' }}</h3>
        </div>

        @if ($statusMessage)
            <div class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                {{ $statusMessage }}
            </div>
        @endif
    </div>

    <form x-on:submit.prevent="$wire.set('content', $refs.contentInput.value); $wire.saveEntry();" class="space-y-4">
        <div>
            <label for="journal-title" class="mb-1 block text-sm font-medium text-stone-700">Titre</label>
            <input wire:model="title" id="journal-title" type="text" class="w-full rounded-2xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-100" placeholder="Une journée douce, un besoin, une intuition..." />
            @error('title') <span class="mt-1 block text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="journal-content" class="mb-1 block text-sm font-medium text-stone-700">Écriture</label>

            <div class="overflow-hidden rounded-[1.45rem] border border-stone-200 bg-white shadow-[0_10px_28px_rgba(42,31,25,0.05)]">
                <div class="flex flex-wrap items-center gap-2 border-b border-stone-200 bg-stone-50 px-3 py-2.5">
                    <button type="button" data-editor-action="title" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">Titre</button>
                    <button type="button" data-editor-action="heading" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">Sous-titre</button>
                    <button type="button" data-editor-action="paragraph" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">Texte</button>
                    <button type="button" data-editor-action="bullet-list" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">Liste</button>
                    <button type="button" data-editor-action="task-list" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">Checklist</button>
                    <button type="button" data-editor-action="quote" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">Citation</button>
                    <button type="button" data-editor-action="code" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">Code</button>
                </div>

                <div class="flex flex-wrap items-center gap-2 border-b border-stone-200 bg-white/80 px-3 py-2.5">
                    <button type="button" data-editor-action="bold" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">B</button>
                    <button type="button" data-editor-action="italic" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">I</button>
                    <button type="button" data-editor-action="strike" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">S</button>
                    <button type="button" data-editor-action="highlight" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">Mark</button>
                    <button type="button" data-editor-action="align-left" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">G</button>
                    <button type="button" data-editor-action="align-center" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">C</button>
                    <button type="button" data-editor-action="align-right" class="rounded-lg border border-stone-200 bg-white px-2.5 py-1.5 text-[11px] font-semibold text-stone-700 transition hover:border-stone-300 hover:bg-stone-100">D</button>
                </div>

                <input type="hidden" x-ref="contentInput" id="journal-content" value="{{ $content }}" />
                <div wire:ignore x-ref="editor" class="tiptap-editor" aria-label="Zone de rédaction du journal"></div>
            </div>

            @error('content') <span class="mt-1 block text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="grid gap-3 sm:grid-cols-3">
            <div>
                <label for="journal-status" class="mb-1 block text-sm font-medium text-stone-700">Statut</label>
                <select wire:model="status" id="journal-status" class="w-full rounded-2xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-100">
                    <option value="draft">Brouillon</option>
                    <option value="published">Publier</option>
                </select>
            </div>

            <div>
                <label for="journal-visibility" class="mb-1 block text-sm font-medium text-stone-700">Visibilité</label>
                <select wire:model="visibility" id="journal-visibility" class="w-full rounded-2xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-100">
                    <option value="private">Privé</option>
                    <option value="public">Public</option>
                </select>
            </div>

            <div class="flex items-end">
                <label class="flex w-full items-center gap-2 rounded-2xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-700">
                    <input type="checkbox" wire:model="is_anonymous" class="h-4 w-4 rounded border-stone-300 text-rose-500 focus:ring-rose-500" />
                    Anonyme
                </label>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="cj-button-primary">Enregistrer</button>
            <x-action-message class="me-3" on="journal-entry-saved">
                {{ __('Enregistré.') }}
            </x-action-message>
        </div>
    </form>
</section>
