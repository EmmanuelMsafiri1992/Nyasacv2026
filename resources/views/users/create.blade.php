@extends('layouts.admin')

@section('title', __('Create new user'))
@section('page-title', __('Create new user'))

@section('content')
<div class="row">
    <div class="col-md-12">

        <form role="form" method="post" action="{{ route('settings.users.store') }}">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="form-label">@lang('Name')</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="@lang('Name')">
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('E-mail')</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="@lang('E-mail')">
                            </div>

                          
                              <div class="form-group">
                                <label class="form-label">@lang('Package')</label>
                                <select name="package_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($packages as $package)
                                    <option value="{{ $package->id }}" {{ $package->id == old('package_id') ? 'selected' : '' }}>{{ $package->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                              <div class="form-group">
                                <div class="form-label">@lang('Email Verification')</div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="email_verified" value="1" class="custom-switch-input" checked>
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">@lang('Mark email as verified')</span>
                                </label>
                                <small class="form-text text-muted">
                                    <i class="fe fe-info"></i> Automatically verify email to prevent spam issues
                                </small>
                            </div>
                              <div class="form-group">
                                <div class="form-label">@lang('Administrator')</div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="is_admin" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description">@lang('Allow access to settings')</span>
                                </label>
                            </div>
                            
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label class="form-label">@lang('Password')</label>
                                <input type="password" name="password" value="" class="form-control" placeholder="@lang('Password')">
                            </div>

                            <div class="form-group">
                                <label class="form-label">@lang('Confirm password')</label>
                                <input type="password" name="password_confirmation" value="" class="form-control" placeholder="@lang('Password')">
                            </div>
                            <div class="form-group">
                                <label class="form-label">@lang('Package ends at')</label>
                                <input type="text" name="package_ends_at" value="{{ old('package_ends_at') }}" class="form-control dm-date-time-picker" placeholder="@lang('Package ends at')">
                            </div>

                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <a href="{{ route('settings.users.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                        <button class="btn btn-success ml-auto">@lang('Add user')</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
@stop