<?php

namespace App\Services;

use App\Models\Education;
use App\Models\User;
use App\Interfaces\StudentEducationRepositoryInterface;
use App\Interfaces\StudentEducationServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class StudentEducationService implements StudentEducationServiceInterface
{
    protected StudentEducationRepositoryInterface $repository;

    public function __construct(
        StudentEducationRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function getAll(User $user): Collection
    {
        return $this->repository->getAll($user);
    }

    public function create(User $user, array $data): Education
    {
        return $this->repository->create($user, $data);
    }

    public function update(
        User $user,
        Education $education,
        array $data
    ): Education {
        return $this->repository->update(
            $user,
            $education,
            $data
        );
    }

    public function delete(User $user, Education $education): void
    {
        $this->repository->delete($user, $education);
    }
}