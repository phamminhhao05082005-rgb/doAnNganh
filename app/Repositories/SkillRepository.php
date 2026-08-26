<?php

namespace App\Repositories;

use App\Interfaces\SkillRepositoryInterface;
use App\Models\Skill;

class SkillRepository implements SkillRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        $query = Skill::query();
        if (!empty($filters['keyword'])) {
            $query->where('name', 'like', "%" . $filters['keyword'] . "%");
        }
        return $query->orderBy('name')->paginate(10);
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
