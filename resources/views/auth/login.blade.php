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
            <form class="card" action="{{ route('login') }}" method="post">
                @csrf
                <div class="card-body p-6">
                    <div class="card-title">@lang('Login to your account')</div>
                    <div class="form-group">
                        <label for="email" class="form-label">@lang('E-Mail Address')</label>
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="@lang('Enter email')" required autofocus>
                        @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">
                            @lang('Password')
                            <a href="{{ route('password.request') }}" class="float-right small">@lang('I forgot password')</a>
                        </label>
                        <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" placeholder="Password">
                        @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old( 'remember') ? 'checked' : '' }}>
                            <span class="custom-control-label">@lang('Remember me')</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary btn-block">@lang('Sign in')</button>
                    </div>
                    @if(config('services.facebook.client_id') && config('services.facebook.client_secret'))
                    <div class="form-footer">
                        <a href="{{ route('login.social', 'facebook') }}" class="btn btn-block btn-facebook"><i class="fe fe-facebook"></i> @lang('Login with Facebook')</a>
                    </div>
                    @endif
                </div>
            </form>
            <div class="text-center" style="color: rgba(255, 255, 255, 0.95); font-size: 0.9375rem; font-weight: 500;">
                @lang('Don\'t have account yet?') <a href="{{ route('register') }}">@lang('Sign up')</a>

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
