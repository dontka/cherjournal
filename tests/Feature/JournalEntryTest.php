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
