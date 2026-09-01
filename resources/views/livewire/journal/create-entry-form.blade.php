<?php

use App\Models\JournalEntry;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $title = '';
    public string $content = '';
    public string $status = 'draft';
    public string $visibility = 'private';
    public bool $is_anonymous = false;
    public string $statusMessage = '';

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
        $this->reset(['title', 'content', 'status', 'visibility', 'is_anonymous']);
        $this->status = 'draft';
        $this->visibility = 'private';
        $this->is_anonymous = false;
        $this->dispatch('journal-entry-saved');
    }
};
?>

<section class="space-y-5">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-[10px] font-semibold uppercase tracking-[0.22em] text-stone-500">Mon journal</p>
            <h3 class="mt-2 text-2xl font-bold text-stone-900">Écrire une nouvelle entrée</h3>
        </div>

        @if ($statusMessage)
            <div class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                {{ $statusMessage }}
            </div>
        @endif
    </div>

    <form wire:submit="saveEntry" class="space-y-4">
        <div>
            <label for="journal-title" class="mb-1 block text-sm font-medium text-stone-700">Titre</label>
            <input wire:model="title" id="journal-title" type="text" class="w-full rounded-2xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-100" placeholder="Une journée douce, un besoin, une intuition..." />
            @error('title') <span class="mt-1 block text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="journal-content" class="mb-1 block text-sm font-medium text-stone-700">Écriture</label>
            <textarea wire:model="content" id="journal-content" rows="8" class="w-full rounded-2xl border border-stone-200 bg-white px-3 py-2.5 text-sm text-stone-900 focus:border-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-100" placeholder="Décris ce que tu ressens, ce que tu traverses, ou ce que tu veux retenir..."></textarea>
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
