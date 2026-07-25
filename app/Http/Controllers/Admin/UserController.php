<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AuthEnums;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $userId = auth('web')->user()->id;
        $users = User::where('id', '!=', $userId)->latest()->get();

        return view('admin.customer.index', compact("users"));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'is_active' => 'required|boolean',
            'role'      => 'nullable|in:' . AuthEnums::USER->value . ',' . AuthEnums::ADMIN->value,
        ]);

        $user->update([
            'is_active' => $request->is_active,
        ]);

        if ($request->filled('role')) {
            $user->syncRoles([$request->role]);
        }

        return back()->with('success', 'Customer info updated successfully.');
    }
}
