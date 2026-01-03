@extends('layouts.admin')

@section('title', __('Localization'))
@section('page-title', __('Localization Settings'))

@push('head')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.localization-page-header {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.localization-section {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 25px;
}

.localization-section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 30px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.localization-section-header i {
    font-size: 24px;
}

.localization-section-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.localization-section-body {
    padding: 30px;
}

.form-group-modern {
    margin-bottom: 25px;
}

.form-label-modern {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-label-modern i {
    color: #667eea;
    font-size: 16px;
}

.form-control-modern {
    border: 2px solid #e2e8f0 !important;
    border-radius: 10px !important;
    padding: 12px 16px !important;
    font-size: 14px !important;
    transition: all 0.3s ease;
    width: 100%;
    background-color: white !important;
    height: auto !important;
    min-height: 48px;
}

.form-control-modern:focus {
    border-color: #667eea !important;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
    outline: none !important;
}

.form-control-modern:hover {
    border-color: #cbd5e1 !important;
}

.form-help-text {
    font-size: 12px;
    color: #64748b;
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.form-help-text i {
    font-size: 14px;
    color: #94a3b8;
}

.localization-footer {
    background: white;
    padding: 25px 30px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    position: sticky;
    bottom: 20px;
    z-index: 10;
}

.btn-save-modern {
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

.btn-save-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-save-modern i {
    font-size: 18px;
}

.setting-preview {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 20px;
    margin-top: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.setting-preview-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.setting-preview-content {
    flex: 1;
}

.setting-preview-label {
    font-size: 12px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.setting-preview-value {
    font-size: 24px;
    font-weight: 800;
    color: #1e293b;
}

.info-card {
    background: linear-gradient(135deg, #f0f7ff 0%, #e6f0ff 100%);
    border: 2px solid rgba(102, 126, 234, 0.2);
    border-radius: 16px;
    padding: 25px;
    margin-bottom: 25px;
    display: flex;
    gap: 20px;
    align-items: flex-start;
}

.info-card-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 22px;
    flex-shrink: 0;
}

.info-card-content {
    flex: 1;
}

.info-card-title {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
}

.info-card-text {
    font-size: 14px;
    color: #475569;
    line-height: 1.6;
    margin: 0;
}

/* Select2 Custom Styling */
.select2-container {
    width: 100% !important;
}

.select2-container--default .select2-selection--single {
    border: 2px solid #e2e8f0 !important;
    border-radius: 10px !important;
    height: 48px !important;
    padding: 8px 12px !important;
    background-color: white !important;
}

.select2-container--default .select2-selection--single:hover {
    border-color: #cbd5e1 !important;
}

.select2-container--default.select2-container--focus .select2-selection--single,
.select2-container--default.select2-container--open .select2-selection--single {
    border-color: #667eea !important;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
    outline: none !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 28px !important;
    color: #1e293b !important;
    font-size: 14px !important;
    padding-left: 4px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 46px !important;
    right: 10px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: #667eea transparent transparent transparent !important;
}

.select2-dropdown {
    border: 2px solid #e2e8f0 !important;
    border-radius: 10px !important;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15) !important;
    margin-top: 5px !important;
    overflow: hidden;
}

.select2-container--default .select2-search--dropdown {
    padding: 10px !important;
}

.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 2px solid #e2e8f0 !important;
    border-radius: 8px !important;
    padding: 10px 12px !important;
    font-size: 14px !important;
    outline: none !important;
}

.select2-container--default .select2-search--dropdown .select2-search__field:focus {
    border-color: #667eea !important;
}

.select2-container--default .select2-results__option {
    padding: 10px 15px !important;
    font-size: 14px !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected],
.select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
}

.select2-container--default .select2-results__option--selected {
    background-color: #f0f7ff !important;
    color: #667eea !important;
    font-weight: 600 !important;
}

.select2-results__options {
    max-height: 300px !important;
}

@media (max-width: 768px) {
    .localization-section-body {
        padding: 20px;
    }

    .localization-page-header {
        padding: 20px;
    }

    .localization-footer {
        position: relative;
        bottom: 0;
    }

    .info-card {
        flex-direction: column;
        text-align: center;
    }

    .info-card-icon {
        margin: 0 auto;
    }

    .setting-preview {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Page Header -->
        <div class="localization-page-header">
            <h2 class="mb-1" style="font-weight: 800; color: #1e293b;">
                <i class="fe fe-globe mr-2" style="color: #667eea;"></i>@lang('Localization Settings')
            </h2>
            <p class="text-muted mb-0">@lang('Configure language, currency, and regional settings for your application')</p>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-card-icon">
                <i class="fe fe-info"></i>
            </div>
            <div class="info-card-content">
                <div class="info-card-title">@lang('Regional Configuration')</div>
                <p class="info-card-text">
                    @lang('These settings control how your application displays dates, times, currencies, and language. Changes will affect all users and should be set according to your primary target audience or business location.')
                </p>
            </div>
        </div>

        <form role="form" method="post" action="{{ route('settings.update', 'localization') }}" autocomplete="off">
            @csrf
            @method('PUT')

            <!-- Language & Region Section -->
            <div class="localization-section">
                <div class="localization-section-header">
                    <i class="fe fe-map"></i>
                    <h3 class="localization-section-title">@lang('Language & Region')</h3>
                </div>
                <div class="localization-section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-globe"></i>
                                    @lang('Default Language')
                                </label>
                                <select name="settings[APP_LOCALE]" class="form-control form-control-modern select2-basic" id="language-select">
                                    @if(isset($languages) && is_array($languages) && count($languages) > 0)
                                        @foreach($languages as $code => $language)
                                            <option value="{{ $code }}" {{ $code == config('app.locale', 'en') ? 'selected' : '' }}>
                                                {{ $language['name'] ?? $code }} ({{ $language['native'] ?? $code }})
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="en" selected>English (English)</option>
                                        <option value="pt">Portuguese (Português)</option>
                                    @endif
                                </select>
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    @lang('Primary language for your application interface')
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-clock"></i>
                                    @lang('Timezone')
                                </label>
                                <select name="settings[APP_TIMEZONE]" class="form-control form-control-modern select2-searchable" id="timezone-select">
                                    @if(isset($time_zones) && is_array($time_zones) && count($time_zones) > 0)
                                        @foreach($time_zones as $zone)
                                            <option value="{{ $zone }}" {{ $zone == config('app.timezone', 'UTC') ? 'selected' : '' }}>
                                                {{ $zone }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="UTC" selected>UTC</option>
                                        <option value="Africa/Johannesburg">Africa/Johannesburg</option>
                                        <option value="America/New_York">America/New_York</option>
                                        <option value="Europe/London">Europe/London</option>
                                    @endif
                                </select>
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    @lang('Controls how dates and times are displayed')
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Currency Settings Section -->
            <div class="localization-section">
                <div class="localization-section-header">
                    <i class="fe fe-dollar-sign"></i>
                    <h3 class="localization-section-title">@lang('Currency Settings')</h3>
                </div>
                <div class="localization-section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-credit-card"></i>
                                    @lang('Currency Code')
                                </label>
                                <select name="settings[CURRENCY_CODE]" class="form-control form-control-modern select2-searchable" id="currency-select">
                                    @if(isset($currencies) && is_array($currencies) && count($currencies) > 0)
                                        @foreach($currencies as $code => $title)
                                            <option value="{{ $code }}" {{ $code == config('rb.CURRENCY_CODE', 'USD') ? 'selected' : '' }}>
                                                {{ $code }} - {{ $title }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="USD" selected>USD - US Dollar</option>
                                        <option value="EUR">EUR - Euro</option>
                                        <option value="GBP">GBP - British Pound</option>
                                        <option value="ZAR">ZAR - South African Rand</option>
                                    @endif
                                </select>
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    @lang('International currency code (e.g., USD, EUR, GBP)')
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-dollar-sign"></i>
                                    @lang('Currency Symbol')
                                </label>
                                <input type="text"
                                       name="settings[CURRENCY_SYMBOL]"
                                       value="{{ config('rb.CURRENCY_SYMBOL', '$') }}"
                                       class="form-control form-control-modern"
                                       id="currency-symbol-input"
                                       placeholder="$"
                                       maxlength="5">
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    @lang('Symbol displayed before prices (e.g., $, €, £, ¥)')
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Currency Preview -->
                    <div class="setting-preview">
                        <div class="setting-preview-icon">
                            <i class="fe fe-eye"></i>
                        </div>
                        <div class="setting-preview-content">
                            <div class="setting-preview-label">@lang('Price Display Preview')</div>
                            <div class="setting-preview-value" id="currency-preview">
                                {{ config('rb.CURRENCY_SYMBOL', '$') }}99.99 {{ config('rb.CURRENCY_CODE', 'USD') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="localization-footer">
                <button type="submit" class="btn btn-save-modern">
                    <i class="fe fe-check-circle"></i>
                    @lang('Save Localization Settings')
                </button>
            </div>

        </form>

    </div>
</div>
@stop

@push('scripts')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2 for searchable dropdowns (timezone, currency)
    $('.select2-searchable').select2({
        placeholder: 'Select an option',
        allowClear: false,
        width: '100%',
        dropdownAutoWidth: false
    });

    // Initialize Select2 for basic dropdowns (language)
    $('.select2-basic').select2({
        placeholder: 'Select an option',
        allowClear: false,
        width: '100%',
        minimumResultsForSearch: Infinity // Disable search for small lists
    });

    // Update currency preview when inputs change
    function updateCurrencyPreview() {
        var symbol = $('#currency-symbol-input').val() || '$';
        var code = $('#currency-select').val() || 'USD';
        $('#currency-preview').text(symbol + '99.99 ' + code);
    }

    // Bind events
    $('#currency-symbol-input').on('input keyup', updateCurrencyPreview);
    $('#currency-select').on('change', updateCurrencyPreview);

    // Initial preview update
    updateCurrencyPreview();
});
</script>
@endpush
