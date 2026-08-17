<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\JobServiceInterface;
use Illuminate\Http\Request;

class AdminJobController extends Controller
{
    public function __construct(
        private JobServiceInterface $jobService
    ) {}

    public function index(Request $request)
    {
        
        $jobs = $this->jobService->getAllJobs($request->all());
        
        return view('admin.jobs.index', compact('jobs'));
    }

    public function show(int $id)
    {
        
        $job = $this->jobService->getJobDetail($id);

        return view('admin.jobs.show', compact('job'));
    }

    public function toggleStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|boolean'
        ]);

        $this->jobService->toggleStatus($id, $request->status);

        $message = $request->status ? 'Đã mở lại tin tuyển dụng!' : 'Đã tạm đóng tin tuyển dụng!';

        return redirect()->back()->with('success', $message);
    }
}