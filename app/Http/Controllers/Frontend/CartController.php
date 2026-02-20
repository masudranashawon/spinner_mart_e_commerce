<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
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
            return back()->withErrors('Product variant not found.');
        }

        // Stock check
        if ($variant->current_stock < $request->quantity) {
            return back()->withErrors('Not enough stock available.');
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
        } else {
            Cart::create([
                'user_id' => auth('web')->user()->id,
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
                'quantity' => $request->quantity,
                'price' => $price,
            ]);
        }

        return back()->withSSuccess('Product added to cart successfully!');
    }
}
