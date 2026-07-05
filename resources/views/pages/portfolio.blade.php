@extends('layouts.app')

@section('title', 'Portfolio — DF_137')

@section('content')

<section class="portfolio-section" style="padding-top:140px;">
    <div class="section-header reveal reveal-up">
        <span class="section-label">My Work</span>
        <h2 class="section-title">Portfolio</h2>
        <p class="section-subtitle">Explore my projects across 3D modeling, machine learning, and programming. Each piece represents a unique challenge and creative solution.</p>
    </div>

    <div class="filter-tabs reveal reveal-up" id="filterTabs">
        <button class="filter-tab active" data-filter="all">All</button>
        <button class="filter-tab" data-filter="3d">3D</button>
        <button class="filter-tab" data-filter="ml">ML</button>
        <button class="filter-tab" data-filter="programming">Programming</button>
    </div>

    <div class="portfolio-grid" id="portfolioGrid">
        @forelse($portfolios as $portfolio)
            <a href="{{ route('portfolio.show', $portfolio->slug) }}" class="portfolio-card tilt-card reveal reveal-up" data-category="{{ strtolower($portfolio->category) }}">
                <div class="tilt-card-shine"></div>
                <div class="portfolio-card-image">
                    @if($portfolio->featured_image)
                        <img src="{{ asset('storage/' . $portfolio->featured_image) }}" alt="{{ $portfolio->title }}" loading="lazy">
                    @else
                        <img src="https://via.placeholder.com/600x400/1C0D2A/C7A6FF?text={{ urlencode($portfolio->title) }}" alt="{{ $portfolio->title }}" loading="lazy">
                    @endif
                    <div class="portfolio-card-overlay">
                        <span class="btn btn-ghost" style="padding:8px 20px;font-size:0.8rem;">View Project →</span>
                    </div>
                </div>
                <div class="portfolio-card-body tilt-card-inner">
                    <span class="portfolio-card-category">{{ strtoupper($portfolio->category) }}</span>
                    <h3 class="portfolio-card-title">{{ $portfolio->title }}</h3>
                    <p class="portfolio-card-desc">{{ $portfolio->excerpt }}</p>
                    @if($portfolio->tags)
                        <div class="portfolio-card-tags">
                            @foreach(explode(',', $portfolio->tags) as $tag)
                                <span class="portfolio-card-tag">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </a>
        @empty
            <div class="empty-state" style="grid-column:1/-1;">
                <h3>No projects yet</h3>
                <p>Check back soon for exciting new work.</p>
            </div>
        @endforelse
    </div>
</section>

@endsection
