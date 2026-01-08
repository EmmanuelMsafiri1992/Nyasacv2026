<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiActionVerb extends Model
{
    use HasFactory;

    protected $fillable = [
        'verb',
        'category',
        'tense',
        'strength',
        'synonyms',
        'is_active',
    ];

    protected $casts = [
        'synonyms' => 'array',
        'strength' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopePast($query)
    {
        return $query->where('tense', 'past');
    }

    public function scopePresent($query)
    {
        return $query->where('tense', 'present');
    }

    public function scopeStrong($query, int $minStrength = 7)
    {
        return $query->where('strength', '>=', $minStrength);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('strength', 'desc');
    }

    public function getRandomSynonym(): string
    {
        if (empty($this->synonyms)) {
            return $this->verb;
        }

        $all = array_merge([$this->verb], $this->synonyms);
        return $all[array_rand($all)];
    }
}
