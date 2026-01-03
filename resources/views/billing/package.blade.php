@extends('layouts.dashboard')

@section('title', $package->title)
@section('header-title', __('Confirm Subscription'))

@section('content')
<div class="dashboard-content">
    <div class="row">
        <!-- Package Details -->
        <div class="col-md-5 mb-4">
            <div class="card {{ $package->is_featured ? 'card-featured' : '' }}">
                @if ($package->is_featured)
                    <div class="ribbon ribbon-top ribbon-bookmark bg-success">
                        <i class="fe fe-star"></i> @lang('Popular')
                    </div>
                @endif
                <div class="card-status bg-{{ $package->is_featured ? 'success' : 'blue' }}"></div>
                <div class="card-body text-center" style="padding: 2rem;">
                    <div class="mb-3">
                        <h3 class="card-title mb-2">{{ $package->title }}</h3>
                        <div class="text-muted small">{{ $package->interval_number }} {{ $package->interval }}</div>
                    </div>

                    <div class="display-3 my-4 font-weight-bold" style="color: {{ $package->is_featured ? '#5eba00' : '#467fcf' }};">
                        <span style="font-size: 0.6em; vertical-align: super;">{{ $currency_symbol }}</span>{{ $package->wholeprice }}<span style="font-size: 0.6em;">.{{ $package->fraction_price }}</span>
                    </div>

                    <ul class="list-unstyled text-left mb-0">
                        <li class="mb-3">
                            <i class="fe fe-check text-success mr-2"></i>
                            <span>@lang('Unlimited resumes')</span>
                        </li>
                        <li class="mb-3">
                            <i class="fe fe-check text-success mr-2"></i>
                            <span>@lang('Free templates & colors')</span>
                        </li>
                        <li class="mb-3">
                            <i class="fe fe-{{ $package->settings['template_premium'] ? 'check text-success' : 'x text-danger' }} mr-2"></i>
                            <span>@lang('Premium templates')</span>
                        </li>
                        <li class="mb-3">
                            <i class="fe fe-{{ $package->settings['export_pdf'] ? 'check text-success' : 'x text-danger' }} mr-2"></i>
                            <span>@lang('Unlimited PDF downloads')</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Confirmation Form -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-status bg-success"></div>
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fe fe-check-circle mr-2"></i>@lang('Confirm Subscription')
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <div class="d-flex">
                            <div class="mr-3">
                                <i class="fe fe-credit-card" style="font-size: 32px;"></i>
                            </div>
                            <div>
                                <h4 class="alert-title">@lang('Selected Package')</h4>
                                <p class="mb-2">@lang('You have selected the') <strong>{{ $package->title }}</strong> @lang('package.')</p>
                                <p class="mb-0">@lang('Please select a payment method below to complete your purchase.')</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="mb-3">@lang('Subscription Summary')</h4>
                            <div class="row mb-2">
                                <div class="col-6 text-muted">@lang('Package')</div>
                                <div class="col-6 text-right font-weight-bold">{{ $package->title }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 text-muted">@lang('Billing Cycle')</div>
                                <div class="col-6 text-right">{{ $package->interval_number }} {{ $package->interval }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6 text-muted">@lang('Price')</div>
                                <div class="col-6 text-right">{{ $currency_symbol }}{{ $package->wholeprice }}.{{ $package->fraction_price }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6 text-muted font-weight-bold">@lang('Total')</div>
                                <div class="col-6 text-right">
                                    <h3 class="mb-0" style="color: {{ $package->is_featured ? '#5eba00' : '#467fcf' }};">
                                        {{ $currency_symbol }}{{ $package->wholeprice }}.{{ $package->fraction_price }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Gateway Selection -->
                    <h4 class="mb-3">@lang('Select Payment Method')</h4>

                    @if(setting('STRIPE_KEY'))
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <i class="fe fe-credit-card text-primary" style="font-size: 32px;"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">@lang('Credit/Debit Card')</h5>
                                        <p class="text-muted mb-0 small">@lang('Pay securely with Stripe')</p>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('stripe-form').style.display='block'; this.style.display='none';">
                                    @lang('Select')
                                </button>
                            </div>

                            <div id="stripe-form" style="display:none;" class="mt-3 pt-3 border-top">
                                <form action="{{ route('gateway.purchase', [$package, 'stripe']) }}" method="POST" id="payment-form">
                                    @csrf
                                    <div class="alert alert-warning">
                                        <i class="fe fe-alert-triangle mr-2"></i>
                                        <strong>@lang('Demo Mode')</strong>: @lang('Use test card') <code>4242 4242 4242 4242</code> @lang('with any future expiry and CVC')
                                    </div>
                                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                        data-key="{{ setting('STRIPE_KEY') }}"
                                        data-amount="{{ $package->price * 100 }}"
                                        data-name="{{ config('app.name') }}"
                                        data-description="{{ $package->title }}"
                                        data-image="{{ asset('img/logo.png') }}"
                                        data-locale="auto"
                                        data-currency="{{ config('rb.CURRENCY_CODE') }}">
                                    </script>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(setting('PAYPAL_CLIENT_ID'))
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <i class="fe fe-dollar-sign text-info" style="font-size: 32px;"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">PayPal</h5>
                                        <p class="text-muted mb-0 small">@lang('Pay with your PayPal account')</p>
                                    </div>
                                </div>
                                <form action="{{ route('gateway.purchase', [$package, 'paypal']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-info">
                                        <i class="fe fe-external-link mr-1"></i>@lang('Pay with PayPal')
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(!setting('STRIPE_KEY') && !setting('PAYPAL_CLIENT_ID'))
                    <div class="alert alert-danger">
                        <i class="fe fe-alert-triangle mr-2"></i>
                        <strong>@lang('Payment Not Configured')</strong>
                        <p class="mb-0">@lang('No payment gateways are currently configured. Please contact the administrator.')</p>
                    </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('billing.index') }}" class="btn btn-link">
                            <i class="fe fe-arrow-left mr-1"></i>@lang('Choose different plan')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
.card-featured {
    border: 2px solid #5eba00;
    box-shadow: 0 10px 30px rgba(94, 186, 0, 0.2);
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
