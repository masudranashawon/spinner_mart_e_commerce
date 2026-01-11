<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductVariantRequest;
use App\Models\Product;
use App\Repositories\ProductVariantRepository;


class ProductVariantController extends Controller
{
    public function bulkStore(ProductVariantRequest $request, Product $product)
    {
        $productVariant = ProductVariantRepository::storeByRequest($request, $product);

        if ($productVariant) {
            return to_route("product.show", $product->id)->withSuccess("Variants saved successfully");
        } else {
            return to_route("product.show", $product->id)->withError("Variants saved failed");
        }
    }
}
