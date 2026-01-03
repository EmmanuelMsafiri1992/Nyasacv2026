@extends('layouts.app', ['bodyClass' => ''])

@section('title', $post->seo_title ?? $post->title)

@push('head')
<meta name="description" content="{{ $post->seo_description ?? $post->excerpt }}">
<meta name="keywords" content="{{ $post->seo_keywords ?? implode(', ', $post->tags ?? []) }}">
<meta property="og:title" content="{{ $post->title }}">
<meta property="og:description" content="{{ $post->excerpt }}">
@if($post->featured_image)
<meta property="og:image" content="{{ Storage::url($post->featured_image) }}">
@endif
@endpush

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <!-- Back Button -->
            <a href="{{ route('blog') }}" class="btn btn-link mb-3">
                <i class="fe fe-arrow-left mr-1"></i> Back to Blog
            </a>

            <!-- Featured Image -->
            @if($post->featured_image)
            <img src="{{ Storage::url($post->featured_image) }}" class="img-fluid rounded mb-4" alt="{{ $post->title }}">
            @endif

            <!-- Post Header -->
            <div class="mb-4">
                @if($post->category)
                    <a href="{{ $post->category->url }}" class="badge badge-primary mb-2">{{ $post->category->name }}</a>
                @endif

                <h1 class="display-4 font-weight-bold mb-3">{{ $post->title }}</h1>

                <div class="d-flex align-items-center text-muted mb-3">
                    <span class="mr-4">
                        <i class="fe fe-user mr-1"></i>
                        {{ $post->author->name }}
                    </span>
                    <span class="mr-4">
                        <i class="fe fe-calendar mr-1"></i>
                        {{ $post->published_at->format('F d, Y') }}
                    </span>
                    <span class="mr-4">
                        <i class="fe fe-clock mr-1"></i>
                        {{ $post->reading_time }} min read
                    </span>
                    <span>
                        <i class="fe fe-eye mr-1"></i>
                        {{ number_format($post->views_count) }} views
                    </span>
                </div>

                @if($post->tags && count($post->tags) > 0)
                <div class="mb-3">
                    @foreach($post->tags as $tag)
                        <span class="badge badge-secondary mr-1">#{{ $tag }}</span>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Post Content -->
            <div class="post-content mb-5">
                {!! $post->content !!}
            </div>

            <!-- Social Sharing Buttons -->
            <div class="mb-4 p-4" style="background: #f7fafc; border-radius: 12px;">
                <h5 class="mb-3 font-weight-600">Share this article:</h5>
                <div class="d-flex flex-wrap" style="gap: 0.75rem;">
                    <!-- Twitter -->
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="btn btn-sm" style="background: #1DA1F2; color: white; border-radius: 8px; padding: 0.5rem 1rem; display: flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                        <span class="d-none d-sm-inline">Twitter</span>
                    </a>

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="btn btn-sm" style="background: #1877F2; color: white; border-radius: 8px; padding: 0.5rem 1rem; display: flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="d-none d-sm-inline">Facebook</span>
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" target="_blank" rel="noopener" class="btn btn-sm" style="background: #0A66C2; color: white; border-radius: 8px; padding: 0.5rem 1rem; display: flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        <span class="d-none d-sm-inline">LinkedIn</span>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->url()) }}" target="_blank" rel="noopener" class="btn btn-sm" style="background: #25D366; color: white; border-radius: 8px; padding: 0.5rem 1rem; display: flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        <span class="d-none d-sm-inline">WhatsApp</span>
                    </a>

                    <!-- Copy Link -->
                    <button onclick="copyPostLink()" class="btn btn-sm" style="background: #718096; color: white; border-radius: 8px; padding: 0.5rem 1rem; display: flex; align-items: center; gap: 0.5rem; border: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                        </svg>
                        <span class="d-none d-sm-inline">Copy Link</span>
                    </button>
                </div>
            </div>

            <script>
            function copyPostLink() {
                const url = '{{ request()->url() }}';
                navigator.clipboard.writeText(url).then(function() {
                    alert('Link copied to clipboard!');
                }, function(err) {
                    console.error('Could not copy text: ', err);
                });
            }
            </script>

            <hr class="my-5">

            <!-- Related Posts -->
            @if($relatedPosts->count() > 0)
            <div class="mb-5">
                <h3 class="mb-4">Related Articles</h3>
                <div class="row">
                    @foreach($relatedPosts as $related)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            @if($related->featured_image)
                                <img src="{{ Storage::url($related->featured_image) }}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="{{ $related->title }}">
                            @endif
                            <div class="card-body">
                                <h6 class="card-title">
                                    <a href="{{ $related->public_url }}" class="text-dark">{{ $related->title }}</a>
                                </h6>
                                <small class="text-muted">
                                    {{ $related->reading_time }} min read
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.post-content {
    font-size: 1.1rem;
    line-height: 1.8;
}
.post-content h2 {
    font-size: 2rem;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
}
.post-content h3 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}
.post-content p {
    margin-bottom: 1.25rem;
}
.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
}
.post-content ul, .post-content ol {
    margin-bottom: 1.25rem;
    padding-left: 2rem;
}
.post-content li {
    margin-bottom: 0.5rem;
}
.post-content blockquote {
    border-left: 4px solid #667eea;
    padding-left: 1.5rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6c757d;
}
.post-content code {
    background: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 4px;
    font-size: 0.9em;
}
.post-content pre {
    background: #2d3748;
    color: #fff;
    padding: 1rem;
    border-radius: 8px;
    overflow-x: auto;
    margin: 1.5rem 0;
}
.post-content pre code {
    background: transparent;
    padding: 0;
    color: #fff;
}
</style>
@endsection
