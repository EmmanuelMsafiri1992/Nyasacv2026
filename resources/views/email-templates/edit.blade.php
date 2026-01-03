@extends('layouts.admin')

@section('title', __('Edit Email Template'))
@section('page-title', __('Edit Email Template'))

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Template Details')</h3>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('settings.email-templates.update', $emailTemplate) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label">@lang('Template Name') <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $emailTemplate->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Category')</label>
                        <select name="category" class="form-control @error('category') is-invalid @enderror">
                            <option value="">@lang('Select a category')</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category', $emailTemplate->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Email Subject') <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                               value="{{ old('subject', $emailTemplate->subject) }}" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">@lang('Message') <span class="text-danger">*</span></label>
                        <textarea name="message" rows="12" class="form-control @error('message') is-invalid @enderror"
                                  required>{{ old('message', $emailTemplate->message) }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">@lang('You can use variables: {name} for user name, {email} for user email')</small>
                    </div>

                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" name="is_active" class="custom-control-input" value="1" {{ old('is_active', $emailTemplate->is_active) ? 'checked' : '' }}>
                            <span class="custom-control-label">@lang('Active (available for use)')</span>
                        </label>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fe fe-save mr-1"></i> @lang('Update Template')
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
                <h3 class="card-title">@lang('Template Info')</h3>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th>@lang('Created By'):</th>
                        <td>{{ $emailTemplate->creator->name }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Created At'):</th>
                        <td>{{ $emailTemplate->created_at->format('M j, Y') }}</td>
                    </tr>
                    <tr>
                        <th>@lang('Last Updated'):</th>
                        <td>{{ $emailTemplate->updated_at->diffForHumans() }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Template Variables')</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <code>{name}</code>
                    <div class="small text-muted">@lang('User\'s full name')</div>
                </div>

                <div class="mb-3">
                    <code>{email}</code>
                    <div class="small text-muted">@lang('User\'s email address')</div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
