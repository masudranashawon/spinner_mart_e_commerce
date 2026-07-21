<?php

namespace App\Models;

use App\Enums\AddressTypeEnums;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function getDisplayAddressAttribute()
    {
        $address = $this->addresses->firstWhere('address_type', AddressTypeEnums::SHIPPING->value);

        // If no shipping address, use billing address
        if (!$address) {
            $address = $this->addresses->firstWhere('address_type', AddressTypeEnums::BILLING->value);
        }

        return $address;
    }

    // public function coupon()
    // {
    //     return $this->belongsTo(Coupon::class);
    // }

    protected static function booted()
    {
        static::creating(function ($order) {

            $yearMonth = Carbon::now()->format('ym');
            $prefix = 'SP-' . $yearMonth . '-'; // OUTPUT: #SP-2026-

            // find last order
            $lastOrder = self::where('order_number', 'LIKE', $prefix . '%')
                ->orderBy('id', 'desc')
                ->first();

            // get last order number
            if ($lastOrder) {
                $lastNumber = intval(substr($lastOrder->order_number, -4));
                $nextNumber = $lastNumber + 1;
            } else {
                // if no order found, start from 1
                $nextNumber = 1;
            }

            // set order code
            $order->order_number = $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }
}
