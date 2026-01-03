@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col col-login mx-auto">
            <div class="auth-logo">
                <a href="/" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; justify-content: center;">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
                        <svg style="width: 28px; height: 28px; fill: white;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                            <path d="M14 2v6h6"/>
                            <line x1="8" y1="13" x2="16" y2="13" stroke="white" stroke-width="1.5" fill="none"/>
                            <line x1="8" y1="17" x2="16" y2="17" stroke="white" stroke-width="1.5" fill="none"/>
                        </svg>
                    </div>
                    <span style="font-size: 1.75rem; font-weight: 800; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; letter-spacing: -0.02em;">{{ config('app.name') }}</span>
                </a>
            </div>

            <form class="card" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="card-body p-6">
                    <div class="card-title">{{ __('Reset Password') }}</div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{ __('Enter your email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>
            </form>

            <div class="text-center" style="color: rgba(255, 255, 255, 0.95); font-size: 0.9375rem; font-weight: 500;">
                {{ __('Remember your password?') }} <a href="{{ route('login') }}">{{ __('Sign in') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
