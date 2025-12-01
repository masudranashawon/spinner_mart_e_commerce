<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view("admin.category.index");
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
