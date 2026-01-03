@extends('layouts.admin')

@section('title', $adminEmail->subject)
@section('page-title', 'View Email')

@push('head')
<style>
.email-view-container {
    max-width: 900px;
    margin: 0 auto;
}

.email-view-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    overflow: hidden;
}

.email-view-header {
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
}

.email-view-subject {
    font-size: 1.5rem;
    font-weight: 600;
    color: #212529;
    margin-bottom: 15px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}

.email-view-subject h2 {
    margin: 0;
    font-size: 1.4rem;
    flex: 1;
}

.email-view-meta {
    display: flex;
    align-items: center;
    gap: 15px;
}

.email-sender-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.email-sender-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 18px;
}

.email-sender-details {
    flex: 1;
}

.email-sender-name {
    font-weight: 600;
    color: #212529;
    font-size: 15px;
}

.email-sender-email {
    font-size: 13px;
    color: #6c757d;
}

.email-date {
    font-size: 13px;
    color: #6c757d;
    white-space: nowrap;
}

.email-view-actions {
    display: flex;
    gap: 10px;
    margin-left: auto;
}

.email-view-body {
    padding: 25px;
    min-height: 200px;
}

.email-view-body-content {
    font-size: 15px;
    line-height: 1.7;
    color: #212529;
}

.email-view-body-content img {
    max-width: 100%;
    height: auto;
}

.email-view-footer {
    padding: 20px;
    border-top: 1px solid #e9ecef;
    background: #f8f9fa;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.email-thread {
    margin-top: 20px;
}

.email-thread-title {
    font-size: 14px;
    color: #6c757d;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e9ecef;
}

.email-thread-item {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 10px;
}

.email-thread-item.current {
    background: #e7eaff;
    border-left: 3px solid #667eea;
}

.email-thread-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 13px;
}

.email-thread-sender {
    font-weight: 600;
    color: #495057;
}

.email-thread-date {
    color: #6c757d;
}

.email-thread-preview {
    font-size: 14px;
    color: #495057;
}

.attachment-list {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #e9ecef;
}

.attachment-item {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f8f9fa;
    padding: 8px 12px;
    border-radius: 6px;
    margin-right: 10px;
    margin-bottom: 10px;
    font-size: 13px;
    color: #495057;
}

.attachment-item i {
    color: #667eea;
}

.email-labels {
    display: flex;
    gap: 8px;
    margin-top: 10px;
}

.email-label {
    font-size: 11px;
    padding: 3px 8px;
    border-radius: 4px;
    background: #e9ecef;
    color: #495057;
}

.email-label.starred {
    background: #fff3cd;
    color: #856404;
}

.email-label.unread {
    background: #cce5ff;
    color: #004085;
}
</style>
@endpush

@section('content')
<div class="email-view-container">
    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('settings.admin-emails.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fe fe-arrow-left mr-1"></i> Back to Inbox
        </a>
        <div class="btn-group btn-group-sm">
            @if($adminEmail->folder !== 'trash')
                <form action="{{ route('settings.admin-emails.trash', $adminEmail) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger" title="Move to Trash">
                        <i class="fe fe-trash-2"></i>
                    </button>
                </form>
            @else
                <form action="{{ route('settings.admin-emails.restore', $adminEmail) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-success" title="Restore">
                        <i class="fe fe-rotate-ccw"></i>
                    </button>
                </form>
                <form action="{{ route('settings.admin-emails.destroy', $adminEmail) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Permanently delete this email?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" title="Delete Permanently">
                        <i class="fe fe-x"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="email-view-card">
        <div class="email-view-header">
            <div class="email-view-subject">
                <h2>{{ $adminEmail->subject }}</h2>
                <div class="email-view-actions">
                    <button class="btn btn-sm {{ $adminEmail->is_starred ? 'btn-warning' : 'btn-outline-warning' }}"
                            onclick="toggleStar({{ $adminEmail->id }}, this)">
                        <i class="fe fe-star"></i>
                    </button>
                </div>
            </div>

            <div class="email-view-meta">
                <div class="email-sender-info">
                    <div class="email-sender-avatar">
                        {{ strtoupper(substr($adminEmail->from_name ?: $adminEmail->from_email, 0, 1)) }}
                    </div>
                    <div class="email-sender-details">
                        <div class="email-sender-name">
                            {{ $adminEmail->from_name ?: $adminEmail->from_email }}
                        </div>
                        <div class="email-sender-email">
                            &lt;{{ $adminEmail->from_email }}&gt;
                            <span class="text-muted">to</span>
                            {{ $adminEmail->to_email }}
                        </div>
                    </div>
                </div>
                <div class="email-date">
                    {{ ($adminEmail->received_at ?? $adminEmail->sent_at ?? $adminEmail->created_at)->format('M d, Y h:i A') }}
                </div>
            </div>

            <div class="email-labels">
                @if($adminEmail->is_starred)
                    <span class="email-label starred"><i class="fe fe-star mr-1"></i> Starred</span>
                @endif
                @if($adminEmail->has_attachments)
                    <span class="email-label"><i class="fe fe-paperclip mr-1"></i> Has Attachments</span>
                @endif
                <span class="email-label">{{ ucfirst($adminEmail->folder) }}</span>
            </div>
        </div>

        <div class="email-view-body">
            <div class="email-view-body-content">
                @if($adminEmail->body_html)
                    {!! $adminEmail->body_html !!}
                @else
                    {!! nl2br(e($adminEmail->body_text)) !!}
                @endif
            </div>

            @if($adminEmail->has_attachments && $adminEmail->attachments)
                <div class="attachment-list">
                    <strong class="text-muted small"><i class="fe fe-paperclip mr-1"></i> Attachments:</strong>
                    <div class="mt-2">
                        @foreach($adminEmail->attachments as $attachment)
                            <div class="attachment-item">
                                <i class="fe fe-file"></i>
                                {{ $attachment['name'] ?? 'Attachment' }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="email-view-footer">
            <div>
                <a href="{{ route('settings.admin-emails.compose', ['reply_to' => $adminEmail->id]) }}"
                   class="btn btn-primary">
                    <i class="fe fe-corner-up-left mr-1"></i> Reply
                </a>
                <a href="{{ route('settings.admin-emails.compose') }}" class="btn btn-outline-secondary ml-2">
                    <i class="fe fe-edit-2 mr-1"></i> Forward
                </a>
            </div>
            <div class="text-muted small">
                Message ID: {{ Str::limit($adminEmail->message_id, 30) }}
            </div>
        </div>
    </div>

    @if($thread->count() > 1)
        <div class="email-thread">
            <div class="email-thread-title">
                <i class="fe fe-message-square mr-1"></i> Conversation Thread ({{ $thread->count() }} messages)
            </div>
            @foreach($thread as $threadEmail)
                <div class="email-thread-item {{ $threadEmail->id === $adminEmail->id ? 'current' : '' }}">
                    <div class="email-thread-header">
                        <span class="email-thread-sender">
                            {{ $threadEmail->from_name ?: $threadEmail->from_email }}
                        </span>
                        <span class="email-thread-date">
                            {{ ($threadEmail->received_at ?? $threadEmail->sent_at ?? $threadEmail->created_at)->format('M d, Y h:i A') }}
                        </span>
                    </div>
                    <div class="email-thread-preview">
                        @if($threadEmail->id === $adminEmail->id)
                            <em>Current message</em>
                        @else
                            <a href="{{ route('settings.admin-emails.show', $threadEmail) }}">
                                {{ Str::limit($threadEmail->body_text, 150) }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function toggleStar(id, button) {
    fetch(`{{ url('settings/admin-emails') }}/${id}/star`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.starred) {
            button.classList.remove('btn-outline-warning');
            button.classList.add('btn-warning');
        } else {
            button.classList.remove('btn-warning');
            button.classList.add('btn-outline-warning');
        }
    });
}
</script>
@endpush
