<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\JobServiceInterface;
use App\Models\Job;
use App\Http\Resources\JobDetailResource;
use App\Http\Resources\JobListResource;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct(
        private JobServiceInterface $jobService
    ) {}

    public function index(Request $request)
    {

        return JobListResource::collection(
            $this->jobService->getAllJobs($request->all())
        );
    }

    public function show(Job $job)
    {
        return response()->json([
            'data' => new JobDetailResource(
                $this->jobService->getJobDetail($job->id)
            )
        ]);
    }
}
