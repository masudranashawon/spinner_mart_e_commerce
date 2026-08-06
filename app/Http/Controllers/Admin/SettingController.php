<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $groups = $request->input('group', []);

        $data = $request->except(['_token', '_method', 'group']);

        foreach ($data as $key => $value) {

            // Handle file uploads directly
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $path = $file->store('settings', 'public');
                $value = $path;

                // Delete old file to save server space
                $oldSetting = Setting::where('key', $key)->first();
                if ($oldSetting && $oldSetting->value && Storage::disk('public')->exists($oldSetting->value)) {
                    Storage::disk('public')->delete($oldSetting->value);
                }
            }

            // Save text or image path in the database, including the group
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => $groups[$key] ?? Setting::where('key', $key)->value('group') ?? 'general'
                ]
            );
        }

        // Clear cache so changes appear immediately
        Cache::forget('site_settings');

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
