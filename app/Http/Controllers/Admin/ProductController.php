<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index');
    }

    public function create()
    {
        $categories = Category::latest("id")->get();
        $subCategories = SubCategory::latest("id")->get();
        $brands = Brand::latest("id")->get();

        return view('admin.product.create', compact("categories", "subCategories", "brands"));
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
