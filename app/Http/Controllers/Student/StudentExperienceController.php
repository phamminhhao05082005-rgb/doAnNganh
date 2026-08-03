<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreExperienceRequest;
use App\Http\Requests\Student\UpdateExperienceRequest;
use App\Http\Resources\Student\StudentExperienceResource;
use App\Models\Experience;
use App\Interfaces\StudentExperienceServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StudentExperienceController extends Controller
{
    protected StudentExperienceServiceInterface $service;

    public function __construct(
        StudentExperienceServiceInterface $service
    ) {
        $this->service = $service;
    }

    public function index(Request $request): AnonymousResourceCollection {

        return StudentExperienceResource::collection(
            $this->service->getAll($request->user()));
    }

    public function store(StoreExperienceRequest $request) {

        return response()->json([
            'message' => 'Thêm kinh nghiệm thành công.',
            'data' => new StudentExperienceResource(
                $this->service->create($request->user(), $request->validated()))], 201);
    }

    public function update(
        UpdateExperienceRequest $request,
        Experience $experience
    ) {

        return response()->json([
            'message' => 'Cập nhật kinh nghiệm thành công.',
            'data' => new StudentExperienceResource(
                $this->service->update($request->user(), $experience, $request->validated()))]);
    }

    public function destroy(Request $request, Experience $experience) {

        $this->service->delete($request->user(), $experience);
        return response()->json(['message' => 'Xóa kinh nghiệm thành công.']);
    }
}