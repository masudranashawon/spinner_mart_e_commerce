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
            'variants' => function ($q) {
                $q->where('current_stock', '>', 0)  //variants with stock
                    ->with(['color:id,name,color_code', 'size:id,name']);
            },
            'galleries',
            'details.category',
            'tags'
        ])
            ->where('slug', $slug)
            ->firstOrFail();

        // Default variant
        $defaultVariant = $product->variants
            ->where('current_stock', '>', 0)
            ->first() ?? $product->variants->first();

        // Frontend variants data
        $variantsData = $product->variants->map(function ($v) {
            return [
                'id'          => $v->id,
                'color_id'    => $v->color_id,
                'size_id'     => $v->size_id,
                'sku'         => $v->sku_code,
                'price'       => number_format($v->selling_price, 2),
                'discount'    => $v->discount_price ? number_format($v->discount_price, 2) : null,
                'stock'       => $v->current_stock,
                'in_stock'    => $v->current_stock > 0,
            ];
        });

        return view('frontend.shop.show', compact(
            'product',
            'defaultVariant',
            'variantsData'
        ));
    }
}