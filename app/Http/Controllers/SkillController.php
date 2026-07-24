<?php

namespace App\Http\Controllers;

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
}