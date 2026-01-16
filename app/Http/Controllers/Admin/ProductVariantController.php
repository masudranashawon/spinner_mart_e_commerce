<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductVariantRequest;
use App\Models\Product;
use App\Models\ProductVariant;
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

    public function destroy(Product $product, ProductVariant $variant)
    {
        if ($variant->product_id !== $product->id) {
            abort(403, 'Unauthorized action.');
        }

        $deleted = $variant->delete();

        if ($product->variants()->count() == 0) {
            ProductVariant::create([
                'product_id' => $product->id,
                'size_id'    => null,
                'color_id'   => null,
                'sku_code'   => $product->sku_code,
                'buying_price' => $product->buying_price,
                'selling_price' => $product->selling_price,
            ]);
        }

        if ($deleted) {
            return to_route("product.show", $product->id)->withSuccess("Variant deleted successfully");
        } else {
            return to_route("product.show", $product->id)->withError("Variant deletion failed");
        }
    }

    public function update(
        ProductVariantRequest $request,
        Product $product,
        ProductVariant $variant
    ) {
        $productVariant = ProductVariantRepository::updateByRequest($request, $product, $variant);

        if ($productVariant) {
            return to_route("product.show", $product->id)->withSuccess("Variants updated successfully");
        } else {
            return to_route("product.show", $product->id)->withError("Variants update failed");
        }
    }
}
