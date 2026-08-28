<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Company;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        
        $companies = Company::orderBy('name')->get();
        $query = Review::with(['user', 'company'])->latest();

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $reviews = $query->paginate(15);
        return view('admin.reviews.index', compact('reviews', 'companies'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Đã xoá đánh giá không hợp lệ thành công.');
    }
}