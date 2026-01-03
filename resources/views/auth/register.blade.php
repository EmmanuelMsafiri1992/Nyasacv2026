@extends('layouts.auth')

@if(config('recaptcha.api_site_key') && config('recaptcha.api_secret_key'))
    @push('head')
        {!! htmlScriptTagJsApi() !!}
    @endpush
@endif

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

            <form class="card" action="{{ route('register') }}" method="post">
                @csrf

                <div class="card-body p-6">
                    <div class="card-title">@lang('Create new account')</div>
                    <div class="form-group">
                        <label for="name" class="form-label">@lang('Name')</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="@lang('Enter name')" required autofocus>
                        @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">@lang('Email address')</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="@lang('Enter email')" required>
                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">@lang('Password')</label>
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="@lang('Password')" required>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">@lang('Confirm password')</label>
                        <input id="password_confirmation" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="@lang('Confirm password')" required>
                    </div>
                    @if(config('recaptcha.api_site_key') && config('recaptcha.api_secret_key'))
                    <div class="form-group">
                        {!! htmlFormSnippet() !!}
                        @if ($errors->has('g-recaptcha-response'))
                            <div class="text-red mt-1">
                                <small><strong>{{ $errors->first('g-recaptcha-response') }}</strong></small>
                            </div>
                        @endif
                    </div>
                    @endif
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-block">@lang('Create new account')</button>
                    </div>
                    @if(config('services.facebook.client_id') && config('services.facebook.client_secret'))
                    <div class="form-footer">
                        <a href="{{ route('login.social', 'facebook') }}" class="btn btn-block btn-facebook"><i class="fe fe-facebook"></i> @lang('Login with Facebook')</a>
                    </div>
                    @endif
                </div>
            </form>
            <div class="text-center" style="color: rgba(255, 255, 255, 0.95); font-size: 0.9375rem; font-weight: 500;">
                @lang('Already have account?') <a href="{{ route('login') }}">@lang('Sign in')</a>

                <div class="mt-4">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $active_language['native'] }}
                        </button>
                        <div class="dropdown-menu">
                            @foreach($languages as $code => $language)
                                <a href="{{ route('localize', $code) }}" rel="alternate" hreflang="{{ $code }}" class="dropdown-item">{{ $language['native'] }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection