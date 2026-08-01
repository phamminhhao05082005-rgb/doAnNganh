<?php

namespace App\Repositories;

use App\Models\CV;
use App\Models\CVExperience;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\CVExperienceRepositoryInterface;

class CVExperienceRepository
implements CVExperienceRepositoryInterface
{
    public function getAll(
        CV $cv
    ): Collection
    {
        return $cv->experiences()
            ->latest()
            ->get();
    }

    public function create(
        CV $cv,
        array $data
    ): CVExperience
    {
        return $cv->experiences()
            ->create($data);
    }

    public function update(
        CVExperience $experience,
        array $data
    ): CVExperience
    {
        $experience->update($data);

        return $experience->refresh();
    }

    public function delete(
        CVExperience $experience
    ): void
    {
        $experience->delete();
    }
}