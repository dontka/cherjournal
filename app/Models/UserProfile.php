<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'display_name',
        'username',
        'gender',
        'avatar_url',
        'avatar_key',
        'avatar_id',
        'theme',
        'menu',
        'points',
        'onboarding_completed',
        'bio',
        'timezone',
        'is_public',
        'is_anonymous',
        'email_notifications',
        'in_app_notifications',
        'comments_enabled',
        'comment_moderation',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_anonymous' => 'boolean',
        'menu' => 'array',
        'points' => 'integer',
        'onboarding_completed' => 'boolean',
        'email_notifications' => 'boolean',
        'in_app_notifications' => 'boolean',
        'comments_enabled' => 'boolean',
        'comment_moderation' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function avatar(): BelongsTo
    {
        return $this->belongsTo(Avatar::class);
    }
}
