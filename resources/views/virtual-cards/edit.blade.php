@extends('layouts.dashboard')

@section('title', __('Edit Virtual Card'))
@section('header-title', __('Edit Virtual Card'))

@section('content')
<div class="dashboard-content">
    <div class="mb-4">
        <h2 class="mb-1">@lang('Edit Virtual Card')</h2>
        <p class="text-muted mb-0">{{ $card->title }}</p>
    </div>

    <form action="{{ route('virtual-cards.update', $card->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                                   value="{{ old('title', $card->title) }}" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">@lang('Full Name')</label>
                            <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                                   value="{{ old('full_name', $card->full_name) }}" required>
                            @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Job Title')</label>
                                    <input type="text" name="job_title" class="form-control"
                                           value="{{ old('job_title', $card->job_title) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Company')</label>
                                    <input type="text" name="company" class="form-control"
                                           value="{{ old('company', $card->company) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Bio')</label>
                            <textarea name="bio" rows="3" class="form-control">{{ old('bio', $card->bio) }}</textarea>
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
                                           value="{{ old('email', $card->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Phone')</label>
                                    <input type="text" name="phone" class="form-control"
                                           value="{{ old('phone', $card->phone) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Website')</label>
                                    <input type="url" name="website" class="form-control"
                                           value="{{ old('website', $card->website) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('Location')</label>
                                    <input type="text" name="location" class="form-control"
                                           value="{{ old('location', $card->location) }}">
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
                        @php $social = $card->social_links ?? []; @endphp

                        <div class="form-group">
                            <label class="form-label">LinkedIn</label>
                            <input type="url" name="linkedin" class="form-control"
                                   value="{{ old('linkedin', $social['linkedin'] ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Twitter</label>
                            <input type="url" name="twitter" class="form-control"
                                   value="{{ old('twitter', $social['twitter'] ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Facebook</label>
                            <input type="url" name="facebook" class="form-control"
                                   value="{{ old('facebook', $social['facebook'] ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Instagram</label>
                            <input type="url" name="instagram" class="form-control"
                                   value="{{ old('instagram', $social['instagram'] ?? '') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">GitHub</label>
                            <input type="url" name="github" class="form-control"
                                   value="{{ old('github', $social['github'] ?? '') }}">
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
                                    <option value="{{ $key }}" {{ $card->theme == $key ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Primary Color')</label>
                            <input type="color" name="primary_color" class="form-control"
                                   value="{{ old('primary_color', $card->primary_color) }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Profile Photo')</label>
                            @if($card->profile_photo)
                                <img src="{{ Storage::url($card->profile_photo) }}" class="img-thumbnail mb-2" style="max-width: 150px;">
                            @endif
                            <input type="file" name="profile_photo" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label class="form-label">@lang('Cover Photo')</label>
                            @if($card->cover_photo)
                                <img src="{{ Storage::url($card->cover_photo) }}" class="img-thumbnail mb-2" style="max-width: 100%;">
                            @endif
                            <input type="file" name="cover_photo" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label class="custom-switch">
                                <input type="checkbox" name="is_active" value="1" class="custom-switch-input" {{ $card->is_active ? 'checked' : '' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">@lang('Active')</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Sharing -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">@lang('Share')</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">@lang('Public URL')</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $card->public_url }}" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" onclick="copyToClipboard('{{ $card->public_url }}')">
                                        <i class="fe fe-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <a href="{{ $card->public_url }}" target="_blank" class="btn btn-outline-primary btn-block">
                            <i class="fe fe-external-link mr-2"></i> @lang('View Public Card')
                        </a>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fe fe-save mr-2"></i> @lang('Save Changes')
                        </button>
                        <a href="{{ route('virtual-cards.index') }}" class="btn btn-secondary btn-block">
                            @lang('Cancel')
                        </a>
                        <form action="{{ route('virtual-cards.destroy', $card->id) }}" method="POST" class="mt-2" onsubmit="return confirm('@lang('Are you sure you want to delete this card?')')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fe fe-trash mr-2"></i> @lang('Delete Card')
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('URL copied to clipboard!');
    });
}
</script>
@endpush
@endsection
