<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Repositories\MediaRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('web')->user();

        return view('admin.profile.index', compact('user'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = auth('web')->user();
        $media = $user->media;

        if ($request->hasFile("thumbnail")) {
            if ($user?->media && Storage::exists($user?->media?->src)) {
                $media = MediaRepository::updateByRequest($request->file("thumbnail"), "user", "image", $user->media);
            } else {
                $media = MediaRepository::storeByRequest($request->file("thumbnail"), "user", "image");
            }
        }

        UserRepository::updateProfile($user, $request,  $media);

        return back()->withSuccess('Profile updated successfully.');
    }

    public function updatePassword(PasswordUpdateRequest $request)
    {
        $user = $request->user();

        UserRepository::updatePassword($user, $request->password);

        return back()->withSuccess('Password updated successfully.');
    }
}
