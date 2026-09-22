<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Http\Requests\Employer\UpdateApplicationStatusRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\CVResource;
use App\Interfaces\ApplicationServiceInterface;
use App\Jobs\EvaluateJobCvsJob;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

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
                Auth::user(),
                $request->validated()
            )

        );
    }

    public function myApplications(Request $request): AnonymousResourceCollection
    {
        $perPage = $request->input('per_page', 10);

        return ApplicationResource::collection(
            $this->service->getMyApplications(
                $request->user(),
                $perPage
            )
        );
    }

    public function jobApplications(
        Request $request,
        int $jobId
    ): AnonymousResourceCollection {
        $perPage = $request->input('per_page', 10);

        return ApplicationResource::collection(
            $this->service->getJobApplications(
                $request->user(),
                $jobId,
                $perPage
            )
        );
    }

    public function updateStatus(
        UpdateApplicationStatusRequest $request,
        int $id
    ) {
        return new ApplicationResource(

            $this->service->updateStatus(
                Auth::user(),
                $id,
                $request->validated()['status']
            )

        );
    }

    public function destroy(
        int $id
    ) {
        $this->service->delete(
            Auth::user(),
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

        $user = Auth::user();
        if (
            !$application->job ||
            !$application->job->company ||
            $application->job->company->owner_id !== $user->id
        ) {
            return response()->json([
                'message' => 'Bạn không có quyền xem CV của đơn ứng tuyển này.'
            ], 403);
        }

        if (!$application->cv) {
            return response()->json([
                'message' => 'Không tìm thấy CV liên kết với đơn ứng tuyển này.'
            ], 404);
        }

        return new ApplicationResource($application);
    }

    public function evaluateJobCvs(Request $request, int $jobId): JsonResponse
    {
        try {
            $user = $request->user();
            $force = $request->boolean('force', false);

            EvaluateJobCvsJob::dispatch($user, $jobId, $force);

            return response()->json([
                'status'  => 'success',
                'message' => 'Đánh giá danh sách CV thành công.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
