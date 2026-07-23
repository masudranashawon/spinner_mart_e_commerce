<?php

namespace App\Models;

use App\Enums\CouponTypeEnums;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded =["id"];

    protected $casts = [
        'coupon_type' => CouponTypeEnums::class,
        'discount' => 'decimal:2',
        'min_amount' => 'decimal:2',
    ];
}
