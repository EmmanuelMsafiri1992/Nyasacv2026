<?php

namespace App\Http\Controllers;

use App\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid email address.'
            ], 422);
        }

        try {
            // Check if already subscribed
            $existing = NewsletterSubscriber::where('email', $request->email)->first();

            if ($existing) {
                if ($existing->status === 'active') {
                    return response()->json([
                        'success' => false,
                        'message' => 'This email is already subscribed to our newsletter.'
                    ], 409);
                } else {
                    // Resubscribe
                    $existing->resubscribe();
                    return response()->json([
                        'success' => true,
                        'message' => 'Welcome back! You\'ve been resubscribed to our newsletter.'
                    ]);
                }
            }

            // Create new subscriber
            NewsletterSubscriber::create([
                'email' => $request->email,
                'name' => $request->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing! Check your inbox for career tips and resources.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again later.'
            ], 500);
        }
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe($token)
    {
        $subscriber = NewsletterSubscriber::where('token', $token)->first();

        if (!$subscriber) {
            return view('newsletter.unsubscribe-error');
        }

        if ($subscriber->status === 'unsubscribed') {
            return view('newsletter.already-unsubscribed', compact('subscriber'));
        }

        $subscriber->unsubscribe();

        return view('newsletter.unsubscribed', compact('subscriber'));
    }
}
