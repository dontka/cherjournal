<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AvatarSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
            ->set('avatarKey', 'default-memo-1')
            ->set('theme', 'forest')
            ->set('menu', ['journal', 'profile'])
            ->call('finish')
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'gender' => 'female',
            'avatar_key' => 'default-memo-1',
            'theme' => 'forest',
            'points' => 10,
            'onboarding_completed' => true,
        ]);

        $this->assertSame(['journal', 'profile'], $user->profile->fresh()->menu);
        $this->assertDatabaseHas('point_transactions', [
            'user_id' => $user->id,
            'amount' => 10,
            'action' => 'onboarding_completed',
        ]);
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

    public function test_user_can_upload_a_custom_avatar_after_unlocking_it(): void
    {
        $user = User::factory()->create();
        $user->profile->update(['points' => 50]);

        Storage::fake('public');
        $this->actingAs($user);

        Volt::test('onboarding')
            ->set('customAvatar', UploadedFile::fake()->image('portrait.png'))
            ->call('finish')
            ->assertRedirect(route('dashboard', absolute: false));

        $profile = $user->profile->fresh();

        $this->assertNull($profile->avatar_id);
        $this->assertStringContainsString('/storage/avatars/custom/', $profile->avatar_url);
        Storage::disk('public')->assertExists(str_replace('/storage/', '', parse_url($profile->avatar_url, PHP_URL_PATH)));
    }
}
