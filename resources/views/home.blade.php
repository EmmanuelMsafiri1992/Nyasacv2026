@extends('layouts.dashboard')

@section('title', __('Dashboard'))
@section('header-title', __('Dashboard'))

@section('content')
<div class="dashboard-content">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"></button>
            {{ session('status') }}
        </div>
    @endif

    <!-- Welcome Section -->
    <div class="page-header mb-4">
        <h1 class="page-title">@lang('Welcome back'), {{ auth()->user()->name }}! 👋</h1>
        <p class="text-muted">@lang("Here's what's happening with your account today.")</p>
    </div>

    <!-- Quick Actions -->
    <div class="card">
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

    <!-- Getting Started Tips -->
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title"><i class="fe fe-info mr-2"></i> @lang('Getting Started')</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                        <div class="stamp stamp-md bg-blue mr-3">
                            <span>1</span>
                        </div>
                        <div>
                            <h4>@lang('Choose a Template')</h4>
                            <p class="text-muted">@lang('Browse our collection of professional resume templates and pick the one that suits you best.')</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                        <div class="stamp stamp-md bg-green mr-3">
                            <span>2</span>
                        </div>
                        <div>
                            <h4>@lang('Fill Your Information')</h4>
                            <p class="text-muted">@lang('Add your personal details, work experience, education, and skills using our easy-to-use editor.')</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="d-flex align-items-start">
                        <div class="stamp stamp-md bg-purple mr-3">
                            <span>3</span>
                        </div>
                        <div>
                            <h4>@lang('Download & Apply')</h4>
                            <p class="text-muted">@lang('Export your resume as PDF and start applying to your dream jobs!')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
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
</style>
@endsection
@endsection
