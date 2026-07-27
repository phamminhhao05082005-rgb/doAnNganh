<?php

namespace App\Services;

use App\Interfaces\StudentProfileRepositoryInterface;
use App\Interfaces\StudentProfileServiceInterface;
use App\Models\User;

class StudentProfileService implements StudentProfileServiceInterface
{
    protected StudentProfileRepositoryInterface $repository;

    public function __construct(
        StudentProfileRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function getProfile(User $user): User
    {
        return $this->repository->getProfile($user);
    }

    public function update(User $user, array $data): User
    {
        return $this->repository->update($user, $data);
    }
}
