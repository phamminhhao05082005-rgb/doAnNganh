<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\CreateJobRequest;
use App\Http\Requests\Employer\UpdateJobRequest;
use App\Interfaces\JobServiceInterface;
use App\Models\Job;
use App\Http\Resources\JobDetailResource;
use App\Http\Resources\JobListResource;

class EmployerJobController extends Controller
{
    public function __construct(
        private JobServiceInterface $jobService
    ) {}

    public function getJobsOfCompany()
    {
        return response()->json([
            'data' => JobListResource::collection(
                $this->jobService->getMyJobs()
            )
        ]);
    }

    public function store(CreateJobRequest $request)
    {
        $job = $this->jobService->create(
            $request->validated()
        );

        return response()->json([
            'message' => 'Create job successfully.',
            'data' => new JobDetailResource($job)
        ], 201);
    }

    public function update(
        UpdateJobRequest $request,
        Job $job
    ) {

        $job = $this->jobService->update(
            $job,
            $request->validated()
        );

        return response()->json([
            'message' => 'Update job successfully.',
            'data' => new JobDetailResource($job)
        ]);
    }

    public function destroy(Job $job)
    {
        $this->jobService->delete($job);

        return response()->json([
            'message' => 'Delete job successfully.'
        ]);
    }
}
