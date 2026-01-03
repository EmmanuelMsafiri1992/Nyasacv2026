<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\BlogPost;
use App\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts
     */
    public function index()
    {
        $posts = BlogPost::with(['category', 'author'])
                        ->latest()
                        ->paginate(20);

        return view('settings.blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new blog post
     */
    public function create()
    {
        $categories = BlogCategory::where('is_active', true)
                                  ->orderBy('name')
                                  ->get();

        return view('settings.blog.create', compact('categories'));
    }

    /**
     * Store a newly created blog post
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'tags' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $validated['author_id'] = Auth::id();
        $validated['slug'] = Str::slug($request->title);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('blog/featured', 'public');
        }

        // Convert tags string to array
        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Set published_at if publishing
        if ($validated['is_published'] && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post = BlogPost::create($validated);

        return redirect()->route('settings.blog.edit', $post->id)
                         ->with('success', 'Blog post created successfully!');
    }

    /**
     * Show the form for editing the specified blog post
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        $categories = BlogCategory::where('is_active', true)
                                  ->orderBy('name')
                                  ->get();

        return view('settings.blog.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified blog post
     */
    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'nullable|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|max:2048',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string',
            'seo_keywords' => 'nullable|string',
            'tags' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ]);

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('blog/featured', 'public');
        }

        // Convert tags string to array
        if ($request->filled('tags')) {
            $validated['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // Set published_at when publishing for the first time
        if ($validated['is_published'] && !$post->published_at) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        return redirect()->route('settings.blog.edit', $post->id)
                         ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog post
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        // Delete featured image
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('settings.blog.index')
                         ->with('success', 'Blog post deleted successfully!');
    }
}
