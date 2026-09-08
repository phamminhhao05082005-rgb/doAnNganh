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

    public function getApplicationsByMonth(): array
    {
        $year = now()->year;
        $data = Application::selectRaw('MONTH(applied_at) as month, COUNT(*) as total')
            ->whereNotNull('applied_at')
            ->whereYear('applied_at', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $labels = [];
        $totals = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = "Tháng $i";
            $totals[] = $data[$i] ?? 0;
        }

        return [
            'labels' => $labels,
            'data'   => $totals,
        ];
    }

    public function getJobsByMonth(): array
    {
        $year = now()->year;
        $data = Job::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $labels = [];
        $totals = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = "Tháng $i";
            $totals[] = $data[$i] ?? 0;
        }

        return [
            'labels' => $labels,
            'data'   => $totals,
        ];
    }
}
