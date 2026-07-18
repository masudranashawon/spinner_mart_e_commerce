<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CouponTypeEnums;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Repositories\CouponRepository;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        $couponTypes = CouponTypeEnums::cases();

        return view("admin.coupon.index", compact('coupons', 'couponTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'couponCode' => 'required|unique:coupons,coupon_code',
            'type' => 'required',
            'discount' => 'required',
            'startDate' => 'required|date|after_or_equal:today',
            'expiryDate' => 'required|date|after:startDate',
        ]);

        CouponRepository::storeByRequest($request);

        return back()->withSuccess('Coupon created successfully');
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'editCouponType' => 'required',
            'editDiscount' => 'required',
            'editStartDate' => 'required|date|after_or_equal:today',
            'editExpiryDate' => 'required|date|after:editStartDate',
            'editStatus' => 'required|in:0,1',
        ]);

        CouponRepository::updateByRequest($coupon, $request);

        return back()->with('success', 'Coupon updated successfully');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return back()->withSuccess('Coupon deleted successfully');
    }
}
