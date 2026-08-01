<?php

namespace App\Services;

use App\Models\CV;
use App\Models\CVExperience;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\CVExperienceServiceInterface;
use App\Interfaces\CVExperienceRepositoryInterface;

class CVExperienceService
implements CVExperienceServiceInterface
{
    protected CVExperienceRepositoryInterface $repository;

    public function __construct(
        CVExperienceRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function getAll(
        CV $cv
    ): Collection
    {
        return $this->repository->getAll($cv);
    }

    public function create(
        CV $cv,
        array $data
    ): CVExperience
    {
        return $this->repository->create(
            $cv,
            $data
        );
    }

    public function update(
        CVExperience $experience,
        array $data
    ): CVExperience
    {
        return $this->repository->update(
            $experience,
            $data
        );
    }

    public function delete(
        CVExperience $experience
    ): void
    {
        $this->repository->delete(
            $experience
        );
    }
}