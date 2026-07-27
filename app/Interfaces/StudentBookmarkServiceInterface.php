<?php

namespace App\Interfaces;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface StudentBookmarkServiceInterface
{
    public function getAll(User $user): Collection;

    public function bookmark(
        User $user,
        Job $job
    ): void;

    public function unBookmark(
        User $user,
        Job $job
    ): void;
}