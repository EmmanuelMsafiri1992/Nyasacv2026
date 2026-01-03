@auth
    @extends('layouts.dashboard')

    @section('title', __('Blog'))
    @section('header-title', __('Blog'))

    @section('content')
    <div class="dashboard-content">
        <div class="card">
            <div class="card-status bg-blue"></div>
            <div class="card-body content-page">
                {!! $blog !!}
            </div>
        </div>
    </div>

    @section('styles')
    <style>
    .content-page {
        font-size: 1.05rem;
        line-height: 1.8;
    }
    .content-page h1, .content-page h2, .content-page h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .content-page p {
        margin-bottom: 1rem;
    }
    </style>
    @endsection
    @endsection
@else
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @includeWhen(config('rb.GOOGLE_ANALYTICS'), 'partials.google-analytics')

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">
        <title>{{ __(config('app.name')) }} &mdash; {{ __(config('rb.SITE_DESCRIPTION')) }}</title>
        <meta name="description" content="{{ config('rb.SITE_DESCRIPTION') }}">
        <meta name="keywords" content="{{ config('rb.SITE_KEYWORDS') }}">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,600,700|Quicksand:700|Indie+Flower:400">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ mix('css/app.bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('landingpage/default/css/app.css') }}?v={{ config('rb.version') }}">


    </head>
    <body data-spy="scroll" data-target="#mainNav" data-offset="70">

        <div class="page">
        <header class="header js-header">
            <div class="container">
                <div class="d-flex align-items-center position-relative">
                    <a href="{{ route('landing') }}" class="logo">
                        <img src="{{ asset('img/logo.png') }}" alt="" title="">
                        <div>
                            {{ __(config('app.name')) }}
                        </div>
                    </a>
                    <nav class="ml-auto header-nav d-none d-md-block">
                        <a class="nav-link" href="{{ route('landing') }}">@lang('Home')</a>
                        <a class="nav-link" href="{{ route('templates') }}">@lang('All Templates')</a>
                        <a class="nav-link" href="{{ route('login') }}">@lang('Login')</a>
                        <a class="nav-link" href="{{ route('register') }}">@lang('Register')</a>
                    </nav>
                </div>
            </div>
        </header>
        <main class="main bg-light">
            <section class="section">
                <div class="container">
                    {!!$blog!!}
                </div>
            </section>
        </main>

            <footer class="footer">
                <div class="container">
                    <div class="row text-center text-lg-left">
                        <div class="col-lg-6">
                                &copy; {{ date('Y') }} <a href="{{ config('app.url') }}" target="_blank">{{ __(config('app.name')) }}</a> &mdash; {{ __(config('rb.SITE_DESCRIPTION')) }}
                        </div>
                        <div class="col-lg-6 text-lg-right">
                        <a href="{{ route('about') }}">@lang('About Us')</a>
                            <a href="{{ route('contact') }}">@lang('Contact Us')</a>
                            <a href="{{ route('blog') }}">@lang('Blog')</a>
                            <a href="{{ route('privacy') }}">@lang('Privacy Policy')</a>
                            <a href="{{ route('terms') }}">@lang('Term and condition')</a>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <a id="back-to-top" href="#" class="btn btn-light btn-lg back-to-top" role="button"><i class="fe fe-chevron-up"></i></a>
        <script src="{{ mix('js/app.bundle.js') }}" type="text/javascript"></script>

        <script>
        $(document).ready(function(){
            "use strict";

            $(window).scroll(function () {
                    if ($(this).scrollTop() > 50) {
                        $('#back-to-top').fadeIn();
                    } else {
                        $('#back-to-top').fadeOut();
                    }
                });

                // scroll body to 0px on click
                $( "#back-to-top" ).on( "click", function() {
                    $('body,html').animate({
                        scrollTop: 0
                    }, 200);
                    return false;
                });
        });
    </script>
    </body>
</html>
@endauth