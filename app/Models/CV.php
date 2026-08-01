<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CV extends Model
{
    protected $table = 'cvs';

    protected $fillable = [

        'user_id',

        'profile_id',

        'template_id',

        'title',

        'full_name',

        'email',

        'phone',

        'avatar',

        'job_title',

        'summary',

        'experience_year',

        'expected_salary',

        'status'

    ];

    protected function casts(): array
    {
        return [

            'status' => 'boolean'

        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(
            CVTemplate::class,
            'template_id'
        );
    }

    public function educations(): HasMany
    {
        return $this->hasMany(
            CVEducation::class,
            'cv_id'
        );
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(
            CVExperience::class,
            'cv_id'
        );
    }
}
