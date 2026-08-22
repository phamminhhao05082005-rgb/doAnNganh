<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Application extends Model
{
    protected $fillable = [
        'job_id',
        'cv_id',
        'status',
        'applied_at',
        'ai_score',
        'ai_evaluation'
    ];

    protected function casts(): array
    {
        return [
            'applied_at'    => 'datetime',
            'ai_score'      => 'integer',
            'ai_evaluation' => 'array'
        ];
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function cv(): BelongsTo
    {
        return $this->belongsTo(CV::class, 'cv_id');
    }

    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            CV::class,
            'id',       
            'id',       
            'cv_id',    
            'user_id' 
        );
    }
}