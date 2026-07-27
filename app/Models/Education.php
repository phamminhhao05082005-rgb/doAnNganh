<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    protected $table = 'educations';

    protected $fillable = [
        'profile_id',
        'school',
        'major',
        'start_year',
        'end_year',
    ];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(CandidateProfile::class);
    }
}
