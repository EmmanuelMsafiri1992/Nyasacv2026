@auth
    @extends('layouts.dashboard')

    @section('title', __('Templates'))
    @section('header-title', __('Templates'))

    @section('content')
    <div class="dashboard-content">
        <div class="mb-4">
            <h2 class="mb-0">@lang('Choose a Template')</h2>
            <p class="text-muted mb-0">@lang('Select the perfect template for your professional resume')</p>
        </div>

        <!-- Template Categories -->
        <div class="card mb-4">
            <div class="card-body">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item">
                        <a href="{{ url('templates')}}" class="nav-link {{ (request()->is('templates')) ? 'active' : '' }}">
                            <i class="fe fe-grid mr-2"></i>@lang("All Templates")
                        </a>
                    </li>
                    @foreach($categories as $item)
                        <li class="nav-item">
                            <a href="{{ url('templates'). '/' .$item->id}}" class="nav-link {{ request()->is('templates/'.$item->id) ? 'active' : '' }}">
                                {{$item->name}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Templates Grid -->
        @if($data->count() > 0)
            <div class="row">
                @foreach($data as $item)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card card-template h-100">
                            @if($item->is_premium)
                                <div class="ribbon ribbon-top ribbon-bookmark bg-warning">
                                    <i class="fe fe-star"></i> @lang("Premium")
                                </div>
                            @endif
                            <a href="{{ url('resume/createresume/' . $item->id) }}" class="template-link">
                                <div class="card-img-top template-preview">
                                    <img src="{{ URL::to('/') }}/images/{{ $item->thumb }}" alt="{{ $item->name }}" class="img-fluid">
                                    <div class="template-overlay">
                                        <div class="template-actions">
                                            <button class="btn btn-primary btn-lg">
                                                <i class="fe fe-edit mr-2"></i>@lang('Use Template')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-1">{{ $item->name }}</h5>
                                    @if($item->is_premium)
                                        <span class="badge badge-warning">
                                            <i class="fe fe-star"></i> @lang('Premium')
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            <i class="fe fe-check"></i> @lang('Free')
                                        </span>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $data->appends( Request::all() )->links() }}
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fe fe-layout" style="font-size: 80px; color: #e0e0e0;"></i>
                    </div>
                    <h3>@lang('No Templates Found')</h3>
                    <p class="text-muted mb-4">@lang('No templates available in this category. Try selecting a different category.')</p>
                    <a href="{{ url('templates')}}" class="btn btn-primary">
                        <i class="fe fe-grid mr-2"></i>@lang('View All Templates')
                    </a>
                </div>
            </div>
        @endif
    </div>

    @section('styles')
    <style>
    .card-template {
        transition: transform 0.3s, box-shadow 0.3s;
        overflow: hidden;
    }

    .card-template:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .template-link {
        text-decoration: none;
        color: inherit;
    }

    .template-link:hover {
        text-decoration: none;
        color: inherit;
    }

    .template-preview {
        position: relative;
        overflow: hidden;
        background: #f5f7fb;
        padding: 20px;
    }

    .template-preview img {
        transition: transform 0.3s;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .card-template:hover .template-preview img {
        transform: scale(1.05);
    }

    .template-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(102, 126, 234, 0.95);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .card-template:hover .template-overlay {
        opacity: 1;
    }

    .template-actions {
        transform: translateY(20px);
        transition: transform 0.3s;
    }

    .card-template:hover .template-actions {
        transform: translateY(0);
    }

    .ribbon {
        width: 100px;
        position: absolute;
        top: 10px;
        right: -10px;
        padding: 5px 10px;
        color: white;
        text-align: center;
        font-size: 12px;
        font-weight: bold;
        z-index: 10;
    }

    .ribbon-bookmark:before {
        content: '';
        position: absolute;
        right: 0;
        bottom: -10px;
        border-left: 50px solid transparent;
        border-right: 50px solid;
        border-right-color: inherit;
        border-bottom: 10px solid transparent;
    }

    .nav-pills .nav-link {
        border-radius: 8px;
        font-weight: 500;
    }

    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    </style>
    @endsection
    @endsection
@else
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>

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
                    <div class="section-title">
                        <h2>@lang('Choose a Template')</h2>
                    </div>
                    <div class="row">
                    <div class="col-sm-12">

                    <ul class="categories-list nav border-0 flex-column flex-lg-row">
                      <li class="categories-item">
                          <a href="{{ url('templates')}}" class="categories-link {{ (request()->is('templates')) ? 'categories-link-isCurrent' : '' }}">@lang('All Templates')</a>
                        </li>
                      @foreach($categories as $item)
                        <li class="categories-item">
                          <a href="{{ url('templates'). '/' .$item->id}}" class="categories-link {{ request()->is('templates/'.$item->id) ? 'categories-link-isCurrent' : '' }}">{{$item->name}}</a>
                        </li>
                      @endforeach


                    </ul>

                  </div>

                </div>

            <div class="list_teamplate">
              <div class="row">
                @if($data->count() > 0)
                @foreach($data as $item)
                 <div class="col-md-4">
                                          <a href="{{ url('resume/createresume/' . $item->id) }}" class="nav-link">
                                          <div class="card">
                                              @if($item->is_premium)
                                                <span class="resume-premium">@lang("Premium")</span>
                                              @endif
                                              <img src="{{ URL::to('/') }}/images/{{ $item->thumb }}" class="card-img-top" alt="...">
                                              <div class="card-body">
                                                <h5 class="card-title">{{ $item->name }}</h5>
                                              </div>
                                            </div>
                                          </a>
                                      </div>

                @endforeach

                @endif
              </div>
              <div class="row mt-5">
                {{ $data->appends( Request::all() )->links() }}
              </div>
               <div class="row mt-5">
                  <div class="col-sm-12">
                 @if($data->count()== 0)
                  <h1 class="page-title">@lang('Not found template')</h1>
                 @endif
               </div>
               </div>
            </div>
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

        <script src="{{ mix('js/app.bundle.js') }}" type="text/javascript"></script>

       <script type="text/javascript">
        $(document).ready(function(){

    // Lift card and show stats on Mouseover
    $('.product-card').hover(function(){
            $(this).addClass('animate');
            $('div.carouselNext, div.carouselPrev').addClass('visible');

         }, function(){
            $(this).removeClass('animate');
            $('div.carouselNext, div.carouselPrev').removeClass('visible');
    });

});
    </script>
    </body>
</html>
@endauth
