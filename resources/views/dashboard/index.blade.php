@extends('layouts.dashboard')

@section('title', __('Dashboard'))

@section('content')
<div class="dashboard-wrapper">
    <!-- Main Content -->
    <div class="dashboard-content">
        <div class="page-header mb-4">
            <h1 class="page-title">@lang('Welcome back'), {{ $user->name }}! 👋</h1>
            <p class="text-muted">@lang("Here's what's happening with your account today.")</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stamp stamp-md bg-blue mr-3">
                                <i class="fe fe-file-text"></i>
                            </div>
                            <div>
                                <h3 class="m-0">{{ $totalResumes }}</h3>
                                <small class="text-muted">@lang('Total Resumes')</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stamp stamp-md bg-{{ $hasActiveSubscription ? 'success' : 'secondary' }} mr-3">
                                <i class="fe fe-package"></i>
                            </div>
                            <div>
                                @if($hasActiveSubscription)
                                    <h3 class="m-0 text-success">@lang('Active')</h3>
                                    <small class="text-muted">{{ $user->package->title ?? 'Subscription' }}</small>
                                @else
                                    <h3 class="m-0 text-muted">@lang('No Plan')</h3>
                                    <small class="text-muted">@lang('Subscribe Now')</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-hover">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="stamp stamp-md bg-{{ $user->email_verified_at ? 'green' : 'warning' }} mr-3">
                                <i class="fe fe-{{ $user->email_verified_at ? 'check-circle' : 'alert-circle' }}"></i>
                            </div>
                            <div>
                                @if($user->email_verified_at)
                                    <h3 class="m-0 text-success">@lang('Verified')</h3>
                                    <small class="text-muted">@lang('Email Verified')</small>
                                @else
                                    <h3 class="m-0 text-warning">@lang('Pending')</h3>
                                    <small class="text-muted">@lang('Verify Email')</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription Status Alert -->
        @if(!$hasActiveSubscription)
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"></button>
                <div class="d-flex">
                    <div class="mr-3">
                        <i class="fe fe-alert-triangle" style="font-size: 32px;"></i>
                    </div>
                    <div>
                        <h4 class="alert-title">@lang('Upgrade to Premium')</h4>
                        <p class="mb-2">@lang('Subscribe to a package to unlock premium features and create professional resumes.')</p>
                        <a href="{{ route('billing.index') }}" class="btn btn-warning btn-sm">
                            <i class="fe fe-package mr-2"></i>@lang('View Packages')
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"></button>
                <div class="d-flex">
                    <div class="mr-3">
                        <i class="fe fe-check-circle" style="font-size: 32px;"></i>
                    </div>
                    <div>
                        <h4 class="alert-title">@lang('Active Subscription')</h4>
                        <p class="mb-0">
                            <strong>@lang('Plan'):</strong> {{ $user->package->title ?? 'N/A' }} |
                            <strong>@lang('Expires'):</strong> {{ $user->package_ends_at ? $user->package_ends_at->format('M j, Y') : 'N/A' }}
                            <span class="badge badge-success ml-2">{{ $user->package_ends_at ? $user->package_ends_at->diffForHumans() : 'N/A' }}</span>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title"><i class="fe fe-zap mr-2"></i> @lang('Quick Actions')</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('resume.template') }}" class="btn btn-primary btn-block btn-lg d-flex flex-column align-items-center py-4">
                            <i class="fe fe-plus-circle mb-2" style="font-size: 32px;"></i>
                            <span>@lang('Create Resume')</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('resume.index') }}" class="btn btn-info btn-block btn-lg d-flex flex-column align-items-center py-4">
                            <i class="fe fe-list mb-2" style="font-size: 32px;"></i>
                            <span>@lang('My Resumes')</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('templates') }}" class="btn btn-purple btn-block btn-lg d-flex flex-column align-items-center py-4">
                            <i class="fe fe-layout mb-2" style="font-size: 32px;"></i>
                            <span>@lang('Templates')</span>
                        </a>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <a href="{{ route('billing.index') }}" class="btn btn-success btn-block btn-lg d-flex flex-column align-items-center py-4">
                            <i class="fe fe-package mb-2" style="font-size: 32px;"></i>
                            <span>@lang('Billing')</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Resumes -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fe fe-file-text mr-2"></i> @lang('Recent Resumes')</h3>
                @if($totalResumes > 0)
                    <div class="card-options">
                        <a href="{{ route('resume.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fe fe-arrow-right mr-1"></i>@lang('View All')
                        </a>
                    </div>
                @endif
            </div>
            <div class="card-body">
                @if($resumes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-vcenter">
                            <thead>
                                <tr>
                                    <th>@lang('Resume')</th>
                                    <th>@lang('Template')</th>
                                    <th>@lang('Created')</th>
                                    <th>@lang('Updated')</th>
                                    <th class="text-right">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resumes as $resume)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold">{{ $resume->name ?? 'Untitled Resume' }}</div>
                                        <div class="small text-muted">{{ Str::limit($resume->job_title ?? 'No job title', 40) }}</div>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $resume->template->title ?? 'Default' }}</span>
                                    </td>
                                    <td>
                                        <div class="small">{{ $resume->created_at->format('M j, Y') }}</div>
                                        <div class="small text-muted">{{ $resume->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td>
                                        <div class="small">{{ $resume->updated_at->format('M j, Y') }}</div>
                                        <div class="small text-muted">{{ $resume->updated_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <a href="{{ route('resume.edit', $resume) }}" class="btn btn-sm btn-primary" title="@lang('Edit')">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            @if($hasActiveSubscription)
                                            <a href="{{ route('resume.exportpdf', $resume) }}" class="btn btn-sm btn-success" target="_blank" title="@lang('Download PDF')">
                                                <i class="fe fe-download"></i>
                                            </a>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-danger" onclick="if(confirm('@lang('Are you sure?')')) { document.getElementById('delete-resume-{{ $resume->id }}').submit(); }" title="@lang('Delete')">
                                                <i class="fe fe-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-resume-{{ $resume->id }}" method="POST" action="{{ route('resume.delete', $resume) }}" style="display: none;">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fe fe-file-text" style="font-size: 80px; color: #e0e0e0;"></i>
                        </div>
                        <h3>@lang('No Resumes Yet')</h3>
                        <p class="text-muted mb-4">@lang('Create your first professional resume now and stand out from the crowd!')</p>
                        <a href="{{ route('resume.template') }}" class="btn btn-primary btn-lg">
                            <i class="fe fe-plus-circle mr-2"></i>@lang('Create Your First Resume')
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.dashboard-wrapper {
    padding: 0;
}

.dashboard-content {
    padding: 2rem;
}

.card-hover {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.btn-purple {
    background-color: #a55eea;
    border-color: #a55eea;
    color: white;
}

.btn-purple:hover {
    background-color: #974ddc;
    border-color: #974ddc;
    color: white;
}

@media (max-width: 768px) {
    .dashboard-content {
        padding: 1rem;
    }
}
</style>
@endsection
