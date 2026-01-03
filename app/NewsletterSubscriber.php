<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'name',
        'status',
        'token',
        'subscribed_at',
        'unsubscribed_at'
    ];

    protected $dates = [
        'subscribed_at',
        'unsubscribed_at',
        'created_at',
        'updated_at'
    ];

    /**
     * Boot function to auto-generate token
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscriber) {
            if (empty($subscriber->token)) {
                $subscriber->token = Str::random(32);
            }
        });
    }

    /**
     * Scope to get active subscribers
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Unsubscribe this subscriber
     */
    public function unsubscribe()
    {
        $this->status = 'unsubscribed';
        $this->unsubscribed_at = now();
        $this->save();
    }

    /**
     * Resubscribe this subscriber
     */
    public function resubscribe()
    {
        $this->status = 'active';
        $this->unsubscribed_at = null;
        $this->save();
    }
}
