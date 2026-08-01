<?php

namespace App\Interfaces;

use App\Models\CV;
use Illuminate\Database\Eloquent\Collection;

interface CVRepositoryInterface
{
    public function getMyCVs(int $userId): Collection;

    public function findById(int $id): CV;

    public function create(array $data): CV;

    public function update(
        CV $cv,
        array $data
    ): CV;

    public function delete(CV $cv): bool;
}