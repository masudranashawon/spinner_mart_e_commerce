<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use App\Repositories\MediaRepository;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest("id")->get();

        return view("admin.brand.index", compact("brands"));
    }

    public function store(BrandRequest $request)
    {
        $media = null;

        if ($request->hasFile("image")) {
            $media = MediaRepository::storeByRequest($request->file("image"), "brand", "image");
        }

        $brand = BrandRepository::storeByRequest($request, $media);

        if ($brand) {
            return to_route("brand.index")->withSuccess("Brand created successfully");
        } else {
            return to_route("brand.index")->withError("Brand not created");
        }
    }

    public function edit(Brand $brand)
    {
        return view("admin.brand.edit", compact("brand"));
    }

    public function update(BrandRequest $request, Brand $brand)
    {
        $media = $brand->media;

        if ($request->hasFile("image")) {
            if ($brand?->media && Storage::exists($brand?->media?->src)) {
                $media = MediaRepository::updateByRequest($request->file("image"), "brand", "image", $brand->media);
            } else {
                $media = MediaRepository::storeByRequest($request->file("image"), "brand", "image");
            }
        }

        $brand = BrandRepository::updateByRequest($request, $brand, $media);

        if ($brand) {
            return to_route("brand.index")->withSuccess("Brand updated successfully");
        } else {
            return to_route("brand.index")->withError("Brand not updated");
        }
    }

    public function destroy(Brand $brand)
    {
        MediaRepository::deleteByRequest($brand->media);

        $deleted = $brand->delete();

        if ($deleted) {
            return to_route("brand.index")->withSuccess("Brand deleted successfully");
        } else {
            return to_route("brand.index")->withError("Brand not deleted");
        }
    }
}
