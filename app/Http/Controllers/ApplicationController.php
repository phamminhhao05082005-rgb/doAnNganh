<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Http\Requests\Employer\UpdateApplicationStatusRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\CVResource;
use App\Interfaces\ApplicationServiceInterface;
use App\Models\Application;
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

    public function getCVDetail($applicationId)
    {

        $application = Application::with(['job', 'cv.template', 'cv.educations', 'cv.experiences'])
            ->findOrFail($applicationId);

        $user = auth()->user();
        if (
            !$application->job ||
            !$application->job->company ||
            $application->job->company->owner_id !== $user->id
        ) {
            return response()->json([
                'message' => 'Bạn không có quyền xem CV của đơn ứng tuyển này.'
            ], 403);
        }

        $cv = $application->cv;

        if (!$cv) {
            return response()->json([
                'message' => 'Không tìm thấy CV liên kết với đơn ứng tuyển này.'
            ], 404);
        }

        return new CVResource($cv);
    }
}
