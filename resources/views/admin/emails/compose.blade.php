@extends('layouts.admin')

@section('title', isset($replyTo) ? 'Reply to Email' : 'Compose Email')
@section('page-title', isset($replyTo) ? 'Reply to Email' : 'Compose Email')

@push('head')
<style>
.compose-container {
    max-width: 900px;
    margin: 0 auto;
}

.compose-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    overflow: hidden;
}

.compose-header {
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
    background: #f8f9fa;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.compose-header h4 {
    margin: 0;
    font-weight: 600;
    color: #495057;
}

.compose-body {
    padding: 20px;
}

.compose-field {
    margin-bottom: 15px;
}

.compose-field label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #495057;
    font-size: 14px;
}

.compose-field input,
.compose-field select,
.compose-field textarea {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    font-size: 14px;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.compose-field input:focus,
.compose-field select:focus,
.compose-field textarea:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.recipient-input {
    position: relative;
}

.recipient-suggestions {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #dee2e6;
    border-top: none;
    border-radius: 0 0 6px 6px;
    max-height: 200px;
    overflow-y: auto;
    z-index: 100;
    display: none;
}

.recipient-suggestions.show {
    display: block;
}

.recipient-suggestion {
    padding: 10px 15px;
    cursor: pointer;
    border-bottom: 1px solid #f1f3f5;
}

.recipient-suggestion:hover {
    background: #f8f9fa;
}

.recipient-suggestion:last-child {
    border-bottom: none;
}

.recipient-name {
    font-weight: 600;
    color: #495057;
}

.recipient-email {
    font-size: 12px;
    color: #6c757d;
}

.compose-footer {
    padding: 20px;
    border-top: 1px solid #e9ecef;
    background: #f8f9fa;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.reply-original {
    background: #f8f9fa;
    border-left: 3px solid #667eea;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 0 6px 6px 0;
}

.reply-original-header {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 10px;
}

.reply-original-content {
    font-size: 14px;
    color: #495057;
    max-height: 200px;
    overflow-y: auto;
}

.quick-templates {
    margin-top: 15px;
}

.quick-template-btn {
    font-size: 12px;
    padding: 5px 10px;
    margin-right: 5px;
    margin-bottom: 5px;
}
</style>
@endpush

@section('content')
<div class="compose-container">
    <div class="mb-3">
        <a href="{{ route('settings.admin-emails.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fe fe-arrow-left mr-1"></i> Back to Inbox
        </a>
    </div>

    <div class="compose-card">
        <div class="compose-header">
            <h4>
                <i class="fe fe-edit-2 mr-2"></i>
                {{ isset($replyTo) ? 'Reply to: ' . Str::limit($replyTo->subject, 40) : 'Compose New Email' }}
            </h4>
        </div>

        <form action="{{ route('settings.admin-emails.send') }}" method="POST">
            @csrf
            @if(isset($replyTo))
                <input type="hidden" name="reply_to_id" value="{{ $replyTo->id }}">
            @endif

            <div class="compose-body">
                @if(isset($replyTo))
                    <div class="reply-original">
                        <div class="reply-original-header">
                            <strong>{{ $replyTo->from_name ?: $replyTo->from_email }}</strong>
                            wrote on {{ $replyTo->received_at->format('M d, Y h:i A') }}
                        </div>
                        <div class="reply-original-content">
                            {!! $replyTo->body_html ?: nl2br(e($replyTo->body_text)) !!}
                        </div>
                    </div>
                @endif

                <div class="compose-field">
                    <label for="to_email">
                        <i class="fe fe-user mr-1"></i> To
                    </label>
                    <div class="recipient-input">
                        <input type="email"
                               name="to_email"
                               id="to_email"
                               class="form-control @error('to_email') is-invalid @enderror"
                               placeholder="recipient@example.com"
                               value="{{ old('to_email', isset($replyTo) ? $replyTo->from_email : '') }}"
                               required
                               autocomplete="off">
                        <div class="recipient-suggestions" id="recipientSuggestions">
                            @foreach($users as $user)
                                <div class="recipient-suggestion" data-email="{{ $user->email }}">
                                    <div class="recipient-name">{{ $user->name }}</div>
                                    <div class="recipient-email">{{ $user->email }}</div>
                                </div>
                            @endforeach
                        </div>
                        @error('to_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="compose-field">
                    <label for="subject">
                        <i class="fe fe-type mr-1"></i> Subject
                    </label>
                    <input type="text"
                           name="subject"
                           id="subject"
                           class="form-control @error('subject') is-invalid @enderror"
                           placeholder="Email subject"
                           value="{{ old('subject', isset($replyTo) ? 'Re: ' . $replyTo->subject : '') }}"
                           required>
                    @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="compose-field">
                    <label for="body">
                        <i class="fe fe-file-text mr-1"></i> Message
                    </label>
                    <textarea name="body"
                              id="body"
                              class="form-control @error('body') is-invalid @enderror"
                              rows="12"
                              placeholder="Write your message here..."
                              required>{{ old('body') }}</textarea>
                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="quick-templates">
                    <span class="text-muted small">Quick responses:</span>
                    <button type="button" class="btn btn-outline-secondary quick-template-btn"
                            onclick="insertTemplate('thank_you')">Thank You</button>
                    <button type="button" class="btn btn-outline-secondary quick-template-btn"
                            onclick="insertTemplate('received')">Received</button>
                    <button type="button" class="btn btn-outline-secondary quick-template-btn"
                            onclick="insertTemplate('follow_up')">Follow Up</button>
                </div>
            </div>

            <div class="compose-footer">
                <div>
                    <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                        <i class="fe fe-x mr-1"></i> Cancel
                    </button>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-send mr-1"></i> Send Email
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Recipient autocomplete
const toInput = document.getElementById('to_email');
const suggestions = document.getElementById('recipientSuggestions');
const suggestionItems = document.querySelectorAll('.recipient-suggestion');

toInput.addEventListener('focus', function() {
    if (this.value.length === 0) {
        suggestions.classList.add('show');
    }
});

toInput.addEventListener('input', function() {
    const query = this.value.toLowerCase();
    let hasVisible = false;

    suggestionItems.forEach(item => {
        const email = item.dataset.email.toLowerCase();
        const name = item.querySelector('.recipient-name').textContent.toLowerCase();

        if (email.includes(query) || name.includes(query)) {
            item.style.display = 'block';
            hasVisible = true;
        } else {
            item.style.display = 'none';
        }
    });

    if (hasVisible && query.length > 0) {
        suggestions.classList.add('show');
    } else if (query.length === 0) {
        suggestions.classList.add('show');
        suggestionItems.forEach(item => item.style.display = 'block');
    } else {
        suggestions.classList.remove('show');
    }
});

suggestionItems.forEach(item => {
    item.addEventListener('click', function() {
        toInput.value = this.dataset.email;
        suggestions.classList.remove('show');
    });
});

document.addEventListener('click', function(e) {
    if (!toInput.contains(e.target) && !suggestions.contains(e.target)) {
        suggestions.classList.remove('show');
    }
});

// Quick templates
const templates = {
    thank_you: `Dear User,

Thank you for contacting NyasaCV. We appreciate your message and will get back to you as soon as possible.

Best regards,
NyasaCV Team`,

    received: `Dear User,

Thank you for your message. We have received your inquiry and our team is currently reviewing it.

We will respond to you within 24-48 hours.

Best regards,
NyasaCV Team`,

    follow_up: `Dear User,

We wanted to follow up on your recent inquiry. Is there anything else we can help you with?

Please don't hesitate to reach out if you have any questions.

Best regards,
NyasaCV Team`
};

function insertTemplate(type) {
    const textarea = document.getElementById('body');
    textarea.value = templates[type];
    textarea.focus();
}

// Initialize CKEditor if available
if (typeof CKEDITOR !== 'undefined') {
    CKEDITOR.replace('body', {
        height: 300,
        removePlugins: 'elementspath',
        resize_enabled: false
    });
}
</script>
@endpush
