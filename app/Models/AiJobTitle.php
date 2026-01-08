<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiJobTitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_id',
        'title',
        'slug',
        'level',
        'aliases',
        'is_active',
    ];

    protected $casts = [
        'aliases' => 'array',
        'is_active' => 'boolean',
    ];

    public function industry(): BelongsTo
    {
        return $this->belongsTo(AiIndustry::class, 'industry_id');
    }

    public function summaryTemplates(): HasMany
    {
        return $this->hasMany(AiSummaryTemplate::class, 'job_title_id');
    }

    public function achievementTemplates(): HasMany
    {
        return $this->hasMany(AiAchievementTemplate::class, 'job_title_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByLevel($query, string $level)
    {
        return $query->where('level', $level);
    }

    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhereJsonContains('aliases', $search);
        });
    }
}
