<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        Page::create([
            // slug will be auto-generated from the title, so no need to update it manually
            'title' => $request->title,
            'content' => $request->content,
            'show_in_footer' => $request->has('show_in_footer'),
            'is_active' => true,
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $page->update([
            // slug will be auto-generated from the title, so no need to update it manually
            'title' => $request->title,
            'content' => $request->content,
            'show_in_footer' => $request->has('show_in_footer'),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    // Status toggle
    public function toggleStatus(Page $page)
    {
        $page->update(['is_active' => !$page->is_active]);
        return back()->with('success', 'Page status updated.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success', 'Page deleted successfully.');
    }
}
