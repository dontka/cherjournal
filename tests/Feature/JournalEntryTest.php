<?php

namespace Tests\Feature;

use App\Models\JournalEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class JournalEntryTest extends TestCase
{
    use RefreshDatabase;

    public function test_journal_page_is_accessible_to_authenticated_users(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/journal')
            ->assertOk()
            ->assertSee('Mon journal')
            ->assertSeeVolt('journal.create-entry-form');
    }

    public function test_user_can_create_a_draft_entry(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('journal.create-entry-form')
            ->set('title', 'Réveil doux')
            ->set('content', 'J’ai appris à ralentir et à respirer profondément.')
            ->set('status', 'draft')
            ->set('visibility', 'private')
            ->set('is_anonymous', true)
            ->call('saveEntry');

        $component
            ->assertHasNoErrors()
            ->assertNoRedirect()
            ->assertSee('Brouillon enregistré.');

        $this->assertDatabaseHas('journal_entries', [
            'user_id' => $user->id,
            'title' => 'Réveil doux',
            'status' => 'draft',
            'visibility' => 'private',
            'is_anonymous' => true,
        ]);
        $this->assertDatabaseHas('point_transactions', [
            'user_id' => $user->id,
            'amount' => 5,
            'action' => 'journal_entry_created',
        ]);
    }

    public function test_user_can_create_a_published_entry(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('journal.create-entry-form')
            ->set('title', 'Le courage de reprendre')
            ->set('content', 'Aujourd’hui, j’ai choisi de commencer sans pression.')
            ->set('status', 'published')
            ->set('visibility', 'public')
            ->set('is_anonymous', false)
            ->call('saveEntry');

        $component
            ->assertHasNoErrors()
            ->assertNoRedirect();

        $entry = JournalEntry::query()->where('user_id', $user->id)->first();

        $this->assertNotNull($entry);
        $this->assertSame('published', $entry->status);
        $this->assertSame('public', $entry->visibility);
    }

    public function test_user_can_edit_an_existing_entry(): void
    {
        $user = User::factory()->create();
        $entry = JournalEntry::create([
            'user_id' => $user->id,
            'title' => 'Premier jet',
            'slug' => 'premier-jet',
            'content' => 'Ce texte est ancien et doit être remplacé.',
            'status' => 'draft',
            'visibility' => 'private',
            'is_anonymous' => false,
        ]);

        $this->actingAs($user);

        $component = Volt::test('journal.create-entry-form')
            ->set('entryId', $entry->id)
            ->set('title', 'Premier jet mis à jour')
            ->set('content', 'Ce texte a été réécrit pour refléter une idée plus claire.')
            ->set('status', 'published')
            ->set('visibility', 'public')
            ->set('is_anonymous', true)
            ->call('saveEntry');

        $component
            ->assertHasNoErrors()
            ->assertNoRedirect()
            ->assertSee('Publication mise à jour.');

        $this->assertDatabaseHas('journal_entries', [
            'id' => $entry->id,
            'title' => 'Premier jet mis à jour',
            'content' => 'Ce texte a été réécrit pour refléter une idée plus claire.',
            'status' => 'published',
            'visibility' => 'public',
            'is_anonymous' => true,
        ]);
    }

    public function test_user_can_archive_and_delete_an_entry(): void
    {
        $user = User::factory()->create();
        $entry = JournalEntry::create([
            'user_id' => $user->id,
            'title' => 'Journal de transition',
            'slug' => 'journal-de-transition',
            'content' => 'Je m’efforce de reprendre le rythme de mon journal sans me juger.',
            'status' => 'draft',
            'visibility' => 'private',
            'is_anonymous' => false,
        ]);

        $this->actingAs($user);

        Volt::test('journal.entries-list')
            ->call('archiveEntry', $entry->id)
            ->assertHasNoErrors();

        $this->assertSame('archived', $entry->fresh()->status);

        Volt::test('journal.entries-list')
            ->call('deleteEntry', $entry->id)
            ->assertHasNoErrors();

        $this->assertDatabaseMissing('journal_entries', ['id' => $entry->id]);
    }

    public function test_journal_entry_can_be_loaded_for_editing(): void
    {
        $user = User::factory()->create();
        $entry = JournalEntry::create([
            'user_id' => $user->id,
            'title' => 'Entrée à éditer',
            'slug' => 'entree-a-editer',
            'content' => 'Texte de l’entrée avant modification.',
            'status' => 'draft',
            'visibility' => 'private',
            'is_anonymous' => false,
        ]);

        $this->actingAs($user);

        $component = Volt::test('journal.create-entry-form')
            ->call('loadEntry', $entry->id);

        $component
            ->assertSet('entryId', $entry->id)
            ->assertSet('title', 'Entrée à éditer')
            ->assertSet('content', 'Texte de l’entrée avant modification.');
    }

    public function test_journal_history_preview_strips_html_tags(): void
    {
        $user = User::factory()->create();
        JournalEntry::create([
            'user_id' => $user->id,
            'title' => 'Note enrichie',
            'slug' => 'note-enrichie',
            'content' => '<p>Bonjour <strong>monde</strong> et <em>merci</em>.</p><p>Suite de texte.</p>',
            'status' => 'published',
            'visibility' => 'private',
            'is_anonymous' => false,
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Bonjour monde et merci.')
            ->assertDontSee('<p>Bonjour')
            ->assertDontSee('<strong>');
    }

    public function test_journal_history_has_pagination_for_many_entries(): void
    {
        $user = User::factory()->create();

        foreach (range(1, 12) as $index) {
            JournalEntry::create([
                'user_id' => $user->id,
                'title' => 'Entrée '.$index,
                'slug' => 'entree-'.$index,
                'content' => 'Contenu de l’entrée '.$index,
                'status' => 'draft',
                'visibility' => 'private',
                'is_anonymous' => false,
            ]);
        }

        $this->actingAs($user)
            ->get('/journal')
            ->assertOk()
            ->assertSee('Historique du journal')
            ->assertSee('Suivant');
    }

    public function test_dashboard_displays_user_journal_summary_and_actions(): void
    {
        $user = User::factory()->create();

        JournalEntry::create([
            'user_id' => $user->id,
            'title' => 'Première note',
            'slug' => 'premiere-note',
            'content' => 'Je veux reprendre le rythme avec une écriture plus douce et régulière.',
            'status' => 'published',
            'visibility' => 'private',
            'is_anonymous' => false,
        ]);

        JournalEntry::create([
            'user_id' => $user->id,
            'title' => 'Brouillon',
            'slug' => 'brouillon',
            'content' => 'Je garde cette pensée en attente avant de la partager.',
            'status' => 'draft',
            'visibility' => 'private',
            'is_anonymous' => true,
        ]);

        JournalEntry::create([
            'user_id' => $user->id,
            'title' => 'Archivée',
            'slug' => 'archivee',
            'content' => 'Cette entrée a trouvé sa place dans l’archive.',
            'status' => 'archived',
            'visibility' => 'private',
            'is_anonymous' => false,
        ]);

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Mon tableau de bord')
            ->assertSee('Brouillons')
            ->assertSee('Publiees')
            ->assertSee('Archives')
            ->assertSee('Nouvelle entrée');
    }
}
