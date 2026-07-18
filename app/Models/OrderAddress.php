<?php

namespace App\Models;

use App\Enums\AddressTypeEnums;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $guarded = ['id'];

    // protected function casts(): array
    // {
    //     return [
    //         'address_type' => AddressTypeEnums::class,
    //     ];
    // }

    // public function order()
    // {
    //     return $this->belongsTo(Order::class);
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
