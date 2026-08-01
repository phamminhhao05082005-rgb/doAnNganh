<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CVExperience extends Model
{
    protected $table = "cv_experiences";

    protected $fillable = [

        'cv_id',

        'company_name',

        'position',

        'start_date',

        'end_date',

        'description'

    ];

    public function cv(): BelongsTo
    {
        return $this->belongsTo(
            CV::class,
            'cv_id'
        );
    }
}
