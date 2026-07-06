@extends('layouts.app')

@section('title', $post->title . ' — DF_137 Blog')

@section('content')

<div class="reading-progress" id="readingProgress"></div>

{{-- Hero with Parallax --}}
<section class="blog-detail-hero" id="blogHero">
    @if($post->featured_image)
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" id="parallaxImg">
    @else
        <img src="https://via.placeholder.com/1920x1080/2b0057/C7A6FF?text={{ urlencode($post->title) }}" alt="{{ $post->title }}" id="parallaxImg">
    @endif
    <div class="blog-detail-hero-content reveal reveal-up">
        <span class="section-label">{{ $post->category ?? 'Article' }}</span>
        <h1>{{ $post->title }}</h1>
        <div class="blog-meta" style="justify-content:center;">
            <span>{{ $post->created_at ? $post->created_at->format('M d, Y') : '' }}</span>
            <span>•</span>
            <span>{{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
        </div>
    </div>
</section>

{{-- Body --}}
<article class="blog-detail-body">
    <div class="blog-detail-content reveal reveal-up">
        {!! $post->content !!}
    </div>

    @if($post->tags)
        <div class="blog-tags reveal reveal-up">
            @if(is_array($post->tags))
                @foreach($post->tags as $tag)
                    <span class="blog-tag">{{ trim($tag) }}</span>
                @endforeach
            @elseif(is_string($post->tags))
                @foreach(explode(',', $post->tags) as $tag)
                    <span class="blog-tag">{{ trim($tag) }}</span>
                @endforeach
            @endif
        </div>
    @endif

    <div style="margin-top:48px;padding-top:32px;border-top:1px solid var(--glass-border);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
        <a href="{{ route('blog.index') }}" class="btn btn-ghost">← Back to Blog</a>
        <div class="footer-social" style="display:flex;gap:12px;">
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}" target="_blank" class="social-link" aria-label="Share on Twitter">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>
            </a>
        </div>
    </div>
</article>

@endsection

@section('scripts')
<script>
// Parallax + reading progress
document.addEventListener('DOMContentLoaded', () => {
    const parallaxImg = document.getElementById('parallaxImg');
    if (parallaxImg && typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
        gsap.to(parallaxImg, {
            yPercent: 20,
            ease: 'none',
            scrollTrigger: { trigger: '#blogHero', start: 'top top', end: 'bottom top', scrub: true }
        });
    }
});
</script>
@endsection
