<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index()
    {
        // Fetch all reviews with related product and user information, ordered by latest
        $reviews = ProductReview::with(['product', 'user'])
            ->latest()
            ->paginate(10);

        return view('admin.review.index', compact('reviews'));
    }

    public function toggleStatus(ProductReview $review)
    {
        // Toggle the approval status of the review
        $review->update([
            'is_approved' => !$review->is_approved
        ]);

        $this->updateProductRating($review->product);

        return back()->with('success', 'Review status updated successfully.');
    }

    public function destroy(ProductReview $review)
    {
        $product = $review->product;
        
        $review->delete();

        $this->updateProductRating($product);

        return back()->with('success', 'Review deleted successfully.');
    }

    /**
     * Update the product's average rating and total reviews based on approved reviews.
     */
    private function updateProductRating($product)
    {
        $avgRating = $product->productReviews()->where('is_approved', true)->avg('rating') ?? 0;
        $totalReviews = $product->productReviews()->where('is_approved', true)->count();

        $product->update([
            'rating' => round($avgRating),
            'reviews' => $totalReviews
        ]);
    }
}