<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CandidateProfile extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'summary',
        'experience_year',
        'expected_salary'
    ];

    protected function casts(): array
    {
        return [
            'expected_salary' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class, 'profile_id');
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class, 'profile_id');
    }

    public function cvs(): HasMany
    {
        return $this->hasMany(CV::class, 'profile_id');
    }
}