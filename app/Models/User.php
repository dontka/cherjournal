<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'status',
        'last_login_at',
    ];

    protected static function booted(): void
    {
        static::created(function (self $user): void {
            $user->profile()->firstOrCreate(
                ['user_id' => $user->id],
                [
                    'username' => $user->username,
                    'display_name' => $user->name,
                    'avatar_url' => $user->generateAvatarUrl(),
                    'is_public' => true,
                    'is_anonymous' => false,
                    'email_notifications' => true,
                    'in_app_notifications' => true,
                    'comments_enabled' => true,
                    'comment_moderation' => false,
                ]
            );
        });
    }

    public function generateAvatarUrl(): string
    {
        $source = trim($this->username ?: $this->name ?: 'CJ');
        $initials = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $source), 0, 2));
        $initials = $initials !== '' ? $initials : 'CJ';
        $background = strtoupper(dechex(random_int(0, 0xFFFFFF)));

        return 'https://ui-avatars.com/api/?name='.urlencode($initials).'&background='.trim($background, '#').'&color=fff&size=200';
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function userSettings(): HasMany
    {
        return $this->hasMany(UserSetting::class);
    }

    public function journalEntries(): HasMany
    {
        return $this->hasMany(JournalEntry::class);
    }

    public function pointTransactions(): HasMany
    {
        return $this->hasMany(PointTransaction::class);
    }
}
