<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'owner_id',
        'name',
        'logo',
        'website',
        'address',
        'description'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id')
        ->withTrashed();
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}