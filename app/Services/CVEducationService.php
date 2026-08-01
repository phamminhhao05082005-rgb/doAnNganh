<?php

namespace App\Services;

use App\Models\CV;
use App\Models\CVEducation;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\CVEducationServiceInterface;
use App\Interfaces\CVEducationRepositoryInterface;

class CVEducationService
implements CVEducationServiceInterface
{
    protected CVEducationRepositoryInterface $repository;

    public function __construct(
        CVEducationRepositoryInterface $repository
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
    ): CVEducation
    {
        return $this->repository->create(
            $cv,
            $data
        );
    }

    public function update(
        CVEducation $education,
        array $data
    ): CVEducation
    {
        return $this->repository->update(
            $education,
            $data
        );
    }

    public function delete(
        CVEducation $education
    ): void
    {
        $this->repository->delete(
            $education
        );
    }
}