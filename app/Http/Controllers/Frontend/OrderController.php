<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        $order = OrderRepository::storeByRequest($request);

        return to_route('home')->with('success', 'Order has been placed successfully!');
    }
}
