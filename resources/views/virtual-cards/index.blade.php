@extends('layouts.dashboard')

@section('title', __('My Virtual Cards'))
@section('header-title', __('Virtual Cards'))

@section('content')
<div class="dashboard-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">@lang('My Virtual Cards')</h2>
            <p class="text-muted mb-0">@lang('Create and share digital business cards')</p>
        </div>
        <a href="{{ route('virtual-cards.create') }}" class="btn btn-primary">
            <i class="fe fe-plus mr-2"></i> @lang('Create New Card')
        </a>
    </div>

    @if($cards->count() > 0)
        <div class="row">
            @foreach($cards as $card)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card">
                        @if($card->cover_photo)
                            <img src="{{ Storage::url($card->cover_photo) }}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="{{ $card->title }}">
                        @else
                            <div class="card-img-top" style="height: 150px; background: linear-gradient(135deg, {{ $card->primary_color ?? '#667eea' }} 0%, {{ $card->primary_color ?? '#764ba2' }} 100%);"></div>
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $card->title }}</h5>
                            <p class="text-muted mb-2">
                                <i class="fe fe-user mr-1"></i> {{ $card->full_name }}
                                @if($card->job_title)
                                    <br><small>{{ $card->job_title }}</small>
                                @endif
                            </p>

                            <div class="d-flex align-items-center mb-3">
                                <span class="badge badge-{{ $card->is_active ? 'success' : 'secondary' }} mr-2">
                                    {{ $card->is_active ? __('Active') : __('Inactive') }}
                                </span>
                                <small class="text-muted">
                                    <i class="fe fe-eye mr-1"></i> {{ $card->views_count }} @lang('views')
                                </small>
                            </div>

                            <div class="btn-group btn-block">
                                <a href="{{ route('virtual-cards.show', $card->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fe fe-eye"></i> @lang('Preview')
                                </a>
                                <a href="{{ route('virtual-cards.edit', $card->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fe fe-edit"></i> @lang('Edit')
                                </a>
                                <a href="{{ $card->public_url }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fe fe-share-2"></i> @lang('Share')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fe fe-credit-card" style="font-size: 64px; opacity: 0.3;"></i>
                <h4 class="mt-3">@lang('No Virtual Cards Yet')</h4>
                <p class="text-muted">@lang('Create your first digital business card to share with others')</p>
                <a href="{{ route('virtual-cards.create') }}" class="btn btn-primary mt-3">
                    <i class="fe fe-plus mr-2"></i> @lang('Create Your First Card')
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
