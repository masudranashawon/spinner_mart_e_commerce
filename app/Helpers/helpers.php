<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (!function_exists('get_setting')) {
    function get_setting(string $key, $default = null)
    {
        $settings = Cache::rememberForever('site_settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });

        $value = $settings[$key] ?? $default;
        $imageKeys = ['site_logo', 'site_favicon', 'footer_logo'];

        if (in_array($key, $imageKeys) && $value) {
            // External URL (http/https)
            if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
                return $value;
            }

            // Uploaded file from Admin (Storage)
            if (Storage::disk('public')->exists($value)) {
                return Storage::url($value);
            }

            // Default Theme Asset (From Seeder)
            if (file_exists(public_path($value))) {
                return asset($value);
            }

            // Fallback Placeholder
            return asset('placeholder.jpg');
        }

        return $value;
    }
}
