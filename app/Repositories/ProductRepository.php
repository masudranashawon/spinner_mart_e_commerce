<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\ProductVariant;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\MediaRepository;
use Illuminate\Support\Facades\Storage;

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

        $discountPercent = 0;

        if ($request->discount_price) {
            $discountPercent = round(
                (($request->selling_price - $request->discount_price) / $request->selling_price) * 100
            );
        }

        $product = self::create([
            "name" => $request->name,
            "sku_code" => $request->product_sku,
            "buying_price" => $request->buying_price,
            "selling_price" => $request->selling_price,
            "discount_price" => $request->discount_price,
            "discount" => $discountPercent,
            "media_id" =>   $thumbnail->id ?? null,
        ]);

        ProductDetails::create([
            "product_id" => $product->id,
            "brand_id" => $request->brand,
            "category_id" => $request->category,
            "sub_category_id" => $request->sub_category,
            "short_description" => $request->short_description,
            "description" => $request->description,
            "additional_info" => $request->additional_information,
        ]);

        $tags = $request->tags;

        $product->tags()->sync($tags);

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

        ProductVariant::create([
            'product_id'    => $product->id,
            'size_id'       => null,
            'color_id'      => null,
            'sku_code'      => $product->sku_code,
            'buying_price'  => $product->buying_price,
            'selling_price' => $product->selling_price,
            "discount_price" => $request->discount_price,
            "discount" => $discountPercent,
        ]);

        return $product;
    }

    public static function updateByRequest(Request $request, Product $product): Product
    {
        return DB::transaction(function () use ($request, $product) {
            // Thumbnail update
            if ($request->hasFile('thumbnail')) {
                if ($product?->media && Storage::exists($product?->media?->src)) {
                    $thumbnail = MediaRepository::updateByRequest($request->file('thumbnail'), 'product', 'image', $product->media);
                } else {
                    $thumbnail = MediaRepository::storeByRequest($request->file('thumbnail'), 'product', 'image');
                }

                $product->media_id = $thumbnail->id;
                $product->save();
            }

            $discountPercent = 0;

            if ($request->discount_price) {
                $discountPercent = round(
                    (($request->selling_price - $request->discount_price) / $request->selling_price) * 100
                );
            }

            // Product main table
            $product->update([
                'name' => $request->name,
                'buying_price' => $request->buying_price,
                'selling_price' => $request->selling_price,
                "discount_price" => $request->discount_price,
                "discount" =>  $discountPercent,
            ]);

            // Product details table
            $product->details()->update([
                'brand_id' => $request->brand,
                'category_id' => $request->category,
                'sub_category_id' => $request->sub_category,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'additional_info' => $request->additional_information,
            ]);

            // Tags
            $product->refresh();

            if ($request->tags) {
                $product->tags()->sync($request->tags);
            }

            // Delete existing gallery images
            if ($request->deleted_gallery_ids) {

                $ids = explode(',', $request->deleted_gallery_ids);

                $medias = $product->galleries()
                    ->whereIn('media_id', $ids)
                    ->get();

                foreach ($medias as $media) {
                    MediaRepository::deleteByRequest($media);
                }

                $product->galleries()->detach($ids);
            }

            // Add new gallery images
            if ($request->hasFile('gallery_images')) {

                $mediaIds = [];

                foreach ($request->file('gallery_images') as $image) {
                    $media = MediaRepository::storeByRequest($image, 'product', 'image');
                    $mediaIds[] = $media->id;
                }

                if (count($mediaIds)) {
                    $product->galleries()->attach($mediaIds);
                }
            }

            return $product;
        });
    }
}
