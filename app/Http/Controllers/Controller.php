<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

abstract class Controller
{
    protected function toastValidate(Request $request, array $rules)
    {
        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->with('error', collect($e->errors())->flatten()->first());
        }

        return null;
    }
}
