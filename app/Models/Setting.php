<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'group',
        'value',
        'is_public',
    ];

    protected $casts = [
        'value' => 'array',
        'is_public' => 'boolean',
    ];

    public function userSettings(): HasMany
    {
        return $this->hasMany(UserSetting::class);
    }
}
