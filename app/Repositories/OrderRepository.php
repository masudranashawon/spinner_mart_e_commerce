<?php

namespace App\Repositories;

use App\Enums\CouponTypeEnums;
use App\Enums\OrderStatusEnums;
use App\Enums\PaymentStatusEnums;
use App\Models\Coupon;
use App\Models\Order;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        return Order::class;
    }

    public static function storeByRequest(Request $request): Order
    {
        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        $cartItems = $user->cartItems;
        $shippingCharge = $request->deliveryCharge;
        $subTotal = $cartItems->sum('total');
        $couponId = session('coupon_id');
        $discount = 0;
        $coupon = null;

        // Check if coupon is active
        if ($couponId) {
            $coupon = Coupon::find($couponId);

            if ($coupon && $coupon->status == 1 && $coupon->limit > $coupon->total_applied) {
                $discount = $coupon->coupon_type == CouponTypeEnums::PERCENTAGE->value
                    ? ($subTotal * $coupon->discount) / 100
                    : $coupon->discount;
            } else {
                $coupon = null; // invalid coupon
            }
        }

        $grandTotal = $subTotal - $discount;

        // Create order
        $order = self::create([
            'user_id' => $user->id,
            'shipping_charge' => $shippingCharge,
            'grand_total' => $grandTotal,
            'coupon_id' => $coupon?->id ?? null,
            'order_status' => OrderStatusEnums::PENDING->value,
            'payment_method' => $request->payment_method,
            'has_coupon' => $coupon?->id ? true : false,
            'has_payment' => false,
            'note' => $request->note,
            'payment_status' => PaymentStatusEnums::PENDING->value,
        ]);

        // Store order items
        OrderItemsRepository::storeByRequest($request, $order);

        // Update coupon usage
        if ($coupon) {
            $coupon->increment('total_applied');
        }

        // Clear Cart & Session
        $user->cartItems()->delete();
        session()->forget('coupon_id');

        return $order;
    }
}
