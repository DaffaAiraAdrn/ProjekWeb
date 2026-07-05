@extends('layouts.app')

@section('title', $portfolio->title . ' — DF_137')

@section('content')

{{-- Hero with Parallax --}}
<section class="portfolio-detail-hero" id="detailHero">
    @if($portfolio->featured_image)
        <img src="{{ asset('storage/' . $portfolio->featured_image) }}" alt="{{ $portfolio->title }}" id="parallaxImg">
    @else
        <img src="https://via.placeholder.com/1920x1080/2b0057/C7A6FF?text={{ urlencode($portfolio->title) }}" alt="{{ $portfolio->title }}" id="parallaxImg">
    @endif
    <div class="portfolio-detail-hero-content reveal reveal-up">
        <span class="section-label">{{ strtoupper($portfolio->category) }}</span>
        <h1 class="section-title gradient-text" style="margin-bottom:16px;">{{ $portfolio->title }}</h1>
        <p class="section-subtitle">{{ $portfolio->excerpt }}</p>
    </div>
</section>

{{-- Body --}}
<div class="portfolio-detail-body">
    <div class="portfolio-detail-content reveal reveal-up">
        {!! $portfolio->content !!}

        @if($portfolio->gallery_images)
            <h3>Gallery</h3>
            <div class="gallery-grid" id="galleryGrid">
                @foreach(json_decode($portfolio->gallery_images, true) ?? [] as $image)
                    <div class="gallery-item" data-lightbox>
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $portfolio->title }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <aside class="portfolio-detail-sidebar reveal reveal-right">
        <div class="info-card">
            <h4>Project Info</h4>
            <div class="info-row"><span class="label">Category</span><span class="value">{{ ucfirst($portfolio->category) }}</span></div>
            <div class="info-row"><span class="label">Date</span><span class="value">{{ $portfolio->created_at ? $portfolio->created_at->format('M Y') : 'N/A' }}</span></div>
            @if($portfolio->client)<div class="info-row"><span class="label">Client</span><span class="value">{{ $portfolio->client }}</span></div>@endif
            @if($portfolio->url)<div class="info-row"><span class="label">URL</span><span class="value"><a href="{{ $portfolio->url }}" target="_blank" style="color:var(--accent);">Visit →</a></span></div>@endif
            @if($portfolio->tags)
                <div style="margin-top:20px;">
                    <h4 style="margin-bottom:12px;">Tags</h4>
                    <div class="portfolio-card-tags">
                        @foreach(explode(',', $portfolio->tags) as $tag)
                            <span class="portfolio-card-tag">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div style="margin-top:24px;">
            <a href="{{ route('portfolio.index') }}" class="btn btn-ghost" style="width:100%;justify-content:center;">← Back to Portfolio</a>
        </div>
    </aside>
</div>

{{-- Next/Prev Nav --}}
@php
    $allPortfolios = $portfolios ?? collect([]);
    $currentIndex = $allPortfolios->search(function($p) use ($portfolio) { return $p->id === $portfolio->id; });
    $prevProject = $currentIndex !== false && $currentIndex > 0 ? $allPortfolios[$currentIndex - 1] : null;
    $nextProject = $currentIndex !== false && $currentIndex < $allPortfolios->count() - 1 ? $allPortfolios[$currentIndex + 1] : null;
@endphp

@if($prevProject || $nextProject)
<nav class="post-nav">
    @if($prevProject)
        <a href="{{ route('portfolio.show', $prevProject->slug) }}" class="post-nav-link prev">
            <div class="post-nav-label">← Previous</div>
            <div class="post-nav-title">{{ $prevProject->title }}</div>
        </a>
    @else
        <div></div>
    @endif
    @if($nextProject)
        <a href="{{ route('portfolio.show', $nextProject->slug) }}" class="post-nav-link next">
            <div class="post-nav-label">Next →</div>
            <div class="post-nav-title">{{ $nextProject->title }}</div>
        </a>
    @endif
</nav>
@endif

@endsection

@section('scripts')
<script>
// Parallax hero image
document.addEventListener('DOMContentLoaded', () => {
    const parallaxImg = document.getElementById('parallaxImg');
    if (parallaxImg && typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
        gsap.to(parallaxImg, {
            yPercent: 20,
            ease: 'none',
            scrollTrigger: {
                trigger: '#detailHero',
                start: 'top top',
                end: 'bottom top',
                scrub: true
            }
        });
    }
});
</script>
@endsection
