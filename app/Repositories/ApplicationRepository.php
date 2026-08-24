<?php

namespace App\Repositories;

use App\Models\Application;
use App\Models\CV;
use App\Models\Job;
use App\Models\User;
use App\Interfaces\ApplicationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApplicationRepository
implements ApplicationRepositoryInterface
{
    public function apply(
        User $user,
        array $data
    ): Application {

        $cv = CV::where(
            'id',
            $data['cv_id']
        )
            ->where(
                'user_id',
                $user->id
            )
            ->first();

        if (!$cv) {

            throw new ModelNotFoundException();
        }

        $job = Job::findOrFail(
            $data['job_id']
        );

        $exists = Application::where(
            'job_id',
            $job->id
        )
            ->where(
                'cv_id',
                $cv->id
            )
            ->exists();

        if ($exists) {

            throw new \Exception(
                'Bạn đã ứng tuyển công việc này.'
            );
        }

        return Application::create([

            'job_id' => $job->id,

            'cv_id' => $cv->id,

            'status' => 'PENDING',

            'applied_at' => now()

        ]);
    }

    public function getMyApplications(
        User $user,
        int $perPage = 10
    ): LengthAwarePaginator {

        return Application::with([
            'job.company',
            'cv'
        ])
            ->whereHas('cv', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->paginate($perPage);
    }

    public function getApplicationsOfEmployer(
        User $user,
        int $perPage = 10
    ): LengthAwarePaginator {
        return Application::with([
            'job.company',
            'cv.educations',
            'cv.experiences'
        ])
            ->whereHas('job.company', function ($q) use ($user) {
                $q->where('owner_id', $user->id);
            })
            ->latest()
            ->paginate($perPage);
    }

    public function getJobApplications(
        User $user,
        int $jobId,
        int $perPage = 10
    ): LengthAwarePaginator {
        $job = Job::where('id', $jobId)
            ->whereHas('company', function ($q) use ($user) {
                $q->where('owner_id', $user->id);
            })
            ->firstOrFail();

        return Application::with([
            'cv.educations',
            'cv.experiences',
            'job.company'
        ])
            ->where('job_id', $job->id)
            ->latest()
            ->paginate($perPage);
    }


    public function updateStatus(
        Application $application,
        string $status
    ): Application {

        $application->update([

            'status' => $status

        ]);

        return $application->refresh();
    }

    public function findById(
        int $id
    ): Application {

        return Application::with([

            'job.company',

            'cv'

        ])->findOrFail($id);
    }

    public function delete(
        Application $application
    ): void {
        $application->delete();
    }
}
