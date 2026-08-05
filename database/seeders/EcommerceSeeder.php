<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{Setting, Category, SubCategory, Brand, Color, Size, Tag, Product, ProductDetails, ProductVariant};
use Faker\Factory as Faker;

class EcommerceSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Site Settings (Key-Value Pair)
        $settings = [
            // Branding
            ['key' => 'store_name', 'value' => 'Spinner Fashion', 'group' => 'branding'],
            ['key' => 'store_tagline', 'value' => 'Premium Modern Clothing', 'group' => 'branding'],
            ['key' => 'site_logo', 'value' => 'frontend/assets/images/logo.svg', 'group' => 'branding'],
            ['key' => 'footer_logo', 'value' => 'frontend/assets/images/logo-2.svg', 'group' => 'branding'],
            ['key' => 'site_favicon', 'value' => 'frontend/assets/images/favicon.png', 'group' => 'branding'],
            // Contact
            ['key' => 'phone', 'value' => '+880 1711-000000', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'support@spinnerfashion.com', 'group' => 'contact'],
            ['key' => 'address', 'value' => 'Dhanmondi, Dhaka, Bangladesh', 'group' => 'contact'],
            // Order & Delivery
            ['key' => 'tax_percentage', 'value' => '5', 'group' => 'order'],
            ['key' => 'shipping_inside_dhaka', 'value' => '60', 'group' => 'order'],
            ['key' => 'shipping_outside_dhaka', 'value' => '120', 'group' => 'order'],
            ['key' => 'invoice_prefix', 'value' => 'ORD-', 'group' => 'order'],
            // Currency
            ['key' => 'currency_symbol', 'value' => '৳', 'group' => 'currency'],
            ['key' => 'currency_code', 'value' => 'BDT', 'group' => 'currency'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
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
                'discount_price' => $faker->boolean(50) ? $selling_price - 100 : 0,
                'is_active' => true,
                'rating' => $faker->numberBetween(3, 5),
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
