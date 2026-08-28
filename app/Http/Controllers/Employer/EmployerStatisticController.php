<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\EmployerStatisticServiceInterface;
use App\Http\Resources\EmployerStatisticResource;

class EmployerStatisticController extends Controller
{
    protected $statisticService;

    public function __construct(EmployerStatisticServiceInterface $statisticService)
    {
        $this->statisticService = $statisticService;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        
        if (!$user->company) {
            return response()->json([
                'success' => false,
                'message' => 'Tài khoản của bạn chưa được liên kết với công ty nào.'
            ], 403);
        }

        $year = $request->input('year', date('Y'));
        
        $statisticsData = $this->statisticService->getDashboardStatistics($user->company->id, $year);

        return new EmployerStatisticResource($statisticsData);
    }
}