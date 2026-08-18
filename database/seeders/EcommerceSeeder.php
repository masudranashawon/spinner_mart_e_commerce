<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{Setting, Category, SubCategory, Brand, Color, Media, Size, Tag, Product, ProductDetails, ProductVariant, Slider};
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Cache;

class EcommerceSeeder extends Seeder
{
    public function run(): void
    {
        Cache::forget('site_settings');

        $faker = Faker::create();

        // Site Settings (Key-Value Pair)
        $settings = [
            // Branding
            ['key' => 'store_name', 'value' => 'Spinner Mart', 'group' => 'branding'],
            ['key' => 'store_tagline', 'value' => 'Premium Modern Clothing', 'group' => 'branding'],
            ['key' => 'site_logo', 'value' => 'frontend/assets/images/logo.png', 'group' => 'branding'],
            ['key' => 'footer_logo', 'value' => 'frontend/assets/images/logo-2.png', 'group' => 'branding'],
            ['key' => 'site_favicon', 'value' => 'frontend/assets/images/favicon.png', 'group' => 'branding'],
            ['key' => 'footer_about_text', 'value' => 'Spinner Mart brings trendy fashion, premium quality, and affordable prices for every style. Shop clothing, footwear, watches, and accessories confidently.', 'group' => 'branding'],
            // Contact
            ['key' => 'phone', 'value' => '+880 1711-000000', 'group' => 'contact'],
            ['key' => 'secondary_phone', 'value' => '+880 1911-000000', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'support@spinnerfashion.com', 'group' => 'contact'],
            ['key' => 'address', 'value' => 'Dhanmondi, Dhaka, Bangladesh', 'group' => 'contact'],
            ['key' => 'address_map', 'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3689.791320041214!2d91.80976827586767!3d22.361507040672958!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30acd93610428915%3A0xad43a0cf6701a547!2sSpinner%20Fashion!5e0!3m2!1sen!2sbd!4v1786905989125!5m2!1sen!2sbd" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>', 'group' => 'contact'],
            // Order & Delivery
            ['key' => 'vat_percentage', 'value' => '5', 'group' => 'order'],
            ['key' => 'shipping_inside_dhaka', 'value' => '60', 'group' => 'order'],
            ['key' => 'return_policy_days', 'value' => '7', 'group' => 'order'],
            ['key' => 'shipping_outside_dhaka', 'value' => '120', 'group' => 'order'],
            ['key' => 'invoice_prefix', 'value' => 'SP-', 'group' => 'order'],
            // Currency
            ['key' => 'currency_symbol', 'value' => '৳', 'group' => 'currency'],
            ['key' => 'currency_code', 'value' => 'BDT', 'group' => 'currency'],
            // Announcement
            ['key' => 'enable_announcement_bar', 'value' => '1', 'group' => 'enable_announcement_bar'],
            ['key' => 'announcement_text', 'value' => 'Exclusive Deals Available for a Limited Time.', 'group' => 'enable_announcement_bar'],
            ['key' => 'announcement_link', 'value' => '/products', 'group' => 'enable_announcement_bar'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // Hero Sliders Seeder
        for ($i = 1; $i <= 3; $i++) {
            // Media Creation
            $media = Media::create([
                'type' => 'image',
                'src' => "frontend/assets/images/slider/slide-$i.jpg",
                'name' => "Slide $i",
                'extension' => 'jpg',
            ]);

            // Slider Creation
            Slider::create([
                'title' => 'Mega Sale - Up to'.$i.'0% Off',
                'media_id' => $media->id,
                'btn_text' => 'Shop Now',
                'btn_link' => '/shop',
                'is_active' => true,
            ]);
        }

        // Colors, Sizes, Tags & Brands
        $colors = ['Black' => '#000000', 'White' => '#FFFFFF', 'Red' => '#FF0000', 'Blue' => '#0000FF'];
        foreach ($colors as $name => $code) {
            Color::updateOrCreate(['color_code' => $code], ['name' => $name]);
        }

        $sizes = ['S', 'M', 'L', 'XL'];
        foreach ($sizes as $size) {
            Size::updateOrCreate(['name' => $size]);
        }

        $tags = ['Trending', 'New Arrival', 'Winter Collection', 'Summer Vibes'];
        foreach ($tags as $tag) {
            Tag::updateOrCreate(['name' => $tag]);
        }

        for ($i = 1; $i <= 5; $i++) {
            Brand::updateOrCreate(['slug' => Str::slug("Brand $i")], ['name' => "Brand $i"]);
        }

        // Sub Categories 
        $categories = Category::all();
        if ($categories->count() > 0) {
            foreach ($categories as $category) {
                for ($j = 1; $j <= 3; $j++) {
                    SubCategory::updateOrCreate([
                        'slug' => Str::slug($category->name . " SubCat $j")
                    ], [
                        'category_id' => $category->id,
                        'name' => $category->name . " SubCat $j",
                    ]);
                }
            }
        }

        // Products, Product Details & Variants (Without Media)
        for ($i = 1; $i <= 15; $i++) {
            $name = $faker->words(3, true);
            $selling_price = $faker->numberBetween(500, 3000);

            // Product Creation
            $product = Product::create([
                'name' => ucfirst($name),
                'slug' => Str::slug($name) . '-' . rand(1000, 9999),
                'sku_code' => 'SKU-' . strtoupper(Str::random(6)),
                'selling_price' => $selling_price,
                'discount_price' => $faker->boolean(50) ? $selling_price - 100 : null,
                'is_active' => true,
                'sold_count' => rand(5, 50),
            ]);

            // Attach Tags
            $product->tags()->attach(Tag::inRandomOrder()->take(1)->pluck('id'));

            // Product Details
            ProductDetails::create([
                'product_id' => $product->id,
                'brand_id' => Brand::inRandomOrder()->first()->id ?? null,
                'category_id' => Category::inRandomOrder()->first()->id,
                'sub_category_id' => SubCategory::inRandomOrder()->first()->id ?? null,
                'short_description' => $faker->text(150),
                'description' => $faker->paragraph(4),
            ]);

            // Product Variants
            $variantCount = rand(2, 3);
            for ($v = 1; $v <= $variantCount; $v++) {
                ProductVariant::create([
                    'sku_code' => $product->sku_code . '-V' . $v,
                    'product_id' => $product->id,
                    'color_id' => Color::inRandomOrder()->first()->id,
                    'size_id' => Size::inRandomOrder()->first()->id,
                    'selling_price' => $product->selling_price,
                    'discount_price' => $product->discount_price,
                    'current_stock' => rand(0, 50),
                ]);
            }
        }
    }
}
