@extends('layouts.admin')

@section('title', __('E-mail Settings'))
@section('page-title', __('E-mail Settings'))

@push('head')
<style>
.email-page-header {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 30px;
}

.email-section {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 25px;
}

.email-section-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px 30px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.email-section-header.green {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.email-section-header i {
    font-size: 24px;
}

.email-section-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.email-section-body {
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
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 14px;
    transition: all 0.3s ease;
    width: 100%;
    background-color: white;
    height: auto;
    min-height: 48px;
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
    margin-top: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.form-help-text i {
    font-size: 14px;
    color: #94a3b8;
}

select.form-control-modern {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23667eea' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px 12px;
    padding-right: 40px;
    appearance: none;
    cursor: pointer;
}

.email-footer {
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

.btn-test-modern {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    padding: 14px 30px;
    font-weight: 700;
    border-radius: 10px;
    transition: all 0.3s ease;
    color: white;
    font-size: 15px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
}

.btn-test-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    color: white;
}

.btn-test-modern:disabled {
    opacity: 0.7;
    transform: none;
    cursor: not-allowed;
}

.btn-test-modern i {
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

.info-card.warning {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border-color: rgba(245, 158, 11, 0.3);
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

.info-card.warning .info-card-icon {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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

.test-email-card {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 2px solid rgba(16, 185, 129, 0.2);
    border-radius: 16px;
    padding: 25px;
    margin-top: 20px;
}

.test-email-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 15px;
}

.test-email-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 22px;
}

.test-email-title {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.test-email-subtitle {
    font-size: 13px;
    color: #64748b;
    margin: 4px 0 0 0;
}

.test-email-recipient {
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 16px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.test-email-recipient i {
    color: #667eea;
    font-size: 18px;
}

.test-email-recipient span {
    font-size: 14px;
    color: #1e293b;
    font-weight: 500;
}

.alert-modern {
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 500;
}

.alert-modern.success {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    border: 2px solid #86efac;
    color: #166534;
}

.alert-modern.error {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border: 2px solid #fca5a5;
    color: #991b1b;
}

.alert-modern i {
    font-size: 20px;
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
    z-index: 10;
}

.input-group-modern .password-toggle:hover {
    color: #667eea;
}

.input-group-modern .form-control-modern {
    padding-right: 45px;
}

.config-item {
    background: #f8fafc;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 16px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.config-item-label {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
}

.config-item-value {
    font-size: 13px;
    color: #1e293b;
    font-weight: 600;
    font-family: monospace;
}

@media (max-width: 768px) {
    .email-section-body {
        padding: 20px;
    }

    .email-page-header {
        padding: 20px;
    }

    .email-footer {
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

    .test-email-header {
        flex-direction: column;
        text-align: center;
    }
}

/* Spinner animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.fe-loader {
    animation: spin 1s linear infinite;
}
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Page Header -->
        <div class="email-page-header">
            <h2 class="mb-1" style="font-weight: 800; color: #1e293b;">
                <i class="fe fe-mail mr-2" style="color: #667eea;"></i>@lang('E-mail Settings')
            </h2>
            <p class="text-muted mb-0">@lang('Configure your SMTP settings to send emails from your application')</p>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-card-icon">
                <i class="fe fe-info"></i>
            </div>
            <div class="info-card-content">
                <div class="info-card-title">@lang('SMTP Configuration')</div>
                <p class="info-card-text">
                    @lang('These settings allow your application to send emails for user registration, password resets, and notifications. Contact your email provider for the correct SMTP details.')
                </p>
            </div>
        </div>

        <form role="form" method="post" action="{{ route('settings.update', 'email') }}" autocomplete="off">
            @csrf
            @method('PUT')

            <!-- SMTP Server Settings -->
            <div class="email-section">
                <div class="email-section-header">
                    <i class="fe fe-server"></i>
                    <h3 class="email-section-title">@lang('SMTP Server Settings')</h3>
                </div>
                <div class="email-section-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-globe"></i>
                                    @lang('SMTP Host')
                                </label>
                                <input type="text" name="settings[MAIL_HOST]" value="{{ config('mail.host') }}" class="form-control form-control-modern" placeholder="smtp.example.com">
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    @lang('Your email provider\'s SMTP server address')
                                </small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-hash"></i>
                                    @lang('SMTP Port')
                                </label>
                                <input type="text" name="settings[MAIL_PORT]" value="{{ config('mail.port') }}" class="form-control form-control-modern" placeholder="587">
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    @lang('Common ports: 25, 465, 587')
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-shield"></i>
                                    @lang('Encryption')
                                </label>
                                <select name="settings[MAIL_ENCRYPTION]" class="form-control form-control-modern">
                                    <option value="" {{ null == config('mail.encryption') ? 'selected' : '' }}>@lang('No encryption')</option>
                                    <option value="tls" {{ 'tls' == config('mail.encryption') ? 'selected' : '' }}>TLS (@lang('Recommended'))</option>
                                    <option value="ssl" {{ 'ssl' == config('mail.encryption') ? 'selected' : '' }}>SSL</option>
                                </select>
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    @lang('TLS is recommended for port 587')
                                </small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-user"></i>
                                    @lang('SMTP Username')
                                </label>
                                <input type="text" name="settings[MAIL_USERNAME]" value="{{ config('mail.username') }}" class="form-control form-control-modern" placeholder="your@email.com">
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    @lang('Usually your email address')
                                </small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-lock"></i>
                                    @lang('SMTP Password')
                                </label>
                                <div class="input-group-modern">
                                    <input type="password" name="settings[MAIL_PASSWORD]" value="{{ config('mail.password') }}" class="form-control form-control-modern" id="smtp-password" placeholder="••••••••">
                                    <button type="button" class="password-toggle" onclick="togglePassword()">
                                        <i class="fe fe-eye" id="password-icon"></i>
                                    </button>
                                </div>
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    @lang('Your email password or app password')
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sender Information -->
            <div class="email-section">
                <div class="email-section-header">
                    <i class="fe fe-send"></i>
                    <h3 class="email-section-title">@lang('Sender Information')</h3>
                </div>
                <div class="email-section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-at-sign"></i>
                                    @lang('From Address')
                                </label>
                                <input type="email" name="settings[MAIL_FROM_ADDRESS]" value="{{ config('mail.from.address') }}" class="form-control form-control-modern" placeholder="noreply@example.com">
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    @lang('Email address shown as the sender')
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class="fe fe-user"></i>
                                    @lang('From Name')
                                </label>
                                <input type="text" name="settings[MAIL_FROM_NAME]" value="{{ config('mail.from.name') }}" class="form-control form-control-modern" placeholder="{{ config('app.name') }}">
                                <small class="form-help-text">
                                    <i class="fe fe-info"></i>
                                    @lang('Name shown as the sender')
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="email-footer">
                <button type="submit" class="btn btn-save-modern">
                    <i class="fe fe-check-circle"></i>
                    @lang('Save Email Settings')
                </button>
            </div>

        </form>

        <!-- Test Email Section -->
        <div class="email-section" style="margin-top: 30px;">
            <div class="email-section-header green">
                <i class="fe fe-zap"></i>
                <h3 class="email-section-title">@lang('Test Email Connection')</h3>
            </div>
            <div class="email-section-body">
                <div class="test-email-header">
                    <div class="test-email-icon">
                        <i class="fe fe-send"></i>
                    </div>
                    <div>
                        <h4 class="test-email-title">@lang('Verify Your Configuration')</h4>
                        <p class="test-email-subtitle">@lang('Send a test email to verify your SMTP settings are working correctly')</p>
                    </div>
                </div>

                <div class="test-email-recipient">
                    <i class="fe fe-mail"></i>
                    <span>@lang('Test email will be sent to'): <strong>{{ Auth::user()->email }}</strong></span>
                </div>

                <div id="testEmailResult" class="alert-modern" style="display: none;"></div>

                <button type="button" id="sendTestEmailBtn" class="btn btn-test-modern">
                    <i class="fe fe-send"></i>
                    @lang('Send Test Email')
                </button>
            </div>
        </div>

    </div>
</div>
@stop

@push('scripts')
<script>
// Toggle password visibility
function togglePassword() {
    var passwordInput = document.getElementById('smtp-password');
    var passwordIcon = document.getElementById('password-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.className = 'fe fe-eye-off';
    } else {
        passwordInput.type = 'password';
        passwordIcon.className = 'fe fe-eye';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var sendTestBtn = document.getElementById('sendTestEmailBtn');
    var resultDiv = document.getElementById('testEmailResult');

    sendTestBtn.addEventListener('click', function() {
        // Disable button and show loading
        sendTestBtn.disabled = true;
        sendTestBtn.innerHTML = '<i class="fe fe-loader"></i> @lang("Sending...")';
        resultDiv.style.display = 'none';

        // Send test email
        fetch('{{ route("settings.email.test") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(function(response) { return response.json(); })
        .then(function(data) {
            // Show result
            resultDiv.style.display = 'flex';
            if (data.success) {
                resultDiv.className = 'alert-modern success';
                resultDiv.innerHTML = '<i class="fe fe-check-circle"></i><span>' + data.message + '</span>';
            } else {
                resultDiv.className = 'alert-modern error';
                resultDiv.innerHTML = '<i class="fe fe-x-circle"></i><span>' + data.message + '</span>';
            }

            // Re-enable button
            sendTestBtn.disabled = false;
            sendTestBtn.innerHTML = '<i class="fe fe-send"></i> @lang("Send Test Email")';
        })
        .catch(function(error) {
            // Show error
            resultDiv.style.display = 'flex';
            resultDiv.className = 'alert-modern error';
            resultDiv.innerHTML = '<i class="fe fe-x-circle"></i><span>@lang("Error sending test email. Please check your settings and try again.")</span>';

            console.error('Error:', error);

            // Re-enable button
            sendTestBtn.disabled = false;
            sendTestBtn.innerHTML = '<i class="fe fe-send"></i> @lang("Send Test Email")';
        });
    });
});
</script>
@endpush
