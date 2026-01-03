<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessage;
use App\Library\Helper;
use App\Library\Spintax;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\ResumeTemplate;
use App\Models\ResumeCategories;
use Illuminate\Support\Facades\App;

class RBController extends Controller
{
    public function localize($locale)
    {
        $locale = array_key_exists($locale, config('languages')) ? $locale : config('app.fallback_locale');
        
        App::setLocale($locale);
        session()->put('locale', $locale);

        return redirect()->back();
    }

    public function templates(Request $request, $id = null)
    {
        // Get templates
        $user = $request->user();
        $landingpage = config('rb.SITE_LANDING');
        $categories = ResumeCategories::all();

        // Fetch templates based on category id, or fetch all active templates
        $data = ResumeTemplate::where('active', true);
        if ($id) {
            $data->where('category_id', $id);
        }
        $data->orderBy('created_at', 'DESC');
        $data = $data->paginate(12);

        return view('landingpage.' . $landingpage . '.templates', compact('data', 'user', 'categories'));
    }

    public function landing(Request $request)
    {
        $landingpage = config('rb.SITE_LANDING');
        $user = $request->user();
        
        // Fetch active templates
        $templates = ResumeTemplate::where('active', true)->orderBy('created_at', 'DESC')->paginate(9);
        $packages = Package::all();
        $currency_code = config('rb.CURRENCY_CODE');
        $currency_symbol = config('rb.CURRENCY_SYMBOL');

        return view('landingpage.' . $landingpage . '.index', compact('user', 'templates', 'packages', 'currency_code', 'currency_symbol'));
    }

    public function terms(Request $request)
    {
        $user = $request->user();
        $termcondition = config('rb.termcondition');
        $landingpage = config('rb.SITE_LANDING');

        return view('landingpage.' . $landingpage . '.terms', compact('termcondition', 'user'));
    }

    public function privacy(Request $request)
    {
        $user = $request->user();
        $privacy = config('rb.privacy');
        $landingpage = config('rb.SITE_LANDING');

        return view('landingpage.' . $landingpage . '.privacy', compact('privacy', 'user'));
    }
    public function about(Request $request)
    {
        $user = $request->user();
        $about = config('rb.about');
        $landingpage = config('rb.SITE_LANDING');

        return view('landingpage.' . $landingpage . '.about', compact('about', 'user'));
    }
    public function blog(Request $request)
    {
        $user = $request->user();
        $blog = config('rb.blog');
        $landingpage = config('rb.SITE_LANDING');

        return view('landingpage.' . $landingpage . '.blog', compact('blog', 'user'));
    }
    public function contact(Request $request)
    {
        $user = $request->user();
        $contact = config('rb.contact');  
        $landingpage = config('rb.SITE_LANDING');

        return view('landingpage.' . $landingpage . '.contact', compact('contact', 'user'));
    }
}
