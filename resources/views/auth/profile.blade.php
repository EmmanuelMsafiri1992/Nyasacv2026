@extends('layouts.dashboard')

@section('title', __('Profile'))
@section('header-title', __('My Profile'))

@section('content')
<div class="dashboard-content">
    <form role="form" method="post" action="{{ route('profile.update') }}" autocomplete="off">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <!-- Profile Information Card -->
                <div class="card mb-4">
                    <div class="card-status bg-blue"></div>
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fe fe-user mr-2"></i>@lang('Profile Information')
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">@lang('Name') <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="@lang('Full name')" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Email Address')</label>
                            <input type="email" value="{{ $user->email }}" class="form-control" disabled>
                            <small class="form-text text-muted">
                                <i class="fe fe-info mr-1"></i>@lang('Email address cannot be changed')
                                @if($user->email_verified_at)
                                    <span class="badge badge-success ml-2">
                                        <i class="fe fe-check-circle"></i> @lang('Verified')
                                    </span>
                                @endif
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Change Password Card -->
                <div class="card mb-4">
                    <div class="card-status bg-purple"></div>
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fe fe-lock mr-2"></i>@lang('Change Password')
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fe fe-info mr-2"></i>@lang('Leave password fields blank if you don\'t want to change your password.')
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('New Password')</label>
                            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password" placeholder="@lang('Enter new password')">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="form-label">@lang('Confirm New Password')</label>
                            <input type="password" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" name="password_confirmation" placeholder="@lang('Confirm new password')">
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fe fe-save mr-2"></i>@lang('Update Profile')
                    </button>
                </div>
            </div>

            <!-- Account Information Sidebar -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-status bg-green"></div>
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fe fe-info mr-2"></i>@lang('Account Information')
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted">@lang('User ID')</label>
                            <div class="font-weight-bold">#{{ $user->id }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">@lang('Member Since')</label>
                            <div class="font-weight-bold">{{ $user->created_at->format('M j, Y') }}</div>
                            <div class="small text-muted">{{ $user->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">@lang('Last Updated')</label>
                            <div class="font-weight-bold">{{ $user->updated_at->format('M j, Y') }}</div>
                            <div class="small text-muted">{{ $user->updated_at->diffForHumans() }}</div>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label text-muted">@lang('Account Status')</label>
                            <div>
                                @if($user->email_verified_at)
                                    <span class="badge badge-success">
                                        <i class="fe fe-check-circle"></i> @lang('Verified')
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fe fe-alert-triangle"></i> @lang('Unverified')
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">@lang('Subscription')</label>
                            <div>
                                @if($user->package_id && $user->package_ends_at && $user->package_ends_at > now())
                                    <span class="badge badge-success">
                                        <i class="fe fe-check-circle"></i> @lang('Active')
                                    </span>
                                    <div class="small text-muted mt-1">{{ $user->package->title ?? 'N/A' }}</div>
                                @else
                                    <span class="badge badge-secondary">
                                        <i class="fe fe-x-circle"></i> @lang('No Plan')
                                    </span>
                                    <div class="small mt-2">
                                        <a href="{{ route('billing.index') }}" class="btn btn-sm btn-primary btn-block">
                                            @lang('Upgrade Now')
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
