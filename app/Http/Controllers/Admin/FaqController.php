<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();

        return view('admin.faq.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        Faq::create([
            "question" => $request->question,
            "answer" => $request->answer,
        ]);

        return back()->with('success', 'FAQ created successfully.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $faq->update(
            [
                "question" => $request->question,
                "answer" => $request->answer,
            ]
        );

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function toggleStatus(Faq $faq)
    {
        $faq->update(['is_active' => !$faq->is_active]);

        return back()->with('success', 'FAQ status updated.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        
        return back()->with('success', 'FAQ deleted successfully.');
    }
}
