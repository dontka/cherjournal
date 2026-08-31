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
        'avatar_url',
        'bio',
        'timezone',
        'is_public',
        'is_anonymous',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_anonymous' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
