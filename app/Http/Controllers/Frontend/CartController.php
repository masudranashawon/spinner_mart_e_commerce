<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\RecentView;
use Carbon\Carbon;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */

        $user = auth('web')->user();
        $cartItems = $user->cartItems()->latest()->get();

        $recentViews = RecentView::with('product')
            ->where('user_id', $user->id)
            ->latest('updated_at')
            ->take(4)
            ->get();

        $recentViewProducts = $recentViews->map->product;

        return  view('frontend.cart.index', compact('cartItems', 'recentViewProducts'));
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
            'couponCode' => 'required|exists:coupons,coupon_code',
        ]);

        $couponCode = $request->couponCode;
        $coupon = Coupon::where('coupon_code', $couponCode)->first();

        if (!$coupon->status) {
            return response()->json(['status' => false, 'message' => 'This coupon is inactive.'], 400);
        }

        // Calculate actual subtotal from DB (Price * Quantity)
        /** @var \App\Models\User $user */
        $user = auth('web')->user();
        $cartItems = $user->cartItems()->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Cart is empty.'], 400);
        }

        // Properly multiply unit price by quantity for the true subtotal
        $actualSubTotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Check Validations
        $start = Carbon::parse($coupon->start_date)->startOfDay();
        $end = Carbon::parse($coupon->expiry_date)->endOfDay();

        if (now()->lt($start) || now()->gt($end)) {
            return response()->json(['status' => false, 'message' => 'Coupon is not valid at this time.'], 400);
        }

        // Check if coupon limit is reached
        if ($coupon->limit > 0 && $coupon->total_applied >= $coupon->limit) {
            return response()->json(['status' => false, 'message' => 'Coupon usage limit has been reached.'], 400);
        }

        if ($coupon->min_amount > 0 && $coupon->min_amount > $actualSubTotal) {
            return response()->json([
                'status' => false,
                'message' => 'Subtotal price does not meet the minimum amount ('. get_setting('currency_symbol') . $coupon->min_amount . ' )'
            ], 400);
        }

        $type = $coupon->coupon_type instanceof \BackedEnum ? $coupon->coupon_type->value : $coupon->coupon_type;
        $type = strtolower($type);


        // Calculate initial discount to send back to UI
        $discountAmount = 0;
        if ($type === 'percentage') {
            $discountAmount = ($actualSubTotal * $coupon->discount) / 100;
        } else {
            $discountAmount = $coupon->discount;
        }

        $finalTotal = $actualSubTotal - $discountAmount;


        // Coupon apply success
        if ($coupon) {
            session([
                'coupon_id' => $coupon->id,
            ]);
        }

        // Send raw config back so JS can handle real-time qty changes
        return response()->json([
            'message' => 'Coupon applied successfully.',
            'coupon_id' => $coupon->id,
            'coupon_type' => $type,
            'discount_value' => $coupon->discount,
            'min_amount' => $coupon->min_amount ?? 0,
            'calculated_discount' => round($discountAmount, 2),
            'calculated_total' => round($finalTotal, 2)
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
