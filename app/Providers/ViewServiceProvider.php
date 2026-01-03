<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['layouts.app'], function ($view) {

            $route = Route::currentRouteName();
            $route = str_replace('.', '-', $route);
            $view->with('bodyClass', $route);

        });

        

        View::composer(['partials.header', 'auth.login', 'auth.register', 'landingpage.*'], function ($view) {

            $current_locale  = App::getLocale();
            
            $languages       = config('languages');
            
            $active_language = array_key_exists($current_locale, $languages) ? $current_locale : config('app.fallback_locale');
            ;
            
            $view->with('languages', $languages);

            $view->with('active_language', $languages[$active_language]);

        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
