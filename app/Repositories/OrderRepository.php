<?php

namespace App\Repositories;

use Arafat\LaravelRepository\Repository;
use Illuminate\Http\Request;

class OrderRepository extends Repository
{
    /**
     * base method
     *
     * @method model()
     */
    public static function model()
    {
        //return User::class;
    }

    public static function storeByRequest(Request $request)
    {
       self::create([
            //
       ]);
    }
}
