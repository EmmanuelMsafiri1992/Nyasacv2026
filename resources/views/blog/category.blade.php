@extends('layouts.app', ['bodyClass' => ''])

@section('title', $category->name . ' - Blog')

@section('content')
<div class="container py-5">
    <!-- Category Header -->
    <div class="text-center mb-5">
        @if($category->icon)
            <i class="{{ $category->icon }}" style="font-size: 48px; color: {{ $category->color }};"></i>
        @endif
        <h1 class="display-4 font-weight-bold mb-3">{{ $category->name }}</h1>
        @if($category->description)
            <p class="lead text-muted">{{ $category->description }}</p>
        @endif
        <p class="text-muted">{{ $posts->total() }} {{ Str::plural('article', $posts->total()) }}</p>
    </div>

    <!-- Other Categories -->
    <div class="mb-5">
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('blog') }}" class="btn btn-outline-primary">
                All Articles
            </a>
            @foreach($categories as $cat)
                <a href="{{ $cat->url }}" class="btn btn-outline-primary {{ $cat->id == $category->id ? 'active' : '' }}">
                    @if($cat->icon)<i class="{{ $cat->icon }} mr-1"></i>@endif
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Posts -->
    <div class="row">
        @if($posts->count() > 0)
            @foreach($posts as $post)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm hover-shadow">
                    @if($post->featured_image)
                        <img src="{{ Storage::url($post->featured_image) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $post->title }}">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 180px; background: {{ $category->color }};">
                            <i class="fe fe-file-text" style="font-size: 40px; color: white;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ $post->public_url }}" class="text-dark">{{ $post->title }}</a>
                        </h5>
                        <p class="card-text text-muted">{{ Str::limit($post->excerpt, 100) }}</p>
                        <div class="d-flex align-items-center justify-content-between text-muted small">
                            <span>
                                <i class="fe fe-calendar mr-1"></i>
                                {{ $post->published_at->format('M d, Y') }}
                            </span>
                            <span>
                                <i class="fe fe-clock mr-1"></i>
                                {{ $post->reading_time }} min
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="{{ $post->public_url }}" class="btn btn-outline-primary btn-sm btn-block">
                            Read More <i class="fe fe-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Pagination -->
            <div class="col-12">
                {{ $posts->links() }}
            </div>
        @else
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fe fe-inbox" style="font-size: 64px; opacity: 0.3;"></i>
                        <h4 class="mt-3">No Articles in This Category Yet</h4>
                        <p class="text-muted">Check back soon for new content!</p>
                        <a href="{{ route('blog') }}" class="btn btn-primary mt-3">
                            Browse All Articles
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.hover-shadow {
    transition: all 0.3s ease;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}
.gap-3 {
    gap: 0.75rem;
}
</style>
@endsection
