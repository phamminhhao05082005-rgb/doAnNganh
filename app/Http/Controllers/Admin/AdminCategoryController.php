<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Interfaces\CategoryServiceInterface;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function __construct(private CategoryServiceInterface $categoryService) {}

    public function index(Request $request)
    {
        $categories = $this->categoryService->getAll($request->all());

        return view('admin.categories.index', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryService->create($request->validated());
        return redirect()->back()->with('success', 'Thêm danh mục thành công!');
    }

    public function update(CategoryRequest $request, $id)
    {
        $this->categoryService->update($id, $request->validated());
        return redirect()->back()->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $this->categoryService->delete($id);
        return redirect()->back()->with('success', 'Xoá danh mục thành công!');
    }
}
