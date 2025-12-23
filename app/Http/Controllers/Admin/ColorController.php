<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
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
        $color->delete();

        if ($color) {
            return to_route("color.index")->withSuccess("Color deleted successfully");
        } else {
            return to_route("color.index")->withError("Color not deleted");
        }
    }
}
