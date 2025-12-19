<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Repositories\MediaRepository;
use App\Repositories\SubCategoryRepository;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest("id")->get();
        $subCategories = SubCategory::latest("id")->paginate(5);

        return view("admin.subCategory.index", compact("categories", "subCategories"));
    }

    public function store(SubCategoryRequest $request)


    {
        $media = null;

        if ($request->hasFile("image")) {
            $media = MediaRepository::storeByRequest($request->file("image"), "subcategory", "image");
        }

        $subCategory = SubCategoryRepository::storeByRequest($request, $media);

        if ($subCategory) {
            return to_route("subCategory.index")->withSuccess("Sub Category created successfully");
        } else {
            return to_route("subCategory.index")->withError("Sub Category not created");
        }
    }
}
