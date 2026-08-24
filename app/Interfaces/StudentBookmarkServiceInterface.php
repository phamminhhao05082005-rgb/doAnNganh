<?php

namespace App\Interfaces;

use App\Models\Job;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface StudentBookmarkServiceInterface
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