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

        // Subtotal 
        $subTotal = round($cartItems->sum('total'));

        // VAT Calculation (VAT Percentage from settings, default 0 if not set)
        $vatPercentage = (float) get_setting('vat_percentage', 0);
        $vatAmount = round(($subTotal * $vatPercentage) / 100);

        // Shipping Charge
        $shippingCharge = round($request->deliveryCharge ?? 0);

        $couponId = session('coupon_id');
        $discount = 0;
        $coupon = null;
        $couponCode = null;

        // Discount calculation based on coupon
        if ($couponId) {
            $coupon = Coupon::find($couponId);

            if ($coupon && $coupon->status == 1 && ($coupon->limit == 0 || $coupon->limit > $coupon->total_applied)) {
                $discount = $coupon->coupon_type->value === 'percentage'
                    ? ($subTotal * $coupon->discount) / 100
                    : $coupon->discount;

                $discount = round($discount);
                $couponCode = $coupon->coupon_code;
            } else {
                $coupon = null; // invalid coupon
            }
        }

        // Grand Total (Subtotal - Discount + VAT + Shipping)
        $grandTotal = $subTotal - $discount + $vatAmount + $shippingCharge;

        // Create order (order_number is generated in the Order model's creating event)
        $order = self::create([
            'user_id' => $user->id,
            'coupon_id' => $coupon?->id ?? null,
            'coupon_code' => $couponCode,
            'discount_amount' => $discount,
            'subtotal' => $subTotal,
            'vat_amount' => $vatAmount,
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

            if ($order->coupon_id) {
                $coupon = Coupon::find($order->coupon_id);
                if ($coupon && $coupon->total_applied > 0) {
                    $coupon->decrement('total_applied');
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

    public static function adminUpdateStatus(Order $order, Request $request)
    {
        DB::transaction(function () use ($order, $request) {

            $newStatus = $request->order_status;
            $oldStatus = $order->order_status;

            $restockStates = [
                OrderStatusEnums::CANCELLED->value,
                OrderStatusEnums::RETURNED->value
            ];

            $oldWasRestocked = in_array($oldStatus, $restockStates);
            $newIsRestock = in_array($newStatus, $restockStates);

            // Restore Stock (If moving to Cancelled/Returned from normal status)
            if ($newIsRestock && !$oldWasRestocked) {
                self::adjustStockForAdmin($order, true, $newStatus);

                // ===== Restore Coupon =====
                if ($order->coupon_id) {
                    $coupon = Coupon::find($order->coupon_id);

                    if ($coupon && $coupon->total_applied > 0) {
                        $coupon->decrement('total_applied');
                    }
                }
            } elseif (!$newIsRestock && $oldWasRestocked) {
                // Deduct Stock (If moving from Cancelled/Returned to normal status)
                self::adjustStockForAdmin($order, false, $newStatus);

                if ($order->coupon_id) {
                    $coupon = Coupon::find($order->coupon_id);
                    if ($coupon) {
                        $coupon->increment('total_applied');
                    }
                }
            }

            // update new status
            $updateData = [
                'order_status' => $newStatus,
            ];

            if ($request->filled('tracking_note')) {
                $updateData['tracking_note'] = $request->tracking_note;
            }

            if ($request->filled('admin_note')) {
                $updateData['admin_note'] = $request->admin_note;
            }

            // if admin cancel order & give cancel reason
            if ($newStatus === OrderStatusEnums::CANCELLED->value && $request->filled('cancel_reason')) {
                $updateData['cancel_reason'] = $request->cancel_reason;
            }

            // Auto-set delivery date when marked as delivered
            if ($newStatus === OrderStatusEnums::DELIVERED->value) {
                // Set delivery date when order is marked as delivered
                $updateData['delivery_date'] = now();
            } elseif ($oldStatus === OrderStatusEnums::DELIVERED->value && $newStatus !== OrderStatusEnums::DELIVERED->value) {
                // Reset delivery date when order is marked as not delivered
                $updateData['delivery_date'] = null;
            }

            // Update Order
            $order->update($updateData);
        });

        return $order;
    }

    public static function adminUpdatePayment(Order $order, string $paymentStatus)
    {
        // Update Order Status
        $order->update([
            'payment_status' => $paymentStatus
        ]);

        return $order;
    }

    private static function adjustStockForAdmin(Order $order, bool $isRestoring, string $status)
    {
        foreach ($order->items as $item) {

            $variant = $item->variant;
            $product = $item->product;

            if ($variant) {
                // Restore or Deduct Stock
                if ($isRestoring) {
                    $variant->increment('current_stock', $item->quantity);
                } else {
                    $variant->decrement('current_stock', $item->quantity);
                }

                InventoryStock::create([
                    'product_variant_id' => $variant->id,
                    'quantity'           => $isRestoring ? $item->quantity : -$item->quantity,
                    'type'               => $isRestoring ? 'return' : 'stock_out',
                    'note'               => "Admin Status Update ({$status}) - Order #{$order->order_number}",
                ]);
            }

            if ($product) {
                // Update Sold Count
                if ($isRestoring) {
                    $product->decrement('sold_count', $item->quantity);
                } else {
                    $product->increment('sold_count', $item->quantity);
                }
            }
        }
    }

    public static function deleteOrderForAdmin(Order $order)
    {
        DB::transaction(function () use ($order) {

            $restockStates = [
                OrderStatusEnums::CANCELLED->value,
                OrderStatusEnums::RETURNED->value
            ];

            // Restore Stock (If moving to Cancelled/Returned from normal status)
            if (!in_array($order->order_status, $restockStates)) {
                self::adjustStockForAdmin($order, true, 'Order Deleted');
            }


            if ($order->coupon_id) {
                $coupon = Coupon::find($order->coupon_id);
                if ($coupon && $coupon->total_applied > 0) {
                    $coupon->decrement('total_applied');
                }
            }

            // Delete the order and its related items
            $order->delete();
        });
    }
}
