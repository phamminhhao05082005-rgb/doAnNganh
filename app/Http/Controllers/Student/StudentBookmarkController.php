<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\StudentBookmarkResource;
use App\Interfaces\StudentBookmarkServiceInterface;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StudentBookmarkController extends Controller
{
    protected StudentBookmarkServiceInterface $service;

    public function __construct(
        StudentBookmarkServiceInterface $service
    ) {
        $this->service = $service;
    }

    public function index(Request $request): AnonymousResourceCollection {

        return StudentBookmarkResource::collection(
            $this->service->getAll($request->user()));
    }

    public function store(Request $request, Job $job) {

        $this->service->bookmark($request->user(), $job);
        return response()->json(['message' => 'Lưu việc làm thành công.']);
    }

    public function destroy(Request $request, Job $job) {

        $this->service->unBookmark($request->user(), $job);
        return response()->json(['message' => 'Đã bỏ lưu việc làm.']);
    }
}