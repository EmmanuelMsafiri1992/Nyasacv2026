<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class EmailCampaign extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'message',
        'reply_to_email',
        'status',
        'scheduled_at',
        'sent_at',
        'total_recipients',
        'sent_count',
        'failed_count',
        'created_by',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function recipients()
    {
        return $this->hasMany(EmailCampaignRecipient::class, 'campaign_id');
    }

    public function replies()
    {
        return $this->hasMany(EmailReply::class, 'campaign_id');
    }

    public function unreadReplies()
    {
        return $this->hasMany(EmailReply::class, 'campaign_id')->where('is_read', false);
    }
}
