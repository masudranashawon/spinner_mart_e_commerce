<?php

namespace App\Repositories;

use App\Models\Brand;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;

class BrandRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        return Brand::class;
    }

    public static function storeByRequest(Request $request, $media): Brand
    {
        return self::create([
            "name" => $request->name,
            "slug" => $request->slug,
            "media_id" => $media?->id ?? null,
        ]);
    }
}
