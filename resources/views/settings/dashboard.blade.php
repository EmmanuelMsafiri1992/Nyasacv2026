@extends('layouts.admin')

@section('title', __('Dashboard'))
@section('page-title', __('Dashboard Overview'))

@section('content')
<div class="stats-grid">
    <!-- Total Users -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div>
                <div class="stat-card-value">{{ $totalUsers }}</div>
                <div class="stat-card-label">Total Users</div>
            </div>
            <div class="stat-card-icon">
                <i class="fe fe-users"></i>
            </div>
        </div>
        @if(isset($userGrowth))
        <div class="stat-card-change {{ $userGrowth >= 0 ? 'positive' : 'negative' }}">
            <i class="fe fe-{{ $userGrowth >= 0 ? 'trending-up' : 'trending-down' }}"></i>
            <span>{{ abs($userGrowth) }}% from last month</span>
        </div>
        @endif
    </div>

    <!-- Total Resumes -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div>
                <div class="stat-card-value">{{ $totalResumes }}</div>
                <div class="stat-card-label">Total Resumes</div>
            </div>
            <div class="stat-card-icon">
                <i class="fe fe-file-text"></i>
            </div>
        </div>
        @if(isset($resumeGrowth))
        <div class="stat-card-change {{ $resumeGrowth >= 0 ? 'positive' : 'negative' }}">
            <i class="fe fe-{{ $resumeGrowth >= 0 ? 'trending-up' : 'trending-down' }}"></i>
            <span>{{ abs($resumeGrowth) }}% from last month</span>
        </div>
        @endif
    </div>

    <!-- Active Subscriptions -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div>
                <div class="stat-card-value">{{ $activeSubscriptions }}</div>
                <div class="stat-card-label">Active Subscriptions</div>
            </div>
            <div class="stat-card-icon">
                <i class="fe fe-check-circle"></i>
            </div>
        </div>
        @if(isset($subscriptionGrowth))
        <div class="stat-card-change {{ $subscriptionGrowth >= 0 ? 'positive' : 'negative' }}">
            <i class="fe fe-{{ $subscriptionGrowth >= 0 ? 'trending-up' : 'trending-down' }}"></i>
            <span>{{ abs($subscriptionGrowth) }}% from last month</span>
        </div>
        @endif
    </div>

    <!-- Resume Templates -->
    <div class="stat-card">
        <div class="stat-card-header">
            <div>
                <div class="stat-card-value">{{ $totalTemplates }}</div>
                <div class="stat-card-label">Resume Templates</div>
            </div>
            <div class="stat-card-icon">
                <i class="fe fe-layout"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fe fe-trending-up mr-2"></i> Recent Activity</h3>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="activity-list">
                    @forelse($recentUsers->take(5) as $user)
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fe fe-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">New user registered: {{ $user->name }}</div>
                            <div class="activity-time">{{ $user->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state" style="padding: 2rem;">
                        <div class="empty-state-icon">
                            <i class="fe fe-inbox"></i>
                        </div>
                        <div class="empty-state-title">No recent activity</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fe fe-zap mr-2"></i> Quick Actions</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <a href="{{ route('settings.resumetemplate.create') }}" class="btn btn-primary btn-block">
                        <i class="fe fe-plus mr-2"></i> Add Resume Template
                    </a>
                    <a href="{{ route('settings.packages.create') }}" class="btn btn-secondary btn-block">
                        <i class="fe fe-package mr-2"></i> Create Package
                    </a>
                    <a href="{{ route('settings.users.create') }}" class="btn btn-secondary btn-block">
                        <i class="fe fe-user-plus mr-2"></i> Add User
                    </a>
                    <a href="{{ route('settings.index') }}" class="btn btn-outline-primary btn-block">
                        <i class="fe fe-settings mr-2"></i> System Settings
                    </a>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 1.5rem;">
            <div class="card-header">
                <h3 class="card-title"><i class="fe fe-info mr-2"></i> System Info</h3>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.875rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #718096;">Laravel Version:</span>
                        <strong>{{ app()->version() }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #718096;">PHP Version:</span>
                        <strong>{{ phpversion() }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #718096;">App Version:</span>
                        <strong>{{ config('rb.version', '1.0.0') }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
