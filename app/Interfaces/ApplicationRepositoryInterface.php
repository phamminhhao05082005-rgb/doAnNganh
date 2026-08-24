<?php

namespace App\Interfaces;

use App\Models\Application;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ApplicationRepositoryInterface
{
    public function apply(
        User $user,
        array $data
    ): Application;

    public function getMyApplications(
        User $user,
        int $perPage = 10
    ): LengthAwarePaginator;

    public function getApplicationsOfEmployer(
        User $user,
        int $perPage = 10
    ): LengthAwarePaginator;

    public function getJobApplications(
        User $user,
        int $jobId,
        int $perPage = 10
    ): LengthAwarePaginator;

    public function updateStatus(
        Application $application,
        string $status
    ): Application;

    public function findById(
        int $id
    ): Application;

    public function delete(
        Application $application
    ): void;
}
