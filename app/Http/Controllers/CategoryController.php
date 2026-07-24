<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Interfaces\CategoryServiceInterface;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryServiceInterface $categoryService
    ) {}

    public function index()
    {
        return CategoryResource::collection(
            $this->categoryService->getAll()
        );
    }
}