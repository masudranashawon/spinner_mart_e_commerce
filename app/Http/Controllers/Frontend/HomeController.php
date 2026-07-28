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

        $interestedProducts = Product::where('is_active', 1)
            ->inRandomOrder()
            ->take(8)
            ->get();

        $dealsOfTheDay = Product::where('is_active', 1)
            ->where('is_deal_of_the_day', 1)
            ->get();

        $trendingProducts = Product::where('is_active', 1)
            ->where('is_trending', 1)
            ->take(8)
            ->get();

        $topSellingProducts = Product::where('is_active', 1)
            ->orderBy('sold_count', 'desc')
            ->take(3)
            ->get();

        $recentlyAdded = Product::where('is_active', 1)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.index', compact(
            'categories',
            'interestedProducts',
            'dealsOfTheDay',
            'trendingProducts',
            'topSellingProducts',
            'recentlyAdded',
        ));
    }
}
