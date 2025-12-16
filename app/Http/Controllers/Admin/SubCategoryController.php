<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest("id")->get();

        return view("admin.subCategory.index", compact("categories"));
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
