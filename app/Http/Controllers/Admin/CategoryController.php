<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\ProductDetails;
use App\Models\SubCategory;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest("id")->get();

        return view("admin.category.index", compact("categories"));
    }

    public function store(CategoryRequest $request)
    {
        $category = CategoryRepository::storeByRequest($request);

        if ($category) {
            return to_route("category.index")->withSuccess("Category created successfully");
        } else {
            return to_route("category.index")->withError("Category not created");
        }
    }

    public function edit(Category $category)
    {
        return view("admin.category.edit", compact("category"));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category =  CategoryRepository::updateByRequest($request, $category);


        if ($category) {
            return to_route("category.index")->withSuccess("Category updated successfully");
        } else {
            return to_route("category.index")->withError("Category not updated");
        }
    }

    public function destroy(Category $category)
    {
        $hasProducts = ProductDetails::where('category_id', $category->id)->exists();

        if ($hasProducts) {
            return back()->withError("This category cannot be deleted because it is associated with existing products. Please remove them first.");
        }

        // If there are no products, delete the Category
        $isDeleted = $category->delete();

        if ($isDeleted) {
            return to_route("category.index")->withSuccess("Category deleted successfully.");
        } else {
            return back()->withError("Category not deleted.");
        }
    }
}
