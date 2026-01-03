<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminEmail extends Model
{
    protected $fillable = [
        'message_id',
        'from_email',
        'from_name',
        'to_email',
        'subject',
        'body_html',
        'body_text',
        'in_reply_to',
        'references',
        'folder',
        'is_read',
        'is_starred',
        'has_attachments',
        'attachments',
        'received_at',
        'sent_at',
        'user_id',
        'parent_id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_starred' => 'boolean',
        'has_attachments' => 'boolean',
        'attachments' => 'array',
        'received_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(AdminEmail::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(AdminEmail::class, 'parent_id');
    }

    public function scopeInbox($query)
    {
        return $query->where('folder', 'inbox');
    }

    public function scopeSent($query)
    {
        return $query->where('folder', 'sent');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeStarred($query)
    {
        return $query->where('is_starred', true);
    }

    public function getBodyPreviewAttribute(): string
    {
        $text = $this->body_text ?: strip_tags($this->body_html);
        return \Str::limit($text, 100);
    }

    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }

    public function toggleStar(): void
    {
        $this->update(['is_starred' => !$this->is_starred]);
    }

    public function moveToTrash(): void
    {
        $this->update(['folder' => 'trash']);
    }

    public function restore(): void
    {
        $this->update(['folder' => 'inbox']);
    }
}
