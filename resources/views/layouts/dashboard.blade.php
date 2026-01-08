<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png"/>
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/favicon.png') }}"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'NyasaCV') }}</title>

    <!-- CSS -->
    <link href="{{ asset('css/mobile-fix-aggressive.css') }}?v={{ time() }}" rel="stylesheet" type="text/css" />
    <link href="{{ mix('css/app.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/ultra-modern.css') }}?v=1.2" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/mobile-responsive.css') }}?v={{ time() }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/dashboard-modern-2025.css') }}?v={{ time() }}" rel="stylesheet" type="text/css" />

    @yield('styles')

    <style>
    body {
        background: #f5f7fb;
    }

    /* Sidebar Styles */
    .dashboard-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 260px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        z-index: 1000;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 15px rgba(0,0,0,0.1);
    }

    .sidebar-brand {
        padding: 1.5rem 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .sidebar-brand-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .sidebar-brand-icon svg {
        width: 24px;
        height: 24px;
        fill: white;
    }

    .sidebar-brand h2 {
        color: white;
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .sidebar-user {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .sidebar-user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: 700;
        color: #667eea;
    }

    .sidebar-user-info h4 {
        color: white;
        margin: 0;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .sidebar-user-info p {
        color: rgba(255,255,255,0.7);
        margin: 0;
        font-size: 0.8rem;
    }

    .sidebar-nav {
        flex: 1;
        overflow-y: auto;
        padding: 1rem 0;
    }

    .sidebar-nav-item {
        display: block;
        padding: 0.75rem 1.5rem;
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.95rem;
    }

    .sidebar-nav-item i {
        font-size: 1.2rem;
        width: 24px;
        text-align: center;
    }

    .sidebar-nav-item:hover,
    .sidebar-nav-item.active {
        background: rgba(255,255,255,0.1);
        color: white;
        text-decoration: none;
    }

    .sidebar-nav-item.active {
        border-left: 4px solid white;
        padding-left: calc(1.5rem - 4px);
    }

    .sidebar-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(255,255,255,0.1);
    }

    /* Main Content */
    .dashboard-main {
        margin-left: 260px;
        min-height: 100vh;
    }

    .dashboard-header {
        background: white;
        padding: 1rem 2rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dashboard-header-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .dashboard-content {
        padding: 2rem;
    }

    /* Mobile Menu Toggle */
    .mobile-menu-toggle {
        display: none;
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1100;
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 1.2rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Mobile Responsive */
    @media (max-width: 991px) {
        .dashboard-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s;
        }

        .dashboard-sidebar.show {
            transform: translateX(0);
        }

        .dashboard-main {
            margin-left: 0;
        }

        .mobile-menu-toggle {
            display: block;
        }

        .dashboard-header {
            padding: 1rem;
            padding-left: 4rem;
        }

        .dashboard-content {
            padding: 1rem;
            padding-top: 4rem;
        }
    }

    /* Sidebar Overlay */
    .sidebar-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 999;
    }

    .sidebar-overlay.show {
        display: block;
    }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">
        <i class="fe fe-menu"></i>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div class="dashboard-sidebar" id="dashboardSidebar">
        <!-- Brand -->
        <a href="{{ route('dashboard') }}" class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                    <path d="M14 2v6h6"/>
                    <line x1="8" y1="13" x2="16" y2="13" stroke="white" stroke-width="1.5" fill="none"/>
                    <line x1="8" y1="17" x2="16" y2="17" stroke="white" stroke-width="1.5" fill="none"/>
                </svg>
            </div>
            <h2>{{ config('app.name') }}</h2>
        </a>

        <!-- User Info -->
        @if(auth()->check() && auth()->user())
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <h4>{{ auth()->user()->name }}</h4>
                <p>{{ auth()->user()->email }}</p>
            </div>
        </div>
        @endif

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fe fe-home"></i>
                <span>@lang('Dashboard')</span>
            </a>
            <a href="{{ route('resume.index') }}" class="sidebar-nav-item {{ request()->routeIs('resume.*') ? 'active' : '' }}">
                <i class="fe fe-file-text"></i>
                <span>@lang('My Resumes')</span>
            </a>
            <a href="{{ route('resume.template') }}" class="sidebar-nav-item">
                <i class="fe fe-plus-circle"></i>
                <span>@lang('Create Resume')</span>
            </a>
            <a href="{{ route('resume.ai.index') }}" class="sidebar-nav-item {{ request()->routeIs('resume.ai.*') ? 'active' : '' }}">
                <i class="fe fe-cpu"></i>
                <span>@lang('AI Assistant')</span>
            </a>
            <a href="{{ route('templates') }}" class="sidebar-nav-item {{ request()->routeIs('templates') ? 'active' : '' }}">
                <i class="fe fe-layout"></i>
                <span>@lang('Templates')</span>
            </a>
            <a href="{{ route('billing.index') }}" class="sidebar-nav-item {{ request()->routeIs('billing.*') ? 'active' : '' }}">
                <i class="fe fe-package"></i>
                <span>@lang('Billing & Plans')</span>
            </a>
            <a href="{{ route('profile.index') }}" class="sidebar-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fe fe-user"></i>
                <span>@lang('My Profile')</span>
            </a>

            <div style="height: 1px; background: rgba(255,255,255,0.1); margin: 1rem 0;"></div>

            <a href="{{ route('about') }}" class="sidebar-nav-item">
                <i class="fe fe-info"></i>
                <span>@lang('About')</span>
            </a>
            <a href="{{ route('contact') }}" class="sidebar-nav-item">
                <i class="fe fe-mail"></i>
                <span>@lang('Contact')</span>
            </a>
            <a href="{{ route('terms') }}" class="sidebar-nav-item">
                <i class="fe fe-file-text"></i>
                <span>@lang('Terms')</span>
            </a>
            <a href="{{ route('privacy') }}" class="sidebar-nav-item">
                <i class="fe fe-shield"></i>
                <span>@lang('Privacy')</span>
            </a>
        </nav>

        <!-- Footer -->
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-light btn-block">
                    <i class="fe fe-log-out mr-2"></i>@lang('Logout')
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-main">
        <!-- Header -->
        <div class="dashboard-header">
            <div>
                <h1 class="mb-0">@yield('header-title', __('Dashboard'))</h1>
            </div>
            <div class="dashboard-header-actions">
                @if(auth()->check() && auth()->user())
                    @if(auth()->user()->is_admin)
                        <span class="badge badge-primary">
                            <i class="fe fe-shield mr-1"></i>@lang('Administrator')
                        </span>
                    @elseif(auth()->user()->package_ends_at && auth()->user()->package_ends_at > now())
                        <span class="badge badge-success">
                            <i class="fe fe-check-circle mr-1"></i>
                            {{ auth()->user()->package->title ?? 'Premium' }}
                        </span>
                    @else
                        <a href="{{ route('billing.index') }}" class="btn btn-sm btn-primary">
                            <i class="fe fe-zap mr-1"></i>@lang('Upgrade')
                        </a>
                    @endif
                @endif
            </div>
        </div>

        <!-- Content -->
        <main>
            @if (session('success'))
                <div class="container mt-3">
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="container mt-3">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.bundle.js') }}"></script>

    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('dashboardSidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    // Close sidebar when clicking on a link on mobile
    document.querySelectorAll('.sidebar-nav-item').forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 991) {
                toggleSidebar();
            }
        });
    });
    </script>

    @yield('scripts')
</body>
</html>
