<?php

namespace App\Models;

use App\Enums\Enums\OrderStatusEnums;
use App\Enums\Enums\PaymentMethodEnums;
use App\Enums\Enums\PaymentStatusEnums;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'payment_method' => PaymentMethodEnums::class,
        'payment_status' => PaymentStatusEnums::class,
        'order_status' => OrderStatusEnums::class,
        'placed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function items()
    // {
    //     return $this->hasMany(OrderItem::class);
    // }

    // public function addresses()
    // {
    //     return $this->hasMany(OrderAddress::class);
    // }

    // public function coupon()
    // {
    //     return $this->belongsTo(Coupon::class);
    // }
}
