<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('frontend.pages.about');
    }

    public function faq()
    {
        $faqs = Faq::where('is_active', 1)->latest()->get();

        return view('frontend.pages.faq', compact('faqs'));
    }
}
