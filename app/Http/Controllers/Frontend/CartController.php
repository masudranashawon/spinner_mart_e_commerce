<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
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

    public function destroy(Cart $cart)
    {
        if ($cart->user_id != auth('web')->user()->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $cart->delete();

        return back()->withSuccess('Cart item removed successfully!');
    }
}
