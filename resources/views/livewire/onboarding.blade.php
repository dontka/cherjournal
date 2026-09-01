<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Avatar;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public int $step = 1;
    public string $gender = 'prefer_not_to_say';
    public string $avatarKey = 'default-memo-1';
    public string $theme = 'rose';
    public array $menu = ['journal', 'dashboard', 'profile'];
    public bool $completed = false;

    public function mount(): void
    {
        $profile = Auth::user()->profile()->firstOrCreate(['user_id' => Auth::id()]);
        $this->gender = $profile->gender ?: 'prefer_not_to_say';
        $this->avatarKey = $profile->avatar_key ?: 'default-memo-1';
        $this->theme = $profile->theme ?: 'rose';
        $this->menu = $profile->menu ?: ['journal', 'dashboard', 'profile'];

        if (! $this->avatars()[$this->avatarGroup()]) {
            return;
        }

        if (! collect($this->avatars()[$this->avatarGroup()])->contains('key', $this->avatarKey)) {
            $this->avatarKey = $this->avatars()[$this->avatarGroup()][0]['key'];
        }
    }

    public function avatars(): array
    {
        $catalog = Avatar::query()
            ->where('is_active', true)
            ->where('is_unlocked', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn (Avatar $avatar): array => [
                'key' => $avatar->slug,
                'label' => $avatar->name,
                'src' => asset($avatar->file_path),
            ])
            ->all();

        return [
            'female' => $catalog,
            'male' => $catalog,
            'neutral' => $catalog,
        ];
    }

    public function updatedGender(): void
    {
        $this->avatarKey = $this->avatars()[$this->avatarGroup()][0]['key'];
    }

    public function nextStep(): void
    {
        $this->validateStep();
        $this->step = min(3, $this->step + 1);
    }

    public function previousStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function finish(): void
    {
        $this->validate([
            'gender' => ['required', 'in:female,male,neutral,prefer_not_to_say'],
            'avatarKey' => ['required', 'string', 'max:80'],
            'theme' => ['required', 'in:rose,forest,sun'],
            'menu' => ['required', 'array', 'min:1'],
            'menu.*' => ['required', 'in:journal,dashboard,profile'],
        ]);

        $avatar = Avatar::query()
            ->where('slug', $this->avatarKey)
            ->where('is_active', true)
            ->where('is_unlocked', true)
            ->first();

        if (! $avatar) {
            $this->addError('avatarKey', 'Choisis un avatar proposé pour cette catégorie.');

            return;
        }

        $profile = Auth::user()->profile()->firstOrCreate(['user_id' => Auth::id()]);
        $points = (int) $profile->points;

        if (! $profile->onboarding_completed) {
            $points += 10;
        }

        $profile->update([
            'gender' => $this->gender,
            'avatar_key' => $this->avatarKey,
            'avatar_id' => $avatar->id,
            'avatar_url' => asset($avatar->file_path),
            'theme' => $this->theme,
            'menu' => $this->menu,
            'points' => $points,
            'onboarding_completed' => true,
        ]);

        $this->completed = true;
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    private function validateStep(): void
    {
        if ($this->step === 1) {
            $this->validate(['gender' => ['required', 'in:female,male,neutral,prefer_not_to_say']]);
        }

        if ($this->step === 2) {
            $this->validate(['avatarKey' => ['required', 'string', 'max:80'], 'theme' => ['required', 'in:rose,forest,sun']]);
        }
    }

    private function avatarGroup(): string
    {
        return $this->gender === 'prefer_not_to_say' ? 'neutral' : $this->gender;
    }

}; ?>

<div class="mx-auto flex min-h-screen max-w-3xl items-center px-4 py-8 sm:px-6 lg:px-8">
    <div class="w-full overflow-hidden rounded-[2rem] border border-stone-200 bg-white/90 p-5 shadow-[0_24px_80px_rgba(89,72,67,0.12)] backdrop-blur sm:p-8">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-stone-500">Ton espace</p>
                <h1 class="mt-2 text-3xl font-semibold text-stone-900">Range ton journal à ton image.</h1>
            </div>
            <span class="text-sm font-semibold text-stone-500">{{ $step }} / 3</span>
        </div>

        <div class="mt-6 h-1.5 overflow-hidden rounded-full bg-stone-100">
            <div class="h-full rounded-full bg-stone-900 transition-all" style="width: {{ $step * 33.333 }}%"></div>
        </div>

        <div class="mt-8">
            @if ($step === 1)
                <p class="text-sm text-stone-600">Choisis la façon dont nous pouvons te proposer des avatars. Tu peux aussi rester neutre.</p>
                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    @foreach (['female' => 'Féminin', 'male' => 'Masculin', 'neutral' => 'Neutre', 'prefer_not_to_say' => 'Je préfère ne pas préciser'] as $value => $label)
                        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border p-4 transition {{ $gender === $value ? 'border-stone-900 bg-stone-900 text-white' : 'border-stone-200 bg-stone-50 text-stone-800 hover:border-stone-400' }}">
                            <input wire:model.live="gender" type="radio" value="{{ $value }}" class="sr-only" />
                            <span class="text-sm font-semibold">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            @elseif ($step === 2)
                <p class="text-sm text-stone-600">Choisis un avatar et une ambiance pour ton espace.</p>
                <div class="mt-5 grid grid-cols-2 gap-3 sm:grid-cols-3">
                    @foreach ($this->avatars()[$gender === 'prefer_not_to_say' ? 'neutral' : $gender] as $avatar)
                        <label class="cursor-pointer rounded-2xl border p-3 text-center transition {{ $avatarKey === $avatar['key'] ? 'border-stone-900 bg-stone-50 ring-2 ring-stone-900' : 'border-stone-200 hover:border-stone-400' }}">
                            <input wire:model.live="avatarKey" type="radio" value="{{ $avatar['key'] }}" class="sr-only" />
                            <img src="{{ $avatar['src'] }}" alt="Avatar {{ $avatar['label'] }}" class="mx-auto h-20 w-20 rounded-full" />
                            <span class="mt-2 block text-xs font-semibold text-stone-700">{{ $avatar['label'] }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="mt-6 grid gap-3 sm:grid-cols-3">
                    @foreach (['rose' => 'Rose doux', 'forest' => 'Forêt calme', 'sun' => 'Soleil clair'] as $value => $label)
                        <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-stone-200 p-3 text-sm text-stone-700">
                            <input wire:model.live="theme" type="radio" value="{{ $value }}" />
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-stone-600">Garde seulement les raccourcis dont tu as besoin.</p>
                <div class="mt-5 space-y-3">
                    @foreach (['journal' => 'Mon journal', 'dashboard' => 'Tableau de bord', 'profile' => 'Mon profil'] as $value => $label)
                        <label class="flex items-center justify-between rounded-2xl border border-stone-200 bg-stone-50 p-4 text-sm font-semibold text-stone-800">
                            {{ $label }}
                            <input wire:model.live="menu" type="checkbox" value="{{ $value }}" class="h-5 w-5 rounded border-stone-300 text-stone-900 focus:ring-stone-500" />
                        </label>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mt-8 flex items-center justify-between gap-3">
            <button type="button" wire:click="previousStep" @disabled($step === 1) class="rounded-full border border-stone-200 px-4 py-2 text-sm font-semibold text-stone-700 disabled:opacity-40">Retour</button>
            @if ($step < 3)
                <button type="button" wire:click="nextStep" class="rounded-full bg-stone-900 px-5 py-2 text-sm font-semibold text-white">Continuer</button>
            @else
                <button type="button" wire:click="finish" class="rounded-full bg-stone-900 px-5 py-2 text-sm font-semibold text-white">Terminer mon espace</button>
            @endif
        </div>
    </div>
</div>
