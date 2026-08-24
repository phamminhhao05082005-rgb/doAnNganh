<?php

namespace App\Interfaces;

use App\Models\Application;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ApplicationServiceInterface
{
    public function apply(
        User $user,
        array $data
    ): Application;

    public function getMyApplications(
        User $user,
        int $perPage = 6
    ): LengthAwarePaginator;

    public function getJobApplications(
        User $user,
        int $jobId,
        int $perPage = 10
    ): LengthAwarePaginator;

    public function updateStatus(
        User $user,
        int $applicationId,
        string $status
    ): Application;

    public function delete(
        User $user,
        int $applicationId
    ): void;

    public function evaluateApplicationsByJob(User $user, int $jobId, bool $forceReevaluate = false): Collection;
}
