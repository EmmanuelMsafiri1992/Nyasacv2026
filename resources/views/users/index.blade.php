@extends('layouts.admin')

@section('title', __('Users'))
@section('page-title', __('Users'))

@section('content')
<style>
.users-page-header {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.users-section {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 25px;
}

.users-section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 30px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.users-section-header i {
    font-size: 24px;
}

.users-section-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.users-section-body {
    padding: 0;
}

.stats-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 25px;
    display: flex;
    align-items: center;
    gap: 20px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: #667eea20;
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: white;
}

.stats-icon.blue {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-icon.green {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.stats-icon.purple {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
}

.stats-content h3 {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
    margin: 0;
}

.stats-content p {
    font-size: 14px;
    color: #64748b;
    margin: 0;
    font-weight: 500;
}

.search-filters-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 25px;
    margin-bottom: 25px;
}

.search-filters-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f5f9;
}

.search-filters-header i {
    color: #667eea;
    font-size: 20px;
}

.search-filters-header h4 {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.form-control-modern {
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.form-control-modern:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.form-control-modern:hover {
    border-color: #cbd5e1;
}

select.form-control-modern {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: white;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23667eea' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px 12px;
    padding-right: 40px;
    color: #1e293b;
    cursor: pointer;
    min-height: 48px;
    width: 100%;
}

select.form-control-modern option {
    color: #1e293b;
    background-color: white;
    padding: 12px 16px;
    font-size: 14px;
}

select.form-control-modern option:checked {
    background: #667eea;
    color: white;
}

.btn-modern {
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-modern:hover {
    transform: translateY(-2px);
}

.btn-primary-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
}

.btn-primary-modern:hover {
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-success-modern {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
}

.btn-success-modern:hover {
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    color: white;
}

.btn-danger-modern {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border: none;
    color: white;
}

.btn-danger-modern:hover {
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    color: white;
}

.btn-outline-modern {
    background: white;
    border: 2px solid #e2e8f0;
    color: #64748b;
}

.btn-outline-modern:hover {
    border-color: #667eea;
    color: #667eea;
    background: #f8f9ff;
}

.table-modern {
    margin: 0;
}

.table-modern thead {
    background: #f8fafc;
}

.table-modern thead th {
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    padding: 16px 20px;
    border: none;
    border-bottom: 2px solid #e2e8f0;
}

.table-modern tbody td {
    padding: 18px 20px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px;
}

.table-modern tbody tr:hover {
    background: #f8fafc;
}

.table-modern tbody tr:last-child td {
    border-bottom: none;
}

.user-name-link {
    color: #1e293b;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s ease;
}

.user-name-link:hover {
    color: #667eea;
}

.badge-modern {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.badge-modern.success {
    background: #dcfce7;
    color: #16a34a;
}

.badge-modern.warning {
    background: #fef3c7;
    color: #d97706;
}

.badge-modern.danger {
    background: #fee2e2;
    color: #dc2626;
}

.badge-modern.secondary {
    background: #f1f5f9;
    color: #64748b;
}

.badge-modern.admin {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.action-btn-group {
    display: flex;
    gap: 8px;
}

.action-btn {
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    border: none;
}

.action-btn.edit {
    background: #f0f7ff;
    color: #667eea;
}

.action-btn.edit:hover {
    background: #667eea;
    color: white;
}

.action-btn.delete {
    background: #fef2f2;
    color: #dc2626;
}

.action-btn.delete:hover {
    background: #dc2626;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 60px 30px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea20 0%, #764ba220 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-state-icon i {
    font-size: 36px;
    color: #667eea;
}

.empty-state h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
}

.empty-state p {
    color: #64748b;
    margin-bottom: 20px;
}

.pagination-wrapper {
    margin-top: 25px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    padding: 20px 25px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
}

.pagination-info {
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

.pagination-info strong {
    color: #1e293b;
    font-weight: 700;
}

.pagination-info i {
    vertical-align: middle;
}

.pagination-nav {
    display: flex;
    align-items: center;
}

.pagination-modern {
    display: flex;
    align-items: center;
    gap: 6px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.pagination-modern .page-item .page-link,
.pagination-modern li a,
.pagination-modern li span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 14px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 2px solid #e2e8f0;
    background: white;
    color: #64748b;
}

.pagination-modern .page-item .page-link:hover,
.pagination-modern li a:hover {
    border-color: #667eea;
    color: #667eea;
    background: #f8f9ff;
    transform: translateY(-2px);
}

.pagination-modern .page-item.active .page-link,
.pagination-modern li.active span,
.pagination-modern li span[aria-current="page"] {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.pagination-modern .page-item.disabled .page-link,
.pagination-modern li.disabled span {
    background: #f8fafc;
    border-color: #e2e8f0;
    color: #cbd5e1;
    cursor: not-allowed;
    transform: none;
}

.pagination-modern .page-item:first-child .page-link,
.pagination-modern .page-item:last-child .page-link {
    padding: 0 16px;
}

/* Override default Laravel pagination styles */
.pagination {
    display: flex;
    align-items: center;
    gap: 6px;
    list-style: none;
    margin: 0;
    padding: 0;
}

.pagination li {
    margin: 0;
}

.pagination li a,
.pagination li span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 14px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 2px solid #e2e8f0;
    background: white;
    color: #64748b;
}

.pagination li a:hover {
    border-color: #667eea;
    color: #667eea;
    background: #f8f9ff;
    transform: translateY(-2px);
}

.pagination li.active span,
.pagination li span[aria-current="page"],
.pagination .active > span {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border-color: transparent !important;
    color: white !important;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.pagination li.disabled span,
.pagination .disabled > span {
    background: #f8fafc !important;
    border-color: #e2e8f0 !important;
    color: #cbd5e1 !important;
    cursor: not-allowed;
}

/* Tailwind pagination overrides */
nav[role="navigation"] {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    flex-wrap: wrap;
    gap: 15px;
}

nav[role="navigation"] > div:first-child {
    font-size: 14px;
    color: #64748b;
    font-weight: 500;
}

nav[role="navigation"] > div:first-child span.font-medium {
    color: #1e293b;
    font-weight: 700;
}

nav[role="navigation"] .relative.inline-flex {
    gap: 6px;
}

@media (max-width: 640px) {
    .pagination-wrapper {
        flex-direction: column;
        text-align: center;
    }

    .pagination li a,
    .pagination li span {
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        font-size: 13px;
    }
}

.meta-text {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 4px;
}

.meta-text i {
    margin-right: 4px;
}

.checkbox-modern {
    width: 18px;
    height: 18px;
    border-radius: 5px;
    cursor: pointer;
}

@media (max-width: 768px) {
    .users-page-header {
        padding: 20px;
    }

    .search-filters-card {
        padding: 20px;
    }

    .stats-card {
        padding: 20px;
    }

    .action-btn-group {
        flex-direction: column;
    }

    .table-modern thead th,
    .table-modern tbody td {
        padding: 12px 15px;
    }
}
</style>

<div class="row">
    <div class="col-md-12">
        <!-- Page Header -->
        <div class="users-page-header">
            <h2 class="mb-1" style="font-weight: 800; color: #1e293b;">
                <i class="fe fe-users mr-2" style="color: #667eea;"></i>User Management
            </h2>
            <p class="text-muted mb-0">Manage registered users, subscriptions, and email verification status</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="stats-card">
                    <div class="stats-icon blue">
                        <i class="fe fe-users"></i>
                    </div>
                    <div class="stats-content">
                        <h3>{{ $totalUsers }}</h3>
                        <p>@lang('Total Registered')</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="stats-card">
                    <div class="stats-icon green">
                        <i class="fe fe-check-circle"></i>
                    </div>
                    <div class="stats-content">
                        <h3>{{ $verifiedUsers }}</h3>
                        <p>@lang('Email Verified')</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-icon purple">
                        <i class="fe fe-package"></i>
                    </div>
                    <div class="stats-content">
                        <h3>{{ $subscribedUsers }}</h3>
                        <p>@lang('Active Subscriptions')</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="search-filters-card">
            <div class="search-filters-header">
                <i class="fe fe-filter"></i>
                <h4>@lang('Search & Filters')</h4>
            </div>
            <form method="get" action="{{ route('settings.users.index') }}" autocomplete="off">
                <div class="row align-items-end">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label" style="font-weight: 600; color: #475569; font-size: 13px;">
                            <i class="fe fe-search mr-1" style="color: #667eea;"></i>@lang('Search Users')
                        </label>
                        <input type="text" name="search" value="{{ Request::get('search') }}" class="form-control form-control-modern" placeholder="@lang('Name or email...')">
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label class="form-label" style="font-weight: 600; color: #475569; font-size: 13px;">
                            <i class="fe fe-filter mr-1" style="color: #667eea;"></i>@lang('Filter by Status')
                        </label>
                        <select name="verified" class="form-control form-control-modern" onchange="this.form.submit()">
                            <option value="">@lang('All Users')</option>
                            <option value="yes" {{ Request::get('verified') == 'yes' ? 'selected' : '' }}>@lang('Verified Only')</option>
                            <option value="no" {{ Request::get('verified') == 'no' ? 'selected' : '' }}>@lang('Not Verified')</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <div class="d-flex flex-wrap gap-2" style="gap: 10px;">
                            <button type="button" id="sendToSelectedBtn" class="btn btn-modern btn-primary-modern" style="display: none;">
                                <i class="fe fe-mail"></i> @lang('Send Email to Selected')
                            </button>
                            <a href="{{ route('settings.email-campaigns.create') }}" class="btn btn-modern btn-primary-modern">
                                <i class="fe fe-mail"></i> @lang('Send to All Verified')
                            </a>
                            <a href="{{ route('settings.users.create') }}" class="btn btn-modern btn-success-modern">
                                <i class="fe fe-plus"></i> @lang('Create User')
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bulk Actions -->
        @if($data->count() > 0 && $data->where('email_verified_at', null)->where('is_admin', false)->count() > 0)
        <div class="search-filters-card" style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border: 2px solid #fecaca;">
            <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 15px;">
                <div class="d-flex align-items-center" style="gap: 12px;">
                    <div style="width: 45px; height: 45px; background: #dc2626; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fe fe-alert-triangle" style="color: white; font-size: 20px;"></i>
                    </div>
                    <div>
                        <h5 style="margin: 0; font-weight: 700; color: #991b1b;">@lang('Cleanup Unverified Users')</h5>
                        <p style="margin: 0; font-size: 13px; color: #b91c1c;">Remove users who haven't verified their email addresses</p>
                    </div>
                </div>
                <button type="button" class="btn btn-modern btn-danger-modern" onclick="confirmDeleteUnverified()">
                    <i class="fe fe-trash-2"></i> @lang('Delete All Unverified')
                </button>
            </div>
        </div>
        @endif

        <!-- Users Table -->
        @if($data->count() > 0)
        <div class="users-section">
            <div class="users-section-header">
                <i class="fe fe-users"></i>
                <h3 class="users-section-title">@lang('Registered Users')</h3>
            </div>
            <div class="users-section-body">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" id="selectAll" class="checkbox-modern">
                                </th>
                                <th>@lang('Name')</th>
                                <th>@lang('E-mail')</th>
                                <th>@lang('Email Status')</th>
                                <th>@lang('Registration')</th>
                                <th>@lang('Subscription')</th>
                                <th class="text-right">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td>
                                    @if($item->email_verified_at && !$item->is_admin)
                                        <input type="checkbox" class="user-checkbox checkbox-modern" value="{{ $item->id }}" data-email="{{ $item->email }}" data-name="{{ $item->name }}">
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('settings.users.edit', $item) }}" class="user-name-link">{{ $item->name }}</a>
                                    @if($item->is_admin)
                                        <span class="badge-modern admin ml-2">
                                            <i class="fe fe-shield"></i> Admin
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span style="color: #475569;">{{ $item->email }}</span>
                                </td>
                                <td>
                                    @if($item->email_verified_at)
                                        <span class="badge-modern success">
                                            <i class="fe fe-check-circle"></i> @lang('Verified')
                                        </span>
                                        <div class="meta-text">
                                            <i class="fe fe-calendar"></i>{{ $item->email_verified_at->format('M j, Y') }}
                                        </div>
                                    @else
                                        <span class="badge-modern warning">
                                            <i class="fe fe-alert-triangle"></i> @lang('Not Verified')
                                        </span>
                                        <div class="meta-text">
                                            <i class="fe fe-alert-circle"></i>@lang('Potential spam risk')
                                        </div>
                                        <button type="button" class="btn btn-sm mt-2 resend-verification-btn"
                                                data-user-id="{{ $item->id }}"
                                                data-user-email="{{ $item->email }}"
                                                style="background: #f0f7ff; color: #667eea; border: 1px solid #667eea; border-radius: 6px; font-size: 11px; padding: 4px 10px;">
                                            <i class="fe fe-send"></i> @lang('Resend Verification')
                                        </button>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #1e293b;">{{ $item->created_at->format('M j, Y') }}</div>
                                    <div class="meta-text">{{ $item->created_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    @if($item->package_id && $item->package_ends_at && $item->package_ends_at > now())
                                        <span class="badge-modern success">
                                            <i class="fe fe-check-circle"></i> @lang('Active')
                                        </span>
                                        @if($item->package)
                                            <div class="meta-text" style="font-weight: 600; color: #667eea;">
                                                {{ $item->package->title }}
                                            </div>
                                        @endif
                                        <div class="meta-text">
                                            <i class="fe fe-clock"></i>@lang('Expires'): {{ \Carbon\Carbon::parse($item->package_ends_at)->format('M j, Y') }}
                                        </div>
                                    @elseif($item->package_id && $item->package_ends_at && $item->package_ends_at <= now())
                                        <span class="badge-modern danger">
                                            <i class="fe fe-x-circle"></i> @lang('Expired')
                                        </span>
                                        <div class="meta-text">
                                            <i class="fe fe-clock"></i>@lang('Ended'): {{ \Carbon\Carbon::parse($item->package_ends_at)->format('M j, Y') }}
                                        </div>
                                    @else
                                        <span class="badge-modern secondary">
                                            <i class="fe fe-minus-circle"></i> @lang('No Subscription')
                                        </span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="action-btn-group justify-content-end">
                                        <a href="{{ route('settings.users.edit', $item) }}" class="action-btn edit">
                                            <i class="fe fe-edit-2"></i> @lang('Edit')
                                        </a>
                                        <button type="button" class="action-btn delete" onclick="if(confirm('@lang('Confirm delete?')')) { document.getElementById('delete-form-{{ $item->id }}').submit(); }">
                                            <i class="fe fe-trash-2"></i> @lang('Delete')
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $item->id }}" method="post" action="{{ route('settings.users.destroy', $item) }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="pagination-wrapper">
            <div class="pagination-info">
                <i class="fe fe-list mr-2" style="color: #667eea;"></i>
                @lang('Showing') <strong>{{ $data->firstItem() ?? 0 }}</strong> @lang('to') <strong>{{ $data->lastItem() ?? 0 }}</strong> @lang('of') <strong>{{ $data->total() }}</strong> @lang('users')
            </div>
            <div class="pagination-nav">
                @if ($data->hasPages())
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($data->onFirstPage())
                            <li class="disabled">
                                <span><i class="fe fe-chevron-left"></i></span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $data->appends(Request::all())->previousPageUrl() }}">
                                    <i class="fe fe-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($data->appends(Request::all())->getUrlRange(1, $data->lastPage()) as $page => $url)
                            @if ($page == $data->currentPage())
                                <li class="active"><span>{{ $page }}</span></li>
                            @elseif ($page == 1 || $page == $data->lastPage() || abs($page - $data->currentPage()) <= 2)
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @elseif (abs($page - $data->currentPage()) == 3)
                                <li class="disabled"><span>...</span></li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($data->hasMorePages())
                            <li>
                                <a href="{{ $data->appends(Request::all())->nextPageUrl() }}">
                                    <i class="fe fe-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="disabled">
                                <span><i class="fe fe-chevron-right"></i></span>
                            </li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fe fe-users"></i>
            </div>
            <h3>@lang('No users found')</h3>
            <p>@lang('There are no users matching your search criteria.')</p>
            <a href="{{ route('settings.users.create') }}" class="btn btn-modern btn-success-modern">
                <i class="fe fe-plus"></i> @lang('Create First User')
            </a>
        </div>
        @endif

    </div>
</div>

<!-- Delete Unverified Users Form -->
<form id="delete-unverified-form" method="post" action="{{ route('settings.users.delete-unverified') }}" style="display: none;">
    @csrf
</form>

<script>
// Delete unverified users with confirmation
function confirmDeleteUnverified() {
    const unverifiedCount = {{ $data->where('email_verified_at', null)->where('is_admin', false)->count() }};

    if (unverifiedCount === 0) {
        alert('@lang("No unverified users found to delete.")');
        return;
    }

    const message = '@lang("Are you sure you want to delete all :count unverified users? This action cannot be undone!")'.replace(':count', unverifiedCount);

    if (confirm(message)) {
        const confirmAgain = confirm('@lang("This will permanently delete :count users. Are you absolutely sure?")'.replace(':count', unverifiedCount));
        if (confirmAgain) {
            document.getElementById('delete-unverified-form').submit();
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const sendToSelectedBtn = document.getElementById('sendToSelectedBtn');

    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSendButton();
        });
    }

    // Individual checkbox change
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSendButton();

            // Update select all checkbox
            const allChecked = Array.from(userCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(userCheckboxes).some(cb => cb.checked);
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
        });
    });

    // Update send button visibility
    function updateSendButton() {
        const checkedCount = document.querySelectorAll('.user-checkbox:checked').length;
        if (checkedCount > 0) {
            sendToSelectedBtn.style.display = 'inline-flex';
            sendToSelectedBtn.innerHTML = '<i class="fe fe-mail"></i> ' + '@lang("Send Email to Selected")' + ' (' + checkedCount + ')';
        } else {
            sendToSelectedBtn.style.display = 'none';
        }
    }

    // Send to selected button click
    sendToSelectedBtn.addEventListener('click', function() {
        const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked')).map(cb => cb.value);

        if (selectedUsers.length === 0) {
            alert('@lang("Please select at least one user")');
            return;
        }

        // Store selected users in sessionStorage and redirect
        sessionStorage.setItem('selectedUsers', JSON.stringify(selectedUsers));
        window.location.href = '{{ route("settings.email-campaigns.create") }}?selected=1';
    });

    // Resend verification email functionality
    document.querySelectorAll('.resend-verification-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userEmail = this.dataset.userEmail;
            const button = this;

            // Disable button and show loading state
            button.disabled = true;
            button.innerHTML = '<i class="fe fe-loader fe-spin"></i> @lang("Sending...")';
            button.style.opacity = '0.7';

            fetch('{{ route("settings.users.resend-verification") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success state
                    button.innerHTML = '<i class="fe fe-check"></i> @lang("Sent!")';
                    button.style.background = '#dcfce7';
                    button.style.color = '#16a34a';
                    button.style.borderColor = '#16a34a';

                    // Show success alert
                    showNotification('success', '@lang("Verification email sent successfully to") ' + userEmail);

                    // Reset button after 3 seconds
                    setTimeout(function() {
                        button.disabled = false;
                        button.innerHTML = '<i class="fe fe-send"></i> @lang("Resend Verification")';
                        button.style.background = '#f0f7ff';
                        button.style.color = '#667eea';
                        button.style.borderColor = '#667eea';
                        button.style.opacity = '1';
                    }, 3000);
                } else {
                    // Show error state
                    button.innerHTML = '<i class="fe fe-x"></i> @lang("Failed")';
                    button.style.background = '#fee2e2';
                    button.style.color = '#dc2626';
                    button.style.borderColor = '#dc2626';

                    // Show error alert with message
                    showNotification('error', data.message || '@lang("Failed to send verification email. The email address may be invalid or unreachable.")');

                    // Reset button after 3 seconds
                    setTimeout(function() {
                        button.disabled = false;
                        button.innerHTML = '<i class="fe fe-send"></i> @lang("Resend Verification")';
                        button.style.background = '#f0f7ff';
                        button.style.color = '#667eea';
                        button.style.borderColor = '#667eea';
                        button.style.opacity = '1';
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.innerHTML = '<i class="fe fe-x"></i> @lang("Failed")';
                button.style.background = '#fee2e2';
                button.style.color = '#dc2626';
                button.style.borderColor = '#dc2626';

                showNotification('error', '@lang("Network error. Please try again.")');

                setTimeout(function() {
                    button.disabled = false;
                    button.innerHTML = '<i class="fe fe-send"></i> @lang("Resend Verification")';
                    button.style.background = '#f0f7ff';
                    button.style.color = '#667eea';
                    button.style.borderColor = '#667eea';
                    button.style.opacity = '1';
                }, 3000);
            });
        });
    });
});

// Notification function
function showNotification(type, message) {
    // Remove existing notification
    const existingNotif = document.querySelector('.verification-notification');
    if (existingNotif) {
        existingNotif.remove();
    }

    const notifDiv = document.createElement('div');
    notifDiv.className = 'verification-notification';
    notifDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 16px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        animation: slideIn 0.3s ease;
        max-width: 400px;
    `;

    if (type === 'success') {
        notifDiv.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
        notifDiv.style.color = 'white';
        notifDiv.innerHTML = '<i class="fe fe-check-circle"></i> ' + message;
    } else {
        notifDiv.style.background = 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
        notifDiv.style.color = 'white';
        notifDiv.innerHTML = '<i class="fe fe-alert-circle"></i> ' + message;
    }

    document.body.appendChild(notifDiv);

    // Auto remove after 5 seconds
    setTimeout(function() {
        notifDiv.style.animation = 'slideOut 0.3s ease';
        setTimeout(function() {
            notifDiv.remove();
        }, 300);
    }, 5000);
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
    .fe-spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>
@stop
