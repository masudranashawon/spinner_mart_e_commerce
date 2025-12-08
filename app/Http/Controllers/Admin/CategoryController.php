<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest("id")->paginate(4);

        return view("admin.category.index", compact("categories"));
    }

    public function edit(Category $category)
    {
        return view("admin.category.edit", compact("category"));
    }

    public function store(CategoryRequest $request)
    {
        $category = (new CategoryRepository())->storeByRequest($request);

        if ($category) {
            return to_route("category.index")->withSuccess("Category created successfully");
        } else {
            return to_route("category.index")->withError("Category not created");
        }
    }
}
