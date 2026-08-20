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

    // Thumbnail Accessor Updated
    public function thumbnail(): Attribute
    {
        return Attribute::make(
            get: function () {
                $url = asset("placeholder.jpg");

                if ($this->media && $this->media->src) {
                    $src = $this->media->src;

                    // External URL
                    if (str_starts_with($src, 'http://') || str_starts_with($src, 'https://')) {
                        $url = $src;
                    }
                    
                    // Uploaded from Admin (Storage)
                    elseif (Storage::disk('public')->exists($src)) {
                        $url = Storage::url($src);
                    }
                    // Default Theme Asset (From Seeder in public folder)
                    elseif (file_exists(public_path($src))) {
                        $url = asset($src);
                    }
                }

                return $url;
            }
        );
    }
}
