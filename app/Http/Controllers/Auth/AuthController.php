<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AuthEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email'    => 'required|email:rfc,dns',
            'password' => 'required|string|min:6',
        ]);


        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $user = User::where('email', $request->email)->where('password', Hash::make($request->password))->first();

        if (!$user && Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $user = Auth::user();
        }

        if (!$user->hasRole(AuthEnums::USER->value)) {
            Auth::logout();
            return back()->withError('Unauthorized access');
        }

        if ($user && $user->hasRole(AuthEnums::USER->value)) {
            Auth::login($user);
            return to_route('home')->withSuccess('Login successfully');
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerStore(AuthRequest $request)
    {
        $user = AuthRepository::storeByRequest($request);

        $user->assignRole(AuthEnums::USER->value);

        if ($user) {
            return to_route("home")->withSuccess("Register Successful");
        } else {
            return to_route("register")->withError("Register Failed");
        }
    }
}
