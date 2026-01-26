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

        $data = [
            [
                "name" => "Men",
                "slug" => "men",
            ],
            [
                "name" => "Women",
                "slug" => "women",
            ],
            [
                "name" => "Kids",
                "slug" => "kids",
            ],
            [
                "name" => "Footwear",
                "slug" => "footwear",
            ],
            [
                "name" => "Accessories",
                "slug" => "accessories",
            ],

        ];

        foreach ($data as $category) {
            Category::updateOrCreate([
                'name' => $category['name'],
            ], $category);
        }
    }
}
