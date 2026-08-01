<?php

namespace App\Interfaces;

use App\Models\CV;
use App\Models\CVExperience;
use Illuminate\Database\Eloquent\Collection;

interface CVExperienceRepositoryInterface
{
    public function getAll(CV $cv): Collection;

    public function create(
        CV $cv,
        array $data
    ): CVExperience;

    public function update(
        CVExperience $experience,
        array $data
    ): CVExperience;

    public function delete(
        CVExperience $experience
    ): void;
}