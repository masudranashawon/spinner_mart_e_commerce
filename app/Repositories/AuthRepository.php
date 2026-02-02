<?php

namespace App\Repositories;

use App\Models\User;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        return User::class;
    }

    public static function storeByRequest(Request $request)
    {
        return  self::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}
