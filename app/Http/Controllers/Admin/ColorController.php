<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::latest()->get();

        return view('admin.color.index', compact('colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color_code' => 'required|string|max:7|unique:colors,color_code',
        ]);

        $color = Color::create([
            'name' => $request->name,
            'color_code' => $request->color_code,
        ]);

        if ($color) {
            return to_route("color.index")->withSuccess("Color created successfully");
        } else {
            return to_route("color.index")->withError("Color not created");
        }
    }

    public function update(Request $request, Color $color)

    {
        if ($resp = $this->toastValidate($request, [
            'name' => 'required|string|max:255',
            'color_code' => 'required|string|max:7|unique:colors,color_code,' . $color->id,
        ])) {
            return $resp; // validation fail → toast error
        }

        $color->update([
            "name" => $request->name,
            "color_code" => $request->color_code,
        ]);

        if ($color) {
            return to_route("color.index")->withSuccess("Color updated successfully");
        } else {
            return to_route("color.index")->withError("Color not updated");
        }
    }

    public function destroy(Color $color)
    {
        $hasProducts = ProductVariant::where('color_id', $color->id)->exists();

        if ($hasProducts) {
            return back()->withError("This color cannot be deleted because it is associated with existing products. Please remove them first.");
        }

        // If there are no products, delete the color
        $isDeleted = $color->delete();

        if ($isDeleted) {
            return to_route("color.index")->withSuccess("Color deleted successfully");
        } else {
            return back()->withError("Color not deleted");
        }
    }
}
