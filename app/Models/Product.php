<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $guarded = ["id"];

    public function details()
    {
        return $this->hasOne(ProductDetails::class);
    }

    public function galleries()
    {
        return $this->belongsToMany(
            Media::class,
            'product_galleries',
            'product_id',
            'media_id'
        )->withTimestamps();;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $baseSlug = Str::slug($product->name);
                $slug = $baseSlug;
                $count = 1;

                while (Product::where("slug", $slug)->exists()) {
                    $slug = $baseSlug . "-" . $count++;
                }

                $product->slug =   $slug;
            } else {
                $product->slug = Str::slug($product->slug);
            }
        });
    }
}
