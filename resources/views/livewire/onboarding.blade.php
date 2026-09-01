<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Avatar;
use App\Models\PointTransaction;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component
{
    use WithFileUploads;

    public int $step = 1;
    public string $gender = 'prefer_not_to_say';
    public string $displayName = '';
    public string $avatarKey = 'default-memo-1';
    public string $theme = 'rose';
    public array $menu = ['journal', 'dashboard', 'profile'];
    public bool $completed = false;
    public int $profilePoints = 0;
    public bool $isPublic = true;
    public bool $isAnonymous = false;
    public ?TemporaryUploadedFile $customAvatar = null;

    public function mount(): void
    {
        $profile = Auth::user()->profile()->firstOrCreate(['user_id' => Auth::id()]);
        $this->gender = $profile->gender ?: 'prefer_not_to_say';
        $this->displayName = $profile->display_name ?: Auth::user()->name;
        $this->avatarKey = $profile->avatar_key ?: 'default-memo-1';
        $this->theme = $profile->theme ?: 'rose';
        $this->menu = $profile->menu ?: ['journal', 'dashboard', 'profile'];
        $this->profilePoints = (int) $profile->points;
        $this->isPublic = (bool) $profile->is_public;
        $this->isAnonymous = (bool) $profile->is_anonymous;

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
                'required_points' => $avatar->required_points,
                'locked' => $avatar->required_points > $this->profilePoints,
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
        $this->step = min(4, $this->step + 1);
    }

    public function previousStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function finish(): void
    {
        $this->validate([
            'gender' => ['required', 'in:female,male,neutral,prefer_not_to_say'],
            'displayName' => ['required', 'string', 'max:255'],
            'avatarKey' => ['required', 'string', 'max:80'],
            'customAvatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'theme' => ['required', 'in:rose,forest,sun'],
            'menu' => ['required', 'array', 'min:1'],
            'menu.*' => ['required', 'in:journal,dashboard,profile'],
            'isPublic' => ['required', 'boolean'],
            'isAnonymous' => ['required', 'boolean'],
        ]);

        $avatar = Avatar::query()
            ->where('slug', $this->avatarKey)
            ->where('is_active', true)
            ->where('is_unlocked', true)
            ->first();

        $profile = Auth::user()->profile()->firstOrCreate(['user_id' => Auth::id()]);

        if ($this->customAvatar && (int) $profile->points < 50) {
            $this->addError('customAvatar', 'Ton avatar personnalisé se débloque à 50 points.');

            return;
        }

        if (! $this->customAvatar && (! $avatar || $avatar->required_points > (int) $profile->points)) {
            $this->addError('avatarKey', 'Choisis un avatar proposé pour cette catégorie.');

            return;
        }
        $points = (int) $profile->points;
        $avatarUrl = $avatar ? asset($avatar->file_path) : $profile->avatar_url;
        $avatarId = $avatar?->id;

        if ($this->customAvatar) {
            $avatarPath = $this->customAvatar->store('avatars/custom', 'public');
            $avatarUrl = Storage::disk('public')->url($avatarPath);
            $avatarId = null;
        }

        $completedOnboarding = ! $profile->onboarding_completed;

        if ($completedOnboarding) {
            $points += 10;
        }

        $profile->update([
            'gender' => $this->gender,
            'display_name' => $this->displayName,
            'avatar_key' => $this->avatarKey,
            'avatar_id' => $avatarId,
            'avatar_url' => $avatarUrl,
            'theme' => $this->theme,
            'menu' => $this->menu,
            'is_public' => $this->isPublic,
            'is_anonymous' => $this->isAnonymous,
            'points' => $points,
            'onboarding_completed' => true,
        ]);

        if ($completedOnboarding) {
            PointTransaction::create([
                'user_id' => Auth::id(),
                'amount' => 10,
                'action' => 'onboarding_completed',
            ]);
        }

        $this->completed = true;
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }

    private function validateStep(): void
    {
        if ($this->step === 1) {
            $this->validate([
                'displayName' => ['required', 'string', 'max:255'],
                'gender' => ['required', 'in:female,male,neutral,prefer_not_to_say'],
            ]);
        }

        if ($this->step === 2) {
            $this->validate([
                'avatarKey' => ['required', 'string', 'max:80'],
                'customAvatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            ]);
        }

        if ($this->step === 3) {
            $this->validate([
                'theme' => ['required', 'in:rose,forest,sun'],
                'isPublic' => ['required', 'boolean'],
                'isAnonymous' => ['required', 'boolean'],
            ]);
        }
    }

    private function avatarGroup(): string
    {
        return $this->gender === 'prefer_not_to_say' ? 'neutral' : $this->gender;
    }

}; ?>

<div class="mx-auto flex min-h-screen max-w-5xl items-center px-4 py-8 sm:px-6 lg:px-8">
    <div class="grid w-full overflow-hidden rounded-[2rem] border border-stone-200 bg-white/90 shadow-[0_24px_80px_rgba(89,72,67,0.12)] backdrop-blur lg:grid-cols-[0.72fr_1.28fr]">
        <aside class="hidden bg-stone-900 p-8 text-white lg:block">
            <div class="flex h-full flex-col justify-between">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-stone-400">Cher Journal</p>
                    <h2 class="mt-8 text-3xl font-semibold leading-tight">Un espace qui te ressemble.</h2>
                    <p class="mt-4 text-sm leading-7 text-stone-300">Construis ton coin personnel avec des choix simples, réversibles et respectueux de ton intimité.</p>
                </div>
                <div>
                    @php
                        $selectedAvatar = collect($this->avatars()[$this->avatarGroup()])->firstWhere('key', $avatarKey);
                    @endphp
                    <div class="rounded-3xl border border-white/10 bg-white/10 p-4">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-stone-400">Aperçu</p>
                        <div class="mt-4 flex items-center gap-3">
                            @if ($selectedAvatar)
                                <img src="{{ $selectedAvatar['src'] }}" alt="Avatar sélectionné" class="h-14 w-14 rounded-2xl object-cover" />
                            @endif
                            <div class="min-w-0">
                                <p class="truncate font-semibold text-white">{{ $displayName ?: 'Ton espace' }}</p>
                                <p class="mt-1 text-xs text-stone-300">{{ ucfirst($theme) }} · {{ $isAnonymous ? 'Anonyme' : 'Pseudonyme' }}</p>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-xs text-stone-300">
                            <span>{{ $profilePoints }} points</span>
                            <span>{{ count($menu) }} menus actifs</span>
                        </div>
                    </div>
                    <div class="mt-5 space-y-3 text-sm">
                        @foreach (['Identité douce', 'Présence visuelle', 'Ambiance et intimité', 'Ton espace quotidien'] as $index => $label)
                            <div class="flex items-center gap-3 {{ $step === $index + 1 ? 'text-white' : 'text-stone-500' }}">
                                <span class="flex h-7 w-7 items-center justify-center rounded-full border text-xs {{ $step >= $index + 1 ? 'border-white bg-white text-stone-900' : 'border-stone-600' }}">{{ $index + 1 }}</span>
                                <span>{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </aside>
        <main class="p-5 sm:p-8" style="background: {{ ['rose' => '#fffaf7', 'forest' => '#f4faf5', 'sun' => '#fffaf0'][$theme] }}">
        <div class="flex items-center justify-between gap-4">
            <div class="min-w-0">
                <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-stone-500">Ton espace</p>
                <h1 class="mt-2 text-2xl font-semibold text-stone-900 sm:text-3xl">
                    @if ($step === 1) Ton identité @elseif ($step === 2) Ta présence visuelle @elseif ($step === 3) Ton ambiance @else Ton espace quotidien @endif
                </h1>
            </div>
            <span class="text-sm font-semibold text-stone-500">{{ $step }} / 4</span>
        </div>

        <div class="mt-6 h-1.5 overflow-hidden rounded-full bg-stone-100">
            <div class="h-full rounded-full bg-stone-900 transition-all" style="width: {{ $step * 25 }}%"></div>
        </div>

        <div class="mt-8">
            @if ($step === 1)
                <p class="text-sm text-stone-600">Commence par la présence que tu veux donner à ton espace.</p>
                <label class="mt-5 block text-sm font-semibold text-stone-800">Nom affiché
                    <input wire:model.live="displayName" type="text" maxlength="255" class="cj-input" placeholder="Le nom qui apparaîtra dans ton espace" />
                </label>
                @error('displayName') <span class="mt-1 block text-xs text-red-600">{{ $message }}</span> @enderror
                <p class="mt-5 text-sm font-semibold text-stone-800">Préférence d’avatar</p>
                <div class="mt-3 grid gap-3 sm:grid-cols-2">
                    @foreach (['female' => 'Féminin', 'male' => 'Masculin', 'neutral' => 'Neutre', 'prefer_not_to_say' => 'Je préfère ne pas préciser'] as $value => $label)
                        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border p-4 transition {{ $gender === $value ? 'border-stone-900 bg-stone-900 text-white' : 'border-stone-200 bg-stone-50 text-stone-800 hover:border-stone-400' }}">
                            <input wire:model.live="gender" type="radio" value="{{ $value }}" class="sr-only" />
                            <span class="text-sm font-semibold">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            @elseif ($step === 2)
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <p class="text-sm text-stone-600">Choisis un avatar et une ambiance pour ton espace.</p>
                    <span class="rounded-full bg-stone-100 px-3 py-1 text-xs font-semibold text-stone-700">{{ $profilePoints }} points</span>
                </div>
                <div class="mt-5 grid max-h-[28rem] grid-cols-2 gap-3 overflow-y-auto pr-1 sm:grid-cols-3">
                    @foreach ($this->avatars()[$gender === 'prefer_not_to_say' ? 'neutral' : $gender] as $avatar)
                        <label class="cursor-pointer rounded-2xl border p-3 text-center transition {{ $avatar['locked'] ? 'cursor-not-allowed border-stone-200 bg-stone-100 opacity-60' : ($avatarKey === $avatar['key'] ? 'border-stone-900 bg-stone-50 ring-2 ring-stone-900' : 'border-stone-200 hover:border-stone-400') }}">
                            <input wire:model.live="avatarKey" type="radio" value="{{ $avatar['key'] }}" class="sr-only" @disabled($avatar['locked']) />
                            <img src="{{ $avatar['src'] }}" alt="Avatar {{ $avatar['label'] }}" class="mx-auto h-20 w-20 rounded-full" />
                            <span class="mt-2 block text-xs font-semibold text-stone-700">{{ $avatar['label'] }}</span>
                            @if ($avatar['locked'])
                                <span class="mt-1 block text-[10px] text-stone-500">{{ $avatar['required_points'] }} points</span>
                            @endif
                        </label>
                    @endforeach
                </div>
                <div class="mt-5 rounded-2xl border border-dashed border-stone-300 bg-white/70 p-4">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <p class="text-sm font-semibold text-stone-800">Ton propre avatar</p>
                        <span class="text-[11px] font-medium text-stone-500">Disponible à 50 points</span>
                    </div>
                    <input wire:model="customAvatar" type="file" accept="image/jpeg,image/png,image/webp" class="mt-3 block w-full text-xs text-stone-600 file:mr-3 file:rounded-full file:border-0 file:bg-stone-900 file:px-3 file:py-2 file:text-xs file:font-semibold file:text-white" @disabled($profilePoints < 50) />
                    @error('customAvatar') <span class="mt-1 block text-xs text-red-600">{{ $message }}</span> @enderror
                    @if ($customAvatar)
                        <p class="mt-2 text-xs font-medium text-emerald-700">Avatar personnalisé sélectionné.</p>
                    @endif
                </div>
            @elseif ($step === 3)
                <p class="text-sm text-stone-600">Crée une ambiance et choisis ce qui doit rester visible.</p>
                <div class="mt-5 grid gap-3 sm:grid-cols-3">
                    @foreach (['rose' => 'Rose doux', 'forest' => 'Forêt calme', 'sun' => 'Soleil clair'] as $value => $label)
                        <label class="cursor-pointer rounded-2xl border p-4 text-sm font-semibold text-stone-700 transition {{ $theme === $value ? 'border-stone-900 bg-stone-50 ring-2 ring-stone-900' : 'border-stone-200 hover:border-stone-400' }}">
                            <input wire:model.live="theme" type="radio" value="{{ $value }}" class="sr-only" />
                            {{ $label }}
                        </label>
                    @endforeach
                </div>
                <div class="mt-6 space-y-3">
                    <label class="flex items-center justify-between rounded-2xl border border-stone-200 bg-stone-50 p-4 text-sm font-semibold text-stone-800">Profil visible<input wire:model.live="isPublic" type="checkbox" class="h-5 w-5 rounded border-stone-300 text-stone-900 focus:ring-stone-500" /></label>
                    <label class="flex items-center justify-between rounded-2xl border border-stone-200 bg-stone-50 p-4 text-sm font-semibold text-stone-800">Mode anonyme par défaut<input wire:model.live="isAnonymous" type="checkbox" class="h-5 w-5 rounded border-stone-300 text-stone-900 focus:ring-stone-500" /></label>
                </div>
            @else
                <p class="text-sm text-stone-600">Voici la configuration qui sera appliquée à ton espace.</p>
                <div class="mt-5 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl border border-stone-200 bg-stone-50 p-4"><span class="text-xs text-stone-500">Nom affiché</span><p class="mt-1 font-semibold text-stone-900">{{ $displayName }}</p></div>
                    <div class="rounded-2xl border border-stone-200 bg-stone-50 p-4"><span class="text-xs text-stone-500">Ambiance</span><p class="mt-1 font-semibold text-stone-900">{{ ['rose' => 'Rose doux', 'forest' => 'Forêt calme', 'sun' => 'Soleil clair'][$theme] }}</p></div>
                    <div class="rounded-2xl border border-stone-200 bg-stone-50 p-4"><span class="text-xs text-stone-500">Confidentialité</span><p class="mt-1 font-semibold text-stone-900">{{ $isPublic ? 'Profil visible' : 'Profil privé' }} · {{ $isAnonymous ? 'Anonyme' : 'Pseudonyme' }}</p></div>
                    <div class="rounded-2xl border border-stone-200 bg-stone-50 p-4"><span class="text-xs text-stone-500">Récompense</span><p class="mt-1 font-semibold text-stone-900">+10 points de départ</p></div>
                </div>
                <p class="mt-5 text-sm font-semibold text-stone-800">Menus activés</p>
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
            @if ($step < 4)
                <button type="button" wire:click="nextStep" wire:loading.attr="disabled" wire:target="nextStep" class="rounded-full bg-stone-900 px-5 py-2 text-sm font-semibold text-white disabled:cursor-wait disabled:opacity-60">
                    <span wire:loading.remove wire:target="nextStep">Continuer</span>
                    <span wire:loading wire:target="nextStep">Vérification...</span>
                </button>
            @else
                <button type="button" wire:click="finish" wire:loading.attr="disabled" wire:target="finish" class="rounded-full bg-stone-900 px-5 py-2 text-sm font-semibold text-white disabled:cursor-wait disabled:opacity-60">
                    <span wire:loading.remove wire:target="finish">Terminer mon espace</span>
                    <span wire:loading wire:target="finish">Enregistrement...</span>
                </button>
            @endif
        </div>
        </main>
    </div>
</div>
