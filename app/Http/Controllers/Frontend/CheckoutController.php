<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)

    {
         $couponId = $request->coupon_id;

        return view('frontend.checkout.index', compact('couponId'));
    }
}
