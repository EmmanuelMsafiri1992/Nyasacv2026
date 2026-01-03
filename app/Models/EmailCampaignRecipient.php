<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class EmailCampaignRecipient extends Model
{
    protected $fillable = [
        'campaign_id',
        'user_id',
        'status',
        'sent_at',
        'error_message',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function campaign()
    {
        return $this->belongsTo(EmailCampaign::class, 'campaign_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
