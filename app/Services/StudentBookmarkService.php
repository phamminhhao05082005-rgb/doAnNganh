<?php

namespace App\Services;

use App\Interfaces\StudentBookmarkRepositoryInterface;
use App\Interfaces\StudentBookmarkServiceInterface;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Exception;

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
        $this->checkOwner($user);
        return $this->repository->getAll($user);
    }

    public function bookmark(
        User $user,
        Job $job
    ): void {
        $this->checkOwner($user);

        if (!$job->status) {
            throw new Exception("Cannot bookmark an inactive job.");
        }

        $this->repository->bookmark(
            $user,
            $job
        );
    }

    public function unBookmark(
        User $user,
        Job $job
    ): void {
        $this->checkOwner($user);

        $this->repository->unBookmark(
            $user,
            $job
        );
    }

    private function checkOwner(User $targetUser): void
    {
        $currentUser = Auth::user();

        if (!$currentUser || $currentUser->id !== $targetUser->id) {
            throw new Exception("Bạn không thể thao tác trên job yêu thích của sinh viên khác.");
        }

        $currentUser->loadMissing('role');
        if ($currentUser->role?->name !== 'STUDENT') {
            throw new Exception("Chỉ sinh viên mới được phép thêm yêu thích công việc.");
        }
    }
}