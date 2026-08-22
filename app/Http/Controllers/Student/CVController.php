<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CVRequest;
use App\Http\Requests\StoreCVRequest;
use App\Http\Requests\UpdateCVRequest;
use App\Http\Resources\CVResource;
use App\Interfaces\CVServiceInterface;

class CVController extends Controller
{
    protected CVServiceInterface $service;

    public function __construct(CVServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return CVResource::collection(
            $this->service->getMyCVs($request->user())
        );
    }

    public function show(int $id)
    {
        return new CVResource($this->service->findById($id));
    }

    public function store(StoreCVRequest $request)
    {
        return new CVResource(
            $this->service->create($request->user(), $request->validated())
        );
    }

    public function update(UpdateCVRequest $request, int $id)
    {
        return new CVResource(
            $this->service->update($request->user(), $id, $request->validated())
        );
    }

    public function destroy(Request $request, int $id)
    {
        $this->service->delete($request->user(), $id);
        return response()->json(['message' => 'Đã xóa CV']);
    }
}
