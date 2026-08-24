<?php

namespace App\Repositories;

use App\Interfaces\StudentBookmarkRepositoryInterface;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudentBookmarkRepository implements StudentBookmarkRepositoryInterface
{

    public function getAll(User $user, int $perPage = 6): LengthAwarePaginator
    {
        return $user->bookmarkedJobs()
            ->with([
                'company',
                'category',
                'skills'
            ])
            ->latest('bookmarks.created_at')
            ->paginate($perPage);
    }
    public function bookmark(User $user, Job $job): void
    {
        $user->bookmarkedJobs()
            ->syncWithoutDetaching([$job->id]);
    }

    public function unBookmark(User $user, Job $job): void
    {

        $user->bookmarkedJobs()
            ->detach($job->id);
    }
}
