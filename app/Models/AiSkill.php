<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_id',
        'name',
        'category',
        'related_job_titles',
        'popularity',
        'is_active',
    ];

    protected $casts = [
        'related_job_titles' => 'array',
        'popularity' => 'integer',
        'is_active' => 'boolean',
    ];

    public function industry(): BelongsTo
    {
        return $this->belongsTo(AiIndustry::class, 'industry_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeTechnical($query)
    {
        return $query->where('category', 'technical');
    }

    public function scopeSoft($query)
    {
        return $query->where('category', 'soft');
    }

    public function scopePopular($query, int $minPopularity = 70)
    {
        return $query->where('popularity', '>=', $minPopularity);
    }

    public function scopeForJobTitle($query, int $jobTitleId)
    {
        return $query->whereJsonContains('related_job_titles', $jobTitleId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('popularity', 'desc');
    }
}
