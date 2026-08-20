<?php

namespace App\Repositories;

use App\Models\Application;
use App\Models\Bookmark;
use App\Models\CV;
use App\Models\Job;
use App\Models\User;
use App\Models\CVTemplate;
use App\Models\Category;
use App\Models\Company; 

class AnalyticsRepository
{
   
    public function countStudents(): int
    {
        return User::whereHas('role', function ($query) {
            $query->where('name', 'STUDENT');
        })->count();
    }

    public function countEmployers(): int
    {
        return User::whereHas('role', function ($query) {
            $query->where('name', 'EMPLOYER');
        })->count();
    }

    public function countJobs(): int
    {
        return Job::count();
    }

    public function countActiveJobs(): int
    {
        return Job::where('status', true)->count();
    }

    public function countApplications(): int
    {
        return Application::count();
    }

    public function countBookmarks(): int
    {
        return Bookmark::count();
    }

    public function countCVs(): int
    {
        return CV::count();
    }

    public function countClosedJobs(): int
    {
        return Job::where('status', false)->count();
    }

    public function getJobsCountByCategory()
    {
        return Category::withCount('jobs')
            ->having('jobs_count', '>', 0)
            ->orderByDesc('jobs_count')
            ->get(['id', 'name']);
    }

    public function getApplicationsCountByCategory()
    {
        return Category::withCount('applications')
            ->having('applications_count', '>', 0)
            ->orderByDesc('applications_count')
            ->get(['id', 'name']);
    }

    public function getApplicationsByMonth(): array
    {
        $data = Application::selectRaw('MONTH(applied_at) as month, YEAR(applied_at) as year, COUNT(*) as total')
            ->whereNotNull('applied_at')
            ->where('applied_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $labels = [];
        $totals = [];

        foreach ($data as $row) {
            $labels[] = "Tháng {$row->month}/{$row->year}";
            $totals[] = $row->total;
        }

        return [
            'labels' => $labels,
            'data'   => $totals,
        ];
    }

    public function getCVTemplatesUsage(): array
    {
        $templates = CVTemplate::withCount('cvs')
            ->having('cvs_count', '>', 0)
            ->orderByDesc('cvs_count')
            ->get();

        return [
            'labels' => $templates->pluck('name'),
            'data'   => $templates->pluck('cvs_count'),
        ];
    }

    public function getTopCompaniesByJobs(int $limit = 10): array
    {
        $companies = Company::withCount('jobs')
            ->having('jobs_count', '>', 0)
            ->orderByDesc('jobs_count')
            ->limit($limit)
            ->get(['id', 'name']);

        return [
            'labels' => $companies->pluck('name'),
            'data'   => $companies->pluck('jobs_count'),
        ];
    }
}