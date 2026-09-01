<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $username = '';
    public string $display_name = '';
    public string $bio = '';
    public string $timezone = 'UTC';
    public string $avatar_url = '';
    public bool $is_public = true;
    public bool $is_anonymous = false;
    public bool $email_notifications = true;
    public bool $in_app_notifications = true;
    public bool $comments_enabled = true;
    public bool $comment_moderation = false;
    public bool $profileSaved = false;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username ?? $profile->username ?? '';
        $this->display_name = $profile->display_name ?? '';
        $this->bio = $profile->bio ?? '';
        $this->timezone = $profile->timezone ?? 'UTC';
        $this->avatar_url = $profile->avatar_url ?? '';
        $this->is_public = (bool) ($profile->is_public ?? true);
        $this->is_anonymous = (bool) ($profile->is_anonymous ?? false);
        $this->email_notifications = (bool) ($profile->email_notifications ?? true);
        $this->in_app_notifications = (bool) ($profile->in_app_notifications ?? true);
        $this->comments_enabled = (bool) ($profile->comments_enabled ?? true);
        $this->comment_moderation = (bool) ($profile->comment_moderation ?? false);
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'username' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z0-9._-]+$/', Rule::unique(User::class, 'username')->ignore($user->id)],
            'display_name' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'timezone' => ['nullable', 'string', 'max:255'],
            'avatar_url' => ['nullable', 'url', 'max:500'],
            'is_public' => ['required', 'boolean'],
            'is_anonymous' => ['required', 'boolean'],
            'email_notifications' => ['required', 'boolean'],
            'in_app_notifications' => ['required', 'boolean'],
            'comments_enabled' => ['required', 'boolean'],
            'comment_moderation' => ['required', 'boolean'],
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'] ?? null,
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $profile->fill([
            'username' => $validated['username'] ?? null,
            'display_name' => $validated['display_name'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'timezone' => $validated['timezone'] ?? 'UTC',
            'avatar_url' => $validated['avatar_url'] ?? null,
            'is_public' => (bool) $validated['is_public'],
            'is_anonymous' => (bool) $validated['is_anonymous'],
            'email_notifications' => (bool) $validated['email_notifications'],
            'in_app_notifications' => (bool) $validated['in_app_notifications'],
            'comments_enabled' => (bool) $validated['comments_enabled'],
            'comment_moderation' => (bool) $validated['comment_moderation'],
        ]);
        $profile->save();

        $this->profileSaved = true;
        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-semibold text-stone-900">
            {{ __('Informations du profil') }}
        </h2>

        <p class="mt-1 text-sm text-stone-600">
            {{ __('Personnalise ton identité, ton anonymat et la manière dont tu souhaites être visible.') }}
        </p>
    </header>

    <div class="mt-6 rounded-3xl border border-rose-100 bg-gradient-to-br from-rose-50 via-white to-emerald-50 p-4">
        <div class="flex items-center gap-4">
            <img
                src="{{ $avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($username ?: $name ?: 'CJ') . '&background=F6D7D0&color=fff&size=200' }}"
                alt="Avatar"
                class="h-16 w-16 rounded-full border-2 border-white object-cover shadow-sm"
            />
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-stone-500">Avatar</p>
                <p class="mt-1 text-sm text-stone-700">{{ $display_name ?: ($username ?: $name ?: 'Mon profil') }}</p>
            </div>
        </div>
    </div>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username / pseudonym')" />
            <x-text-input wire:model="username" id="username" name="username" type="text" class="mt-1 block w-full" autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="display_name" :value="__('Display name')" />
            <x-text-input wire:model="display_name" id="display_name" name="display_name" type="text" class="mt-1 block w-full" autocomplete="nickname" />
            <x-input-error class="mt-2" :messages="$errors->get('display_name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="timezone" :value="__('Timezone')" />
            <x-text-input wire:model="timezone" id="timezone" name="timezone" type="text" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('timezone')" />
        </div>

        <div>
            <x-input-label for="avatar_url" :value="__('Avatar URL')" />
            <x-text-input wire:model="avatar_url" id="avatar_url" name="avatar_url" type="url" class="mt-1 block w-full" placeholder="https://example.com/avatar.png" />
            <x-input-error class="mt-2" :messages="$errors->get('avatar_url')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea wire:model="bio" id="bio" name="bio" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"></textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="space-y-3">
            <label class="flex items-center">
                <input type="checkbox" wire:model="is_public" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="ms-2 text-sm text-gray-600">{{ __('Public profile') }}</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" wire:model="is_anonymous" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="ms-2 text-sm text-gray-600">{{ __('Anonymous mode') }}</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" wire:model="email_notifications" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="ms-2 text-sm text-gray-600">{{ __('Email notifications') }}</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" wire:model="in_app_notifications" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="ms-2 text-sm text-gray-600">{{ __('In-app notifications') }}</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" wire:model="comments_enabled" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="ms-2 text-sm text-gray-600">{{ __('Comments enabled') }}</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" wire:model="comment_moderation" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="ms-2 text-sm text-gray-600">{{ __('Moderate comments') }}</span>
            </label>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if ($profileSaved)
                <div class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-sm font-medium text-emerald-700">
                    Profil mis à jour.
                </div>
            @endif

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
