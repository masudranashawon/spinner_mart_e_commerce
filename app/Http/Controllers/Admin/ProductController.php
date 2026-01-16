<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\InventoryStock;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
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

    public function show(Product $product)
    {
        $colors = Color::latest()->get();
        $sizes = Size::latest()->get();

        // product variants
        $productVariants = ProductVariant::where('product_id', $product->id)->where(function ($q) {
            $q->whereNotNull('size_id')->orWhereNotNull('color_id');
        })->latest()->get(); // Fetch variants

        //stock variants
        $stockVariants = ProductVariant::where('product_id', $product->id)->latest()->get();

        // product galleries
        $productGalleries =  $product->galleries->map(function ($media) {
            return [
                "media_id" => $media->id,
                "src" => $media->gallery_url, // using accessor from Media model
            ];
        });

        // stock history
        $stockHistory = InventoryStock::whereIn(
            'product_variant_id',
            $stockVariants->pluck('id')
        )->latest()->get();

        return view('admin.product.show', compact("product", "productGalleries", "colors", "sizes", "productVariants", "stockVariants", "stockHistory"));
    }

    public function edit(Product $product)
    {
        $categories = Category::latest("id")->get();
        $subCategories = SubCategory::latest("id")->get();
        $brands = Brand::latest("id")->get();
        $tags = Tag::latest("id")->get();

        // product tags
        $productTags =   $product->tags->pluck('id')->toArray();

        return view('admin.product.edit', compact('product', 'categories', 'subCategories', 'brands', 'tags', 'productTags'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product = ProductRepository::updateByRequest($request, $product);

        if ($product) {
            return to_route("product.index")->withSuccess("Product updated successfully");
        } else {
            return to_route("product.index")->withError("Product not updated");
        }
    }
}
