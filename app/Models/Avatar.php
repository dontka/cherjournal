<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Avatar extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'name', 'file_path', 'category', 'gender', 'is_active',
        'is_unlocked', 'required_points', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_unlocked' => 'boolean',
        'required_points' => 'integer',
        'sort_order' => 'integer',
    ];

    public function userProfiles(): HasMany
    {
        return $this->hasMany(UserProfile::class);
    }
}
