<?php

namespace App\Services;

use App\Models\Education;
use App\Models\User;
use App\Interfaces\StudentEducationRepositoryInterface;
use App\Interfaces\StudentEducationServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

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
        $this->checkUserMatch($user);
        return $this->repository->create($user, $data);
    }

    public function update(
        User $user,
        Education $education,
        array $data
    ): Education {
        $this->checkOwner($user, $education);
        return $this->repository->update(
            $user,
            $education,
            $data
        );
    }

    public function delete(User $user, Education $education): void
    {
        $this->checkOwner($user, $education);
        $this->repository->delete($user, $education);
    }

    private function checkOwner(User $user, Education $education): void
    {
        $this->checkUserMatch($user);

        $profile = $user->candidateProfile;
        if (!$profile || $education->profile_id !== $profile->id) {
            throw new Exception("You cannot access or modify this education record.");
        }
    }

    private function checkUserMatch(User $user): void
    {
        $currentUser = Auth::user();

        if (!$currentUser || $currentUser->id !== $user->id) {
            throw new Exception("Unauthorized access.");
        }
    }
}