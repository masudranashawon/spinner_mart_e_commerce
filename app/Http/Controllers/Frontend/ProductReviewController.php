<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\OrderStatusEnums;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $user = auth('web')->user();

        // Check if user has purchased the product
        $hasPurchased = Order::where('user_id', $user->id)
            ->whereIn('order_status', [
                OrderStatusEnums::DELIVERED->value,
                OrderStatusEnums::RETURN_REQUESTED->value,
                OrderStatusEnums::RETURNED->value
            ])
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'You can only review products you have received.');
        }

        // Check if user has already reviewed the product
        $alreadyReviewed = ProductReview::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'You have already reviewed this product.');
        }


        ProductReview::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'rating' => $request->rating,
            'review' => $request->review,
            'is_approved' => true,
        ]);

        // Update product's average rating and total reviews
        $avgRating = $product->productReviews()->where('is_approved', true)->avg('rating');
        $totalReviews = $product->productReviews()->where('is_approved', true)->count();

        $product->update([
            'rating' => round($avgRating),
            'reviews' => $totalReviews
        ]);

        return back()->with('success', 'Thank you! Your review has been submitted successfully.');
    }
}
