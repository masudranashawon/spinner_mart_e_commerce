<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Repositories\MediaRepository;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::with('media')->latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'btn_text' => 'nullable|string|max:50',
            'btn_link' => 'nullable|string|max:255',
        ]);

        $media = MediaRepository::storeByRequest($request->file('image'), 'sliders');

        Slider::create([
            'media_id' => $media->id,
            'btn_text' => $request->btn_text,
            'btn_link' => $request->btn_link,
            'is_active' => true,
        ]);

        return back()->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'btn_text' => 'nullable|string|max:50',
            'btn_link' => 'nullable|string|max:255',
        ]);

        $data = [
            'btn_text' => $request->btn_text,
            'btn_link' => $request->btn_link,
        ];

        if ($request->hasFile('image')) {
            if ($slider->media) {
                MediaRepository::updateByRequest($request->file('image'), 'sliders', null, $slider->media);
            } else {
                $media = MediaRepository::storeByRequest($request->file('image'), 'sliders');
                $data['media_id'] = $media->id;
            }
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function toggleStatus(Slider $slider)
    {
        $slider->update(['is_active' => !$slider->is_active]);
        return back()->with('success', 'Slider status updated.');
    }

    public function destroy(Slider $slider)
    {
        MediaRepository::deleteByRequest($slider->media);
        $slider->delete();
        return back()->with('success', 'Slider deleted successfully.');
    }
}
