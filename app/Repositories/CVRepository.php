<?php

namespace App\Repositories;

use App\Models\CV;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\CVRepositoryInterface;

class CVRepository
implements CVRepositoryInterface
{
    public function getMyCVs(int $userId): Collection
    {
        return CV::with('template')
            ->where('user_id', $userId)->latest()->get();
    }

    public function findById(int $id): CV
    {
        return CV::findOrFail($id);
    }

    public function create(array $data): CV
    {
        return CV::create($data);
    }

    public function update(CV $cv, array $data): CV
    {
        $cv->update($data);
        return $cv->refresh();
    }

    public function delete(CV $cv): bool
    {
        return $cv->delete();
    }
}