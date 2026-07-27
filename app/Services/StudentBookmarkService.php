<?php

namespace App\Services;

use App\Interfaces\StudentBookmarkRepositoryInterface;
use App\Interfaces\StudentBookmarkServiceInterface;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class StudentBookmarkService implements StudentBookmarkServiceInterface
{
    protected StudentBookmarkRepositoryInterface $repository;

    public function __construct(
        StudentBookmarkRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function getAll(User $user): Collection
    {
        return $this->repository->getAll($user);
    }

    public function bookmark(
        User $user,
        Job $job
    ): void {

        $this->repository->bookmark(
            $user,
            $job
        );
    }

    public function unBookmark(
        User $user,
        Job $job
    ): void {

        $this->repository->unBookmark(
            $user,
            $job
        );
    }
}