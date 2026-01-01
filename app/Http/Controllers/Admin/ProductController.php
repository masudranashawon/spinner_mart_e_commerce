<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest("id")->get();

        return view('admin.product.index', compact("products"));
    }

    public function create()
    {
        $categories = Category::latest("id")->get();
        $subCategories = SubCategory::latest("id")->get();
        $brands = Brand::latest("id")->get();
        $tags = Tag::latest("id")->get();

        return view('admin.product.create', compact("categories", "subCategories", "brands", "tags"));
    }

    public function store(ProductRequest $request)
    {
        $product =   ProductRepository::storeByRequest($request);

        if ($product) {
            return to_route("product.index")->withSuccess("Product created successfully");
        } else {
            return to_route("product.index")->withError("Product not created");
        }
    }
}
