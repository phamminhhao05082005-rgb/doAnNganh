<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        $query = Category::query();
        if (!empty($filters['keyword'])) {
            $query->where('name', 'like', "%" . $filters['keyword'] . "%");
        }
        return $query->orderBy('name')->paginate(10);
    }

    public function findById($id)
    {
        return Category::findOrFail($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($id, array $data)
    {
        $category = $this->findById($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->findById($id);
        return $category->delete();
    }
}
