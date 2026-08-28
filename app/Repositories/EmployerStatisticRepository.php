<?php

namespace App\Repositories;

use App\Models\Job;
use App\Models\Application;
use App\Interfaces\EmployerStatisticRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EmployerStatisticRepository implements EmployerStatisticRepositoryInterface
{

    public function getJobsCountPerMonth(int $companyId, int $year)
    {
        return Job::where('company_id', $companyId)
            ->whereYear('created_at', $year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(id) as total_jobs')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public function getApplicationsCountPerMonth(int $companyId, int $year)
    {
        return Application::whereHas('job', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->whereYear('applied_at', $year)
            ->select(
                DB::raw('MONTH(applied_at) as month'),
                DB::raw('COUNT(id) as total_applications')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public function getJobsByCategory(int $companyId)
    {
        return Job::where('company_id', $companyId)
            ->select('category_id', DB::raw('COUNT(id) as total'))
            ->with('category:id,name') 
            ->groupBy('category_id')
            ->get();
    }
}