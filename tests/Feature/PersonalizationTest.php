<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AvatarSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class PersonalizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(AvatarSeeder::class);
    }

    public function test_guest_cannot_access_personalization_wizard(): void
    {
        $this->get('/onboarding')->assertRedirect(route('login'));
    }

    public function test_user_can_save_personalization_choices(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Volt::test('onboarding')
            ->set('gender', 'female')
            ->set('avatarKey', 'anime-toon-1')
            ->set('theme', 'forest')
            ->set('menu', ['journal', 'profile'])
            ->call('finish')
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'gender' => 'female',
            'avatar_key' => 'anime-toon-1',
            'theme' => 'forest',
            'points' => 10,
            'onboarding_completed' => true,
        ]);

        $this->assertSame(['journal', 'profile'], $user->profile->fresh()->menu);
    }

    public function test_user_cannot_save_an_unknown_avatar(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        Volt::test('onboarding')
            ->set('gender', 'male')
            ->set('avatarKey', 'unknown-avatar')
            ->call('finish')
            ->assertHasErrors('avatarKey');

        $this->assertFalse((bool) $user->profile->fresh()->onboarding_completed);
    }
}
