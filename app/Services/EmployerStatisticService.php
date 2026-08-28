<?php

namespace App\Services;

use App\Interfaces\EmployerStatisticRepositoryInterface;
use App\Interfaces\EmployerStatisticServiceInterface;

class EmployerStatisticService implements EmployerStatisticServiceInterface
{
    protected $statisticRepository;

    public function __construct(EmployerStatisticRepositoryInterface $statisticRepository)
    {
        $this->statisticRepository = $statisticRepository;
    }

    public function getDashboardStatistics(int $companyId, int $year)
    {
        $jobsPerMonthRaw = $this->statisticRepository->getJobsCountPerMonth($companyId, $year);
        $appsPerMonthRaw = $this->statisticRepository->getApplicationsCountPerMonth($companyId, $year);
        $jobsByCategoryRaw = $this->statisticRepository->getJobsByCategory($companyId);

        $monthlyJobs = array_fill(1, 12, 0);
        $monthlyApps = array_fill(1, 12, 0);

        foreach ($jobsPerMonthRaw as $item) {
            $monthlyJobs[$item->month] = $item->total_jobs;
        }

        foreach ($appsPerMonthRaw as $item) {
            $monthlyApps[$item->month] = $item->total_applications;
        }

        $pieChartLabels = [];
        $pieChartSeries = [];

        foreach ($jobsByCategoryRaw as $item) {
            $pieChartLabels[] = $item->category ? $item->category->name : 'Khác';
            $pieChartSeries[] = $item->total;
        }

        return [
            'year' => $year,
            'line_chart' => [
                'months' => ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                'jobs_posted' => array_values($monthlyJobs),
                'cvs_applied' => array_values($monthlyApps),
            ],
            'pie_chart_categories' => [
                'labels' => $pieChartLabels,
                'series' => $pieChartSeries,
            ],
            'summary' => [
                'total_jobs_this_year' => array_sum($monthlyJobs),
                'total_cvs_this_year' => array_sum($monthlyApps),
            ]
        ];
    }
}