<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use App\Repositories\MediaRepository;
use App\Repositories\SubCategoryRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest("id")->get();
        $subCategories = SubCategory::latest("id")->get();

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

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::latest("id")->get();

        return view("admin.subCategory.edit", compact("subCategory", "categories"));
    }

    public function update(SubCategoryRequest $request, SubCategory $subCategory)
    {
        $media = $subCategory->media;

        if ($request->hasFile("image")) {
            if ($subCategory?->media && Storage::exists($subCategory?->media?->src)) {
                $media = MediaRepository::updateByRequest($request->file("image"), "subcategory", "image", $subCategory->media);
            } else {
                $media = MediaRepository::storeByRequest($request->file("image"), "subcategory", "image");
            }
        }

        $subCategory =  SubCategoryRepository::updateByRequest($request, $subCategory, $media);

        if ($subCategory) {
            return to_route("subCategory.index")->withSuccess("Sub Category updated successfully");
        } else {
            return to_route("subCategory.index")->withError("Sub Category not updated");
        }
    }
}
