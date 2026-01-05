<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $guarded = ["id"];

    public function galleryUrl(): Attribute
    {
        $url = asset("placeholder.jpg");

        if (Storage::exists($this->src)) {
            $url = Storage::url($this->src);
        }

        return Attribute::make(
            get: fn() => $url,
        );
    }
}
