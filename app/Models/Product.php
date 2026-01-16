<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $guarded = ["id"];

    public function details()
    {
        return $this->hasOne(ProductDetails::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function galleries()
    {
        return $this->belongsToMany(
            Media::class,
            'product_galleries',
            'product_id',
            'media_id'
        );
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tags',
            'product_id',
            'tag_id'
        );
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function thumbnail(): Attribute
    {
        $url = asset("placeholder.jpg");

        if ($this->media && Storage::exists($this->media->src)) {
            $url = Storage::url($this->media->src);
        }

        return Attribute::make(
            get: fn() => $url,
        );
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
