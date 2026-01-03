@extends('layouts.admin')

@section('title', $emailCampaign->name)
@section('page-title', $emailCampaign->name)

@section('content')
<div class="page-header">
    <div class="page-options">
        @if($emailCampaign->status != 'sent')
            <form method="post" action="{{ route('settings.email-campaigns.send', $emailCampaign) }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success" onclick="return confirm('@lang('Are you sure you want to send this campaign to all verified users?')')">
                    <i class="fe fe-send mr-1"></i> @lang('Send Campaign Now')
                </button>
            </form>
        @endif
        <a href="{{ route('settings.email-campaigns.index') }}" class="btn btn-secondary ml-2">
            <i class="fe fe-arrow-left mr-1"></i> @lang('Back to Campaigns')
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="stamp stamp-md bg-blue mr-3">
                        <i class="fe fe-users"></i>
                    </div>
                    <div>
                        <h4 class="m-0">{{ $stats['total'] }}</h4>
                        <small class="text-muted">@lang('Total Recipients')</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="stamp stamp-md bg-success mr-3">
                        <i class="fe fe-check-circle"></i>
                    </div>
                    <div>
                        <h4 class="m-0">{{ $stats['sent'] }}</h4>
                        <small class="text-muted">@lang('Sent')</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="stamp stamp-md bg-warning mr-3">
                        <i class="fe fe-clock"></i>
                    </div>
                    <div>
                        <h4 class="m-0">{{ $stats['pending'] }}</h4>
                        <small class="text-muted">@lang('Pending')</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center">
                    <div class="stamp stamp-md bg-purple mr-3">
                        <i class="fe fe-message-square"></i>
                    </div>
                    <div>
                        <h4 class="m-0">{{ $stats['replies'] }}</h4>
                        <small class="text-muted">@lang('Replies')
                            @if($stats['unread_replies'] > 0)
                                <span class="badge badge-danger ml-1">{{ $stats['unread_replies'] }}</span>
                            @endif
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Campaign Details')</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">@lang('Status')</th>
                        <td>
                            @if($emailCampaign->status == 'draft')
                                <span class="badge badge-secondary">
                                    <i class="fe fe-edit mr-1"></i>Draft
                                </span>
                            @elseif($emailCampaign->status == 'sending')
                                <span class="badge badge-info">
                                    <i class="fe fe-send mr-1"></i>Sending
                                </span>
                            @elseif($emailCampaign->status == 'sent')
                                <span class="badge badge-success">
                                    <i class="fe fe-check-circle mr-1"></i>Sent
                                </span>
                            @else
                                <span class="badge badge-warning">
                                    <i class="fe fe-clock mr-1"></i>{{ ucfirst($emailCampaign->status) }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>@lang('Subject')</th>
                        <td>{{ $emailCampaign->subject }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Reply-To Email')</th>
                        <td>{{ $emailCampaign->reply_to_email ?? __('Default') }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Created By')</th>
                        <td>{{ $emailCampaign->creator->name }} ({{ $emailCampaign->creator->email }})</td>
                    </tr>
                    <tr>
                        <th>@lang('Created At')</th>
                        <td>{{ $emailCampaign->created_at->format('F j, Y \a\t g:i A') }}</td>
                    </tr>
                    @if($emailCampaign->sent_at)
                    <tr>
                        <th>@lang('Sent At')</th>
                        <td>{{ $emailCampaign->sent_at->format('F j, Y \a\t g:i A') }}</td>
                    </tr>
                    @endif
                </table>

                <hr>

                <h4>@lang('Message')</h4>
                <div class="border p-3 bg-light">
                    {!! nl2br(e($emailCampaign->message)) !!}
                </div>
            </div>
        </div>

        @if($emailCampaign->replies->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Recent Replies')</h3>
                <div class="card-options">
                    <a href="{{ route('settings.email-campaigns.replies', $emailCampaign) }}" class="btn btn-sm btn-primary">
                        @lang('View All Replies')
                    </a>
                </div>
            </div>
            <div class="card-body">
                @foreach($emailCampaign->replies->take(5) as $reply)
                    <div class="mb-3 p-3 border {{ $reply->is_read ? 'bg-light' : 'bg-white' }}">
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <strong>{{ $reply->user->name }}</strong>
                                <span class="text-muted">({{ $reply->from_email }})</span>
                            </div>
                            <div>
                                <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                @if(!$reply->is_read)
                                    <span class="badge badge-primary ml-2">New</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-muted mb-1"><strong>{{ $reply->subject }}</strong></div>
                        <div>{{ Str::limit($reply->message, 200) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-4">
        @if($stats['failed'] > 0)
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h3 class="card-title">@lang('Failed Deliveries')</h3>
            </div>
            <div class="card-body">
                <p>{{ $stats['failed'] }} @lang('emails failed to send.')</p>
                @foreach($emailCampaign->recipients()->where('status', 'failed')->take(5)->get() as $failed)
                    <div class="mb-2">
                        <small class="text-muted">{{ $failed->user->email }}</small>
                        <div class="small text-danger">{{ Str::limit($failed->error_message, 100) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Actions')</h3>
            </div>
            <div class="card-body">
                @if($emailCampaign->replies_count > 0)
                    <a href="{{ route('settings.email-campaigns.replies', $emailCampaign) }}" class="btn btn-primary btn-block mb-2">
                        <i class="fe fe-message-square mr-1"></i> @lang('View All Replies')
                    </a>
                @endif

                <form method="post" action="{{ route('settings.email-campaigns.destroy', $emailCampaign) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('@lang('Are you sure you want to delete this campaign? This action cannot be undone.')')">
                        <i class="fe fe-trash mr-1"></i> @lang('Delete Campaign')
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
