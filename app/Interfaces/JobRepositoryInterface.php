<?php

namespace App\Interfaces;

use App\Models\Job;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface JobRepositoryInterface
{
    public function getMyJobs(int $companyId, int $perPage = 10): LengthAwarePaginator;

    public function findById(int $jobId): ?Job;

    public function create(
        array $data
    ): Job;

    public function update(
        Job $job,
        array $data
    ): Job;

    public function delete(
        Job $job
    ): void;

    public function getAllJobs();
}