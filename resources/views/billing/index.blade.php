@extends('layouts.dashboard')

@section('title', __('Billing & Plans'))
@section('header-title', __('Billing & Plans'))

@section('content')
<div class="dashboard-content">
    <div class="mb-4">
        <h2 class="mb-0">@lang('Choose Your Plan')</h2>
        <p class="text-muted mb-0">@lang('Select the perfect plan for your resume building needs')</p>
    </div>

    @if($subscribed)
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"></button>
            <div class="d-flex">
                <div class="mr-3">
                    <i class="fe fe-check-circle" style="font-size: 32px;"></i>
                </div>
                <div>
                    <h4 class="alert-title">@lang('Active Subscription')</h4>
                    <p class="mb-0">
                        @if($subscription_expires_in > 0)
                            @lang('Your subscription for :package is currently active and expires in :expires_in days.', [
                                'package' => '<strong>' . $subscription_title . '</strong>',
                                'expires_in' => '<strong>' . ceil($subscription_expires_in) . '</strong>'
                            ])
                        @else
                            @lang('Your subscription for :package expires today!', [
                                'package' => '<strong>' . $subscription_title . '</strong>'
                            ])
                        @endif
                    </p>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->package_id && auth()->user()->package_ends_at)
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"></button>
            <div class="d-flex">
                <div class="mr-3">
                    <i class="fe fe-x-circle" style="font-size: 32px;"></i>
                </div>
                <div>
                    <h4 class="alert-title">@lang('Subscription Expired')</h4>
                    <p class="mb-0">@lang('Your :package subscription has expired. Please choose a plan below to renew and continue enjoying premium features.', [
                        'package' => '<strong>' . auth()->user()->package->title . '</strong>'
                    ])</p>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"></button>
            <div class="d-flex">
                <div class="mr-3">
                    <i class="fe fe-info" style="font-size: 32px;"></i>
                </div>
                <div>
                    <h4 class="alert-title">@lang('No Active Subscription')</h4>
                    <p class="mb-0">@lang('Choose a plan below to unlock premium features and templates.')</p>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        @foreach($packages as $package)
            <div class="col-sm-6 col-lg-{{ 12 / count($packages) }} mb-4">
                <div class="card {{ $package->is_featured ? 'card-featured' : '' }}" style="height: 100%;">
                    @if ($package->is_featured)
                        <div class="ribbon ribbon-top ribbon-bookmark bg-success">
                            <i class="fe fe-star"></i> @lang('Popular')
                        </div>
                    @endif
                    <div class="card-body text-center d-flex flex-column" style="padding: 2rem;">
                        <div class="mb-3">
                            <h3 class="card-title mb-2">{{ $package->title }}</h3>
                            <div class="text-muted small">{{ $package->interval_number }} {{ $package->interval }}</div>
                        </div>

                        <div class="display-3 my-4 font-weight-bold" style="color: {{ $package->is_featured ? '#5eba00' : '#467fcf' }};">
                            <span style="font-size: 0.6em; vertical-align: super;">{{ $currency_symbol }}</span>{{ $package->wholeprice }}<span style="font-size: 0.6em;">.{{ $package->fraction_price }}</span>
                        </div>

                        <ul class="list-unstyled text-left mb-4 flex-grow-1">
                            <li class="mb-2">
                                <i class="fe fe-check text-success mr-2"></i>
                                <span>@lang('Unlimited resumes')</span>
                            </li>
                            <li class="mb-2">
                                <i class="fe fe-check text-success mr-2"></i>
                                <span>@lang('Free templates & colors')</span>
                            </li>
                            <li class="mb-2">
                                <i class="fe fe-{{ $package->settings['template_premium'] ? 'check text-success' : 'x text-danger' }} mr-2"></i>
                                <span>@lang('Premium templates')</span>
                            </li>
                            <li class="mb-2">
                                <i class="fe fe-{{ $package->settings['export_pdf'] ? 'check text-success' : 'x text-danger' }} mr-2"></i>
                                <span>@lang('Unlimited PDF downloads')</span>
                            </li>
                        </ul>

                        <div class="mt-auto">
                            <a href="{{ route('billing.package', $package) }}" class="btn btn-{{ $package->is_featured ? 'success' : 'primary' }} btn-block btn-lg">
                                <i class="fe fe-check mr-2"></i>@lang('Choose Plan')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($subscribed)
        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title"><i class="fe fe-settings mr-2"></i>@lang('Subscription Management')</h3>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-2">@lang('Current Plan: :plan', ['plan' => $subscription_title])</h4>
                        <p class="text-muted mb-0">
                            @lang('Want to change your plan? You can cancel your current subscription and choose a different plan.')
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <form action="{{ route('billing.cancel') }}" method="POST" onsubmit="return confirm('@lang('Are you sure you want to cancel your subscription?')');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fe fe-x-circle mr-2"></i>@lang('Cancel Subscription')
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->package_id && auth()->user()->package_ends_at)
        <div class="card mt-4">
            <div class="card-header bg-danger text-white">
                <h3 class="card-title"><i class="fe fe-alert-triangle mr-2"></i>@lang('Expired Subscription')</h3>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-2">@lang('Your subscription has expired')</h4>
                        <p class="text-muted mb-0">
                            @lang('Your :plan subscription expired on :date. Choose a new plan below to continue using premium features.', [
                                'plan' => auth()->user()->package->title,
                                'date' => auth()->user()->package_ends_at->format('M j, Y')
                            ])
                        </p>
                    </div>
                    <div class="col-md-4 text-right">
                        <form action="{{ route('billing.cancel') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-secondary btn-sm">
                                <i class="fe fe-trash mr-1"></i>@lang('Clear Expired Data')
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@section('styles')
<style>
.card-featured {
    border: 2px solid #5eba00;
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(94, 186, 0, 0.2);
}

.card-featured:hover {
    box-shadow: 0 15px 40px rgba(94, 186, 0, 0.3);
}

.ribbon {
    width: 100px;
    position: absolute;
    top: 10px;
    right: -10px;
    padding: 5px 10px;
    color: white;
    text-align: center;
    font-size: 12px;
    font-weight: bold;
    z-index: 10;
}

.ribbon-bookmark:before {
    content: '';
    position: absolute;
    right: 0;
    bottom: -10px;
    border-left: 50px solid transparent;
    border-right: 50px solid;
    border-right-color: inherit;
    border-bottom: 10px solid transparent;
}
</style>
@endsection
@endsection
