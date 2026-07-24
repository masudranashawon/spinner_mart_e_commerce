<?php

namespace App\Repositories;

use App\Models\Media;
use App\Models\User;
use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository extends Repository
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

    public static function updateProfile(User $user, Request $request, ?Media $media = null): User
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            "media_id" =>  $media?->id ?? null,
        ]);

        return $user;
    }

    public static function updatePassword(User $user, string $password): User
    {
        $user->update([
            'password' => Hash::make($password),
        ]);

        return $user;
    }
}
