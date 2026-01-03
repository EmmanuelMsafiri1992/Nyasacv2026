<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'tags',
        'reading_time',
        'views_count',
        'is_featured',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            // Calculate reading time
            if ($post->content && !$post->reading_time) {
                $wordCount = str_word_count(strip_tags($post->content));
                $post->reading_time = max(1, ceil($wordCount / 200)); // 200 words per minute
            }

            // Auto-generate excerpt if not provided
            if (!$post->excerpt && $post->content) {
                $post->excerpt = Str::limit(strip_tags($post->content), 160);
            }

            // Auto-fill SEO fields if empty
            if (!$post->seo_title) {
                $post->seo_title = $post->title;
            }

            if (!$post->seo_description) {
                $post->seo_description = $post->excerpt;
            }
        });
    }

    /**
     * Get the category that the post belongs to
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    /**
     * Get the author of the post
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the public URL for this post
     */
    public function getPublicUrlAttribute()
    {
        return url('/blog/' . $this->slug);
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Scope for published posts
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope for featured posts
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get related posts
     */
    public function getRelatedPosts($limit = 3)
    {
        return self::published()
                   ->where('id', '!=', $this->id)
                   ->where('category_id', $this->category_id)
                   ->latest('published_at')
                   ->limit($limit)
                   ->get();
    }
}
