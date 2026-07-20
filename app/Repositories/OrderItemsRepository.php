<?php

namespace App\Repositories;

use App\Models\InventoryStock;
use App\Models\Order;
use App\Models\OrderItem;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderItemsRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        return OrderItem::class;
    }

    public static function storeByRequest(Request $request, Order $order)
    {
        /** @var \App\Models\User $user */
        $user = auth('web')->user();
        $cartItems = $user->cartItems;

        // Loop through cart items
        foreach ($cartItems as $item) {
            $product = $item->product;
            $variant = $item->variant;

            // Check if product variant exists
            if (!$variant) {
                throw ValidationException::withMessages([
                    'product' => 'Product variant not found.',
                ]);
            }

            // Check if product variant is in stock
            if ($variant->current_stock < $item->quantity) {
                throw ValidationException::withMessages([
                    'stock' => "{$product->name} is out of stock.",
                ]);
            }

            // Create order item
            self::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_variant_id' => $item->product_variant_id,
                'product_name' => $product->name,
                'sku' => $variant->sku_code,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'subtotal' => $item->quantity * $item->price,
            ]);

            // Increase sold count
            $product->increment('sold_count', $item->quantity);

            // Decrease current stock
            $variant->decrement('current_stock', $item->quantity);

            // Inventory history
            InventoryStock::create([
                'product_variant_id' => $variant->id,
                'quantity'           => -$item->quantity,
                'type'               => 'stock_out',
                'note'               => "Order Placed: {$order->order_number}",
            ]);
        }
    }
}
