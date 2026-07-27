<?php

namespace App\Services;

use App\Interfaces\JobRepositoryInterface;
use App\Interfaces\JobServiceInterface;
use App\Models\Job;
use Exception;
use Illuminate\Support\Facades\Auth;

class JobService implements JobServiceInterface
{
    public function __construct(
        private JobRepositoryInterface $jobRepository
    ) {}

    public function getMyJobs()
    {
        $companyId = Auth::user()->company->id;
        return $this->jobRepository->getMyJobs($companyId);
    }

    public function getAllJobs(array $filters = [])
    {
        return $this->jobRepository->getAllJobs($filters);
    }

    public function getJobDetail(int $jobId): Job
    {
        $job = $this->jobRepository->findById($jobId);

        if (!$job) {
            throw new Exception("Job not found.");
        }

        $user = Auth::user();

        switch ($user->role->name) {

            case 'ADMIN':
                return $job;

            case 'EMPLOYER':

                if ($job->company_id != $user->company->id) {
                    throw new Exception("You cannot access this job.");
                }

                return $job;

            case 'STUDENT':

                if (!$job->status) {
                    throw new Exception("Job not found.");
                }

                return $job;

            default:
                throw new Exception("Unauthorized.");
        }
    }

    public function create(array $data): Job
    {
        $data['company_id'] = Auth::user()
            ->company
            ->id;

        return $this->jobRepository
            ->create($data);
    }

    public function update(Job $job, array $data): Job {
        $this->checkOwner($job);
        return $this->jobRepository->update($job, $data);
    }

    public function delete(Job $job): void
    {
        $this->checkOwner($job);
        $this->jobRepository->delete($job);
    }

    private function checkOwner(Job $job): void
    {
        $companyId = Auth::user()->company->id;

        if ($job->company_id != $companyId) {
            throw new Exception(
                "You cannot access this job."
            );
        }
    }
}
