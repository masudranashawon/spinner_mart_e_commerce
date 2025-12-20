<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use App\Repositories\MediaRepository;
use Illuminate\Http\Request;

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
}
