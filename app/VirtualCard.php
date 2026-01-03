<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VirtualCard extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'full_name',
        'job_title',
        'company',
        'email',
        'phone',
        'website',
        'location',
        'bio',
        'profile_photo',
        'cover_photo',
        'theme',
        'primary_color',
        'social_links',
        'custom_fields',
        'views_count',
        'is_active'
    ];

    protected $casts = [
        'social_links' => 'array',
        'custom_fields' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($card) {
            if (empty($card->slug)) {
                $card->slug = Str::slug($card->title) . '-' . Str::random(6);
            }
        });
    }

    /**
     * Get the user that owns the virtual card
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the public URL for this virtual card
     */
    public function getPublicUrlAttribute()
    {
        return url('/card/' . $this->slug);
    }

    /**
     * Get the QR code URL for this virtual card
     */
    public function getQrCodeUrlAttribute()
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($this->public_url);
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Get vCard format for download
     */
    public function getVCardContent()
    {
        $vcard = "BEGIN:VCARD\r\n";
        $vcard .= "VERSION:3.0\r\n";
        $vcard .= "FN:" . $this->full_name . "\r\n";

        if ($this->job_title) {
            $vcard .= "TITLE:" . $this->job_title . "\r\n";
        }

        if ($this->company) {
            $vcard .= "ORG:" . $this->company . "\r\n";
        }

        if ($this->email) {
            $vcard .= "EMAIL:" . $this->email . "\r\n";
        }

        if ($this->phone) {
            $vcard .= "TEL:" . $this->phone . "\r\n";
        }

        if ($this->website) {
            $vcard .= "URL:" . $this->website . "\r\n";
        }

        if ($this->location) {
            $vcard .= "ADR:;;" . $this->location . "\r\n";
        }

        if ($this->bio) {
            $vcard .= "NOTE:" . $this->bio . "\r\n";
        }

        $vcard .= "END:VCARD\r\n";

        return $vcard;
    }
}
