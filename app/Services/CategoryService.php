<?php

namespace App\Services;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {}

    public function getAll()
    {
        return $this->categoryRepository->getAll();
    }
}