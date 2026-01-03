<?php

namespace App\Http\Controllers;

use App\VirtualCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VirtualCardController extends Controller
{
    /**
     * Display a listing of user's virtual cards
     */
    public function index()
    {
        $cards = Auth::user()->virtualCards()->latest()->get();
        return view('virtual-cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new virtual card
     */
    public function create()
    {
        $themes = [
            'modern' => 'Modern',
            'minimal' => 'Minimal',
            'elegant' => 'Elegant',
            'creative' => 'Creative',
            'corporate' => 'Corporate'
        ];

        return view('virtual-cards.create', compact('themes'));
    }

    /**
     * Store a newly created virtual card
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'full_name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Block URLs, links, and common spam patterns
                    if (preg_match('/(https?:\/\/|www\.|payment|confirm.*transaction|click here|hs=)/i', $value)) {
                        $fail(__('The :attribute contains invalid content.'));
                    }
                },
            ],
            'job_title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'theme' => 'required|string',
            'primary_color' => 'nullable|string|max:7',
            'profile_photo' => 'nullable|image|max:2048',
            'cover_photo' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($request->title) . '-' . Str::random(6);

        // Handle photo uploads
        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('virtual-cards/profiles', 'public');
        }

        if ($request->hasFile('cover_photo')) {
            $validated['cover_photo'] = $request->file('cover_photo')->store('virtual-cards/covers', 'public');
        }

        // Handle social links
        $socialLinks = [];
        foreach (['linkedin', 'twitter', 'facebook', 'instagram', 'github'] as $platform) {
            if ($request->filled($platform)) {
                $socialLinks[$platform] = $request->input($platform);
            }
        }
        $validated['social_links'] = $socialLinks;

        $card = VirtualCard::create($validated);

        return redirect()->route('virtual-cards.show', $card->id)
                         ->with('success', 'Virtual card created successfully!');
    }

    /**
     * Display the specified virtual card (user view)
     */
    public function show($id)
    {
        $card = Auth::user()->virtualCards()->findOrFail($id);
        return view('virtual-cards.show', compact('card'));
    }

    /**
     * Show the form for editing the specified virtual card
     */
    public function edit($id)
    {
        $card = Auth::user()->virtualCards()->findOrFail($id);
        $themes = [
            'modern' => 'Modern',
            'minimal' => 'Minimal',
            'elegant' => 'Elegant',
            'creative' => 'Creative',
            'corporate' => 'Corporate'
        ];

        return view('virtual-cards.edit', compact('card', 'themes'));
    }

    /**
     * Update the specified virtual card
     */
    public function update(Request $request, $id)
    {
        $card = Auth::user()->virtualCards()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'full_name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Block URLs, links, and common spam patterns
                    if (preg_match('/(https?:\/\/|www\.|payment|confirm.*transaction|click here|hs=)/i', $value)) {
                        $fail(__('The :attribute contains invalid content.'));
                    }
                },
            ],
            'job_title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'theme' => 'required|string',
            'primary_color' => 'nullable|string|max:7',
            'profile_photo' => 'nullable|image|max:2048',
            'cover_photo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        // Handle photo uploads
        if ($request->hasFile('profile_photo')) {
            if ($card->profile_photo) {
                Storage::disk('public')->delete($card->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')->store('virtual-cards/profiles', 'public');
        }

        if ($request->hasFile('cover_photo')) {
            if ($card->cover_photo) {
                Storage::disk('public')->delete($card->cover_photo);
            }
            $validated['cover_photo'] = $request->file('cover_photo')->store('virtual-cards/covers', 'public');
        }

        // Handle social links
        $socialLinks = [];
        foreach (['linkedin', 'twitter', 'facebook', 'instagram', 'github'] as $platform) {
            if ($request->filled($platform)) {
                $socialLinks[$platform] = $request->input($platform);
            }
        }
        $validated['social_links'] = $socialLinks;

        $card->update($validated);

        return redirect()->route('virtual-cards.show', $card->id)
                         ->with('success', 'Virtual card updated successfully!');
    }

    /**
     * Remove the specified virtual card
     */
    public function destroy($id)
    {
        $card = Auth::user()->virtualCards()->findOrFail($id);

        // Delete photos
        if ($card->profile_photo) {
            Storage::disk('public')->delete($card->profile_photo);
        }
        if ($card->cover_photo) {
            Storage::disk('public')->delete($card->cover_photo);
        }

        $card->delete();

        return redirect()->route('virtual-cards.index')
                         ->with('success', 'Virtual card deleted successfully!');
    }

    /**
     * Display public view of virtual card
     */
    public function publicView($slug)
    {
        $card = VirtualCard::where('slug', $slug)
                           ->where('is_active', true)
                           ->firstOrFail();

        $card->incrementViews();

        return view('virtual-cards.public', compact('card'));
    }

    /**
     * Download vCard file
     */
    public function downloadVCard($slug)
    {
        $card = VirtualCard::where('slug', $slug)
                           ->where('is_active', true)
                           ->firstOrFail();

        $vcard = $card->getVCardContent();
        $filename = Str::slug($card->full_name) . '.vcf';

        return response($vcard, 200, [
            'Content-Type' => 'text/vcard',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
