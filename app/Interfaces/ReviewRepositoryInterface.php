<?php

namespace App\Interfaces;

use App\Models\Review;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReviewRepositoryInterface
{
    public function getByCompanyId(int $companyId, int $perPage = 15): LengthAwarePaginator;
    public function findById(int $id): ?Review;
    public function findByUserAndCompany(int $userId, int $companyId): ?Review;
    public function create(array $data): Review;
    public function update(Review $review, array $data): Review;
    public function delete(Review $review): bool;
    public function hasUserAppliedToCompany(int $userId, int $companyId): bool;
}