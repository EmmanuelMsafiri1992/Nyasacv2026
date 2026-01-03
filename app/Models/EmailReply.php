<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class EmailReply extends Model
{
    protected $fillable = [
        'campaign_id',
        'user_id',
        'from_email',
        'from_name',
        'subject',
        'message',
        'raw_email',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function campaign()
    {
        return $this->belongsTo(EmailCampaign::class, 'campaign_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}
