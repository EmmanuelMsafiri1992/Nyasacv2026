@extends('layouts.admin')

@section('title', __('Create Email Campaign'))
@section('page-title', __('Create Email Campaign'))

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Campaign Details')</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('settings.email-campaigns.store') }}" id="campaignForm">
                    @csrf

                    <input type="hidden" name="selected_users" id="selectedUsersInput" value="">

                    @if($templates->count() > 0)
                    <div class="alert alert-info">
                        <i class="fe fe-info mr-2"></i>
                        <strong>@lang('Tip'):</strong> @lang('You can use an existing template or create a new message from scratch.')
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Use Template (Optional)')</label>
                        <select id="templateSelect" class="form-control">
                            <option value="">@lang('-- Select a template or write custom message --')</option>
                            @foreach($templates as $template)
                                <option value="{{ $template->id }}"
                                        data-name="{{ $template->name }}"
                                        data-subject="{{ $template->subject }}"
                                        data-message="{{ $template->message }}">
                                    {{ $template->name }}
                                    @if($template->category)
                                        ({{ $template->category }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">@lang('Select a pre-made template to auto-fill the fields below')</small>
                    </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">@lang('Campaign Name') <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required placeholder="@lang('Internal name for this campaign')">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">@lang('This is for your reference only and won\'t be sent to users.')</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Email Subject') <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                               value="{{ old('subject') }}" required placeholder="@lang('Email subject line')">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Message') <span class="text-danger">*</span></label>
                        <textarea name="message" rows="10" class="form-control @error('message') is-invalid @enderror"
                                  required placeholder="@lang('Your marketing message...')">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">@lang('This message will be sent to all verified users.')</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Reply-To Email')</label>
                        <input type="email" name="reply_to_email" class="form-control @error('reply_to_email') is-invalid @enderror"
                               value="{{ old('reply_to_email') }}" placeholder="@lang('replies@example.com')">
                        @error('reply_to_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">@lang('Users will reply to this email address. Leave empty to use the default from address.')</small>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fe fe-save mr-1"></i> @lang('Create Campaign')
                        </button>
                        <a href="{{ route('settings.email-campaigns.index') }}" class="btn btn-secondary">
                            <i class="fe fe-x mr-1"></i> @lang('Cancel')
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Campaign Info')</h3>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stamp stamp-md bg-success mr-3">
                            <i class="fe fe-users"></i>
                        </div>
                        <div>
                            <h3 class="m-0" id="recipientCount">{{ $verifiedUsersCount }}</h3>
                            <small class="text-muted" id="recipientLabel">@lang('Verified Users')</small>
                        </div>
                    </div>
                    <div id="selectedUsersList" style="display: none;">
                        <strong>@lang('Selected Users'):</strong>
                        <div id="selectedUsersNames" class="mt-2 small"></div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="fe fe-info mr-2"></i>
                    <strong>@lang('Important')</strong>
                    <ul class="mb-0 mt-2">
                        <li>@lang('Only users with verified emails will receive this campaign.')</li>
                        <li>@lang('Admin users are excluded from marketing emails.')</li>
                        <li>@lang('Campaign can be sent after creation.')</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <i class="fe fe-alert-triangle mr-2"></i>
                    <strong>@lang('Best Practices')</strong>
                    <ul class="mb-0 mt-2">
                        <li>@lang('Use a clear and concise subject line.')</li>
                        <li>@lang('Keep your message brief and actionable.')</li>
                        <li>@lang('Include a clear call-to-action.')</li>
                        <li>@lang('Always provide a reply-to email.')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Template selection functionality
    const templateSelect = document.getElementById('templateSelect');
    if (templateSelect) {
        templateSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (this.value) {
                const templateName = selectedOption.dataset.name;
                const templateSubject = selectedOption.dataset.subject;
                const templateMessage = selectedOption.dataset.message;

                // Auto-fill form fields
                document.querySelector('input[name="name"]').value = templateName + ' - ' + new Date().toLocaleDateString();
                document.querySelector('input[name="subject"]').value = templateSubject;
                document.querySelector('textarea[name="message"]').value = templateMessage;
            }
        });
    }

    // Check if users were selected
    const urlParams = new URLSearchParams(window.location.search);
    const isSelected = urlParams.get('selected');

    if (isSelected === '1') {
        const selectedUsers = JSON.parse(sessionStorage.getItem('selectedUsers') || '[]');

        if (selectedUsers.length > 0) {
            // Update hidden input
            document.getElementById('selectedUsersInput').value = JSON.stringify(selectedUsers);

            // Update recipient count
            document.getElementById('recipientCount').textContent = selectedUsers.length;
            document.getElementById('recipientLabel').textContent = '@lang("Selected Users")';

            // Show selected users list
            document.getElementById('selectedUsersList').style.display = 'block';

            // Fetch user details and display
            fetch('{{ route("settings.email-campaigns.get-selected-users") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ user_ids: selectedUsers })
            })
            .then(response => response.json())
            .then(data => {
                const namesDiv = document.getElementById('selectedUsersNames');
                namesDiv.innerHTML = data.users.map(user =>
                    `<div class="mb-1"><i class="fe fe-user mr-1"></i>${user.name} (${user.email})</div>`
                ).join('');
            })
            .catch(error => console.error('Error:', error));

            // Clear sessionStorage
            sessionStorage.removeItem('selectedUsers');
        }
    }
});
</script>
@stop
