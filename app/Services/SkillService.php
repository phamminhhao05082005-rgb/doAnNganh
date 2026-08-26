<?php

namespace App\Services;

use App\Interfaces\SkillRepositoryInterface;
use App\Interfaces\SkillServiceInterface;

class SkillService implements SkillServiceInterface
{
    public function __construct(
        private SkillRepositoryInterface $skillRepository
    ) {}

    public function getAll(array $filters = [])
    {
        return $this->skillRepository->getAll($filters);
    }

    public function findById($id)
    {
        return $this->skillRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->skillRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->skillRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->skillRepository->delete($id);
    }
}
