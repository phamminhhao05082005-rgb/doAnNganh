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

    public function findById($id)
    {
        return Skill::findOrFail($id);
    }

    public function create(array $data)
    {
        return Skill::create($data);
    }

    public function update($id, array $data)
    {
        $skill = $this->findById($id);
        $skill->update($data);
        return $skill;
    }

    public function delete($id)
    {
        $skill = $this->findById($id);
        return $skill->delete();
    }
}
