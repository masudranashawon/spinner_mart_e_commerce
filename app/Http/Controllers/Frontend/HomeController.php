<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::latest('id')->get();
        $recentlyAdded = Product::latest('id')->take(3)->get();

        return view('frontend.index', compact('categories', 'recentlyAdded'));
    }
}
