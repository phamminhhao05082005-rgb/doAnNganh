<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    protected $table = "educations";

    protected $fillable = [

        'profile_id',

        'school_name',

        'major',

        'degree',

        'gpa',

        'start_date',

        'end_date'

    ];

    protected function casts(): array
    {
        return [

            'start_date' => 'date',

            'end_date' => 'date',

            'gpa' => 'decimal:2'

        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(
            CandidateProfile::class
        );
    }
}