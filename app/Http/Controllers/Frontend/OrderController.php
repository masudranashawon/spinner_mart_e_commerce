<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Repositories\OrderAddressRepository;
use App\Repositories\OrderRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index()
    {
        $user = auth('web')->user();

        $orders = Order::query()
            ->where('user_id', $user->id)
            ->with(['items', 'addresses'])
            ->latest()
            ->paginate(10);

        return view('frontend.order.index', compact('orders'));
    }

    public function store(OrderRequest $request)
    {

        DB::transaction(function () use ($request) {
            $order = OrderRepository::storeByRequest($request);
            $orderAddress = OrderAddressRepository::storeByRequest($request, $order);
        });

        return to_route('order.index')->with('success', 'Order has been placed successfully!');
    }

    public function show(Order $order)
    {
        // get billing and shipping address
        $billingAddress = $order->addresses->where('address_type', 'billing')->first();
        $shippingAddress = $order->addresses->where('address_type', 'shipping')->first();
        $returnDays = (int) get_setting('return_policy_days', 7);
        $isEligibleForReturn = false;

        if ($order->order_status === 'delivered' && $order->delivery_date) {
            $deliveryDate = Carbon::parse($order->delivery_date);
            $lastReturnDate = $deliveryDate->copy()->addDays($returnDays);
            
            // Check if the order is eligible for return
            $isEligibleForReturn = now()->lessThanOrEqualTo($lastReturnDate);
        }

        return view('frontend.order.show', compact('order', 'billingAddress', 'shippingAddress','isEligibleForReturn', 'returnDays'));
    }

    public function invoice(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // get billing and shipping address
        $billingAddress = $order->addresses->where('address_type', 'billing')->first();
        $shippingAddress = $order->addresses->where('address_type', 'shipping')->first();

        return view('frontend.order.invoice', compact('order', 'billingAddress', 'shippingAddress'));
    }

    public function cancelOrder(Request $request, Order $order)
    {
        $userId = auth('web')->user()->id;

        $request->validate([
            'cancel_reason' => 'required|string|max:1000',
        ]);

        if ($order->user_id !== $userId) {
            abort(403, 'Unauthorized action.');
        }

        // Check if order is eligible for cancellation
        if ($order->order_status !== 'pending') {
            return back()->with('error', 'You can only cancel pending orders.');
        }

        OrderRepository::cancelOrderByUser($order, $request->cancel_reason);

        return back()->with('success', 'Your order has been cancelled successfully.');
    }

    public function returnRequest(Request $request, Order $order)
    {
        $userId = auth('web')->user()->id;

        $request->validate([
            'return_reason' => 'required|string|max:1000',
        ]);

        if ($order->user_id !== $userId) {
            abort(403, 'Unauthorized action.');
        }

        // Check if order is eligible for return
        if ($order->order_status !== 'delivered') {
            return back()->with('error', 'You can only request a return for delivered orders.');
        }

        OrderRepository::requestReturnByUser($order, $request->return_reason);

        return back()->with('success', 'Your return request has been submitted successfully.');
    }
}
