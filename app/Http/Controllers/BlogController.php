<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts
     */
    public function index(Request $request)
    {
        $query = BlogPost::with(['category', 'author'])
                         ->published()
                         ->latest('published_at');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate(12);
        $categories = BlogCategory::where('is_active', true)
                                  ->orderBy('display_order')
                                  ->get();
        $featuredPosts = BlogPost::published()
                                 ->featured()
                                 ->latest('published_at')
                                 ->limit(3)
                                 ->get();

        return view('blog.index', compact('posts', 'categories', 'featuredPosts'));
    }

    /**
     * Display the specified blog post
     */
    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
                       ->published()
                       ->with(['category', 'author'])
                       ->firstOrFail();

        $post->incrementViews();

        $relatedPosts = $post->getRelatedPosts(3);

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    /**
     * Display posts by category
     */
    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)
                                ->where('is_active', true)
                                ->firstOrFail();

        $posts = BlogPost::with(['category', 'author'])
                        ->published()
                        ->where('category_id', $category->id)
                        ->latest('published_at')
                        ->paginate(12);

        $categories = BlogCategory::where('is_active', true)
                                  ->orderBy('display_order')
                                  ->get();

        return view('blog.category', compact('category', 'posts', 'categories'));
    }
}
