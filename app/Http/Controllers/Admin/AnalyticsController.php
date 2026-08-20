<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AnalyticsController extends Controller
{
    protected AnalyticsService $analyticsService;

    public function __construct(AnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    public function index(): View
    {
        $stats = $this->analyticsService->getOverviewStats();

        return view('admin.analytics.index', compact('stats'));
    }

    public function chartData(): JsonResponse
    {
        $data = $this->analyticsService->getCategoryChartsData();

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    public function applicationsOverTime(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $this->analyticsService->getAdvancedChartsData()['applications_over_time']
        ]);
    }

    public function cvTemplatesUsage(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $this->analyticsService->getAdvancedChartsData()['cv_templates_usage']
        ]);
    }

    public function companyJobs(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $this->analyticsService->getAdvancedChartsData()['top_companies_jobs']
        ]);
    }
}