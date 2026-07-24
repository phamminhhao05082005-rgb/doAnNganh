<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CV extends Model
{
    protected $table = 'cvs';

    protected $fillable = [
        'profile_id',
        'template_id',
        'title',
        'file_url',
        'is_default',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(CandidateProfile::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(CVTemplate::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}