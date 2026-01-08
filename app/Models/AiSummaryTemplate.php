<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiSummaryTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_id',
        'job_title_id',
        'experience_level',
        'template',
        'tone',
        'priority',
        'is_active',
    ];

    protected $casts = [
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

    public function scopeByLevel($query, string $level)
    {
        return $query->where('experience_level', $level);
    }

    public function scopeByTone($query, string $tone)
    {
        return $query->where('tone', $tone);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('priority', 'desc');
    }
}
