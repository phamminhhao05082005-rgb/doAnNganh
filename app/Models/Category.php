<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Category extends Model
{
    protected $fillable = [
        'name'
    ];

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function applications(): HasManyThrough
    {
        return $this->hasManyThrough(
            Application::class,
            Job::class,
            'category_id', 
            'job_id',      
            'id',         
            'id'         
        );
    }
}