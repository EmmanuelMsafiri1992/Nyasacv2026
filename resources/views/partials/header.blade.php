<div class="d-flex">
    <a class="header-brand" href="{{ route('landing') }}">
        <img src="{{ asset('img/logo.png') }}" class="header-brand-img" alt="Resume Builder">
        {{ __(config('app.name')) }}
    </a>
    <div class="d-flex order-lg-2 ml-auto">
        <div class="dropup">
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

        @auth
        <div class="dropdown">
            <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                <span class="avatar avatar-blue avatar-shortname mr-3 d-lg-none">
                    <div>{{ Auth::user()->name }}</div>
                </span>
                <span class="d-none d-lg-block">
                    <span class="text-default">{{ Auth::user()->name }}</span>
                    <small class="text-muted d-block mt-1">{{ Auth::user()->email }}</small>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                <a class="dropdown-item" href="{{ route('profile.index') }}">
                    <i class="dropdown-icon fe fe-user"></i> @lang('Profile')
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('logout') }}">
                    <i class="dropdown-icon fe fe-log-out"></i> @lang('Sign out')
                </a>
            </div>
        </div>
        @else
        <div class="dropdown">
            <a href="{{ route('login') }}" class="nav-link pr-0 leading-none">
                <span class="d-none d-lg-block">
                    <span class="text-default">@lang('Sign In')</span>
                </span>
            </a>
        </div>
        @endauth
    </div>
    <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0 collapsed" data-toggle="collapse" data-target="#headerMenuCollapse" aria-expanded="false">
        <span class="header-toggler-icon"></span>
    </a>
</div>
