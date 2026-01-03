@extends('layouts.admin')

@section('title', __('Campaign Replies'))
@section('page-title', __('Replies: ') . $emailCampaign->name)

@section('content')
<div class="page-header">
    <div class="page-options">
        <a href="{{ route('settings.email-campaigns.show', $emailCampaign) }}" class="btn btn-secondary">
            <i class="fe fe-arrow-left mr-1"></i> @lang('Back to Campaign')
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @if($replies->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Email Replies')</h3>
                </div>
                <div class="card-body">
                    @foreach($replies as $reply)
                        <div class="card mb-3 {{ $reply->is_read ? '' : 'border-primary' }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h4 class="mb-1">
                                            {{ $reply->user->name }}
                                            @if(!$reply->is_read)
                                                <span class="badge badge-primary ml-2">New</span>
                                            @endif
                                        </h4>
                                        <div class="text-muted">
                                            <i class="fe fe-mail mr-1"></i>{{ $reply->from_email }}
                                            @if($reply->from_name)
                                                ({{ $reply->from_name }})
                                            @endif
                                        </div>
                                        <div class="text-muted small">
                                            <i class="fe fe-clock mr-1"></i>{{ $reply->created_at->format('F j, Y \a\t g:i A') }}
                                            <span class="ml-2">({{ $reply->created_at->diffForHumans() }})</span>
                                        </div>
                                    </div>
                                    <div>
                                        @if(!$reply->is_read)
                                            <form method="post" action="{{ route('settings.email-campaigns.mark-reply-read', [$emailCampaign, $reply]) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fe fe-check mr-1"></i> @lang('Mark as Read')
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <strong>@lang('Subject'):</strong> {{ $reply->subject }}
                                </div>

                                <div class="border-top pt-3">
                                    <strong>@lang('Message'):</strong>
                                    <div class="mt-2">
                                        {!! nl2br(e($reply->message)) !!}
                                    </div>
                                </div>

                                <div class="mt-3 pt-3 border-top">
                                    <small class="text-muted">
                                        <i class="fe fe-info mr-1"></i>
                                        @lang('Reply to this user directly at:')
                                        <a href="mailto:{{ $reply->from_email }}">{{ $reply->from_email }}</a>
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{ $replies->links() }}
        @else
            <div class="alert alert-primary text-center">
                <i class="fe fe-alert-triangle mr-2"></i> @lang('No replies yet for this campaign.')
            </div>
        @endif
    </div>
</div>
@stop
