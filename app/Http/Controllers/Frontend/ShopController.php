<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Tag;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {

        $categories = Category::latest('id')->get();
        $products = Product::latest()->paginate(20)->withQueryString();
        $tags = Tag::latest('id')->get();
        $sizes = Size::latest('id')->get();
        $colors = Color::latest('id')->get();
        $recentlyAdded = $products->take(3);

        return view('frontend.shop.index', compact('categories', 'products', 'recentlyAdded', 'tags', 'sizes', 'colors'));
    }

    public function show($slug)
    {
        $product = Product::with([
            'variants.color',
            'variants.size'
        ])
            ->where('slug', $slug)
            ->firstOrFail();

        // Default variant
        $defaultVariant = $product->variants->first();

        // ALL variants
        $variants = $product->variants->map(function ($v) {
            return [
                'id'       => $v->id,
                'color_id' => $v->color_id,
                'size_id'  => $v->size_id,
                'sku'      => $v->sku_code,
                'price'    => $v->selling_price,
                'discount' => $v->discount_price,
                'stock'    => $v->currentStock,
            ];
        })->values();

        return view('frontend.shop.show', compact(
            'product',
            'defaultVariant',
            'variants'
        ));
    }
}
