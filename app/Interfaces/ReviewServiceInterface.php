<?php

namespace App\Interfaces;

use App\Models\Review;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReviewServiceInterface
{
    public function getCompanyReviews(int $companyId, int $perPage = 15): LengthAwarePaginator;
    public function createReview(int $userId, array $data): Review;
    public function updateReview(int $reviewId, int $userId, array $data): Review;
    public function deleteReview(int $reviewId, int $userId): bool;
}