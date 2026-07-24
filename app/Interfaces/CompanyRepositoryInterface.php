<?php

namespace App\Interfaces;

use App\Models\Company;

interface CompanyRepositoryInterface
{
    public function getAll();

    public function findById(int $id): ?Company;

    public function create(array $userData, array $companyData): Company;

    public function update(Company $company, array $userData, array $companyData): Company;

    public function delete(Company $company): void;

    public function restore(int $id): void;

    public function findByIdWithTrashed(int $id): ?Company;

    public function findByOwnerId(int $ownerId): ?Company;
}