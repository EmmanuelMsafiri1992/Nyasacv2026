<?php

namespace App\Http\Controllers;

use DateTimeZone;
use Illuminate\Http\Request;
use App\Library\Helper;
use App\Models\ResumeCategories;
use App\Models\ResumeTemplate;
use App\Notifications\TestEmail;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        // Get dashboard statistics
        $totalUsers = \App\User::count();
        $totalResumes = \App\Models\Resume::count();
        $activeSubscriptions = \App\User::whereNotNull('package_id')
            ->where('package_ends_at', '>', now())
            ->count();
        $totalTemplates = \App\Models\ResumeTemplate::count();

        // Get recent users
        $recentUsers = \App\User::orderBy('created_at', 'desc')->take(10)->get();

        // Calculate growth (optional - placeholder for now)
        $userGrowth = 0;
        $resumeGrowth = 0;
        $subscriptionGrowth = 0;

        return view('settings.dashboard', compact(
            'totalUsers',
            'totalResumes',
            'activeSubscriptions',
            'totalTemplates',
            'recentUsers',
            'userGrowth',
            'resumeGrowth',
            'subscriptionGrowth'
        ));
    }

    public function general(Request $request)
    {
        $landingpage = Storage::disk('landingpage')->directories();
        $currencies = config('currencies');
        $languages  = config('languages');
        $time_zones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        return view('settings.index', compact(
            'landingpage',
            'currencies',
            'languages',
            'time_zones'
        ));
    }

    public function localization(Request $request)
    {
        $landingpage = Storage::disk('landingpage')->directories();
        $currencies = config('currencies');
        $languages  = config('languages');
        $time_zones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        return view('settings.localization', compact(
            'landingpage',
            'currencies',
            'languages',
            'time_zones'
        ));
    }

    public function email(Request $request)
    {
        $landingpage      = Storage::disk('landingpage')->directories();
        $currencies = config('currencies');
        $languages  = config('languages');
        $time_zones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        return view('settings.email', compact(
            'landingpage',
            'currencies',
            'languages',
            'time_zones'
        ));
    }
    
    public function integrations(Request $request)
    {
        $landingpage      = Storage::disk('landingpage')->directories();
        $currencies = config('currencies');
        $languages  = config('languages');
        $time_zones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        return view('settings.integrations', compact(
            'landingpage',
            'currencies',
            'languages',
            'time_zones'
        ));
    }

    public function update(Request $request, $group = '')
    {

        switch ($group) {

            case 'localization':

                $request->validate([
                    'settings'               => 'required',
                    'settings.APP_LOCALE'    => 'required',
                    'settings.CURRENCY_CODE' => 'required',
                    'settings.APP_TIMEZONE'  => 'required',
                ]);

                break;

            case 'email':

                $request->validate([
                    'settings'                   => 'required',
                    'settings.MAIL_HOST'         => 'required',
                    'settings.MAIL_PORT'         => 'required|integer',
                    'settings.MAIL_USERNAME'     => 'required',
                    'settings.MAIL_PASSWORD'     => 'required',
                    'settings.MAIL_ENCRYPTION'   => 'required',
                    'settings.MAIL_FROM_ADDRESS' => 'required|email',
                    'settings.MAIL_FROM_NAME'    => 'required',
                ]);

                break;

            case 'integrations':

                $request->validate([
                    'settings' => 'required',
                ]);

                break;

            default:

                $request->validate([
                    'settings'            => 'required',
                    'settings.APP_URL'    => 'required|url',
                    'settings.APP_NAME'   => 'required',
                    'settings.SITE_LANDING'  => 'required',
                ]);

                break;
        }
        
        $settings = collect($request->settings)->filter(function ($value, $setting) {
            if (is_null($value)) {
                setting()->forget($setting);
            }
            return !is_null($value);
        });

        // Bool params
       
        $settings->put('DISABLE_LANDING', $request->filled('settings.DISABLE_LANDING'));
        $settings->put('PAYPAL_SANDBOX', $request->input('settings.PAYPAL_SANDBOX') ? true : false);

        setting($settings->all())->save();

        Artisan::call('config:clear');

        return back()->with('success', __('Settings saved successfully'));
    }

    /**
     * Send a test email to verify email configuration.
     */
    public function sendTestEmail(Request $request)
    {
        try {
            $user = $request->user();
            $user->notify(new TestEmail());

            return response()->json([
                'success' => true,
                'message' => __('Test email sent successfully to :email', ['email' => $user->email])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to send test email: :error', ['error' => $e->getMessage()])
            ], 500);
        }
    }
}
