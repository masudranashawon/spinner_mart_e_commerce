<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductVariant;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductVariantRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        return ProductVariant::class;
    }

    public static function storeByRequest(Request $request, Product $product): ProductVariant
    {
        foreach ($request->variants as $variant) {
            // Validate that at least one of color_id or size_id is provided
            if (empty($variant['color_id']) && empty($variant['size_id'])) {
                throw ValidationException::withMessages([
                    'variants' => 'Please select Color or Size for variant.',
                ]);
            }

            // Check for existing variant with same color_id and size_id for the product
            $exists = ProductVariant::where('product_id', $product->id)
                ->where('color_id', $variant['color_id'] ?? null)
                ->where('size_id', $variant['size_id'] ?? null)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'variants' => "Same variant (Color & Size) already exists.",
                ]);
            }

            // Create the new ProductVariant
            $productVariant = self::create([
                'product_id'    => $product->id,
                'color_id'      => $variant['color_id'],
                'size_id'       => $variant['size_id'],
                'sku_code'      => $variant['sku'],
                'buying_price'  => $variant['buying_price'],
                'selling_price' => $variant['selling_price'],
            ]);
        }

        return $productVariant;
    }
}
