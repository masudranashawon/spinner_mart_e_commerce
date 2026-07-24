<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Get all orders for admin
        $orders = Order::latest()->get();

        return view('admin.order.index', compact('orders'));
    }

    public function invoice(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $billingAddress = $order->addresses->where('address_type', 'billing')->first();
        $shippingAddress = $order->addresses->where('address_type', 'shipping')->first();

        // Reusing the frontend invoice view
        return view('frontend.order.invoice', compact('order', 'billingAddress', 'shippingAddress'));
    }

    public function destroy(Order $order)
    {
        // Delete order
        $order->delete();

        return to_route('admin.order.index')->with('success', 'Order deleted successfully.');
    }
}
