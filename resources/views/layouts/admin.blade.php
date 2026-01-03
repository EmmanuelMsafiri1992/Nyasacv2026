<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="{{ app()->getLocale() }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#667eea">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}" />
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="{{ mix('css/app.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ultra-modern.css') }}?v={{ config('rb.version') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}?v={{ config('rb.version') }}">

    @stack('head')

    <!-- COMPACT SIDEBAR - INLINED TO OVERRIDE EVERYTHING -->
    <style>
/* FORCE COMPACT SIDEBAR */
body.admin-layout aside.admin-sidebar {
    position: fixed !important; left: 0 !important; top: 0 !important; bottom: 0 !important;
    width: 240px !important; height: 100vh !important; background: #ffffff !important;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1) !important; border-right: 3px solid #667eea !important;
    z-index: 1000 !important; display: flex !important; flex-direction: column !important; overflow: hidden !important;
}
body.admin-layout aside.admin-sidebar .sidebar-header-compact {
    padding: 12px 15px !important; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important; flex-shrink: 0 !important; display: block !important;
}
body.admin-layout aside.admin-sidebar .sidebar-logo-compact {
    display: flex !important; align-items: center !important; color: white !important;
    font-size: 16px !important; font-weight: 600 !important;
}
body.admin-layout aside.admin-sidebar .sidebar-logo-compact i {
    font-size: 20px !important; margin-right: 8px !important; color: white !important;
}
body.admin-layout aside.admin-sidebar .sidebar-logo-compact span {
    display: inline !important; opacity: 1 !important; visibility: visible !important; color: white !important;
}
body.admin-layout aside.admin-sidebar nav.sidebar-nav-compact {
    flex: 1 !important; padding: 8px 0 !important; overflow-y: auto !important; overflow-x: hidden !important; display: block !important;
}
body.admin-layout aside.admin-sidebar nav.sidebar-nav-compact a.nav-item-compact {
    display: flex !important; align-items: center !important; padding: 8px 15px !important;
    color: #6c757d !important; text-decoration: none !important; font-size: 13px !important;
    border-left: 3px solid transparent !important; transition: all 0.2s ease !important;
}
body.admin-layout aside.admin-sidebar nav.sidebar-nav-compact a.nav-item-compact:hover {
    background-color: #f8f9fa !important; color: #667eea !important; border-left-color: #667eea !important;
}
body.admin-layout aside.admin-sidebar nav.sidebar-nav-compact a.nav-item-compact.active {
    background-color: #e7eaff !important; color: #667eea !important; font-weight: 600 !important; border-left-color: #667eea !important;
}
body.admin-layout aside.admin-sidebar nav.sidebar-nav-compact a.nav-item-compact i {
    font-size: 16px !important; margin-right: 10px !important; width: 18px !important;
    text-align: center !important; flex-shrink: 0 !important;
}
body.admin-layout aside.admin-sidebar nav.sidebar-nav-compact a.nav-item-compact span {
    display: inline !important; opacity: 1 !important; visibility: visible !important;
}
body.admin-layout aside.admin-sidebar nav.sidebar-nav-compact .nav-divider {
    height: 1px !important; background: linear-gradient(to right, transparent, #dee2e6, transparent) !important;
    margin: 6px 15px !important; display: block !important;
}
body.admin-layout aside.admin-sidebar .sidebar-footer-compact {
    padding: 10px 15px !important; background: #f8f9fa !important; border-top: 1px solid #dee2e6 !important;
    display: flex !important; align-items: center !important; justify-content: space-between !important; flex-shrink: 0 !important;
}
body.admin-layout aside.admin-sidebar .sidebar-footer-compact .user-info-compact {
    display: flex !important; align-items: center !important; color: #495057 !important;
    font-size: 12px !important; font-weight: 500 !important; overflow: hidden !important;
}
body.admin-layout aside.admin-sidebar .sidebar-footer-compact .user-info-compact i {
    font-size: 14px !important; margin-right: 6px !important; color: #667eea !important; flex-shrink: 0 !important;
}
body.admin-layout aside.admin-sidebar .sidebar-footer-compact .user-info-compact span {
    display: inline !important; opacity: 1 !important; visibility: visible !important;
}
body.admin-layout aside.admin-sidebar .sidebar-footer-compact button.logout-btn-compact {
    background: #dc3545 !important; color: white !important; border: none !important;
    padding: 6px 10px !important; border-radius: 4px !important; cursor: pointer !important;
    font-size: 14px !important; flex-shrink: 0 !important;
}
body.admin-layout aside.admin-sidebar .sidebar-footer-compact button.logout-btn-compact:hover {
    background: #c82333 !important;
}
body.admin-layout main.admin-main {
    margin-left: 240px !important;
}
body.admin-layout aside.admin-sidebar.collapsed {
    width: 240px !important;
}
body.admin-layout aside.admin-sidebar.collapsed .sidebar-logo-compact span,
body.admin-layout aside.admin-sidebar.collapsed .nav-item-compact span,
body.admin-layout aside.admin-sidebar.collapsed .user-info-compact span {
    display: inline !important; opacity: 1 !important; visibility: visible !important;
}
@media (max-width: 992px) {
    body.admin-layout aside.admin-sidebar { transform: translateX(-100%) !important; }
    body.admin-layout aside.admin-sidebar.mobile-open { transform: translateX(0) !important; }
    body.admin-layout main.admin-main { margin-left: 0 !important; }
}
    </style>
    <script type="text/javascript">
        var BASE_URL = '{{ url('/') }}';
    </script>
</head>

<body class="admin-layout">

    <!-- Sidebar -->
    <aside class="admin-sidebar" style="background: white !important; width: 240px !important; border-right: 3px solid #667eea !important;">
        <div class="sidebar-header-compact">
            <div class="sidebar-logo-compact">
                <i class="fe fe-shield"></i>
                <span>{{ Str::limit(config('app.name'), 20) }}</span>
            </div>
        </div>

        <nav class="sidebar-nav-compact">
            <!-- Overview Section -->
            <a href="{{ route('settings.index') }}" class="nav-item-compact {{ Request::is('settings') && !Request::is('settings/*') ? 'active' : '' }}" title="Dashboard">
                <i class="fe fe-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('resume.index') }}" class="nav-item-compact" title="View Site">
                <i class="fe fe-eye"></i>
                <span>View Site</span>
            </a>

            <!-- Divider -->
            <div class="nav-divider"></div>

            <!-- Content Management -->
            <a href="{{ route('settings.resumetemplate.index') }}" class="nav-item-compact {{ Request::is('settings/resumetemplate*') ? 'active' : '' }}" title="Resume Templates">
                <i class="fe fe-layout"></i>
                <span>Templates</span>
            </a>
            <a href="{{ route('settings.resumetemplatecategories.index') }}" class="nav-item-compact {{ Request::is('settings/resumetemplatecategories*') ? 'active' : '' }}" title="Template Categories">
                <i class="fe fe-folder"></i>
                <span>Categories</span>
            </a>

            <!-- Divider -->
            <div class="nav-divider"></div>

            <!-- User & Email Management -->
            <a href="{{ route('settings.users.index') }}" class="nav-item-compact {{ Request::is('settings/users*') ? 'active' : '' }}" title="Users">
                <i class="fe fe-users"></i>
                <span>Users</span>
            </a>
            <a href="{{ route('settings.email-templates.index') }}" class="nav-item-compact {{ Request::is('settings/email-templates*') ? 'active' : '' }}" title="Email Templates">
                <i class="fe fe-file-text"></i>
                <span>Email Templates</span>
            </a>
            <a href="{{ route('settings.email-campaigns.index') }}" class="nav-item-compact {{ Request::is('settings/email-campaigns*') ? 'active' : '' }}" title="Email Campaigns">
                <i class="fe fe-send"></i>
                <span>Campaigns</span>
            </a>
            <a href="{{ route('settings.admin-emails.index') }}" class="nav-item-compact {{ Request::is('settings/admin-emails*') ? 'active' : '' }}" title="Email Inbox">
                <i class="fe fe-inbox"></i>
                <span>Email Inbox</span>
            </a>

            <!-- Divider -->
            <div class="nav-divider"></div>

            <!-- Billing -->
            <a href="{{ route('settings.packages.index') }}" class="nav-item-compact {{ Request::is('settings/packages*') ? 'active' : '' }}" title="Packages">
                <i class="fe fe-package"></i>
                <span>Packages</span>
            </a>
            <a href="{{ route('settings.payments') }}" class="nav-item-compact {{ Request::is('settings/payments*') ? 'active' : '' }}" title="Payments">
                <i class="fe fe-dollar-sign"></i>
                <span>Payments</span>
            </a>

            <!-- Divider -->
            <div class="nav-divider"></div>

            <!-- Settings -->
            <a href="{{ route('settings.general') }}" class="nav-item-compact {{ Request::is('settings/general*') ? 'active' : '' }}" title="General Settings">
                <i class="fe fe-settings"></i>
                <span>Settings</span>
            </a>
            <a href="{{ route('settings.localization') }}" class="nav-item-compact {{ Request::is('settings/localization*') ? 'active' : '' }}" title="Localization">
                <i class="fe fe-globe"></i>
                <span>Localization</span>
            </a>
            <a href="{{ route('settings.email') }}" class="nav-item-compact {{ Request::is('settings/email*') ? 'active' : '' }}" title="Email Settings">
                <i class="fe fe-mail"></i>
                <span>Email Config</span>
            </a>
            <a href="{{ route('settings.integrations') }}" class="nav-item-compact {{ Request::is('settings/integrations*') ? 'active' : '' }}" title="Integrations">
                <i class="fe fe-code"></i>
                <span>Integrations</span>
            </a>
        </nav>

        <div class="sidebar-footer-compact">
            <div class="user-info-compact">
                <i class="fe fe-user-check"></i>
                <span>{{ Str::limit(Auth::user()->name, 15) }}</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn-compact" title="Logout">
                    <i class="fe fe-log-out"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Top Header -->
        <header class="admin-header">
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fe fe-menu"></i>
            </button>
            <div class="header-title">
                <h1>@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="header-actions">
                <div class="header-user">
                    <div class="user-avatar-small">
                        <i class="fe fe-user"></i>
                    </div>
                    <span>{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="admin-content">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li><i class="fe fe-alert-circle mr-2"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fe fe-check-circle mr-2"></i> {!! session('success') !!}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fe fe-alert-triangle mr-2"></i> {!! session('error') !!}
                </div>
            @endif

            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="admin-footer">
            <div class="footer-content">
                <span>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</span>
                <span>Powered by <strong>NyasaCV</strong></span>
            </div>
        </footer>
    </main>

    <script src="{{ asset('ckeditor/ckeditor.js') }}?v={{ config('rb.version') }}"></script>
    <script src="{{ mix('js/app.bundle.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        // Flatpickr initialization
        $('input.dm-date-time-picker[type=text]').flatpickr({
            locale: document.documentElement.lang,
            enableTime: true,
            allowInput: true,
            time_24hr: true,
            enableSeconds: true,
            altInput: true,
            altFormat: "H:i - F j, Y",
            dateFormat: "Y-m-d H:i:S"
        });

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.admin-sidebar');
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');

            // Clear old collapsed state (compact sidebar doesn't use collapse)
            localStorage.removeItem('sidebarCollapsed');
            sidebar.classList.remove('collapsed');

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('mobile-open');
                });
            }

            // Close sidebar on mobile when clicking outside
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 992) {
                    if (!sidebar.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                        sidebar.classList.remove('mobile-open');
                    }
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
