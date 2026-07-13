<?php

namespace App\Repositories;

use App\Models\Order;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;

class OrderRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        return Order::class;
    }

    public static function storeByRequest(Request $request): Order
    {
        $order =  self::create([
            //
        ]);

        return $order;
    }
}
