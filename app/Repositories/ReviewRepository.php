<?php

namespace App\Repositories;

use App\Interfaces\ReviewRepositoryInterface;
use App\Models\Application;
use App\Models\Review;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function getByCompanyId(int $companyId, int $perPage = 15): LengthAwarePaginator
    {
        return Review::with('user')
            ->where('company_id', $companyId)
            ->latest()
            ->paginate($perPage);
    }

    public function findById(int $id): ?Review
    {
        return Review::find($id);
    }

    public function findByUserAndCompany(int $userId, int $companyId): ?Review
    {
        return Review::where('user_id', $userId)
            ->where('company_id', $companyId)
            ->first();
    }

    public function create(array $data): Review
    {
        return Review::create($data);
    }

    public function update(Review $review, array $data): Review
    {
        $review->update($data);
        return $review;
    }

    public function delete(Review $review): bool
    {
        return $review->delete();
    }

    public function hasUserAppliedToCompany(int $userId, int $companyId): bool
    {
        return Application::whereHas('cv', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->whereHas('job', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->exists();
    }
}
