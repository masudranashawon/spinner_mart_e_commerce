<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)

    {
        $couponId = session('coupon_id');

        $user = auth('web')->user();

        /** @var \App\Models\User $user */
        $cartItems = $user?->cartItems()?->latest()?->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $coupon = Coupon::find($couponId);
        $discountAmount = 0;

        if ($coupon && $coupon->status) {
            // Calculate actual subtotal from DB (Price * Quantity)
            if ($coupon->min_amount <= 0 || $subtotal >= $coupon->min_amount) {
                if ($coupon->coupon_type === 'percentage') {
                    $discountAmount = ($subtotal * $coupon->discount) / 100;
                } else {
                    $discountAmount = $coupon->discount;
                }
            } else {
               // If user reduces quantity and subtotal drops below coupon minimum
                session()->forget('coupon_id');
                $coupon = null;
            }
        }

        return view('frontend.checkout.index', compact('coupon', 'user', 'cartItems', 'subtotal', 'discountAmount'));
    }
}
