<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Symfony\Component\Clock\now;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Category::query()->delete();

        $data = [
            [
                "id" => 1,
                "name" => "Men",
                "slug" => "men",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "id" => 2,
                "name" => "Women",
                "slug" => "women",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "id" => 3,
                "name" => "Kids",
                "slug" => "kids",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "id" => 4,
                "name" => "Footwear",
                "slug" => "footwear",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "id" => 5,
                "name" => "Bags & Backpacks",
                "slug" => "bags-backpacks",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "id" => 6,
                "name" => "Watches",
                "slug" => "watches",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "id" => 7,
                "name" => "Accessories",
                "slug" => "accessories",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "id" => 8,
                "name" => "Winter Collection",
                "slug" => "winter-collection",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "id" => 9,
                "name" => "New Arrivals",
                "slug" => "new-arrivals",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "id" => 10,
                "name" => "Best Selling",
                "slug" => "best-selling",
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ];

        Category::insert($data);
    }
}
