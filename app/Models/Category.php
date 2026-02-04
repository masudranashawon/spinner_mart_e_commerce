<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $guarded = ["id"];

    public function media()
    {
        return  $this->belongsTo(Media::class);
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

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $baseSlug = Str::slug($category->name);
                $slug = $baseSlug;
                $count = 1;

                while (Category::where("slug", $slug)->exists()) {
                    $slug = $baseSlug . "-" . $count++;
                }

                $category->slug =   $slug;
            } else {
                $category->slug = Str::slug($category->slug);
            }
        });
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
