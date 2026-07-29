<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RecentView;

class RecentViewController extends Controller
{
    public function index()
    {
        $user = auth('web')->user();

        $recentViews = RecentView::with('product')
            ->where('user_id', $user->id)
            ->latest('updated_at')
            ->get();

        $products = $recentViews->map->product;

        return view('frontend.recentview.index', compact('products'));
    }
}
