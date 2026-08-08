<?php

namespace App\Services;

use App\Models\Application;
use App\Models\User;
use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\ApplicationRepositoryInterface;
use App\Interfaces\ApplicationServiceInterface;

class ApplicationService
implements ApplicationServiceInterface
{
    protected ApplicationRepositoryInterface $repository;

    public function __construct(
        ApplicationRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function apply(
        User $user,
        array $data
    ): Application {

        $job = Job::findOrFail(
            $data['job_id']
        );

        if (!$job->status) {

            throw new \Exception(
                "Công việc đã đóng."
            );
        }

        if (
            $job->deadline &&
            now()->gt($job->deadline)
        ) {

            throw new \Exception(
                "Đã hết hạn ứng tuyển."
            );
        }

        return $this->repository->apply(
            $user,
            $data
        );
    }

    public function getMyApplications(
        User $user
    ): Collection {

        return $this->repository
            ->getMyApplications($user);
    }

    public function getJobApplications(
        User $user,
        int $jobId
    ): Collection {

        $job = Job::where(
            'id',
            $jobId
        )
            ->whereHas(
                'company',
                function ($q) use ($user) {

                    $q->where(
                        'owner_id',
                        $user->id
                    );
                }
            )
            ->firstOrFail();

        return Application::with([

            'cv.educations',

            'cv.experiences',

            'job.company'

        ])
            ->where(
                'job_id',
                $job->id
            )
            ->latest()
            ->get();
    }

    public function updateStatus(
        User $user,
        int $applicationId,
        string $status
    ): Application {

        $application = $this->repository
            ->findById($applicationId);

        if ((int) $application->job->company->owner_id !== (int) $user->id) {
            abort(403, 'Bạn không có quyền.');
        }

        return $this->repository->updateStatus($application, $status);
    }

    public function delete(
        User $user,
        int $applicationId
    ): void {
        $application = $this->repository
            ->findById($applicationId);

        if (
            $application->cv->user_id != $user->id
        ) {

            abort(
                403,
                "Bạn không có quyền."
            );
        }

        if (
            $application->status !== "PENDING"
        ) {

            throw new \Exception(
                "Nhà tuyển dụng đã xử lý hồ sơ, không thể hủy ứng tuyển."
            );
        }

        $this->repository
            ->delete($application);
    }
}
