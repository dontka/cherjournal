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
            ->assertNoRedirect();

        $this->assertDatabaseHas('journal_entries', [
            'user_id' => $user->id,
            'title' => 'Réveil doux',
            'status' => 'draft',
            'visibility' => 'private',
            'is_anonymous' => true,
        ]);

        $this->assertSame('Brouillon enregistré.', session('journal_status'));
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
}
