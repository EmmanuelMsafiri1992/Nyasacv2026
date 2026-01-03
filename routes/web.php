<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\RBController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\EmailCampaignController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminEmailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes...
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes...
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes...
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

// Email Verification Routes...
Route::get('email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard')->with('success', __('Email verified successfully!'));
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('email/resend', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', __('Verification link sent!'));
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// Localization
Route::get('lang/{locale}', [RBController::class, 'localize'])->name('localize');

// Landing
if (config('rb.DISABLE_LANDING')) {
    Route::get('/', function () {
        return redirect()->route('resume.index');
    })->name('landing');
} else {
    Route::get('/', [RBController::class, 'landing'])->name('landing');
}
Route::get('templates/{id?}', [RBController::class, 'templates'])->name('templates');

// Install
Route::middleware('installable')->group(function () {
    Route::get('install', [InstallController::class, 'installCheck'])->name('install.check');
    Route::get('installDB/{passed}', [InstallController::class, 'installDB'])->name('install.passed');
    Route::post('installDBPost', [InstallController::class, 'installDBPost'])->name('install.db');
    Route::get('install/setup', [InstallController::class, 'setup'])->name('install.setup');
    Route::get('install/administrator', [InstallController::class, 'install_administrator'])->name('install.administrator');
    Route::post('install/administrator', [InstallController::class, 'install_finish'])->name('install.finish');
});

// Pages
Route::get('terms-and-conditions', [RBController::class, 'terms'])->name('terms');
Route::get('privacy', [RBController::class, 'privacy'])->name('privacy');
Route::get('about', [RBController::class, 'about'])->name('about');
Route::get('contact', [RBController::class, 'contact'])->name('contact');

// Blog (Public)
Route::get('blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog');
Route::get('blog/category/{slug}', [\App\Http\Controllers\BlogController::class, 'category'])->name('blog.category');
Route::get('blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

// Newsletter
Route::post('newsletter/subscribe', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('newsletter/unsubscribe/{token}', [\App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Public Virtual Cards & Portfolios
Route::get('card/{slug}', [\App\Http\Controllers\VirtualCardController::class, 'publicView'])->name('card.public');
Route::get('card/{slug}/download', [\App\Http\Controllers\VirtualCardController::class, 'downloadVCard'])->name('card.download');
Route::get('portfolio/{slug}', [\App\Http\Controllers\PortfolioController::class, 'publicView'])->name('portfolio.public');

// Login with social accounts
Route::get('login/{provider}', [LoginController::class, 'redirectToProvider'])->name('login.social');
Route::get('login/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('login.callback');
Route::get('logout', [LoginController::class, 'logout']);

// Authorized users
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('profile', [UsersController::class, 'profile'])->name('profile.index');
    Route::put('profile', [UsersController::class, 'profile_update'])->name('profile.update');

    // Billing
    Route::get('billing', [BillingController::class, 'index'])->name('billing.index');
    Route::delete('billing', [BillingController::class, 'cancel'])->name('billing.cancel');
    Route::get('billing/{package}', [BillingController::class, 'package'])->name('billing.package');
    Route::post('billing/{package}/activate', [BillingController::class, 'activate'])->name('billing.activate');

    // Payment gateway
    Route::post('billing/{package}/{gateway}', [BillingController::class, 'gateway_purchase'])->name('gateway.purchase');
    Route::get('billing/{payment}/return', [BillingController::class, 'gateway_return'])->name('gateway.return');
    Route::get('billing/{payment}/cancel', [BillingController::class, 'gateway_cancel'])->name('gateway.cancel');
    Route::get('billing/{payment}/notify', [BillingController::class, 'gateway_notify'])->name('gateway.notify');

    // Resume
    Route::prefix('resume')->group(function () {
        Route::get('/', [ResumeController::class, 'index'])->name('resume.index');
        Route::get('template/{id?}', [ResumeController::class, 'getAllTemplate'])->name('resume.template');

        // Only users on subscription
        Route::middleware('billing')->group(function () {
            Route::get('exportpdf/{resume}', [ResumeController::class, 'exportPDF'])->name('resume.exportpdf');
            Route::get('createresume/{template?}', [ResumeController::class, 'getCreateResume']);
        });

        Route::post('create', [ResumeController::class, 'postCreateResume'])->name('resume.save');
        Route::post('delete/{resume}', [ResumeController::class, 'delete'])->name('resume.delete');
        Route::get('edit/{resume}', [ResumeController::class, 'getEditResume'])->name('resume.edit');
        Route::post('edit', [ResumeController::class, 'postEditResume'])->name('resume.update');
    });

    // Chat routes for users
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::post('init', [ChatController::class, 'initConversation'])->name('init');
        Route::post('send', [ChatController::class, 'sendMessage'])->name('send');
        Route::get('{conversationId}/messages', [ChatController::class, 'getMessages'])->name('messages');
    });

    // Virtual Cards
    Route::resource('virtual-cards', 'VirtualCardController')->except(['publicView']);
    Route::post('virtual-cards/{id}/sections', 'VirtualCardController@addSection')->name('virtual-cards.add-section');

    // Portfolios
    Route::resource('portfolios', 'PortfolioController')->except(['publicView']);
    Route::post('portfolios/{id}/sections', 'PortfolioController@addSection')->name('portfolios.add-section');
    Route::put('portfolios/{portfolioId}/sections/{sectionId}', 'PortfolioController@updateSection')->name('portfolios.update-section');
    Route::delete('portfolios/{portfolioId}/sections/{sectionId}', 'PortfolioController@deleteSection')->name('portfolios.delete-section');

    // Administrator
    Route::middleware('can:admin')->prefix('settings')->name('settings.')->group(function () {

        // Settings
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('general', [SettingsController::class, 'general'])->name('general');
        Route::get('localization', [SettingsController::class, 'localization'])->name('localization');
        Route::get('email', [SettingsController::class, 'email'])->name('email');
        Route::post('email/test', [SettingsController::class, 'sendTestEmail'])->name('email.test');
        Route::get('integrations', [SettingsController::class, 'integrations'])->name('integrations');

        // Save settings
        Route::put('{group?}', [SettingsController::class, 'update'])->name('update');

        Route::resource('resumetemplate', 'ResumetemplateController')->except('show');
        Route::resource('resumetemplatecategories', 'ResumetemplatecategoriesController')->except('show');
        Route::resource('packages', 'PackagesController')->except('show');
        Route::resource('users', 'UsersController')->except('show');
        Route::post('users/delete-unverified', [UsersController::class, 'deleteUnverified'])->name('users.delete-unverified');
        Route::post('users/resend-verification', [UsersController::class, 'resendVerification'])->name('users.resend-verification');
        Route::get('payments', [BillingController::class, 'payments'])->name('payments');

        // Email Templates
        Route::get('email-templates', [EmailTemplateController::class, 'index'])->name('email-templates.index');
        Route::get('email-templates/create', [EmailTemplateController::class, 'create'])->name('email-templates.create');
        Route::post('email-templates', [EmailTemplateController::class, 'store'])->name('email-templates.store');
        Route::get('email-templates/{emailTemplate}', [EmailTemplateController::class, 'show'])->name('email-templates.show');
        Route::get('email-templates/{emailTemplate}/edit', [EmailTemplateController::class, 'edit'])->name('email-templates.edit');
        Route::put('email-templates/{emailTemplate}', [EmailTemplateController::class, 'update'])->name('email-templates.update');
        Route::delete('email-templates/{emailTemplate}', [EmailTemplateController::class, 'destroy'])->name('email-templates.destroy');

        // Email Campaigns
        Route::get('email-campaigns', [EmailCampaignController::class, 'index'])->name('email-campaigns.index');
        Route::get('email-campaigns/create', [EmailCampaignController::class, 'create'])->name('email-campaigns.create');
        Route::post('email-campaigns', [EmailCampaignController::class, 'store'])->name('email-campaigns.store');
        Route::post('email-campaigns/get-selected-users', [EmailCampaignController::class, 'getSelectedUsers'])->name('email-campaigns.get-selected-users');
        Route::get('email-campaigns/{emailCampaign}', [EmailCampaignController::class, 'show'])->name('email-campaigns.show');
        Route::post('email-campaigns/{emailCampaign}/send', [EmailCampaignController::class, 'send'])->name('email-campaigns.send');
        Route::get('email-campaigns/{emailCampaign}/replies', [EmailCampaignController::class, 'replies'])->name('email-campaigns.replies');
        Route::post('email-campaigns/{emailCampaign}/replies/{reply}/mark-read', [EmailCampaignController::class, 'markReplyAsRead'])->name('email-campaigns.mark-reply-read');
        Route::delete('email-campaigns/{emailCampaign}', [EmailCampaignController::class, 'destroy'])->name('email-campaigns.destroy');

        // Admin Email Inbox
        Route::get('admin-emails', [AdminEmailController::class, 'index'])->name('admin-emails.index');
        Route::get('admin-emails/compose', [AdminEmailController::class, 'compose'])->name('admin-emails.compose');
        Route::post('admin-emails/send', [AdminEmailController::class, 'send'])->name('admin-emails.send');
        Route::post('admin-emails/fetch', [AdminEmailController::class, 'fetchEmails'])->name('admin-emails.fetch');
        Route::post('admin-emails/bulk', [AdminEmailController::class, 'bulkAction'])->name('admin-emails.bulk');
        Route::get('admin-emails/{adminEmail}', [AdminEmailController::class, 'show'])->name('admin-emails.show');
        Route::post('admin-emails/{adminEmail}/star', [AdminEmailController::class, 'toggleStar'])->name('admin-emails.star');
        Route::post('admin-emails/{adminEmail}/read', [AdminEmailController::class, 'toggleRead'])->name('admin-emails.read');
        Route::post('admin-emails/{adminEmail}/trash', [AdminEmailController::class, 'trash'])->name('admin-emails.trash');
        Route::post('admin-emails/{adminEmail}/restore', [AdminEmailController::class, 'restore'])->name('admin-emails.restore');
        Route::delete('admin-emails/{adminEmail}', [AdminEmailController::class, 'destroy'])->name('admin-emails.destroy');

        // Admin Chat
        Route::get('chat', function () {
            return view('settings.chat');
        })->name('chat.index');

        Route::prefix('chat')->name('chat.')->group(function () {
            Route::get('conversations', [ChatController::class, 'adminGetConversations'])->name('conversations');
            Route::get('conversations/{conversationId}/messages', [ChatController::class, 'adminGetMessages'])->name('conversation-messages');
            Route::post('send', [ChatController::class, 'adminSendMessage'])->name('send-message');
            Route::post('conversations/{conversationId}/close', [ChatController::class, 'adminCloseConversation'])->name('close-conversation');
        });

        // Blog Management
        Route::resource('blog', 'Admin\BlogController');
        Route::resource('blog-categories', 'Admin\BlogCategoryController');

    });
});

// Home route
Route::get('/home', 'HomeController@index')->name('home');
