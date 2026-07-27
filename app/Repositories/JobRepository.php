<?php

namespace App\Repositories;

use App\Interfaces\JobRepositoryInterface;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobRepository implements JobRepositoryInterface
{
    public function getMyJobs(int $companyId)
    {
        return Job::with([
            'category',
            'skills'
        ])
            ->where('company_id', $companyId)
            ->latest()
            ->get();
    }

    public function getAllJobs(array $filters = [])
    {
        $query = Job::with([
            'company',
            'category',
            'skills',
            'bookmarkedUsers' => function ($q) {
                if (auth()->check()) {
                    $q->where('users.id', auth()->id());
                }
            }
        ]);

        $user = Auth::user();

        if (!$user || $user->role->name !== 'ADMIN') {
            $query->where('status', true);
        }

        if (!empty($filters['keyword'])) {

            $keyword = $filters['keyword'];

            $query->where(function ($q) use ($keyword) {

                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhereHas('company', function ($company) use ($keyword) {
                        $company->where('name', 'like', "%{$keyword}%");
                    });
            });
        }

        if (!empty($filters['category_id'])) {

            $query->where(
                'category_id',
                $filters['category_id']
            );
        }

        if (!empty($filters['salary_min'])) {

            $query->where(
                'salary_min',
                '>=',
                $filters['salary_min']
            );
        }

        if (!empty($filters['salary_max'])) {

            $query->where(
                'salary_max',
                '<=',
                $filters['salary_max']
            );
        }

        if (!empty($filters['skills'])) {

            $skills = $filters['skills'];

            $query->whereHas('skills', function ($q) use ($skills) {

                $q->whereIn('skills.id', $skills);
            });
        }

        return $query
            ->latest()
            ->paginate(3);
    }


    public function findById(int $jobId): ?Job
    {
        return Job::with([
            'company',
            'category',
            'skills',
            'bookmarkedUsers' => function ($q) {
                if (auth()->check()) {
                    $q->where('users.id', auth()->id());
                }
            }
        ])->find($jobId);
    }

    public function create(array $data): Job
    {
        $job = Job::create($data);

        if (!empty($data['skills'])) {

            $job->skills()->sync(
                $data['skills']
            );
        }

        return $job->load([
            'category',
            'skills'
        ]);
    }

    public function update(
        Job $job,
        array $data
    ): Job {

        $job->update($data);

        if (isset($data['skills'])) {

            $job->skills()->sync(
                $data['skills']
            );
        }

        return $job->fresh()->load([
            'category',
            'skills'
        ]);
    }

    public function delete(Job $job): void
    {
        $job->delete();
    }
}
