<?php

namespace App\Http\Controllers;

use App\Models\CV;
use App\Models\CVEducation;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CVEducationResource;
use App\Http\Requests\StoreCVEducationRequest;
use App\Http\Requests\UpdateCVEducationRequest;
use App\Interfaces\CVEducationServiceInterface;

class CVEducationController extends Controller
{
    protected CVEducationServiceInterface $service;

    public function __construct(
        CVEducationServiceInterface $service
    ) {
        $this->service = $service;
    }

    public function index(CV $cv)
    {
        return CVEducationResource::collection(
            $this->service->getAll($cv)
        );
    }

    public function store(StoreCVEducationRequest $request, CV $cv)
    {
        return new CVEducationResource(
            $this->service->create($cv, $request->validated()));
    }

    public function update(UpdateCVEducationRequest $request, CV $cv, CVEducation $education)
    {
        if ($education->cv_id != $cv->id) {
            abort(404);
        }

        return new CVEducationResource(
            $this->service->update($education, $request->validated()));
    }

    public function destroy(CV $cv, CVEducation $education): JsonResponse
    {
        if ($education->cv_id != $cv->id) {
            abort(404);
        }

        $this->service->delete($education);

        return response()->json(["message" => "Xoá thành công"]);
    }
}