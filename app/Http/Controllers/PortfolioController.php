<?php

namespace App\Http\Controllers;

use App\Portfolio;
use App\PortfolioSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    /**
     * Display a listing of user's portfolios
     */
    public function index()
    {
        // Check if user has active subscription
        if (!Auth::user()->subscribed() && !Auth::user()->is_admin) {
            return redirect()->route('billing.index')
                           ->with('error', 'You need an active subscription to create portfolios.');
        }

        $portfolios = Auth::user()->portfolios()->latest()->get();
        return view('portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new portfolio
     */
    public function create()
    {
        // Check if user has active subscription
        if (!Auth::user()->subscribed() && !Auth::user()->is_admin) {
            return redirect()->route('billing.index')
                           ->with('error', 'You need an active subscription to create portfolios.');
        }

        $themes = [
            'professional' => 'Professional',
            'creative' => 'Creative',
            'minimal' => 'Minimal',
            'modern' => 'Modern',
            'elegant' => 'Elegant'
        ];

        $layouts = [
            'default' => 'Default',
            'sidebar' => 'Sidebar',
            'grid' => 'Grid',
            'timeline' => 'Timeline'
        ];

        return view('portfolios.create', compact('themes', 'layouts'));
    }

    /**
     * Store a newly created portfolio
     */
    public function store(Request $request)
    {
        if (!Auth::user()->subscribed() && !Auth::user()->is_admin) {
            return redirect()->route('billing.index')
                           ->with('error', 'You need an active subscription to create portfolios.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'theme' => 'required|string',
            'layout' => 'required|string',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'profile_photo' => 'nullable|image|max:2048',
            'cover_photo' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($request->title) . '-' . Str::random(6);

        // Handle photo uploads
        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('portfolios/profiles', 'public');
        }

        if ($request->hasFile('cover_photo')) {
            $validated['cover_photo'] = $request->file('cover_photo')->store('portfolios/covers', 'public');
        }

        // Handle social links
        $socialLinks = [];
        foreach (['linkedin', 'twitter', 'github', 'behance', 'dribbble', 'instagram'] as $platform) {
            if ($request->filled($platform)) {
                $socialLinks[$platform] = $request->input($platform);
            }
        }
        $validated['social_links'] = $socialLinks;

        // Handle contact info
        $validated['contact_email'] = $request->input('contact_email');
        $validated['contact_phone'] = $request->input('contact_phone');
        $validated['location'] = $request->input('location');

        $portfolio = Portfolio::create($validated);

        return redirect()->route('portfolios.edit', $portfolio->id)
                         ->with('success', 'Portfolio created! Now add your sections.');
    }

    /**
     * Display the specified portfolio (user view)
     */
    public function show($id)
    {
        $portfolio = Auth::user()->portfolios()->with('sections')->findOrFail($id);
        return view('portfolios.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified portfolio
     */
    public function edit($id)
    {
        $portfolio = Auth::user()->portfolios()->with('sections')->findOrFail($id);

        $themes = [
            'professional' => 'Professional',
            'creative' => 'Creative',
            'minimal' => 'Minimal',
            'modern' => 'Modern',
            'elegant' => 'Elegant'
        ];

        $layouts = [
            'default' => 'Default',
            'sidebar' => 'Sidebar',
            'grid' => 'Grid',
            'timeline' => 'Timeline'
        ];

        $sectionTypes = PortfolioSection::availableTypes();

        return view('portfolios.edit', compact('portfolio', 'themes', 'layouts', 'sectionTypes'));
    }

    /**
     * Update the specified portfolio
     */
    public function update(Request $request, $id)
    {
        $portfolio = Auth::user()->portfolios()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'theme' => 'required|string',
            'layout' => 'required|string',
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'profile_photo' => 'nullable|image|max:2048',
            'cover_photo' => 'nullable|image|max:2048',
            'is_published' => 'boolean',
        ]);

        // Handle photo uploads
        if ($request->hasFile('profile_photo')) {
            if ($portfolio->profile_photo) {
                Storage::disk('public')->delete($portfolio->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')->store('portfolios/profiles', 'public');
        }

        if ($request->hasFile('cover_photo')) {
            if ($portfolio->cover_photo) {
                Storage::disk('public')->delete($portfolio->cover_photo);
            }
            $validated['cover_photo'] = $request->file('cover_photo')->store('portfolios/covers', 'public');
        }

        // Handle social links
        $socialLinks = [];
        foreach (['linkedin', 'twitter', 'github', 'behance', 'dribbble', 'instagram'] as $platform) {
            if ($request->filled($platform)) {
                $socialLinks[$platform] = $request->input($platform);
            }
        }
        $validated['social_links'] = $socialLinks;

        // Handle contact info
        $validated['contact_email'] = $request->input('contact_email');
        $validated['contact_phone'] = $request->input('contact_phone');
        $validated['location'] = $request->input('location');

        $portfolio->update($validated);

        return redirect()->route('portfolios.edit', $portfolio->id)
                         ->with('success', 'Portfolio updated successfully!');
    }

    /**
     * Remove the specified portfolio
     */
    public function destroy($id)
    {
        $portfolio = Auth::user()->portfolios()->findOrFail($id);

        // Delete photos
        if ($portfolio->profile_photo) {
            Storage::disk('public')->delete($portfolio->profile_photo);
        }
        if ($portfolio->cover_photo) {
            Storage::disk('public')->delete($portfolio->cover_photo);
        }

        $portfolio->delete();

        return redirect()->route('portfolios.index')
                         ->with('success', 'Portfolio deleted successfully!');
    }

    /**
     * Display public view of portfolio
     */
    public function publicView($slug)
    {
        $portfolio = Portfolio::where('slug', $slug)
                              ->where('is_published', true)
                              ->with('sections')
                              ->firstOrFail();

        $portfolio->incrementViews();

        return view('portfolios.public', compact('portfolio'));
    }

    /**
     * Add section to portfolio
     */
    public function addSection(Request $request, $id)
    {
        $portfolio = Auth::user()->portfolios()->findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'content' => 'required|array',
        ]);

        $validated['portfolio_id'] = $portfolio->id;
        $validated['display_order'] = $portfolio->sections()->count();

        PortfolioSection::create($validated);

        return back()->with('success', 'Section added successfully!');
    }

    /**
     * Update portfolio section
     */
    public function updateSection(Request $request, $portfolioId, $sectionId)
    {
        $portfolio = Auth::user()->portfolios()->findOrFail($portfolioId);
        $section = $portfolio->sections()->findOrFail($sectionId);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|array',
            'is_visible' => 'boolean',
        ]);

        $section->update($validated);

        return back()->with('success', 'Section updated successfully!');
    }

    /**
     * Delete portfolio section
     */
    public function deleteSection($portfolioId, $sectionId)
    {
        $portfolio = Auth::user()->portfolios()->findOrFail($portfolioId);
        $section = $portfolio->sections()->findOrFail($sectionId);

        $section->delete();

        return back()->with('success', 'Section deleted successfully!');
    }
}
