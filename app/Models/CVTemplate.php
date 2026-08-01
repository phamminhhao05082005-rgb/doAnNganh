<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CVTemplate extends Model
{
    protected $table = 'cv_templates';

    protected $fillable = [
        'name',
        'description',
        'thumbnail',
        'template_path',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function cvs(): HasMany
    {
        return $this->hasMany(CV::class, 'template_id');
    }
}