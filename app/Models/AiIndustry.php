<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AiIndustry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function jobTitles(): HasMany
    {
        return $this->hasMany(AiJobTitle::class, 'industry_id');
    }

    public function summaryTemplates(): HasMany
    {
        return $this->hasMany(AiSummaryTemplate::class, 'industry_id');
    }

    public function achievementTemplates(): HasMany
    {
        return $this->hasMany(AiAchievementTemplate::class, 'industry_id');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(AiSkill::class, 'industry_id');
    }

    public function phrases(): HasMany
    {
        return $this->hasMany(AiPhrase::class, 'industry_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
