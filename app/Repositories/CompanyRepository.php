<?php

namespace App\Repositories;

use App\Interfaces\CompanyRepositoryInterface;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function getAll()
    {
        return Company::withTrashed()
            ->with('owner')
            ->orderByDesc('id')
            ->get();
    }

    public function findById(int $id): ?Company
    {
        return Company::withTrashed()->with('owner')->find($id);
    }

    public function create(array $userData, array $companyData): Company
    {
        return DB::transaction(function () use ($userData, $companyData) {

            $user = User::create($userData);
            $companyData['owner_id'] = $user->id;
            $company = Company::create($companyData);
            return $company->load('owner');
        });
    }

    public function update(
        Company $company,
        array $userData,
        array $companyData
    ): Company {

        return DB::transaction(function () use (
            $company,
            $userData,
            $companyData
        ) {

            $company->owner()->update($userData);
            $company->update($companyData);
            return $company->fresh()->load('owner');
        });
    }

    public function delete(Company $company): void
    {
        DB::transaction(function () use ($company) {

            $company->owner->update(['status' => false,]);
            $company->delete();
        });
    }

    public function findByIdWithTrashed(int $id): ?Company
    {
        return Company::withTrashed()->with('owner')->find($id);
    }

    public function restore(int $id): void
    {
        DB::transaction(function () use ($id) {

            $company = Company::withTrashed()->findOrFail($id);
            $company->restore();
            $company->owner->update(['status' => true,]);
        });
    }

    public function findByOwnerId(int $ownerId): ?Company
    {
        return Company::withTrashed()
            ->with('owner')
            ->where('owner_id', $ownerId)
            ->first();
    }
}
