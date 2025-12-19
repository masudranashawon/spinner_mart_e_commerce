<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    protected $guarded = ["id"];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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

        static::creating(function ($subCategory) {
            if (empty($subCategory->slug)) {
                $baseSlug = Str::slug($subCategory->name);
                $slug = $baseSlug;
                $count = 1;

                while (SubCategory::where("slug", $slug)->exists()) {
                    $slug = $baseSlug . "-" . $count++;
                }

                $subCategory->slug =   $slug;
            } else {
                $subCategory->slug = Str::slug($subCategory->slug);
            }
        });
    }
}
