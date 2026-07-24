<?php

namespace App\Interfaces;

use App\Models\Company;

interface CompanyServiceInterface
{
    public function getAll();

    public function getById(int $id): Company;

    public function create(array $data): Company;

    public function update(Company $company, array $data): Company;

    public function delete(Company $company): void;

    public function restore(int $id): void;

    public function getMyCompany(): Company;

    public function updateMyCompany(array $data): Company;
}