<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventAdminShopping
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = auth('web')->user();

        // Check if the user is authenticated and has the 'admin' role & request is an AJAX request
        if ($user && $user->hasRole('admin')) {

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Admins cannot perform shopping actions!'
                ], 400); // Return a JSON response for AJAX requests
            }

            // Redirect the admin user to a specific page or return an error response
            return redirect()->back()->with('error', 'Admins cannot perform shopping actions! Please use a customer account.');
        }

        return $next($request);
    }
}
