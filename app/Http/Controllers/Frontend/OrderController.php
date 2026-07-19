<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Repositories\OrderRepository;

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
        $order = OrderRepository::storeByRequest($request);

        return to_route('home')->with('success', 'Order has been placed successfully!');
    }
}
