<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AuthEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Repositories\AuthRepository;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
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
