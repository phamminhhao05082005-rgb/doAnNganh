<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCompanyRequest;
use App\Http\Requests\Admin\UpdateCompanyRequest;
use App\Models\Company;
use App\Interfaces\CompanyServiceInterface;

class AdminCompanyController extends Controller
{
    public function __construct(
        private CompanyServiceInterface $companyService
    ) {}

    public function index()
    {
        $companies = $this->companyService->getAll();

        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(CreateCompanyRequest $request)
    {
        $this->companyService->create($request->validated());

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Thêm doanh nghiệp thành công');
    }

    public function show($id)
    {
        $company = $this->companyService->getById($id);

        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit',compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company) {

        $this->companyService->update($company, $request->validated());

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Cập nhật thành công');
    }

    public function destroy(Company $company)
    {
        $this->companyService->delete($company);

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Xóa thành công');
    }

    public function restore(int $id)
    {
        $this->companyService->restore($id);

        return redirect()
            ->route('admin.companies.index')
            ->with('success', 'Khôi phục doanh nghiệp thành công.');
    }
}
