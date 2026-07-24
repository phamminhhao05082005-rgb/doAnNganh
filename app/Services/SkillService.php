<?php

namespace App\Services;

use App\Interfaces\SkillRepositoryInterface;
use App\Interfaces\SkillServiceInterface;

class SkillService implements SkillServiceInterface
{
    public function __construct(
        private SkillRepositoryInterface $skillRepository
    ) {}

    public function getAll()
    {
        return $this->skillRepository->getAll();
    }
}