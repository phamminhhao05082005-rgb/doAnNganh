<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreEducationRequest;
use App\Http\Requests\Student\UpdateEducationRequest;
use App\Http\Resources\Student\StudentEducationResource;
use App\Models\Education;
use App\Interfaces\StudentEducationServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StudentEducationController extends Controller
{
    protected StudentEducationServiceInterface $service;

    public function __construct(
        StudentEducationServiceInterface $service
    ) {
        $this->service = $service;
    }

    /**
     * Danh sách học vấn của sinh viên
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return StudentEducationResource::collection(
            $this->service->getAll($request->user())
        );
    }

    /**
     * Thêm học vấn
     */
    public function store(StoreEducationRequest $request): StudentEducationResource
    {
        return new StudentEducationResource(
            $this->service->create(
                $request->user(),
                $request->validated()
            )
        );
    }

    /**
     * Cập nhật học vấn
     */
    public function update(
        UpdateEducationRequest $request,
        Education $education
    ): StudentEducationResource {

        return new StudentEducationResource(
            $this->service->update(
                $request->user(),
                $education,
                $request->validated()
            )
        );
    }

    /**
     * Xóa học vấn
     */
    public function destroy(
        Request $request,
        Education $education
    ) {
        $this->service->delete(
            $request->user(),
            $education
        );

        return response()->json([
            'message' => 'Xóa học vấn thành công.'
        ]);
    }
}