<?php

namespace App\Interfaces;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface StudentBookmarkRepositoryInterface
{
    public function getAll(User $user, int $perPage = 6): LengthAwarePaginator;

    public function bookmark(
        User $user,
        Job $job
    ): void;

    public function unBookmark(
        User $user,
        Job $job
    ): void;
}