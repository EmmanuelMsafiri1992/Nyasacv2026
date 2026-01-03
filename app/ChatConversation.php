<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatConversation extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'status',
        'unread_admin_count',
        'unread_user_count',
        'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the user that owns the conversation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all messages for the conversation
     */
    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id');
    }

    /**
     * Get the latest message
     */
    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class, 'conversation_id')->latest();
    }

    /**
     * Mark admin messages as read
     */
    public function markAdminMessagesRead()
    {
        $this->messages()
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->update(['unread_user_count' => 0]);
    }

    /**
     * Mark user messages as read
     */
    public function markUserMessagesRead()
    {
        $this->messages()
            ->where('sender_type', 'user')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->update(['unread_admin_count' => 0]);
    }
}
