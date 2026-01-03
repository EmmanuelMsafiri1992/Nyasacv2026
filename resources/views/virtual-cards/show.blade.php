@extends('layouts.dashboard')

@section('title', $card->title)
@section('header-title', __('Preview Virtual Card'))

@section('content')
<div class="dashboard-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">{{ $card->title }}</h2>
            <p class="text-muted mb-0">@lang('Preview Mode')</p>
        </div>
        <div>
            <a href="{{ route('virtual-cards.edit', $card->id) }}" class="btn btn-secondary">
                <i class="fe fe-edit mr-2"></i> @lang('Edit')
            </a>
            <a href="{{ $card->public_url }}" target="_blank" class="btn btn-primary">
                <i class="fe fe-external-link mr-2"></i> @lang('View Public Card')
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <iframe src="{{ $card->public_url }}" style="width: 100%; height: 800px; border: 2px solid #e2e8f0; border-radius: 8px;"></iframe>
        </div>
    </div>
</div>
@endsection
