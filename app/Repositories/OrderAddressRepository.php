<?php

namespace App\Repositories;

use App\Enums\AddressTypeEnums;
use App\Models\Order;
use App\Models\OrderAddress;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;

class OrderAddressRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        return OrderAddress::class;
    }

    public static function storeByRequest(Request $request, Order $order): OrderAddress
    {
        $orderAddress = self::create([
            'order_id' => $order->id,
            'name' => $request->name,
            'country' => $request->country,
            'city' => $request->city,
            'post_code' => $request->postCode,
            'company' => $request->company ?? null,
            'email' => $request->email ?? null,
            'phone' => $request->phone,
            'address' => $request->address,
            'message' => $request->note,
            'address_type' => AddressTypeEnums::BILLING->value,
        ]);

        if (isset($request->different_shipping) && $request->different_shipping == 1) {
            self::create([
                'order_id' => $order->id,
                'name' => $request->shippingName,
                'country' => $request->shippingCountry,
                'city' => $request->shippingCity,
                'post_code' => $request->shippingPostCode,
                'company' => $request->shippingCompany ?? null,
                'email' => $request->shippingEmail ?? null,
                'phone' => $request->shippingPhone,
                'address' => $request->shippingAddress,
                'address_type' => AddressTypeEnums::SHIPPING->value,
            ]);
        }

        return $orderAddress;
    }
}
