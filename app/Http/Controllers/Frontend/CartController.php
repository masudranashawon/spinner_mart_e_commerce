<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\Enums\CouponTypeEnums;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = auth('web')->user();
        $cartItems = $user->cartItems()->latest()->get();

        return  view('frontend.cart.index', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::with('variants')->findOrFail($request->product_id);

        // check if product has color / size variants
        $hasColor = $product->variants->whereNotNull('color_id')->count() > 0;
        $hasSize  = $product->variants->whereNotNull('size_id')->count() > 0;

        // If color / size exists, then validate selection
        if ($hasColor) {
            $request->validate([
                'color' => 'required|exists:colors,id',
            ]);
        }

        if ($hasSize) {
            $request->validate([
                'size' => 'required|exists:sizes,id',
            ]);
        }

        // Find correct variant
        $variant = ProductVariant::where('product_id', $product->id)
            ->when($hasColor, fn($q) => $q->where('color_id', $request->color))
            ->when($hasSize, fn($q) => $q->where('size_id', $request->size))
            ->first();

        if (!$variant) {
            return back()->with('error', 'Selected product option is unavailable.');
        }

        // Stock check
        if ($variant->current_stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available!');
        }

        // Set price
        $price = $variant->discount_price > 0
            ? $variant->discount_price
            : $variant->selling_price;

        // Check existing cart item
        $cart = Cart::where('user_id', auth('web')->user()->id)
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variant->id)
            ->first();

        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->save();

            return back()->withSuccess('Cart updated successfully!');
        } else {
            Cart::create([
                'user_id' => auth('web')->user()->id,
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
                'quantity' => $request->quantity,
                'price' => $price,
            ]);
        }

        return back()->withSuccess('Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|numeric|min:1',
        ]);

        $user = auth('web')->user();

        $cartItem = Cart::where('user_id', $user->id)->where('product_id', $request->product_id)->where('product_variant_id', $request->product_variant_id)->first();

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully'
        ]);
    }

    public function cardCouponApply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|exists:coupons,coupon_code',
            'sub_total' => 'required|numeric|min:0',
        ]);



        $couponCode = $request->coupon_code;

        $coupon = Coupon::where('coupon_code', $couponCode)->first();


        // Check if coupon is active
        $start = Carbon::parse($coupon->start_date)->startOfDay();
        $end = Carbon::parse($coupon->expiry_date)->endOfDay();

        if (now()->lt($start) || now()->gt($end)) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon is not valid at this time.'
            ], 400);
        }

        // Check if coupon usage limit has been reached
        $hasReachedLimit = $coupon->total_applied >= $coupon->limit;
        if ($hasReachedLimit) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon usage limit has been reached.'
            ], 400);
        }

        // Check if the subtotal meets the minimum amount for the coupon
        $minAmount = $coupon->min_amount;
        if ($minAmount > $request->sub_total) {
            return response()->json([
                'status' => false,
                'message' => 'Subtotal price does not meet the minimum amount for this coupon.'
            ], 400);
        }

        // Calculate discount based on coupon type
        $couponDiscount = 0;
        if ($coupon->coupon_type == CouponTypeEnums::PERCENTAGE->value) {
            $couponDiscount = ($request->sub_total * $coupon->discount) / 100;
        } elseif ($coupon->coupon_type == CouponTypeEnums::FIXED->value) {
            $couponDiscount = $coupon->discount;
        }   

        $discountPrice = $request->sub_total - $couponDiscount;

        return response()->json([
            'message' => 'Coupon applied successfully.',
            'discount' => $discountPrice,
            'sub_total' => $request->sub_total
        ], 200);
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id != auth('web')->user()->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $cart->delete();

        return back()->withSuccess('Cart item removed successfully!');
    }
}
