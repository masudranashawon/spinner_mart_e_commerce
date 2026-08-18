<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Slider extends Model
{
    protected $guarded = ['id'];
    
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    // Thumbnail Accessor 
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
}
