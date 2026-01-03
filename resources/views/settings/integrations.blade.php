@extends('layouts.admin')

@section('title', __('Integrations'))
@section('page-title', __('Integrations'))

@push('head')
<style>
.integrations-page-header {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.integration-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 25px;
    height: calc(100% - 25px);
    display: flex;
    flex-direction: column;
}

.integration-card-header {
    padding: 20px 25px;
    display: flex;
    align-items: center;
    gap: 15px;
    color: white;
}

.integration-card-header.stripe {
    background: linear-gradient(135deg, #635bff 0%, #7c3aed 100%);
}

.integration-card-header.paypal {
    background: linear-gradient(135deg, #003087 0%, #009cde 100%);
}

.integration-card-header.recaptcha {
    background: linear-gradient(135deg, #4285f4 0%, #34a853 100%);
}

.integration-card-header.analytics {
    background: linear-gradient(135deg, #f57c00 0%, #ff9800 100%);
}

.integration-card-header.facebook {
    background: linear-gradient(135deg, #1877f2 0%, #42b72a 100%);
}

.integration-card-header.google {
    background: linear-gradient(135deg, #ea4335 0%, #4285f4 100%);
}

.integration-icon {
    width: 50px;
    height: 50px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.integration-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.integration-card-body {
    padding: 25px;
    flex: 1;
}

.integration-card-footer {
    padding: 20px 25px;
    background: #f8fafc;
    border-top: 2px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
}

.form-group-modern {
    margin-bottom: 20px;
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
    width: 100%;
    background-color: white;
    height: auto;
}

.form-control-modern:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.form-control-modern:hover {
    border-color: #cbd5e1;
}

.form-help-text {
    font-size: 12px;
    color: #64748b;
    margin-top: 6px;
}

.info-box {
    background: linear-gradient(135deg, #f0f7ff 0%, #e6f0ff 100%);
    border: 2px solid rgba(102, 126, 234, 0.2);
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 20px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 13px;
    color: #475569;
}

.info-box i {
    color: #667eea;
    font-size: 18px;
    margin-top: 2px;
}

.info-box.warning {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border-color: rgba(245, 158, 11, 0.3);
}

.info-box.warning i {
    color: #f59e0b;
}

.btn-external {
    background: white;
    border: 2px solid #e2e8f0;
    color: #64748b;
    padding: 10px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-external:hover {
    border-color: #667eea;
    color: #667eea;
    background: #f8f9ff;
    text-decoration: none;
}

.toggle-switch {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    padding: 12px 16px;
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.toggle-switch:hover {
    border-color: #cbd5e1;
}

.toggle-switch input {
    display: none;
}

.toggle-slider {
    width: 50px;
    height: 26px;
    background: #cbd5e1;
    border-radius: 13px;
    position: relative;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.toggle-slider::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    background: white;
    border-radius: 50%;
    top: 3px;
    left: 3px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.toggle-switch input:checked + .toggle-slider {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.toggle-switch input:checked + .toggle-slider::after {
    left: 27px;
}

.toggle-label {
    font-size: 14px;
    font-weight: 500;
    color: #475569;
}

.integrations-footer {
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

.section-title {
    font-size: 14px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.section-title i {
    color: #667eea;
}

.callback-url-box {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 15px;
    margin-top: 15px;
}

.callback-url-label {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.callback-url-value {
    font-size: 13px;
    font-family: monospace;
    color: #667eea;
    word-break: break-all;
    background: white;
    padding: 10px 12px;
    border-radius: 8px;
    border: 2px solid #e2e8f0;
}

.input-group-modern {
    position: relative;
}

.input-group-modern .password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #64748b;
    cursor: pointer;
    padding: 5px;
    font-size: 16px;
}

.input-group-modern .password-toggle:hover {
    color: #667eea;
}

.input-group-modern .form-control-modern {
    padding-right: 45px;
}

@media (max-width: 768px) {
    .integrations-page-header {
        padding: 20px;
    }

    .integration-card-body {
        padding: 20px;
    }

    .integration-card-footer {
        flex-direction: column;
    }

    .btn-external {
        width: 100%;
        justify-content: center;
    }

    .integrations-footer {
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
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Page Header -->
        <div class="integrations-page-header">
            <h2 class="mb-1" style="font-weight: 800; color: #1e293b;">
                <i class="fe fe-code mr-2" style="color: #667eea;"></i>@lang('Integrations')
            </h2>
            <p class="text-muted mb-0">@lang('Connect third-party services for payments, analytics, and authentication')</p>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-card-icon">
                <i class="fe fe-info"></i>
            </div>
            <div class="info-card-content">
                <div class="info-card-title">@lang('API Configuration')</div>
                <p class="info-card-text">
                    @lang('Configure your API keys and credentials for third-party services. Keep your secret keys secure and never share them publicly.')
                </p>
            </div>
        </div>

        <form role="form" method="post" action="{{ route('settings.update', 'integrations') }}" autocomplete="off">
            @csrf
            @method('PUT')

            <!-- Payment Gateways Section Title -->
            <div class="section-title">
                <i class="fe fe-credit-card"></i>
                @lang('Payment Gateways')
            </div>

            <!-- Payment Gateway Integrations -->
            <div class="row">
                <!-- Stripe -->
                <div class="col-lg-6 mb-4">
                    <div class="integration-card">
                        <div class="integration-card-header stripe">
                            <div class="integration-icon">
                                <i class="fe fe-credit-card"></i>
                            </div>
                            <h3 class="integration-title">Stripe</h3>
                        </div>
                        <div class="integration-card-body">
                            <div class="info-box">
                                <i class="fe fe-info"></i>
                                <span>@lang('Accept credit/debit card payments securely with Stripe.')</span>
                            </div>

                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-key"></i>
                                    @lang('Publishable Key')
                                </label>
                                <input type="text" name="settings[STRIPE_KEY]" value="{{ setting('STRIPE_KEY') }}" class="form-control form-control-modern" placeholder="pk_test_...">
                                <small class="form-help-text">@lang('Starts with pk_test_ or pk_live_')</small>
                            </div>

                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-lock"></i>
                                    @lang('Secret Key')
                                </label>
                                <div class="input-group-modern">
                                    <input type="password" name="settings[STRIPE_SECRET]" value="{{ setting('STRIPE_SECRET') }}" class="form-control form-control-modern" id="stripe-secret" placeholder="sk_test_...">
                                    <button type="button" class="password-toggle" onclick="toggleField('stripe-secret')">
                                        <i class="fe fe-eye"></i>
                                    </button>
                                </div>
                                <small class="form-help-text">@lang('Starts with sk_test_ or sk_live_')</small>
                            </div>

                            <div class="info-box warning">
                                <i class="fe fe-alert-triangle"></i>
                                <span><strong>@lang('Test Mode'):</strong> @lang('Use test keys (pk_test_ and sk_test_) for development')</span>
                            </div>
                        </div>
                        <div class="integration-card-footer">
                            <a href="https://dashboard.stripe.com/apikeys" target="_blank" class="btn-external">
                                <i class="fe fe-external-link"></i>
                                @lang('Get Stripe Keys')
                            </a>
                        </div>
                    </div>
                </div>

                <!-- PayPal -->
                <div class="col-lg-6 mb-4">
                    <div class="integration-card">
                        <div class="integration-card-header paypal">
                            <div class="integration-icon">
                                <i class="fe fe-dollar-sign"></i>
                            </div>
                            <h3 class="integration-title">PayPal</h3>
                        </div>
                        <div class="integration-card-body">
                            <div class="info-box">
                                <i class="fe fe-info"></i>
                                <span>@lang('Accept payments through PayPal accounts and cards.')</span>
                            </div>

                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-user"></i>
                                    @lang('Client ID')
                                </label>
                                <input type="text" name="settings[PAYPAL_CLIENT_ID]" value="{{ setting('PAYPAL_CLIENT_ID') }}" class="form-control form-control-modern" placeholder="@lang('Your PayPal Client ID')">
                            </div>

                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-lock"></i>
                                    @lang('Secret')
                                </label>
                                <div class="input-group-modern">
                                    <input type="password" name="settings[PAYPAL_SECRET]" value="{{ setting('PAYPAL_SECRET') }}" class="form-control form-control-modern" id="paypal-secret" placeholder="@lang('Your PayPal Secret')">
                                    <button type="button" class="password-toggle" onclick="toggleField('paypal-secret')">
                                        <i class="fe fe-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <label class="toggle-switch">
                                <input type="checkbox" name="settings[PAYPAL_SANDBOX]" value="1" {{ setting('PAYPAL_SANDBOX') ? 'checked' : '' }}>
                                <span class="toggle-slider"></span>
                                <span class="toggle-label">@lang('Sandbox Mode') (@lang('for testing'))</span>
                            </label>
                        </div>
                        <div class="integration-card-footer">
                            <a href="https://developer.paypal.com/developer/applications" target="_blank" class="btn-external">
                                <i class="fe fe-external-link"></i>
                                @lang('Get PayPal Credentials')
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security & Analytics Section Title -->
            <div class="section-title">
                <i class="fe fe-shield"></i>
                @lang('Security & Analytics')
            </div>

            <div class="row">
                <!-- Google reCAPTCHA -->
                <div class="col-lg-6 mb-4">
                    <div class="integration-card">
                        <div class="integration-card-header recaptcha">
                            <div class="integration-icon">
                                <i class="fe fe-shield"></i>
                            </div>
                            <h3 class="integration-title">Google reCAPTCHA</h3>
                        </div>
                        <div class="integration-card-body">
                            <div class="info-box">
                                <i class="fe fe-info"></i>
                                <span>@lang('Protect your forms from spam and bots with reCAPTCHA.')</span>
                            </div>

                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-globe"></i>
                                    @lang('Site Key')
                                </label>
                                <input type="text" name="settings[RECAPTCHA_SITE_KEY]" value="{{ config('recaptcha.api_site_key') }}" class="form-control form-control-modern" placeholder="@lang('Your reCAPTCHA Site Key')">
                            </div>

                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-lock"></i>
                                    @lang('Secret Key')
                                </label>
                                <div class="input-group-modern">
                                    <input type="password" name="settings[RECAPTCHA_SECRET_KEY]" value="{{ config('recaptcha.api_secret_key') }}" class="form-control form-control-modern" id="recaptcha-secret" placeholder="@lang('Your reCAPTCHA Secret Key')">
                                    <button type="button" class="password-toggle" onclick="toggleField('recaptcha-secret')">
                                        <i class="fe fe-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="integration-card-footer">
                            <a href="https://www.google.com/recaptcha/admin" target="_blank" class="btn-external">
                                <i class="fe fe-external-link"></i>
                                @lang('Get reCAPTCHA Keys')
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Google Analytics -->
                <div class="col-lg-6 mb-4">
                    <div class="integration-card">
                        <div class="integration-card-header analytics">
                            <div class="integration-icon">
                                <i class="fe fe-bar-chart-2"></i>
                            </div>
                            <h3 class="integration-title">Google Analytics</h3>
                        </div>
                        <div class="integration-card-body">
                            <div class="info-box">
                                <i class="fe fe-info"></i>
                                <span>@lang('Track website traffic and user behavior with Google Analytics.')</span>
                            </div>

                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-hash"></i>
                                    @lang('Property ID / Measurement ID')
                                </label>
                                <input type="text" name="settings[GOOGLE_ANALYTICS]" value="{{ config('rb.GOOGLE_ANALYTICS') }}" class="form-control form-control-modern" placeholder="G-XXXXXXXXXX or UA-XXXXX-Y">
                                <small class="form-help-text">@lang('Leave empty to disable Google Analytics')</small>
                            </div>

                            <div class="info-box warning">
                                <i class="fe fe-alert-triangle"></i>
                                <span>@lang('Use GA4 Measurement ID (G-XXXXXXXXXX) for new properties')</span>
                            </div>
                        </div>
                        <div class="integration-card-footer">
                            <a href="https://analytics.google.com/" target="_blank" class="btn-external">
                                <i class="fe fe-external-link"></i>
                                @lang('Open Google Analytics')
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Login Section Title -->
            <div class="section-title">
                <i class="fe fe-users"></i>
                @lang('Social Login')
            </div>

            <div class="row">
                <!-- Facebook Login -->
                <div class="col-lg-12 mb-4">
                    <div class="integration-card">
                        <div class="integration-card-header facebook">
                            <div class="integration-icon">
                                <i class="fe fe-facebook"></i>
                            </div>
                            <h3 class="integration-title">@lang('Login with Facebook')</h3>
                        </div>
                        <div class="integration-card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <i class="fe fe-info"></i>
                                        <span>@lang('Allow users to sign in with their Facebook accounts.')</span>
                                    </div>

                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fe fe-hash"></i>
                                            @lang('App ID')
                                        </label>
                                        <input type="text" name="settings[FACEBOOK_CLIENT_ID]" value="{{ config('services.facebook.client_id') }}" class="form-control form-control-modern" placeholder="@lang('Your Facebook App ID')">
                                    </div>

                                    <div class="form-group-modern">
                                        <label class="form-label-modern">
                                            <i class="fe fe-lock"></i>
                                            @lang('App Secret')
                                        </label>
                                        <div class="input-group-modern">
                                            <input type="password" name="settings[FACEBOOK_CLIENT_SECRET]" value="{{ config('services.facebook.client_secret') }}" class="form-control form-control-modern" id="facebook-secret" placeholder="@lang('Your Facebook App Secret')">
                                            <button type="button" class="password-toggle" onclick="toggleField('facebook-secret')">
                                                <i class="fe fe-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="callback-url-box">
                                        <div class="callback-url-label">@lang('Valid OAuth Redirect URI')</div>
                                        <div class="callback-url-value">{{ route('login.callback', 'facebook') }}</div>
                                        <small class="form-help-text mt-2">@lang('Copy this URL to your Facebook App settings')</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="integration-card-footer">
                            <a href="https://developers.facebook.com/apps" target="_blank" class="btn-external">
                                <i class="fe fe-external-link"></i>
                                @lang('Facebook Developer Portal')
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="integrations-footer">
                <button type="submit" class="btn btn-save-modern">
                    <i class="fe fe-check-circle"></i>
                    @lang('Save All Integrations')
                </button>
            </div>

        </form>
    </div>
</div>
@stop

@push('scripts')
<script>
function toggleField(fieldId) {
    var field = document.getElementById(fieldId);
    var icon = field.parentElement.querySelector('.password-toggle i');

    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'fe fe-eye-off';
    } else {
        field.type = 'password';
        icon.className = 'fe fe-eye';
    }
}
</script>
@endpush
