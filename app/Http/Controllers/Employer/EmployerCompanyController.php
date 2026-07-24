<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\UpdateMyCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Interfaces\CompanyServiceInterface;

class EmployerCompanyController extends Controller
{
    public function __construct(
        private CompanyServiceInterface $companyService
    ) {}

    public function show()
    {
        return new CompanyResource(
            $this->companyService->getMyCompany()
        );
    }

    public function update(UpdateMyCompanyRequest $request)
    {
        return new CompanyResource(
            $this->companyService->updateMyCompany(
                $request->validated()
            )
        );
    }
}