<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function bulkStore(Request $request, Product $product)
    {
        // dd($request->all(), $product->id);
        $request->validate([
            'variants' => 'required|array',
            'variants.*.color_id' => 'nullable|exists:colors,id',
            'variants.*.size_id'  => 'nullable|exists:sizes,id',
            'variants.*.buying_price' => 'nullable|numeric|min:0',
            'variants.*.selling_price' => 'nullable|numeric|min:0',
        ]);

        foreach ($request->variants as $variant) {
            ProductVariant::create([
                'product_id'    => $product->id,
                'color_id'      => $variant['color_id'] ?? null,
                'size_id'       => $variant['size_id'] ?? null,
                'sku_code'      => $variant['sku'],
                'buying_price'  => $variant['buying_price'] ?? null,
                'selling_price' => $variant['selling_price'] ?? null,
            ]);
        }


        return back()->with('success', 'Variants saved successfully');
    }
}
