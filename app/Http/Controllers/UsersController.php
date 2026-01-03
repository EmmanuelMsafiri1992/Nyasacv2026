<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::query();

        if ($request->filled('search')) {
            $data->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        // Filter by email verification status
        if ($request->filled('verified')) {
            if ($request->verified == 'yes') {
                $data->whereNotNull('email_verified_at');
            } elseif ($request->verified == 'no') {
                $data->whereNull('email_verified_at');
            }
        }

        // Get statistics
        $totalUsers = User::count();
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();
        $subscribedUsers = User::whereNotNull('package_id')
            ->where('package_ends_at', '>', now())
            ->count();

        $data = $data->paginate(10);

        return view('users.index', compact(
            'data',
            'totalUsers',
            'verifiedUsers',
            'subscribedUsers'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create()
    {
        $packages = Package::all();

        return view('users.create', compact(
            'packages'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'            => [
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
            'email'           => 'required|email|max:255|unique:users',
            'password'        => 'required|string|min:6|same:password_confirmation',
            'trial_ends_at'   => 'nullable|date',
            'package_ends_at' => 'nullable|date',
        ]);

        $request->request->add([
            'password' => Hash::make($request->password),
        ]);

        if (!$request->filled('is_admin')) {
            $request->request->add([
                'is_admin' => false,
            ]);
        } else {
            $request->request->add([
                'is_admin' => true,
            ]);
        }

        // Handle email verification
        if ($request->filled('email_verified') && $request->email_verified == 1) {
            $request->request->add([
                'email_verified_at' => now(),
            ]);
        }

        $user = User::create($request->all());

        return redirect()->route('settings.users.index')
            ->with('success', __('Created successfully'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $packages = Package::all();

        return view('users.edit', compact(
            'user',
            'packages'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'            => [
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
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'password'        => 'nullable|string|min:6|same:password_confirmation',
            'trial_ends_at'   => 'nullable|date',
            'package_ends_at' => 'nullable|date',
        ]);

        if ($request->filled('password')) {
            $request->request->add([
                'password' => Hash::make($request->password),
            ]);
        } else {
            $request->request->remove('password');
        }

        if (!$request->filled('is_admin')) {
            $request->request->add([
                'is_admin' => false,
            ]);
        }

        // Handle email verification
        if ($request->filled('email_verified') && $request->email_verified == 1) {
            if (!$user->email_verified_at) {
                $request->request->add([
                    'email_verified_at' => now(),
                ]);
            }
        } else {
            $request->request->add([
                'email_verified_at' => null,
            ]);
        }

        $user->update($request->all());

        return redirect()->route('settings.users.edit', $user)
            ->with('success', __('Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if ($request->user()->id == $user->id) {
            return redirect()->route('settings.users.index')
                ->with('error', __('You can\'t remove yourself.'));
        }

        $user->delete();

        return redirect()->route('settings.users.index')
            ->with('success', __('Deleted successfully'));
    }

    /**
     * Delete all non-verified users.
     */
    public function deleteUnverified(Request $request)
    {
        // Get count of non-verified users (excluding admins)
        $unverifiedUsers = User::whereNull('email_verified_at')
            ->where('is_admin', false)
            ->get();

        $count = $unverifiedUsers->count();

        if ($count === 0) {
            return redirect()->route('settings.users.index')
                ->with('info', __('No unverified users found to delete.'));
        }

        // Delete the users
        foreach ($unverifiedUsers as $user) {
            // Make sure we're not deleting the current user or admins
            if ($user->id !== $request->user()->id && !$user->is_admin) {
                $user->delete();
            }
        }

        return redirect()->route('settings.users.index')
            ->with('success', __(':count unverified users deleted successfully.', ['count' => $count]));
    }

    /**
     * Resend verification email to a user.
     */
    public function resendVerification(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        // Check if user is already verified
        if ($user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => __('User email is already verified.')
            ]);
        }

        try {
            // Send verification notification
            $user->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'message' => __('Verification email sent successfully.')
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Failed to send verification email: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => __('Failed to send verification email: ') . $e->getMessage()
            ]);
        }
    }

    public function profile(Request $request)
    {
        $user = $request->user();
        return view('auth.profile', compact(
            'user'));
    }

    public function profile_update(Request $request)
    {
        $request->validate([
            'name'     => [
                'required',
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
            'password' => 'same:password_confirmation',
        ]);

        if ($request->filled('password')) {
            $request->request->add([
                'password' => Hash::make($request->password),
            ]);
        } else {
            $request->request->remove('password');
        }

        $request->user()->update($request->all());

        return redirect()->route('profile.index')
            ->with('success', __('Updated successfully'));
    }
}
