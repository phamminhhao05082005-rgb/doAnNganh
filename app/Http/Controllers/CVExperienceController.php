<?php

namespace App\Http\Controllers;

use App\Models\CV;
use App\Models\CVExperience;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CVExperienceResource;
use App\Http\Requests\StoreCVExperienceRequest;
use App\Http\Requests\UpdateCVExperienceRequest;
use App\Interfaces\CVExperienceServiceInterface;

class CVExperienceController extends Controller
{
    protected CVExperienceServiceInterface $service;

    public function __construct(
        CVExperienceServiceInterface $service
    ){
        $this->service=$service;
    }

    public function index(CV $cv)
    {
        return CVExperienceResource::collection(
            $this->service->getAll($cv)
        );
    }

    public function store(
        StoreCVExperienceRequest $request,
        CV $cv
    ){
        return new CVExperienceResource(

            $this->service->create(
                $cv,
                $request->validated()
            )

        );
    }

    public function update(
        UpdateCVExperienceRequest $request,
        CV $cv,
        CVExperience $experience
    ){
        if($experience->cv_id!=$cv->id)
            abort(404);

        return new CVExperienceResource(

            $this->service->update(
                $experience,
                $request->validated()
            )

        );
    }

    public function destroy(
        CV $cv,
        CVExperience $experience
    ):JsonResponse{

        if($experience->cv_id!=$cv->id)
            abort(404);

        $this->service->delete(
            $experience
        );

        return response()->json([
            "message"=>"Deleted"
        ]);
    }
}