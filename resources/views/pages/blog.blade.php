@extends('layouts.app')

@section('title', 'Blog — DF_137')

@section('content')

@php
    $featuredPost = $posts->where('is_featured', true)->first() ?? $posts->first();
    $otherPosts = $posts->filter(function($p) use ($featuredPost) { return $p->id !== ($featuredPost->id ?? null); });
@endphp

{{-- Featured Post --}}
@if($featuredPost)
<section class="blog-featured">
    <a href="{{ route('blog.show', $featuredPost->slug) }}" class="blog-featured-card reveal reveal-scale">
        @if($featuredPost->featured_image)
            <img src="{{ asset('storage/' . $featuredPost->featured_image) }}" alt="{{ $featuredPost->title }}" loading="lazy">
        @else
            <img src="https://via.placeholder.com/1600x900/2b0057/C7A6FF?text={{ urlencode($featuredPost->title) }}" alt="{{ $featuredPost->title }}" loading="lazy">
        @endif
        <div class="blog-featured-content">
            <span class="blog-featured-tag">Featured</span>
            <h2 class="blog-featured-title">{{ $featuredPost->title }}</h2>
            <p class="blog-featured-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($featuredPost->content), 150) }}</p>
            <div class="blog-meta">
                <span>{{ $featuredPost->created_at ? $featuredPost->created_at->format('M d, Y') : '' }}</span>
                <span>•</span>
                <span>{{ \Illuminate\Support\Str::limit(strip_tags($featuredPost->content), 0) ? ceil(str_word_count(strip_tags($featuredPost->content)) / 200) : 1 }} min read</span>
            </div>
        </div>
    </a>
</section>
@endif

{{-- Blog Grid --}}
<section class="blog-grid">
    <div class="section-header reveal reveal-up" style="grid-column:1/-1;margin-bottom:0;">
        <span class="section-label">Latest Articles</span>
        <h2 class="section-title">From the Blog</h2>
    </div>
    @forelse($otherPosts as $post)
        <a href="{{ route('blog.show', $post->slug) }}" class="blog-card reveal reveal-up">
            <div class="blog-card-image">
                @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" loading="lazy">
                @else
                    <img src="https://via.placeholder.com/600x400/1C0D2A/C7A6FF?text={{ urlencode($post->title) }}" alt="{{ $post->title }}" loading="lazy">
                @endif
            </div>
            <div class="blog-card-body">
                <span class="blog-card-tag">{{ $post->category ?? 'Article' }}</span>
                <h3 class="blog-card-title">{{ $post->title }}</h3>
                <p class="blog-card-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}</p>
                <div class="blog-meta">
                    <span>{{ $post->created_at ? $post->created_at->format('M d, Y') : '' }}</span>
                    <span>•</span>
                    <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
                </div>
            </div>
        </a>
    @empty
        @if(!$featuredPost)
            <div class="empty-state" style="grid-column:1/-1;">
                <h3>No blog posts yet</h3>
                <p>Check back soon for articles and insights.</p>
            </div>
        @endif
    @endforelse
</section>

@endsection
