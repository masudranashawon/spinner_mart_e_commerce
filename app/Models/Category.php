<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $guarded = ["id"];

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
}
