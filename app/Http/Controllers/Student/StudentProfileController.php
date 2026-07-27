<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\UpdateStudentProfileRequest;
use App\Http\Resources\Student\StudentProfileResource;
use App\Interfaces\StudentProfileServiceInterface;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    protected StudentProfileServiceInterface $service;

    public function __construct(
        StudentProfileServiceInterface $service
    ) {
        $this->service = $service;
    }

    public function show(Request $request): StudentProfileResource
    {
        return new StudentProfileResource(
            $this->service->getProfile($request->user())
        );
    }

    public function update(UpdateStudentProfileRequest $request)
    {
        return response()->json([
            'message' => 'Cập nhật hồ sơ thành công.',
            'data' => new StudentProfileResource(
                $this->service->update(
                    $request->user(),
                    $request->validated()
                )
            )
        ]);
    }
}