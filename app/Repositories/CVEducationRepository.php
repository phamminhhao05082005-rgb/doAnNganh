<?php

namespace App\Repositories;

use App\Models\CV;
use App\Models\CVEducation;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\CVEducationRepositoryInterface;

class CVEducationRepository
implements CVEducationRepositoryInterface
{
    public function getAll(CV $cv): Collection
    {
        return $cv->educations()->latest()->get();
    }

    public function create(CV $cv, array $data): CVEducation
    {
        return $cv->educations()->create($data);
    }

    public function update(CVEducation $education, array $data): CVEducation
    {
        $education->update($data);
        return $education->refresh();
    }

    public function delete(CVEducation $education): void
    {
        $education->delete();
    }
}