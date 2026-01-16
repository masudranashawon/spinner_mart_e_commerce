<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryStock;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InventoryStockController extends Controller
{
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'stocks' => 'required|array|min:1',
            'stocks.*.variant_id' => 'required|exists:product_variants,id',
            'stocks.*.quantity'   => 'nullable|integer|min:1',
            'stocks.*.type'       => 'required|in:stock_in,stock_out,return,adjustment',
            'stocks.*.note'       => 'nullable|string',
        ]);

        foreach ($request->stocks as $row) {

            // Skip if quantity is not provided
            if (!isset($row['quantity']) || $row['quantity'] === '' || $row['quantity'] === null) {
                continue;
            }

            // Stock calculation
            $qty = (int) $row['quantity'];

            if ($qty <= 0) {
                continue;
            }

            $variant = ProductVariant::find($row['variant_id']);

            if (!$variant) {
                continue;
            }

            if ($row['type'] === 'stock_out') {
                if ($variant->current_stock < $qty) {
                    throw ValidationException::withMessages([
                        'stocks' => "Insufficient stock for SKU {$variant->sku_code}"
                    ]);
                }
                $variant->decrement('current_stock', $qty);
            } else {
                $variant->increment('current_stock', $qty);
            }

            InventoryStock::create([
                'product_variant_id' => $variant->id,
                'quantity'           => $qty,
                'type'               => $row['type'],
                'note'               => $row['note'] ?? null,
            ]);
        }

        return back()->with('success', 'Stock updated successfully');
    }
}
