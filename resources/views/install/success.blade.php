@extends('layouts.install')

@section('content')
<div class="container text-center">
    <div class="display-1 text-muted mb-5"> <i class="fe fe-check-circle text-success"></i></div>
    <h1 class="h2 mb-3">The installation was successful</h1>
    <p class="h4 text-muted font-weight-normal mb-7">The installation was successful...</p>
    <a class="btn btn-success" href="{{ route('landing') }}">
      <i class="fe fe-arrow-left mr-2"></i>Landing Page
    </a>
    <a class="btn btn-primary" href="{{ route('login') }}">
        Login Now
    </a>
    
  </div>
@endsection