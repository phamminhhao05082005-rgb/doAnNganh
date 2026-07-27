<?php

namespace App\Services;

use App\Models\Experience;
use App\Models\User;
use App\Interfaces\StudentExperienceRepositoryInterface;
use App\Interfaces\StudentExperienceServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class StudentExperienceService implements StudentExperienceServiceInterface
{
    protected StudentExperienceRepositoryInterface $repository;

    public function __construct(
        StudentExperienceRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function getAll(User $user): Collection
    {
        return $this->repository->getAll($user);
    }

    public function create(
        User $user,
        array $data
    ): Experience {

        return $this->repository->create(
            $user,
            $data
        );
    }

    public function update(
        User $user,
        Experience $experience,
        array $data
    ): Experience {

        return $this->repository->update(
            $user,
            $experience,
            $data
        );
    }

    public function delete(
        User $user,
        Experience $experience
    ): void {

        $this->repository->delete(
            $user,
            $experience
        );
    }
}