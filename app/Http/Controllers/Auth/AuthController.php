<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AuthEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        // Attempt login
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (!$user->hasRole(AuthEnums::USER->value)) {
                Auth::logout();
                return back()->withErrors('Unauthorized access');
            }

            return redirect()->route('home')->withSuccess('Login successfully');
        }

        return back()->withErrors('Invalid credentials');
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

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('home')->withSuccess('Logout successfully');
    }
}
