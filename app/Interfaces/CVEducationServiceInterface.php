<?php

namespace App\Interfaces;

use App\Models\CV;
use App\Models\CVEducation;
use Illuminate\Database\Eloquent\Collection;

interface CVEducationServiceInterface
{
    public function getAll(CV $cv): Collection;

    public function create(
        CV $cv,
        array $data
    ): CVEducation;

    public function update(
        CVEducation $education,
        array $data
    ): CVEducation;

    public function delete(
        CVEducation $education
    ): void;
}