<?php

namespace App\Repositories;

use App\Enums\CouponTypeEnums;
use App\Enums\OrderStatusEnums;
use App\Enums\PaymentStatusEnums;
use App\Models\Coupon;
use App\Models\InventoryStock;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
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
        $couponCode = null;

        // Check if coupon is active
        if ($couponId) {
            $coupon = Coupon::find($couponId);

            if ($coupon && $coupon->status == 1 && ($coupon->limit == 0 || $coupon->limit > $coupon->total_applied)) {

                $type = $coupon->coupon_type instanceof \BackedEnum ? $coupon->coupon_type->value : $coupon->coupon_type;
                $type = strtolower($type);

                $discount = $type === 'percentage'
                    ? ($subTotal * $coupon->discount) / 100
                    : $coupon->discount;

                $couponCode = $coupon->coupon_code;
            } else {
                $coupon = null; // invalid coupon
            }
        }

        $grandTotal = $subTotal - $discount + $shippingCharge;

        // Create order
        $order = self::create([
            'user_id' => $user->id,
            'coupon_id' => $coupon?->id ?? null,
            'coupon_code' => $couponCode,
            'discount_amount' => $discount,
            'subtotal' => $subTotal,
            'shipping_charge' => $shippingCharge,
            'grand_total' => $grandTotal,
            'order_status' => OrderStatusEnums::PENDING->value,
            'payment_method' => $request->payment_method,
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

    public static function cancelOrderByUser(Order $order, string $reason)
    {
        DB::transaction(function () use ($order, $reason) {
            // Update Order Status
            $order->update([
                'order_status' => OrderStatusEnums::CANCELLED->value,
                'cancel_reason' => $reason,
            ]);

            // Restore Stock & Sold Count
            foreach ($order->items as $item) {

                // Loop through order items
                $variant = $item->variant;
                $product = $item->product;

                // Check if product variant exists
                if ($variant) {
                    $variant->increment('current_stock', $item->quantity);

                    InventoryStock::create([
                        'product_variant_id' => $variant->id,
                        'quantity'           => $item->quantity,
                        'type'               => 'return', // or 'adjustment'
                        'note'               => "Restocked from Cancelled Order: {$order->order_number}",
                    ]);
                }

                // Check if product exists
                if ($product) {
                    // Reduce the sold count since the order is cancelled
                    $product->decrement('sold_count', $item->quantity);
                }
            }
        });
    }

    public static function requestReturnByUser(Order $order, string $reason)
    {
        $order->update([
            // Update Order Status
            'order_status' => OrderStatusEnums::RETURN_REQUESTED->value,
            'return_reason' => $reason,
        ]);
    }
}
