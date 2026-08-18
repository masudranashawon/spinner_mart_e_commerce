<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('get_setting')) {
    function get_setting(string $key, $default = null)
    {
        $settings = Cache::rememberForever('site_settings', function () {
            return Setting::pluck('value', 'key')->toArray();
        });

        $value = $settings[$key] ?? $default;
        $isImage = in_array($key, ['site_logo', 'site_favicon', 'footer_logo'])
            || str_ends_with($key, '_image')
            || str_ends_with($key, '_logo');

        if ($isImage && $value) {
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

if (!function_exists('format_price')) {
    /**
     * Format the price with dynamic currency symbol and optional decimals.
     *
     * @param float|int $amount
     * @param bool $showDecimals
     * @return string
     */
    function format_price($amount, $showDecimals = true)
    {
        // Retrieve the currency symbol from settings, defaulting to '৳' if not set
        $symbol = get_setting('currency_symbol', '৳');

        // Determine the number of decimal places based on the $showDecimals parameter
        $decimals = $showDecimals ? 2 : 0;

        // Format the amount with the specified number of decimal places
        $formattedAmount = number_format((float) $amount, $decimals);

        return $symbol . $formattedAmount;
    }
}
