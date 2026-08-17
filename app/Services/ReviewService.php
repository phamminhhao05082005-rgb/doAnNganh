<?php

namespace App\Services;

use App\Interfaces\ReviewRepositoryInterface;
use App\Interfaces\ReviewServiceInterface;
use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class ReviewService implements ReviewServiceInterface
{
    public function __construct(
        protected ReviewRepositoryInterface $reviewRepository
    ) {}

    public function getCompanyReviews(int $companyId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->reviewRepository->getByCompanyId($companyId, $perPage);
    }

    public function createReview(int $userId, array $data): Review
    {
        $user = User::with('role')->findOrFail($userId);

        if ($user->role?->name !== 'STUDENT') {
            throw new AuthorizationException("Chỉ tài khoản Sinh viên (Student) mới có quyền đánh giá công ty.");
        }

        $hasApplied = $this->reviewRepository->hasUserAppliedToCompany($userId, $data['company_id']);
        if (!$hasApplied) {
            throw new AuthorizationException("Bạn chỉ có thể đánh giá công ty mà bạn đã từng ứng tuyển.");
        }

        $existing = $this->reviewRepository->findByUserAndCompany($userId, $data['company_id']);
        if ($existing) {
            throw new Exception("Bạn đã đánh giá công ty này rồi.", 422);
        }

        $data['user_id'] = $userId;
        return $this->reviewRepository->create($data);
    }

    public function updateReview(int $reviewId, int $userId, array $data): Review
    {
        $review = $this->reviewRepository->findById($reviewId);

        if (!$review) {
            throw new ModelNotFoundException("Không tìm thấy đánh giá.");
        }

        if ($review->user_id !== $userId) {
            throw new AuthorizationException("Bạn không có quyền sửa đánh giá này.");
        }

        return $this->reviewRepository->update($review, $data);
    }

    public function deleteReview(int $reviewId, int $userId): bool
    {
        $review = $this->reviewRepository->findById($reviewId);

        if (!$review) {
            throw new ModelNotFoundException("Không tìm thấy đánh giá.");
        }

        if ($review->user_id !== $userId) {
            throw new AuthorizationException("Bạn không có quyền xóa đánh giá này.");
        }

        return $this->reviewRepository->delete($review);
    }
}