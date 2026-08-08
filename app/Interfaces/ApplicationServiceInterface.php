<?php

namespace App\Interfaces;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface ApplicationServiceInterface
{
    public function apply(
        User $user,
        array $data
    ): Application;

    public function getMyApplications(
        User $user
    ): Collection;

    public function getJobApplications(
        User $user,
        int $jobId
    ): Collection;

    public function updateStatus(
        User $user,
        int $applicationId,
        string $status
    ): Application;

    public function delete(
        User $user,
        int $applicationId
    ): void;
}
