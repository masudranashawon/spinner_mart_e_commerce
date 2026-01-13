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
        $variants = $request->variants ?? [];

        if (count($variants) === 0) {
            throw ValidationException::withMessages([
                'variants' => 'Please add at least one variant.',
            ]);
        }

        // Fetch default variant (size_id & color_id NULL)
        $defaultVariant = ProductVariant::where('product_id', $product->id)
            ->whereNull('size_id')
            ->whereNull('color_id')
            ->first();

        foreach ($variants as $variant) {
            // Variant must have size or color
            if (empty($variant['color_id']) && empty($variant['size_id'])) {
                throw ValidationException::withMessages([
                    'variants' => 'Please select Color or Size for variant.',
                ]);
            }

            // Prevent duplicate variants
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
                'color_id'      => $variant['color_id'] ?? null,
                'size_id'       => $variant['size_id'] ?? null,
                'sku_code'      => $variant['sku'],
                'buying_price'  => $variant['buying_price'],
                'selling_price' => $variant['selling_price'],
            ]);
        }

        if ($defaultVariant) {
            $defaultVariant->delete();
        }

        return $productVariant;
    }

    public static function updateByRequest(
        Request $request,
        Product $product,
        ProductVariant $variant
    ): ProductVariant {
        // default variant edit block
        if (is_null($variant->color_id) && is_null($variant->size_id)) {
            throw ValidationException::withMessages([
                'variant' => 'Default variant cannot be edited.',
            ]);
        }

        // Duplicate check
        $exists = ProductVariant::where('product_id', $product->id)
            ->where('id', '!=', $variant->id)
            ->where('color_id', $request->edit_color)
            ->where('size_id', $request->edit_size)
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'variant' => 'Same variant already exists.',
            ]);
        }

        // Update only editable fields
        $variant->update([
            'size_id'       => $request->edit_size,
            'color_id'      => $request->edit_color,
            'buying_price'  => $request->edit_buying_price,
            'selling_price' => $request->edit_selling_price,
        ]);

        return $variant;
    }
}
