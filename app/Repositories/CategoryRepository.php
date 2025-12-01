<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\MediaRepository;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;

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
}
