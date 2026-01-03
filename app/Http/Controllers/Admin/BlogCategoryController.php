<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of blog categories
     */
    public function index()
    {
        $categories = BlogCategory::withCount('posts')
                                  ->orderBy('display_order')
                                  ->get();

        return view('settings.blog.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('settings.blog.categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['display_order'] = BlogCategory::max('display_order') + 1;

        BlogCategory::create($validated);

        return redirect()->route('settings.blog.categories.index')
                         ->with('success', 'Category created successfully!');
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit($id)
    {
        $category = BlogCategory::findOrFail($id);

        return view('settings.blog.categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
            'display_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $category->update($validated);

        return redirect()->route('settings.blog.categories.index')
                         ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category
     */
    public function destroy($id)
    {
        $category = BlogCategory::findOrFail($id);

        // Check if category has posts
        if ($category->posts()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing posts. Please reassign the posts first.');
        }

        $category->delete();

        return redirect()->route('settings.blog.categories.index')
                         ->with('success', 'Category deleted successfully!');
    }
}
