@extends('layouts.admin')

@section('title', 'Email Inbox')
@section('page-title', 'Email Inbox')

@push('head')
<style>
.email-container {
    display: flex;
    gap: 20px;
    min-height: calc(100vh - 200px);
}

.email-sidebar {
    width: 200px;
    flex-shrink: 0;
}

.email-sidebar .btn-compose {
    width: 100%;
    margin-bottom: 20px;
    padding: 12px;
    font-weight: 600;
}

.email-folders {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.email-folder-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 15px;
    color: #495057;
    text-decoration: none;
    border-left: 3px solid transparent;
    transition: all 0.2s;
}

.email-folder-item:hover {
    background: #f8f9fa;
    color: #667eea;
    text-decoration: none;
}

.email-folder-item.active {
    background: #e7eaff;
    color: #667eea;
    border-left-color: #667eea;
    font-weight: 600;
}

.email-folder-item i {
    margin-right: 10px;
    width: 18px;
}

.email-folder-badge {
    background: #667eea;
    color: white;
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 10px;
}

.email-main {
    flex: 1;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    overflow: hidden;
}

.email-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 20px;
    border-bottom: 1px solid #e9ecef;
    background: #f8f9fa;
}

.email-toolbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.email-search {
    position: relative;
}

.email-search input {
    padding: 8px 15px 8px 35px;
    border: 1px solid #dee2e6;
    border-radius: 20px;
    width: 250px;
    font-size: 14px;
}

.email-search i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.email-list {
    max-height: calc(100vh - 300px);
    overflow-y: auto;
}

.email-item {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #f1f3f5;
    cursor: pointer;
    transition: background 0.2s;
}

.email-item:hover {
    background: #f8f9fa;
}

.email-item.unread {
    background: #f0f4ff;
}

.email-item.unread .email-subject {
    font-weight: 600;
}

.email-checkbox {
    margin-right: 15px;
}

.email-star {
    margin-right: 15px;
    color: #dee2e6;
    cursor: pointer;
    font-size: 18px;
}

.email-star.starred {
    color: #ffc107;
}

.email-star:hover {
    color: #ffc107;
}

.email-sender {
    width: 180px;
    flex-shrink: 0;
    font-size: 14px;
    color: #495057;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.email-content {
    flex: 1;
    min-width: 0;
    padding-right: 20px;
}

.email-subject {
    font-size: 14px;
    color: #212529;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.email-preview {
    font-size: 13px;
    color: #6c757d;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.email-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}

.email-attachment {
    color: #6c757d;
}

.email-date {
    font-size: 12px;
    color: #6c757d;
    white-space: nowrap;
}

.email-empty {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.email-empty i {
    font-size: 48px;
    margin-bottom: 15px;
    color: #dee2e6;
}

@media (max-width: 992px) {
    .email-container {
        flex-direction: column;
    }
    .email-sidebar {
        width: 100%;
    }
    .email-folders {
        display: flex;
        overflow-x: auto;
    }
    .email-folder-item {
        white-space: nowrap;
        border-left: none;
        border-bottom: 3px solid transparent;
    }
    .email-folder-item.active {
        border-bottom-color: #667eea;
    }
    .email-sender {
        width: 120px;
    }
    .email-search input {
        width: 150px;
    }
}
</style>
@endpush

@section('content')
<div class="email-container">
    <!-- Sidebar -->
    <div class="email-sidebar">
        <a href="{{ route('settings.admin-emails.compose') }}" class="btn btn-primary btn-compose">
            <i class="fe fe-edit-2 mr-2"></i> Compose
        </a>

        <div class="email-folders">
            <a href="{{ route('settings.admin-emails.index', ['folder' => 'inbox']) }}"
               class="email-folder-item {{ $folder === 'inbox' ? 'active' : '' }}">
                <span><i class="fe fe-inbox"></i> Inbox</span>
                @if($counts['unread'] > 0)
                    <span class="email-folder-badge">{{ $counts['unread'] }}</span>
                @endif
            </a>
            <a href="{{ route('settings.admin-emails.index', ['folder' => 'starred']) }}"
               class="email-folder-item {{ $folder === 'starred' ? 'active' : '' }}">
                <span><i class="fe fe-star"></i> Starred</span>
                @if($counts['starred'] > 0)
                    <span class="email-folder-badge" style="background: #ffc107;">{{ $counts['starred'] }}</span>
                @endif
            </a>
            <a href="{{ route('settings.admin-emails.index', ['folder' => 'sent']) }}"
               class="email-folder-item {{ $folder === 'sent' ? 'active' : '' }}">
                <span><i class="fe fe-send"></i> Sent</span>
                <span style="color: #6c757d; font-size: 12px;">{{ $counts['sent'] }}</span>
            </a>
            <a href="{{ route('settings.admin-emails.index', ['folder' => 'trash']) }}"
               class="email-folder-item {{ $folder === 'trash' ? 'active' : '' }}">
                <span><i class="fe fe-trash-2"></i> Trash</span>
                @if($counts['trash'] > 0)
                    <span style="color: #6c757d; font-size: 12px;">{{ $counts['trash'] }}</span>
                @endif
            </a>
        </div>

        <div class="mt-3">
            <form action="{{ route('settings.admin-emails.fetch') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-sm btn-block">
                    <i class="fe fe-refresh-cw mr-1"></i> Fetch New Emails
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="email-main">
        <!-- Toolbar -->
        <div class="email-toolbar">
            <div class="email-toolbar-left">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="selectAll">
                    <label class="custom-control-label" for="selectAll"></label>
                </div>

                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary" onclick="bulkAction('read')" title="Mark as Read">
                        <i class="fe fe-check"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="bulkAction('unread')" title="Mark as Unread">
                        <i class="fe fe-circle"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="bulkAction('trash')" title="Move to Trash">
                        <i class="fe fe-trash-2"></i>
                    </button>
                </div>
            </div>

            <div class="email-search">
                <i class="fe fe-search"></i>
                <form action="{{ route('settings.admin-emails.index') }}" method="GET">
                    <input type="hidden" name="folder" value="{{ $folder }}">
                    <input type="text" name="search" placeholder="Search emails..." value="{{ $search ?? '' }}">
                </form>
            </div>
        </div>

        <!-- Email List -->
        <div class="email-list">
            @forelse($emails as $email)
                <div class="email-item {{ !$email->is_read ? 'unread' : '' }}" data-id="{{ $email->id }}">
                    <div class="email-checkbox">
                        <input type="checkbox" class="email-select" value="{{ $email->id }}">
                    </div>

                    <i class="fe fe-star email-star {{ $email->is_starred ? 'starred' : '' }}"
                       onclick="event.stopPropagation(); toggleStar({{ $email->id }}, this)"></i>

                    <a href="{{ route('settings.admin-emails.show', $email) }}" class="d-flex align-items-center flex-grow-1" style="text-decoration: none; color: inherit;">
                        <div class="email-sender">
                            @if($folder === 'sent')
                                To: {{ $email->to_email }}
                            @else
                                {{ $email->from_name ?: $email->from_email }}
                            @endif
                        </div>

                        <div class="email-content">
                            <div class="email-subject">{{ $email->subject }}</div>
                            <div class="email-preview">{{ $email->body_preview }}</div>
                        </div>

                        <div class="email-meta">
                            @if($email->has_attachments)
                                <i class="fe fe-paperclip email-attachment"></i>
                            @endif
                            <span class="email-date">
                                {{ ($email->received_at ?? $email->sent_at ?? $email->created_at)->diffForHumans() }}
                            </span>
                        </div>
                    </a>
                </div>
            @empty
                <div class="email-empty">
                    <i class="fe fe-inbox"></i>
                    <h5>No emails found</h5>
                    <p>{{ $folder === 'inbox' ? 'Click "Fetch New Emails" to check for new messages' : 'This folder is empty' }}</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($emails->hasPages())
            <div class="p-3 border-top">
                {{ $emails->appends(['folder' => $folder, 'search' => $search])->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Bulk Action Form -->
<form id="bulkActionForm" action="{{ route('settings.admin-emails.bulk') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulkActionType">
    <input type="hidden" name="ids" id="bulkActionIds">
</form>
@endsection

@push('scripts')
<script>
document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.email-select').forEach(cb => cb.checked = this.checked);
});

function getSelectedIds() {
    return Array.from(document.querySelectorAll('.email-select:checked')).map(cb => cb.value);
}

function bulkAction(action) {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        alert('Please select at least one email');
        return;
    }
    document.getElementById('bulkActionType').value = action;
    document.getElementById('bulkActionIds').value = JSON.stringify(ids);
    document.getElementById('bulkActionForm').submit();
}

function toggleStar(id, element) {
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
            element.classList.add('starred');
        } else {
            element.classList.remove('starred');
        }
    });
}
</script>
@endpush
