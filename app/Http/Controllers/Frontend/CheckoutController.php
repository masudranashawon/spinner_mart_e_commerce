<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)

    {
        $couponId = $request->coupon_id;

        $user = auth('web')->user();

        /** @var \App\Models\User $user */
        $cartItems = $user?->cartItems()?->latest()?->get();

        return view('frontend.checkout.index', compact('couponId', 'user', 'cartItems'));
    }
}
