<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiCoverLetterTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_id',
        'type',
        'paragraph',
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

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByParagraph($query, string $paragraph)
    {
        return $query->where('paragraph', $paragraph);
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
