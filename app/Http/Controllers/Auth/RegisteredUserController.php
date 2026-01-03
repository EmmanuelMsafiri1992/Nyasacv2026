<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AdminNewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:30',
                'regex:/^[a-zA-Z\s\-\'\.]+$/',
                function ($attribute, $value, $fail) {
                    // Block URLs, links, and common spam patterns
                    if (preg_match('/(https?:\/\/|www\.|\.com|\.net|\.org|\.io|\.co|http)/i', $value)) {
                        $fail(__('The :attribute cannot contain URLs or links.'));
                    }
                    // Block common spam patterns
                    if (preg_match('/(\$\d+|\d+\$|payment|confirm|transaction|click here|hs=|xxx)/i', $value)) {
                        $fail(__('The :attribute contains invalid content.'));
                    }
                },
            ],
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Notify admin about new registration
        Notification::route('mail', 'info@nyasacv.com')
            ->notify(new AdminNewUserNotification($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
