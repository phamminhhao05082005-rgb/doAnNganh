<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Http\Requests\Employer\UpdateApplicationStatusRequest;
use App\Http\Resources\ApplicationResource;
use App\Interfaces\ApplicationServiceInterface;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    protected ApplicationServiceInterface $service;

    public function __construct(
        ApplicationServiceInterface $service
    ) {
        $this->service = $service;
    }

    public function apply(
        ApplyJobRequest $request
    ) {
        return new ApplicationResource(

            $this->service->apply(
                auth()->user(),
                $request->validated()
            )

        );
    }

    public function myApplications()
    {
        return ApplicationResource::collection(

            $this->service->getMyApplications(
                auth()->user()
            )

        );
    }

    public function jobApplications(
        int $jobId
    ) {
        return ApplicationResource::collection(

            $this->service->getJobApplications(
                auth()->user(),
                $jobId
            )

        );
    }

    public function updateStatus(
        UpdateApplicationStatusRequest $request,
        int $id
    ) {
        return new ApplicationResource(

            $this->service->updateStatus(
                auth()->user(),
                $id,
                $request->validated()['status']
            )

        );
    }

    public function destroy(
        int $id
    ) {
        $this->service->delete(
            auth()->user(),
            $id
        );

        return response()->json([
            "message" => "Hủy ứng tuyển thành công."
        ]);
    }
}
