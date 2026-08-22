<?php

namespace App\Services;

use App\Events\NotificationCreated;
use App\Models\Application;
use App\Models\User;
use App\Models\Job;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\ApplicationRepositoryInterface;
use App\Interfaces\ApplicationServiceInterface;
use App\Models\Notification;
use App\Jobs\SendApplicationStatusEmailJob;
use App\Services\GeminiEvaluationService;

class ApplicationService implements ApplicationServiceInterface
{
    protected ApplicationRepositoryInterface $repository;
    protected GeminiEvaluationService $geminiService;

    public function __construct(
        ApplicationRepositoryInterface $repository,
        GeminiEvaluationService $geminiService
    ) {
        $this->repository = $repository;
        $this->geminiService = $geminiService;
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

        $application = $this->repository
            ->updateStatus(
                $application,
                $status
            );

        $candidateUser = $application->cv->user;

        $studentId = $application
            ->cv
            ->user_id;

        $title = 'Cập nhật hồ sơ ứng tuyển';

        $content = match ($status) {
            'ACCEPTED' =>
            'Hồ sơ ứng tuyển của bạn đã được nhà tuyển dụng duyệt.',

            'REJECTED' =>
            'Hồ sơ ứng tuyển của bạn đã bị từ chối.',

            default =>
            'Trạng thái hồ sơ ứng tuyển của bạn đã được cập nhật.'
        };

        $jobId = $application->job_id ?? $application->job->id;

        $notification = Notification::create([
            'user_id' => $studentId,
            'job_id'  => $jobId,
            'title' => $title,
            'content' => $content,
            'is_read' => false
        ]);

        event(new NotificationCreated($notification));

        if ($candidateUser && $candidateUser->email) {
            SendApplicationStatusEmailJob::dispatch($application);
        }

        return $application;
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

    public function evaluateApplicationsByJob(User $user, int $jobId, bool $forceReevaluate = false): Collection
    {
        $job = Job::where('id', $jobId)
            ->whereHas('company', function ($q) use ($user) {
                $q->where('owner_id', $user->id);
            })->firstOrFail();

        $query = Application::with([
            'cv.educations',
            'cv.experiences',
            'job.skills',
            'job.company'
        ])->where('job_id', $job->id);

        if (!$forceReevaluate) {
            $query->whereNull('ai_score');
        }

        $applications = $query->get();

        foreach ($applications as $application) {
            $result = $this->geminiService->evaluateApplication($application);

            $application->update([
                'ai_score'      => $result['score'],
                'ai_evaluation' => $result['evaluation']
            ]);
        }

        return Application::with(['cv', 'job'])
            ->where('job_id', $job->id)
            ->orderByRaw('ai_score IS NULL ASC')
            ->orderBy('ai_score', 'desc')
            ->get();
    }
}
