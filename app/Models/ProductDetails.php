<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class ProductDetails extends Model
{
    protected $guarded = ["id"];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // public function thumbnail(): Attribute
    // {
    //     $url = asset("placeholder.jpg");

    //     if ($this->media && Storage::exists($this->media->src)) {
    //         $url = Storage::url($this->media->src);
    //     }

    //     return Attribute::make(
    //         get: fn() => $url,
    //     );
    // }
}
