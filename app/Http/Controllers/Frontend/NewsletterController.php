<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc,dns|max:255',
        ]);

        // Check if the email already exists in the subscribers table
        $subscriber = Subscriber::where('email', $request->email)->first();

        if ($subscriber) {
            return response()->json([
                'status' => 'error',
                'message' => 'You are already subscribed to our newsletter!'
            ]);
        }

        // Create a new subscriber
        Subscriber::create([
            'email' => $request->email,
            'is_active' => true
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Thanks for subscribing to our newsletter!'
        ]);
    }
}
