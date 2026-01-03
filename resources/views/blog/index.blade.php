@extends('layouts.app', ['bodyClass' => ''])

@section('title', __('Blog'))

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4 font-weight-bold mb-3">{{ config('app.name') }} Blog</h1>
        <p class="lead text-muted">Expert advice on resumes, interviews, and career growth</p>
    </div>

    <!-- Search Bar -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <form action="{{ route('blog') }}" method="GET">
                <div class="input-group input-group-lg">
                    <input type="text" name="search" class="form-control" placeholder="Search articles..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fe fe-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories -->
    @if($categories->count() > 0)
    <div class="mb-5">
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('blog') }}" class="btn btn-outline-primary {{ !request('category') ? 'active' : '' }}">
                All Articles
            </a>
            @foreach($categories as $category)
                <a href="{{ $category->url }}" class="btn btn-outline-primary">
                    @if($category->icon)<i class="{{ $category->icon }} mr-1"></i>@endif
                    {{ $category->name }}
                    <span class="badge badge-light ml-1">{{ $category->published_posts_count }}</span>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Featured Posts -->
    @if($featuredPosts->count() > 0 && !request('search'))
    <div class="mb-5">
        <h3 class="mb-4">Featured Articles</h3>
        <div class="row">
            @foreach($featuredPosts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($post->featured_image)
                        <img src="{{ Storage::url($post->featured_image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $post->title }}">
                    @else
                        <div class="card-img-top bg-primary d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fe fe-file-text" style="font-size: 48px; color: white;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        @if($post->category)
                            <span class="badge badge-primary mb-2">{{ $post->category->name }}</span>
                        @endif
                        <h5 class="card-title">
                            <a href="{{ $post->public_url }}" class="text-dark">{{ $post->title }}</a>
                        </h5>
                        <p class="card-text text-muted">{{ Str::limit($post->excerpt, 120) }}</p>
                        <div class="d-flex align-items-center text-muted small">
                            <span class="mr-3">
                                <i class="fe fe-calendar mr-1"></i>
                                {{ $post->published_at->format('M d, Y') }}
                            </span>
                            <span>
                                <i class="fe fe-clock mr-1"></i>
                                {{ $post->reading_time }} min read
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- All Posts -->
    <div class="row">
        @if($posts->count() > 0)
            @foreach($posts as $post)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm hover-shadow">
                    @if($post->featured_image)
                        <img src="{{ Storage::url($post->featured_image) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $post->title }}">
                    @else
                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 180px;">
                            <i class="fe fe-file-text" style="font-size: 40px; color: white;"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        @if($post->category)
                            <span class="badge badge-primary mb-2">{{ $post->category->name }}</span>
                        @endif
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
                        <h4 class="mt-3">No Articles Found</h4>
                        <p class="text-muted">
                            @if(request('search'))
                                No articles match your search. Try different keywords.
                            @else
                                Check back soon for new content!
                            @endif
                        </p>
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
