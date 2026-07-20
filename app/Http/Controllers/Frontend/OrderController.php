<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Repositories\OrderAddressRepository;
use App\Repositories\OrderRepository;
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

        return view('frontend.order.show', compact('order', 'billingAddress', 'shippingAddress'));
    }
}
