@extends('layouts.admin')

@section('title', __('General Settings'))
@section('page-title', __('General Settings'))

@section('content')
<style>
.settings-page-header {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.settings-section {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 25px;
}

.settings-section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 30px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.settings-section-header i {
    font-size: 24px;
}

.settings-section-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.settings-section-body {
    padding: 30px;
}

.form-group-modern {
    margin-bottom: 25px;
}

.form-label-modern {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-label-modern i {
    color: #667eea;
    font-size: 16px;
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

textarea.form-control-modern {
    min-height: 100px;
    resize: vertical;
}

.form-help-text {
    font-size: 12px;
    color: #64748b;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.form-help-text i {
    font-size: 14px;
    color: #94a3b8;
}

.custom-switch-modern {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    background: #f8f9fa;
    border-radius: 12px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    cursor: pointer;
}

.custom-switch-modern:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

.custom-switch-modern input[type="checkbox"] {
    width: 50px;
    height: 28px;
    cursor: pointer;
}

.custom-switch-label {
    font-size: 15px;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
    flex: 1;
}

.custom-switch-description {
    font-size: 13px;
    color: #64748b;
    margin-top: 4px;
}

.settings-footer {
    background: white;
    padding: 25px 30px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: sticky;
    bottom: 20px;
    z-index: 10;
}

.btn-save-settings {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 14px 0;
    font-weight: 700;
    border-radius: 10px;
    transition: all 0.3s ease;
    color: white;
    font-size: 16px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-save-settings:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-save-settings i {
    font-size: 18px;
}

select.form-control-modern {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23667eea' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px 12px;
    padding-right: 40px;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-color: white;
    color: #1e293b;
    cursor: pointer;
    width: 100%;
    min-height: 48px;
}

select.form-control-modern option {
    color: #1e293b;
    background-color: white;
    padding: 12px 16px;
    font-size: 14px;
}

select.form-control-modern option:hover,
select.form-control-modern option:focus,
select.form-control-modern option:checked {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

@media (max-width: 768px) {
    .settings-section-body {
        padding: 20px;
    }

    .settings-page-header {
        padding: 20px;
    }

    .settings-footer {
        position: relative;
        bottom: 0;
    }
}
</style>

<div class="row">
    <div class="col-md-12">
        <!-- Page Header -->
        <div class="settings-page-header">
            <h2 class="mb-1" style="font-weight: 800; color: #1e293b;">
                <i class="fe fe-settings mr-2" style="color: #667eea;"></i>General Settings
            </h2>
            <p class="text-muted mb-0">Configure your website's basic information and preferences</p>
        </div>

        <form role="form" method="post" action="{{ route('settings.update') }}" autocomplete="off">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="settings-section">
                <div class="settings-section-header">
                    <i class="fe fe-globe"></i>
                    <h3 class="settings-section-title">Basic Information</h3>
                </div>
                <div class="settings-section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-link"></i>
                                    @lang('Site URL')
                                </label>
                                <input type="text" name="settings[APP_URL]" value="{{ config('app.url') }}" class="form-control form-control-modern" placeholder="https://example.com">
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    The main URL where your website is accessible
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-type"></i>
                                    @lang('Site Name')
                                </label>
                                <input type="text" name="settings[APP_NAME]" value="{{ config('app.name') }}" class="form-control form-control-modern" placeholder="My Awesome Site">
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    Your website's name (appears in browser tab and emails)
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fe fe-file-text"></i>
                            @lang('Site Description')
                        </label>
                        <textarea name="settings[SITE_DESCRIPTION]" rows="3" class="form-control form-control-modern" placeholder="Enter a brief description of your website...">{{ config('rb.SITE_DESCRIPTION') }}</textarea>
                        <small class="form-help-text">
                            <i class="fe fe-alert-circle"></i>
                            Recommended length: 150-160 characters (for SEO optimization)
                        </small>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fe fe-tag"></i>
                            @lang('SEO Keywords')
                        </label>
                        <textarea name="settings[SITE_KEYWORDS]" rows="3" class="form-control form-control-modern" placeholder="resume, cv, job, career, professional...">{{ config('rb.SITE_KEYWORDS') }}</textarea>
                        <small class="form-help-text">
                            <i class="fe fe-info"></i>
                            Separate keywords with commas (helps with search engine visibility)
                        </small>
                    </div>
                </div>
            </div>

            <!-- Legal Pages Section -->
            <div class="settings-section">
                <div class="settings-section-header">
                    <i class="fe fe-shield"></i>
                    <h3 class="settings-section-title">Legal Pages</h3>
                </div>
                <div class="settings-section-body">
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fe fe-lock"></i>
                            @lang('Privacy Policy')
                        </label>
                        <textarea name="settings[privacy]" id="privacy" rows="6" class="form-control form-control-modern">{{ config('rb.privacy') }}</textarea>
                        <small class="form-help-text">
                            <i class="fe fe-info"></i>
                            Explain how you collect, use, and protect user data
                        </small>
                    </div>

                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fe fe-file"></i>
                            @lang('Terms and Conditions')
                        </label>
                        <textarea name="settings[termcondition]" id="termcondition" rows="6" class="form-control form-control-modern">{{ config('rb.termcondition') }}</textarea>
                        <small class="form-help-text">
                            <i class="fe fe-info"></i>
                            Define the rules and guidelines for using your service
                        </small>
                    </div>
                </div>
            </div>

            <!-- Landing Page Configuration -->
            <div class="settings-section">
                <div class="settings-section-header">
                    <i class="fe fe-home"></i>
                    <h3 class="settings-section-title">Landing Page Configuration</h3>
                </div>
                <div class="settings-section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-layout"></i>
                                    @lang('Landing Page Template')
                                </label>
                                <select name="settings[SITE_LANDING]" class="form-control form-control-modern">
                                    @foreach($landingpage as $item)
                                        <option value="{{ $item }}" {{ $item == config('rb.SITE_LANDING') ? 'selected' : '' }}>{{ ucfirst($item) }}</option>
                                    @endforeach
                                </select>
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    Choose which landing page design to display
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="custom-switch-modern">
                        <input type="checkbox" name="settings[DISABLE_LANDING]" value="1" class="custom-switch-input" {{ config('rb.DISABLE_LANDING') ? 'checked' : '' }} id="disable-landing">
                        <label for="disable-landing" class="custom-switch-label">
                            <div>
                                <strong>@lang('Disable Landing Page')</strong>
                                <div class="custom-switch-description">
                                    When enabled, visitors will be redirected directly to the login page
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="settings-footer">
                <button type="submit" class="btn btn-save-settings">
                    <i class="fe fe-check-circle"></i>
                    @lang('Save All Settings')
                </button>
            </div>

        </form>

    </div>
</div>
@stop

@push('scripts')
<script>
$(document).ready(function(){
    CKEDITOR.replace('privacy', {
        height: 300,
        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
            { name: 'links', items: ['Link', 'Unlink'] },
            { name: 'styles', items: ['Format'] }
        ]
    });

    CKEDITOR.replace('termcondition', {
        height: 300,
        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
            { name: 'links', items: ['Link', 'Unlink'] },
            { name: 'styles', items: ['Format'] }
        ]
    });
});
</script>
@endpush
