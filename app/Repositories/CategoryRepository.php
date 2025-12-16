<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\MediaRepository;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        return Category::class;
    }

    public static function storeByRequest(Request $request): Category
    {
        if ($request->hasFile("image")) {
            $categoryImage = null;

            $categoryImage = (new MediaRepository())->storeByRequest($request->file("image"), "category");
        }

        return self::create([
            "name" => $request->name,
            "slug" => $request->slug,
            "media_id" =>  $categoryImage->id ?? null,
        ]);
    }

    public static function updateByRequest($request, Category $category): Category
    {
        $categoryImage = $category->media;

        if ($request->hasFile("image")) {
            if ($category?->media && Storage::exists($category?->media?->src)) {
                $categoryImage = MediaRepository::updateByRequest($request->file("image"), "category", "image", $category->media);
            } else {
                $categoryImage = MediaRepository::storeByRequest($request->file("image"), "category");
            }
        }

        $category->update([
            "name" => $request->name,
            "slug" => $request->slug,
            "media_id" =>  $categoryImage->id ?? null,
        ]);

        return $category;
    }
}
