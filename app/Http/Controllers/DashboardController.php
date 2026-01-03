<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
use Auth;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get user's resumes
        $resumes = Resume::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $totalResumes = Resume::where('user_id', $user->id)->count();

        // Check subscription status
        $hasActiveSubscription = $user->package_id &&
            $user->package_ends_at &&
            $user->package_ends_at > now();

        return view('dashboard.index', compact(
            'user',
            'resumes',
            'totalResumes',
            'hasActiveSubscription'
        ));
    }
}
