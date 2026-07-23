<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductVariant extends Model
{
    protected $guarded = ["id"];

    protected $casts = [
        'selling_price' => 'decimal:2',
        'buying_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'discount' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stocks()
    {
        return $this->hasMany(InventoryStock::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
