<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreReviewRequest;
use App\Http\Requests\Student\UpdateReviewRequest;
use App\Http\Resources\Student\ReviewResource;
use App\Interfaces\ReviewServiceInterface;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewServiceInterface $reviewService
    ) {}

    public function index(int $companyId): JsonResponse
    {
        $reviews = $this->reviewService->getCompanyReviews($companyId);
        return ReviewResource::collection($reviews)->response();
    }

    public function store(StoreReviewRequest $request): JsonResponse
    {
        $review = $this->reviewService->createReview(
            $request->user()->id,
            $request->validated()
        );

        return response()->json([
            'message' => 'Đánh giá đã được tạo thành công.',
            'data'    => new ReviewResource($review->load('user'))
        ], 201);
    }

    public function update(UpdateReviewRequest $request, int $id): JsonResponse
    {
        $review = $this->reviewService->updateReview(
            $id,
            $request->user()->id,
            $request->validated()
        );

        return response()->json([
            'message' => 'Đánh giá đã được cập nhật.',
            'data'    => new ReviewResource($review->load('user'))
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->reviewService->deleteReview($id, auth()->id());

        return response()->json([
            'message' => 'Đánh giá đã được xóa thành công.'
        ]);
    }
}