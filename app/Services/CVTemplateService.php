<?php

namespace App\Services;

use App\Models\CVTemplate;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\CVTemplateRepositoryInterface;
use App\Interfaces\CVTemplateServiceInterface;

class CVTemplateService implements CVTemplateServiceInterface
{

    public function __construct(
        private CVTemplateRepositoryInterface $repository
    )
    {
        
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function findById(int $id): CVTemplate
    {
        return $this->repository->findById($id);
    }
}