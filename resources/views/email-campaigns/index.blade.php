@extends('layouts.admin')

@section('title', __('Email Campaigns'))
@section('page-title', __('Email Campaigns'))

@section('content')
<div class="page-header">
    <div class="page-options">
        <a href="{{ route('settings.email-campaigns.create') }}" class="btn btn-primary">
            <i class="fe fe-plus"></i> @lang('Create New Campaign')
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @if($campaigns->count() > 0)
            <div class="card">
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th>@lang('Campaign Name')</th>
                                <th>@lang('Subject')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Recipients')</th>
                                <th>@lang('Replies')</th>
                                <th>@lang('Created')</th>
                                <th class="text-right">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campaigns as $campaign)
                            <tr>
                                <td>
                                    <a href="{{ route('settings.email-campaigns.show', $campaign) }}">
                                        <strong>{{ $campaign->name }}</strong>
                                    </a>
                                </td>
                                <td>{{ Str::limit($campaign->subject, 50) }}</td>
                                <td>
                                    @if($campaign->status == 'draft')
                                        <span class="badge badge-secondary">
                                            <i class="fe fe-edit mr-1"></i>Draft
                                        </span>
                                    @elseif($campaign->status == 'sending')
                                        <span class="badge badge-info">
                                            <i class="fe fe-send mr-1"></i>Sending
                                        </span>
                                    @elseif($campaign->status == 'sent')
                                        <span class="badge badge-success">
                                            <i class="fe fe-check-circle mr-1"></i>Sent
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fe fe-clock mr-1"></i>{{ ucfirst($campaign->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <span class="text-success">{{ $campaign->sent_count }}</span> /
                                        <span>{{ $campaign->total_recipients }}</span>
                                    </div>
                                    @if($campaign->failed_count > 0)
                                        <div class="small text-danger">
                                            {{ $campaign->failed_count }} failed
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($campaign->replies_count > 0)
                                        <a href="{{ route('settings.email-campaigns.replies', $campaign) }}" class="badge badge-primary">
                                            {{ $campaign->replies_count }} replies
                                            @if($campaign->unread_replies_count > 0)
                                                <span class="badge badge-danger ml-1">{{ $campaign->unread_replies_count }}</span>
                                            @endif
                                        </a>
                                    @else
                                        <span class="text-muted">No replies</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">
                                        {{ $campaign->created_at->format('M j, Y') }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ $campaign->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="text-right">
                                    <div class="btn-group">
                                        <a href="{{ route('settings.email-campaigns.show', $campaign) }}" class="btn btn-sm btn-primary">
                                            <i class="fe fe-eye mr-1"></i> @lang('View')
                                        </a>
                                        @if($campaign->status != 'sent')
                                            <form method="post" action="{{ route('settings.email-campaigns.send', $campaign) }}" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('@lang('Are you sure you want to send this campaign to all verified users?')')">
                                                    <i class="fe fe-send mr-1"></i> @lang('Send')
                                                </button>
                                            </form>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-danger" onclick="if(confirm('@lang('Confirm delete?')')) { document.getElementById('delete-form-{{ $campaign->id }}').submit(); }">
                                            <i class="fe fe-trash mr-1"></i> @lang('Delete')
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $campaign->id }}" method="post" action="{{ route('settings.email-campaigns.destroy', $campaign) }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{ $campaigns->links() }}

        @if($campaigns->count() == 0)
            <div class="alert alert-primary text-center">
                <i class="fe fe-alert-triangle mr-2"></i> @lang('No campaigns found. Create your first marketing campaign!')
            </div>
        @endif
    </div>
</div>
@stop
