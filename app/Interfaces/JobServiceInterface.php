<?php

namespace App\Interfaces;

use App\Models\Job;

interface JobServiceInterface
{
    public function getMyJobs();

    public function getAllJobs();

    public function getJobDetail(int $jobId): Job;

    public function create(array $data): Job;

    public function update(
        Job $job,
        array $data
    ): Job;

    public function delete(Job $job): void;

    public function toggleStatus(int $jobId, bool $status): Job;
}
