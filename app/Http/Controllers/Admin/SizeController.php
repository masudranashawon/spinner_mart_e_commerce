<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::latest()->get();

        return view('admin.size.index', compact('sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name',
        ]);

        $size = Size::create([
            'name' => $request->name,
        ]);

        if ($size) {
            return to_route("size.index")->withSuccess("Size created successfully");
        } else {
            return to_route("size.index")->withError("Size not created");
        }
    }


    public function update(Request $request, Size $size)
    {
        if ($resp = $this->toastValidate($request, [
            'name' => 'required|string|max:255|unique:sizes,name,' . $size->id,
        ])) {
            return $resp; // validation fail → toast error
        }

        $size->update([
            'name' => $request->name,
        ]);

        if ($size) {
            return to_route("size.index")->withSuccess("Size updated successfully");
        } else {
            return to_route("size.index")->withError("Size not updated");
        }
    }


    public function destroy(Size $size)
    {
        $size->delete();

        if ($size) {
            return to_route("size.index")->withSuccess("Size deleted successfully");
        } else {
            return to_route("size.index")->withError("Size not deleted");
        }
    }
}
