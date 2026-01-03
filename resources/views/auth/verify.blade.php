@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col col-login mx-auto">
            <div class="auth-logo">
                <img src="{{ asset('img/logo.png') }}" alt="NyasaCV">
            </div>

            <div class="card">
                <div class="card-body p-6">
                    <div class="card-title text-center mb-4">{{ __('Verify Your Email Address') }}</div>

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            <i class="fe fe-check-circle mr-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <div class="avatar avatar-xxl mb-3" style="margin: 0 auto;">
                            <i class="fe fe-mail" style="font-size: 48px; color: #667eea;"></i>
                        </div>
                        <h3>Check Your Email</h3>
                        <p class="text-muted">
                            {{ __('Before proceeding, please check your email for a verification link.') }}
                        </p>
                        <p class="text-muted">
                            {{ __('If you did not receive the email') }},
                        </p>
                    </div>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fe fe-send mr-2"></i>{{ __('Resend Verification Email') }}
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="btn btn-link">
                            <i class="fe fe-arrow-left mr-2"></i>{{ __('Back to Login') }}
                        </a>
                    </div>

                    <div class="alert alert-info mt-4">
                        <div class="d-flex">
                            <div class="mr-3">
                                <i class="fe fe-info"></i>
                            </div>
                            <div>
                                <strong>{{ __('Why verify?') }}</strong><br>
                                <small>{{ __('Email verification helps us ensure account security and prevent spam accounts.') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
