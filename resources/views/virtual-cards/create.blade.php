@extends('layouts.dashboard')

@section('title', __('Create Virtual Card'))
@section('header-title', __('Create Virtual Card'))

@section('content')
<div class="dashboard-content">
    <div class="mb-4">
        <h2 class="mb-1">@lang('Create Virtual Card')</h2>
        <p class="text-muted mb-0">@lang('Create a shareable digital business card')</p>
    </div>

    <form action="{{ route('virtual-cards.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">@lang('Basic Information')</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label required">@lang('Card Title')</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="e.g., Professional Card, Personal Card" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">@lang('Full Name')</label>
                            <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                                   value="{{ old('full_name', auth()->user()->name) }}" required>
                            @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Job Title')</label>
                                    <input type="text" name="job_title" class="form-control"
                                           value="{{ old('job_title') }}" placeholder="e.g., Software Engineer">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Company')</label>
                                    <input type="text" name="company" class="form-control"
                                           value="{{ old('company') }}" placeholder="e.g., Tech Corp">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Bio')</label>
                            <textarea name="bio" rows="3" class="form-control"
                                      placeholder="Tell people about yourself...">{{ old('bio') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">@lang('Contact Information')</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Email')</label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ old('email', auth()->user()->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Phone')</label>
                                    <input type="text" name="phone" class="form-control"
                                           value="{{ old('phone') }}" placeholder="+1 234 567 890">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Website')</label>
                                    <input type="url" name="website" class="form-control"
                                           value="{{ old('website') }}" placeholder="https://example.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Location')</label>
                                    <input type="text" name="location" class="form-control"
                                           value="{{ old('location') }}" placeholder="City, Country">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Media Links -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">@lang('Social Media Links')</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">LinkedIn</label>
                            <input type="url" name="linkedin" class="form-control"
                                   value="{{ old('linkedin') }}" placeholder="https://linkedin.com/in/username">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Twitter</label>
                            <input type="url" name="twitter" class="form-control"
                                   value="{{ old('twitter') }}" placeholder="https://twitter.com/username">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Facebook</label>
                            <input type="url" name="facebook" class="form-control"
                                   value="{{ old('facebook') }}" placeholder="https://facebook.com/username">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Instagram</label>
                            <input type="url" name="instagram" class="form-control"
                                   value="{{ old('instagram') }}" placeholder="https://instagram.com/username">
                        </div>

                        <div class="form-group">
                            <label class="form-label">GitHub</label>
                            <input type="url" name="github" class="form-control"
                                   value="{{ old('github') }}" placeholder="https://github.com/username">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Design Settings -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">@lang('Design')</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">@lang('Theme')</label>
                            <select name="theme" class="form-control" required>
                                @foreach($themes as $key => $name)
                                    <option value="{{ $key }}" {{ old('theme', 'modern') == $key ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Primary Color')</label>
                            <input type="color" name="primary_color" class="form-control"
                                   value="{{ old('primary_color', '#667eea') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Profile Photo')</label>
                            <input type="file" name="profile_photo" class="form-control" accept="image/*">
                            <small class="text-muted">@lang('Square images work best')</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Cover Photo')</label>
                            <input type="file" name="cover_photo" class="form-control" accept="image/*">
                            <small class="text-muted">@lang('Recommended: 1200x400px')</small>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fe fe-save mr-2"></i> @lang('Create Virtual Card')
                        </button>
                        <a href="{{ route('virtual-cards.index') }}" class="btn btn-secondary btn-block">
                            @lang('Cancel')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
