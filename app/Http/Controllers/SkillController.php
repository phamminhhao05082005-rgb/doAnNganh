<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\SkillRequest;
use App\Http\Resources\SkillResource;
use App\Interfaces\SkillServiceInterface;

class SkillController extends Controller
{
    public function __construct(
        private SkillServiceInterface $skillService
    ) {}

    public function index()
    {
        return SkillResource::collection(
            $this->skillService->getAll()
        );
    }

    public function store(SkillRequest $request)
    {
        $skill = $this->skillService->create($request->validated());
        return new SkillResource($skill);
    }

    public function update(SkillRequest $request, $id)
    {
        $skill = $this->skillService->update($id, $request->validated());
        return new SkillResource($skill);
    }

    public function destroy($id)
    {
        $this->skillService->delete($id);
        return response()->json(['message' => 'Xoá kỹ năng thành công']);
    }
}