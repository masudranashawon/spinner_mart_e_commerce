<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductDetails;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;

class ProductRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        return Product::class;
    }

    public static function storeByRequest(Request $request): Product
    {
        if ($request->hasFile("thumbnail")) {
            $thumbnail = null;

            $thumbnail = MediaRepository::storeByRequest($request->file("thumbnail"), "product", "image");
        }

        $product = self::create([
            "name" => $request->name,
            "sku_code" => $request->product_sku,
            "buying_price" => $request->buying_price,
            "selling_price" => $request->selling_price,
            "discount" => 0,
            "media_id" =>   $thumbnail->id ?? null,
        ]);

        $productDetails = ProductDetails::create([
            "product_id" => $product->id,
            "brand_id" => $request->brand,
            "category_id" => $request->category,
            "sub_category_id" => $request->sub_category,
            "short_description" => $request->short_description,
            "description" => $request->description,
            "additional_info" => $request->additional_information,
        ]);

        $galleryImages = $request->file("gallery_images");
        $mediaIds = [];

        if ($galleryImages) {
            foreach ($galleryImages as $image) {
                $media = MediaRepository::storeByRequest($image, "product", "image");
                $mediaIds[] = $media->id;
            }
        }

        if ($mediaIds > 0) {
            $product->galleries()->sync($mediaIds);
        }

        return $product;
    }
}
