<?php

namespace App\Repositories;

use App\Models\CVTemplate;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\CVTemplateRepositoryInterface;

class CVTemplateRepository implements CVTemplateRepositoryInterface
{
    public function getAll(): Collection
    {
        return CVTemplate::where(
            'is_active',
            true
        )->get();
    }

    public function findById(int $id): CVTemplate
    {
        return CVTemplate::where(
            'is_active',
            true
        )->findOrFail($id);
    }
}