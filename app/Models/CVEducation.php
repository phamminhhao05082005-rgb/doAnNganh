<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CVEducation extends Model
{
    protected $table = "cv_educations";

    protected $fillable = [

        'cv_id',

        'school_name',

        'major',

        'start_date',

        'end_date',

        'degree',

        'gpa'

    ];

    public function cv(): BelongsTo
    {
        return $this->belongsTo(
            CV::class,
            'cv_id'
        );
    }
}
