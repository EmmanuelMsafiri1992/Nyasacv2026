<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiAchievementTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_id',
        'job_title_id',
        'category',
        'template',
        'required_inputs',
        'impact_type',
        'priority',
        'is_active',
    ];

    protected $casts = [
        'required_inputs' => 'array',
        'priority' => 'integer',
        'is_active' => 'boolean',
    ];

    public function industry(): BelongsTo
    {
        return $this->belongsTo(AiIndustry::class, 'industry_id');
    }

    public function jobTitle(): BelongsTo
    {
        return $this->belongsTo(AiJobTitle::class, 'job_title_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeQuantitative($query)
    {
        return $query->where('impact_type', 'quantitative');
    }

    public function scopeQualitative($query)
    {
        return $query->where('impact_type', 'qualitative');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('priority', 'desc');
    }
}
