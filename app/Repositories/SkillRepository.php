<?php

namespace App\Repositories;

use App\Interfaces\SkillRepositoryInterface;
use App\Models\Skill;

class SkillRepository implements SkillRepositoryInterface
{
    public function getAll()
    {
        return Skill::orderBy('name')->get();
    }
}