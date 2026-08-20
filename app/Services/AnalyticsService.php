<?php

namespace App\Services;

use App\Repositories\AnalyticsRepository;

class AnalyticsService
{
    protected AnalyticsRepository $analyticsRepository;

    public function __construct(AnalyticsRepository $analyticsRepository)
    {
        $this->analyticsRepository = $analyticsRepository;
    }

    public function getOverviewStats(): array
    {
        return [
            'total_students'     => $this->analyticsRepository->countStudents(),
            'total_employers'    => $this->analyticsRepository->countEmployers(),
            'total_jobs'         => $this->analyticsRepository->countJobs(),
            'active_jobs'        => $this->analyticsRepository->countActiveJobs(),
            'total_applications' => $this->analyticsRepository->countApplications(),
            'total_bookmarks'    => $this->analyticsRepository->countBookmarks(),
            'total_cvs'          => $this->analyticsRepository->countCVs(),
            'closed_jobs'        => $this->analyticsRepository->countClosedJobs(),
        ];
    }

    public function getCategoryChartsData(): array
    {
        $jobsByCategory = $this->analyticsRepository->getJobsCountByCategory();
        $appsByCategory = $this->analyticsRepository->getApplicationsCountByCategory();

        return [
            'jobs_by_category' => [
                'labels' => $jobsByCategory->pluck('name'),
                'data'   => $jobsByCategory->pluck('jobs_count'),
            ],
            'applications_by_category' => [
                'labels' => $appsByCategory->pluck('name'),
                'data'   => $appsByCategory->pluck('applications_count'),
            ]
        ];
    }

    public function getAdvancedChartsData(): array
    {
        return [
            'applications_over_time' => $this->analyticsRepository->getApplicationsByMonth(),
            'cv_templates_usage'     => $this->analyticsRepository->getCVTemplatesUsage(),
            'top_companies_jobs'     => $this->analyticsRepository->getTopCompaniesByJobs(10),
        ];
    }
}