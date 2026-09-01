<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/profile');

        $response
            ->assertOk()
            ->assertSeeVolt('profile.update-profile-information-form')
            ->assertSeeVolt('profile.update-password-form')
            ->assertSeeVolt('profile.delete-user-form');
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.update-profile-information-form')
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->call('updateProfileInformation');

        $component
            ->assertHasNoErrors()
            ->assertNoRedirect();

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.update-profile-information-form')
            ->set('name', 'Test User')
            ->set('email', $user->email)
            ->call('updateProfileInformation');

        $component
            ->assertHasNoErrors()
            ->assertNoRedirect();

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_profile_identity_and_privacy_settings_can_be_updated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.update-profile-information-form')
            ->set('username', 'lavieencouleur')
            ->set('display_name', 'La vie en couleur')
            ->set('bio', 'Journal intime et moments lumineux.')
            ->set('timezone', 'Europe/Paris')
            ->set('is_public', true)
            ->set('is_anonymous', true)
            ->set('avatar_url', 'https://example.com/avatar.png')
            ->set('email_notifications', true)
            ->set('in_app_notifications', false)
            ->set('comments_enabled', true)
            ->set('comment_moderation', true)
            ->call('updateProfileInformation');

        $component
            ->assertHasNoErrors()
            ->assertNoRedirect();

        $user->refresh();

        $this->assertSame('lavieencouleur', $user->username);
        $this->assertSame('La vie en couleur', $user->profile->display_name);
        $this->assertSame('Journal intime et moments lumineux.', $user->profile->bio);
        $this->assertSame('Europe/Paris', $user->profile->timezone);
        $this->assertSame('https://example.com/avatar.png', $user->profile->avatar_url);
        $this->assertTrue((bool) $user->profile->is_public);
        $this->assertTrue((bool) $user->profile->is_anonymous);
        $this->assertTrue((bool) $user->profile->email_notifications);
        $this->assertFalse((bool) $user->profile->in_app_notifications);
        $this->assertTrue((bool) $user->profile->comments_enabled);
        $this->assertTrue((bool) $user->profile->comment_moderation);
    }

    public function test_profile_update_sets_success_flash_message(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.update-profile-information-form')
            ->set('name', 'Alice')
            ->set('email', 'alice@example.com')
            ->set('username', 'alice')
            ->set('display_name', 'Alice')
            ->set('bio', 'Nouveau journal.')
            ->set('timezone', 'Europe/Paris')
            ->set('avatar_url', 'https://example.com/avatar.png')
            ->set('is_public', true)
            ->set('is_anonymous', false)
            ->set('email_notifications', true)
            ->set('in_app_notifications', true)
            ->set('comments_enabled', true)
            ->set('comment_moderation', false)
            ->call('updateProfileInformation');

        $component
            ->assertHasNoErrors()
            ->assertNoRedirect()
            ->assertSee('Profil mis à jour.');
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.delete-user-form')
            ->set('password', 'password')
            ->call('deleteUser');

        $component
            ->assertHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('profile.delete-user-form')
            ->set('password', 'wrong-password')
            ->call('deleteUser');

        $component
            ->assertHasErrors('password')
            ->assertNoRedirect();

        $this->assertNotNull($user->fresh());
    }
}
