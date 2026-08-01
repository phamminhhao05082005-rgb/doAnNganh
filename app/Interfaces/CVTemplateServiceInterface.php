<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Models\CVTemplate;

interface CVTemplateServiceInterface
{
    public function getAll(): Collection;

    public function findById(int $id): CVTemplate;
}