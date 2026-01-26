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
        $products = Product::latest('id')->get();
        $tags = Tag::latest('id')->get();
        $sizes = Size::latest('id')->get();
        $colors = Color::latest('id')->get();
        $recentlyAdded = $products->take(3);

        return view('frontend.shop.index', compact('categories', 'products', 'recentlyAdded', 'tags', 'sizes', 'colors'));
    }
}
