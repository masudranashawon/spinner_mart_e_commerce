<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->get();

        return view('admin.tag.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
        ]);

        $tag = Tag::create([
            'name' => $request->name,
        ]);

        if ($tag) {
            return to_route("tag.index")->withSuccess("Tag created successfully");
        } else {
            return to_route("tag.index")->withError("Tag not created");
        }
    }

    public function update(Request $request, Tag $tag)
    {
        if ($resp = $this->toastValidate($request, [
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ])) {
            return $resp; // validation fail → toast error
        }

        $tag->update([
            'name' => $request->name,
        ]);

        if ($tag) {
            return to_route("tag.index")->withSuccess("Tag updated successfully");
        } else {
            return to_route("tag.index")->withError("Tag not updated");
        }
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        if ($tag) {
            return to_route("tag.index")->withSuccess("Tag deleted successfully");
        } else {
            return to_route("tag.index")->withError("Tag not deleted");
        }
    }
}
