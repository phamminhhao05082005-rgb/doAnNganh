<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SkillRequest;
use App\Interfaces\SkillServiceInterface;

class AdminSkillController extends Controller
{
    public function __construct(private SkillServiceInterface $skillService) {}

    public function index()
    {
        $skills = $this->skillService->getAll();
        return view('admin.skills.index', compact('skills'));
    }

    public function store(SkillRequest $request)
    {
        $this->skillService->create($request->validated());
        return redirect()->back()->with('success', 'Thêm kỹ năng thành công!');
    }

    public function update(SkillRequest $request, $id)
    {
        $this->skillService->update($id, $request->validated());
        return redirect()->back()->with('success', 'Cập nhật kỹ năng thành công!');
    }

    public function destroy($id)
    {
        $this->skillService->delete($id);
        return redirect()->back()->with('success', 'Xoá kỹ năng thành công!');
    }
}