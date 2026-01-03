<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioSection extends Model
{
    protected $fillable = [
        'portfolio_id',
        'type',
        'title',
        'content',
        'display_order',
        'is_visible'
    ];

    protected $casts = [
        'content' => 'array',
        'is_visible' => 'boolean',
    ];

    /**
     * Get the portfolio that owns the section
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    /**
     * Available section types
     */
    public static function availableTypes()
    {
        return [
            'about' => 'About',
            'skills' => 'Skills',
            'experience' => 'Work Experience',
            'education' => 'Education',
            'projects' => 'Projects',
            'certifications' => 'Certifications',
            'testimonials' => 'Testimonials',
            'contact' => 'Contact'
        ];
    }
}
