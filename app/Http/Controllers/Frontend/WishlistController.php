<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth('web')->user()->id)->get();

        // map stock info per product
        $wishlists = $wishlists->map(function ($item) {
            // total stock for product
            $totalStock = ProductVariant::where('product_id', $item->product_id)->sum('current_stock');

            // attach stock
            $item->stock = $totalStock;

            return $item;
        });

        return view('frontend.wishlist.index', compact('wishlists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = auth('web')->user()?->id;

        Wishlist::create([
            'user_id' =>  $userId,
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to wishlist!'
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = auth('web')->id();

        Wishlist::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->delete();

        return back()->withSuccess('Product removed from wishlist!');
    }
}
