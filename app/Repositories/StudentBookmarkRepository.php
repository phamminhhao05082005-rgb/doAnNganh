<?php

namespace App\Repositories;

use App\Interfaces\StudentBookmarkRepositoryInterface;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class StudentBookmarkRepository implements StudentBookmarkRepositoryInterface
{
   
    public function getAll(User $user): Collection
    {
        return $user->bookmarkedJobs()
            ->with([
                'company',
                'category',
                'skills'
            ])
            ->latest('bookmarks.created_at')
            ->get();
    }

    public function bookmark(
        User $user,
        Job $job
    ): void {

        $user->bookmarkedJobs()
            ->syncWithoutDetaching([$job->id]);
    }

    public function unBookmark(
        User $user,
        Job $job
    ): void {

        $user->bookmarkedJobs()
            ->detach($job->id);
    }
}