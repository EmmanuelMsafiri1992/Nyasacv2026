<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'tagline',
        'about',
        'profile_photo',
        'cover_photo',
        'theme',
        'primary_color',
        'secondary_color',
        'font_family',
        'layout',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'social_links',
        'contact_email',
        'contact_phone',
        'location',
        'is_published',
        'views_count'
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_published' => 'boolean',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($portfolio) {
            if (empty($portfolio->slug)) {
                $portfolio->slug = Str::slug($portfolio->title) . '-' . Str::random(6);
            }
        });
    }

    /**
     * Get the user that owns the portfolio
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all sections for the portfolio
     */
    public function sections()
    {
        return $this->hasMany(PortfolioSection::class)->orderBy('display_order');
    }

    /**
     * Get the public URL for this portfolio
     */
    public function getPublicUrlAttribute()
    {
        return url('/portfolio/' . $this->slug);
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Get sections by type
     */
    public function getSectionsByType($type)
    {
        return $this->sections()->where('type', $type)->where('is_visible', true)->get();
    }
}
