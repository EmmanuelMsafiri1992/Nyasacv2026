<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Package extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'price',
        'interval',
        'interval_number',
        'settings',
        'is_featured',
    ];

    protected $casts = [
        'settings'    => 'array',
        'is_featured' => 'boolean',
    ];

    public function getPlanIdAttribute()
    {
        return Str::lower(
            'plan-'
            . $this->id . '-'
            . Str::slug($this->title, '-') . '-'
            . $this->whole_price . '-'
            . $this->fraction_price . '-'
            . config('rb.CURRENCY_CODE') . '-'
            . $this->interval
        );
    }

    public function getPriceInCentsAttribute()
    {
        return $this->price * 100;
    }

    public function getWholePriceAttribute()
    {
        return floor($this->price);
    }

    public function getFractionPriceAttribute()
    {
        return ltrim(round($this->price - $this->whole_price, 2), '0.');
    }

    public function getExportPdfAttribute()
    {
        return $this->settings['export_pdf'];
    }
    public function getTemplatePremiumAttribute()
    {
        return $this->settings['template_premium'];
    }

}
