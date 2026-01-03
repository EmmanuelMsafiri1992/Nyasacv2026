@extends('layouts.admin')

@section('title', __('Update user'))
@section('page-title', __('Update user'))

@section('content')
<div class="row">
    <div class="col-md-12">

        <form role="form" method="post" action="{{ route('settings.users.update', $user) }}">
            @csrf
            @method('PUT')

            <!-- User Information Card -->
            <div class="card">
                <div class="card-status bg-blue"></div>
                <div class="card-header">
                    <h3 class="card-title"><i class="fe fe-user mr-2"></i> @lang('User Information')</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Name') <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="@lang('Name')" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('E-mail') <span class="text-danger">*</span></label>
                                <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="@lang('E-mail')" required>
                                @if($user->email_verified_at)
                                    <small class="form-text text-success">
                                        <i class="fe fe-check-circle"></i> Email verified on {{ $user->email_verified_at->format('M j, Y H:i') }}
                                    </small>
                                @else
                                    <small class="form-text text-muted">
                                        <i class="fe fe-alert-circle"></i> Email not verified yet
                                    </small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Password')</label>
                                <input type="password" name="password" value="" class="form-control" placeholder="@lang('Leave blank to keep current password')">
                                <small class="form-text text-muted">@lang('Leave blank to keep current password')</small>
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('Confirm password')</label>
                                <input type="password" name="password_confirmation" value="" class="form-control" placeholder="@lang('Confirm password')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Status Card -->
            <div class="card">
                <div class="card-status bg-green"></div>
                <div class="card-header">
                    <h3 class="card-title"><i class="fe fe-shield mr-2"></i> @lang('Account Status')</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-label">@lang('Email Verification Status')</div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="email_verified" value="1" class="custom-switch-input" {{ $user->email_verified_at ? 'checked' : '' }}>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">@lang('Mark email as verified')</span>
                                </label>
                                <small class="form-text text-muted">
                                    <i class="fe fe-info"></i> Enable this to verify the user\'s email and allow them full access
                                </small>
                            </div>

                            <div class="form-group">
                                <div class="form-label">@lang('Administrator')</div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="is_admin" value="1" class="custom-switch-input" {{ $user->is_admin ? 'checked' : '' }}>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">@lang('Allow access to admin dashboard')</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <h4 class="alert-title"><i class="fe fe-info"></i> Registration Information</h4>
                                <div><strong>Registered:</strong> {{ $user->created_at->format('M j, Y H:i') }}</div>
                                <div><strong>Time ago:</strong> {{ $user->created_at->diffForHumans() }}</div>
                                <div><strong>Last updated:</strong> {{ $user->updated_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscription Management Card -->
            <div class="card">
                <div class="card-status bg-purple"></div>
                <div class="card-header">
                    <h3 class="card-title"><i class="fe fe-package mr-2"></i> @lang('Subscription Management')</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">@lang('Package')</label>
                                <select name="package_id" class="form-control">
                                    <option value="">@lang('No Package')</option>
                                    @foreach($packages as $package)
                                    <option value="{{ $package->id }}" {{ $package->id == $user->package_id ? 'selected' : '' }}>
                                        {{ $package->title }} - {{ config('rb.CURRENCY_SYMBOL') }}{{ $package->price }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">
                                    <i class="fe fe-info"></i> Select the subscription package for this user
                                </small>
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('Package ends at')</label>
                                <input type="text" name="package_ends_at" value="{{ $user->package_ends_at }}" class="form-control dm-date-time-picker" placeholder="@lang('Package ends at')">
                                <small class="form-text text-muted">
                                    <i class="fe fe-calendar"></i> Set when the subscription expires
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($user->package_id)
                                <div class="alert alert-{{ $user->package_ends_at && $user->package_ends_at > now() ? 'success' : 'warning' }}">
                                    <h4 class="alert-title">
                                        <i class="fe fe-{{ $user->package_ends_at && $user->package_ends_at > now() ? 'check-circle' : 'alert-circle' }}"></i>
                                        @lang('Current Subscription Status')
                                    </h4>
                                    @if($user->package)
                                        <div><strong>Package:</strong> {{ $user->package->title }}</div>
                                    @endif
                                    @if($user->package_ends_at)
                                        <div><strong>Status:</strong>
                                            @if($user->package_ends_at > now())
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Expired</span>
                                            @endif
                                        </div>
                                        <div><strong>Expires:</strong> {{ $user->package_ends_at->format('M j, Y H:i') }}</div>
                                        <div><strong>Time remaining:</strong>
                                            @if($user->package_ends_at > now())
                                                {{ $user->package_ends_at->diffForHumans() }}
                                            @else
                                                Ended {{ $user->package_ends_at->diffForHumans() }}
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="alert alert-secondary">
                                    <h4 class="alert-title"><i class="fe fe-info"></i> @lang('No Active Subscription')</h4>
                                    <p class="mb-0">This user doesn't have any active subscription package.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card">
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.users.index') }}" class="btn btn-secondary">
                            <i class="fe fe-x mr-2"></i>@lang('Cancel')
                        </a>
                        <button type="submit" class="btn btn-primary ml-auto">
                            <i class="fe fe-save mr-2"></i>@lang('Update user')
                        </button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@stop