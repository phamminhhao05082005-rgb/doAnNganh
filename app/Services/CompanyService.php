<?php

namespace App\Services;

use App\Interfaces\CompanyRepositoryInterface;
use App\Interfaces\CompanyServiceInterface;
use App\Models\Company;
use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyService implements CompanyServiceInterface
{
    public function __construct(
        private CompanyRepositoryInterface  $companyRepository
    ) {}

    public function getAll()
    {
        return $this->companyRepository->getAll();
    }

    public function getById(int $id): Company
    {
        $company = $this->companyRepository->findById($id);

        if (!$company) {
            throw new Exception("Company not found.");
        }

        if ($company->trashed()) {

            $user = Auth::user();

            $isAdmin = $user?->role->name === 'ADMIN';

            $isOwner = $user && $company->user_id === $user->id;

            if (! $isAdmin && ! $isOwner) {
                throw new NotFoundHttpException();
            }
        }

        return $company;
    }

    public function create(array $data): Company
    {
        $role = Role::where('name', 'EMPLOYER')->first();

        if (!$role) {
            throw new Exception("Employer role not found.");
        }

        $userData = [

            'role_id' => $role->id,

            'full_name' => $data['full_name'],

            'email' => $data['email'],

            'password' => bcrypt($data['password']),

            'phone' => $data['phone'] ?? null,

            'status' => true,

            'provider' => 'LOCAL',

        ];

        $companyData = [

            'name' => $data['name'],

            'website' => $data['website'] ?? null,

            'address' => $data['address'] ?? null,

            'description' => $data['description'] ?? null,

            'logo' => $data['logo'] ?? null,

        ];

        return $this->companyRepository
            ->create($userData, $companyData);
    }

    public function update(
        Company $company,
        array $data
    ): Company {

        $userData = [

            'full_name' => $data['full_name'],

            'email' => $data['email'],

            'phone' => $data['phone'] ?? null,

        ];

        $companyData = [

            'name' => $data['name'],

            'website' => $data['website'] ?? null,

            'address' => $data['address'] ?? null,

            'description' => $data['description'] ?? null,

            'logo' => $data['logo'] ?? null,

        ];

        return $this->companyRepository
            ->update(
                $company,
                $userData,
                $companyData
            );
    }

    public function delete(Company $company): void
    {
        $this->companyRepository->delete($company);
    }

    public function restore(int $id): void
    {
        $company = $this->companyRepository
            ->findByIdWithTrashed($id);

        if (!$company) {
            throw new Exception("Company not found.");
        }

        $this->companyRepository->restore($id);
    }

    public function getMyCompany(): Company
    {
        $company = $this->companyRepository
            ->findByOwnerId(Auth::id());

        if (!$company) {
            throw new Exception("Company not found.");
        }

        return $company;
    }

    public function updateMyCompany(array $data): Company
    {
        $company = $this->companyRepository
            ->findByOwnerId(Auth::id());

        if (!$company) {
            throw new Exception("Company not found.");
        }

        $userData = [

            'full_name' => $data['full_name'],

            'phone' => $data['phone'] ?? null,

        ];

        $companyData = [

            'name' => $data['name'],

            'website' => $data['website'] ?? null,

            'address' => $data['address'] ?? null,

            'description' => $data['description'] ?? null,

            'logo' => $data['logo'] ?? null,

        ];

        return $this->companyRepository
            ->update(
                $company,
                $userData,
                $companyData
            );
    }
}
