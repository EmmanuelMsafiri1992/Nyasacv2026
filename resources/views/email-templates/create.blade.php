@extends('layouts.admin')

@section('title', __('Create Email Template'))
@section('page-title', __('Create Email Template'))

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Template Details')</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('settings.email-templates.store') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">@lang('Template Name') <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required placeholder="@lang('e.g., Welcome Email, Product Launch')">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">@lang('Internal name to identify this template.')</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Category')</label>
                        <select name="category" class="form-control @error('category') is-invalid @enderror">
                            <option value="">@lang('Select a category')</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Email Subject') <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                               value="{{ old('subject') }}" required placeholder="@lang('Email subject line')">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Message') <span class="text-danger">*</span></label>
                        <textarea name="message" rows="12" class="form-control @error('message') is-invalid @enderror"
                                  required placeholder="@lang('Your email message...')">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">@lang('You can use variables: {name} for user name, {email} for user email')</small>
                    </div>

                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_active" class="custom-control-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="custom-control-label">@lang('Active (available for use)')</span>
                        </label>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fe fe-save mr-1"></i> @lang('Create Template')
                        </button>
                        <a href="{{ route('settings.email-templates.index') }}" class="btn btn-secondary">
                            <i class="fe fe-x mr-1"></i> @lang('Cancel')
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Template Variables')</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">@lang('Use these variables in your message:')</p>

                <div class="mb-3">
                    <code>{name}</code>
                    <div class="small text-muted">@lang('User\'s full name')</div>
                </div>

                <div class="mb-3">
                    <code>{email}</code>
                    <div class="small text-muted">@lang('User\'s email address')</div>
                </div>

                <hr>

                <strong>@lang('Example:')</strong>
                <div class="border p-2 mt-2 bg-light small">
                    <p>Hello {name},</p>
                    <p>We're excited to have you onboard!</p>
                    <p>Your account ({email}) is now active.</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Tips')</h3>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li class="mb-2">@lang('Keep subject lines under 50 characters')</li>
                    <li class="mb-2">@lang('Use clear and actionable language')</li>
                    <li class="mb-2">@lang('Personalize with variables')</li>
                    <li class="mb-2">@lang('Test your template before using')</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop
