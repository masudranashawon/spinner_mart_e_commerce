<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Get all orders for admin
        $orders = Order::latest()->get();

        return view('admin.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $billingAddress = $order->addresses->where('address_type', 'billing')->first();
        $shippingAddress = $order->addresses->where('address_type', 'shipping')->first();

        return view('admin.order.show', compact('order', 'billingAddress', 'shippingAddress'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|string',
            'cancel_reason' => 'nullable|string|max:1000',
            'tracking_note' => 'nullable|string|max:255',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        OrderRepository::adminUpdateStatus($order, $request);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function updatePayment(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|string',
        ]);

        OrderRepository::adminUpdatePayment($order, $request->payment_status);

        return back()->with('success', 'Payment status updated successfully.');
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
        // Delete the order and restore stock and coupons
        OrderRepository::deleteOrderForAdmin($order);

        return to_route('admin.order.index')->with('success', 'Order deleted successfully. Stock and coupons have been restored.');
    }
}
