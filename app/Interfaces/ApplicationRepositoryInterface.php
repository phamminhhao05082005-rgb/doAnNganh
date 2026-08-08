<?php

namespace App\Interfaces;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface ApplicationRepositoryInterface
{
    public function apply(
        User $user,
        array $data
    ): Application;

    public function getMyApplications(
        User $user
    ): Collection;

    public function getApplicationsOfEmployer(
        User $user
    ): Collection;

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
