@extends('layouts.app')

@section('title', $settings['site_title'] ?? 'DF_137 — Daffa Aira Adrin')

@section('content')

{{-- ============ HERO ============ --}}
<section class="hero" id="hero">
    <div class="canvas-bg-orbs">
        <div class="canvas-bg-orb"></div>
        <div class="canvas-bg-orb"></div>
        <div class="canvas-bg-orb"></div>
    </div>
    <div class="grid-pattern"></div>
    <div class="hero-content">
        <p class="hero-greeting" id="heroGreeting">Where Creativity Meets Technology welcome to my little sandbox</p>
        <h1 class="hero-name" id="heroName">
            <span class="gradient-text">{{ $settings['hero_title'] ?? 'Daffa Aira Adrin' }}</span>
        </h1>
        <p class="hero-subtitle" id="heroSubtitle">
            <span>3D Artist</span>
            <span class="accent-dot">•</span>
            <span>ML Engineer</span>
            <span class="accent-dot">•</span>
            <span>Developer</span>
        </p>
        <div class="hero-cta" id="heroCta">
            <a href="{{ route('portfolio.index') }}" class="btn btn-primary">View Portfolio</a>
            <a href="{{ route('contact') }}" class="btn btn-ghost">Get in Touch</a>
        </div>
    </div>
    <div class="scroll-indicator">
        <span>Scroll</span>
        <div class="scroll-indicator-line"></div>
    </div>
</section>

{{-- ============ PORTFOLIO SHOWCASE ============ --}}
<section class="portfolio-section" id="portfolio-showcase">
    <div class="section-header reveal reveal-up">
        <span class="section-label">Selected Work</span>
        <h2 class="section-title">Featured Portfolio</h2>
        <p class="section-subtitle">A curated collection of projects spanning 3D artistry, machine learning, and software development.</p>
    </div>

    <div class="filter-tabs reveal reveal-up" id="filterTabs">
        <button class="filter-tab active" data-filter="all">All</button>
        <button class="filter-tab" data-filter="3d">3D</button>
        <button class="filter-tab" data-filter="ml">ML</button>
        <button class="filter-tab" data-filter="programming">Programming</button>
    </div>

    <div class="portfolio-grid" id="portfolioGrid">
        @forelse($portfolios as $portfolio)
            <a href="{{ route('portfolio.show', $portfolio->slug) }}" class="portfolio-card tilt-card reveal reveal-up" data-category="{{ $portfolio->category }}">
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

{{-- ============ SKILLS SECTION ============ --}}
<section class="section" id="skills">
    <div class="section-header reveal reveal-up">
        <span class="section-label">Capabilities</span>
        <h2 class="section-title">Skills & Expertise</h2>
        <p class="section-subtitle">Technologies and tools I use to bring ideas to life.</p>
    </div>

    <div class="skills-grid">
        <div class="skill-item reveal reveal-up stagger-1">
            <div class="skill-header"><span class="skill-name">3D Modeling (Blender)</span><span class="skill-percent">95%</span></div>
            <div class="skill-bar"><div class="skill-bar-fill" data-width="95"></div></div>
        </div>
        <div class="skill-item reveal reveal-up stagger-2">
            <div class="skill-header"><span class="skill-name">Machine Learning / Python</span><span class="skill-percent">88%</span></div>
            <div class="skill-bar"><div class="skill-bar-fill" data-width="88"></div></div>
        </div>
        <div class="skill-item reveal reveal-up stagger-3">
            <div class="skill-header"><span class="skill-name">Web Development</span><span class="skill-percent">85%</span></div>
            <div class="skill-bar"><div class="skill-bar-fill" data-width="85"></div></div>
        </div>
        <div class="skill-item reveal reveal-up stagger-4">
            <div class="skill-header"><span class="skill-name">Deep Learning / TensorFlow</span><span class="skill-percent">82%</span></div>
            <div class="skill-bar"><div class="skill-bar-fill" data-width="82"></div></div>
        </div>
        <div class="skill-item reveal reveal-up stagger-5">
            <div class="skill-header"><span class="skill-name">C++ / Algorithms</span><span class="skill-percent">78%</span></div>
            <div class="skill-bar"><div class="skill-bar-fill" data-width="78"></div></div>
        </div>
        <div class="skill-item reveal reveal-up stagger-6">
            <div class="skill-header"><span class="skill-name">UI/UX Design</span><span class="skill-percent">75%</span></div>
            <div class="skill-bar"><div class="skill-bar-fill" data-width="75"></div></div>
        </div>
    </div>
</section>

{{-- ============ FEATURED PROJECTS ============ --}}
<section class="section" id="featured">
    <div class="section-header reveal reveal-up">
        <span class="section-label">Highlights</span>
        <h2 class="section-title">Featured Projects</h2>
        <p class="section-subtitle">Deep dives into select projects that define my creative and technical journey.</p>
    </div>

    <div class="featured-grid">
        @php
            $featured = $portfolios->where('featured', true)->take(3);
            if($featured->isEmpty()) { $featured = $portfolios->take(3); }
        @endphp
        @forelse($featured as $project)
            <a href="{{ route('portfolio.show', $project->slug) }}" class="featured-card reveal reveal-scale">
                @if($project->featured_image)
                    <img src="{{ asset('storage/' . $project->featured_image) }}" alt="{{ $project->title }}" loading="lazy">
                @else
                    <img src="https://via.placeholder.com/800x600/2b0057/C7A6FF?text={{ urlencode($project->title) }}" alt="{{ $project->title }}" loading="lazy">
                @endif
                <div class="featured-card-content">
                    <span class="featured-card-category">{{ strtoupper($project->category) }}</span>
                    <h3 class="featured-card-title">{{ $project->title }}</h3>
                    <p class="featured-card-desc">{{ $project->excerpt }}</p>
                </div>
            </a>
        @empty
            <div class="empty-state" style="grid-column:1/-1;">
                <h3>No featured projects</h3>
                <p>Featured projects will appear here.</p>
            </div>
        @endforelse
    </div>
</section>

@endsection

@section('scripts')
<script>
// Hero entrance animation
document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap !== 'undefined') {
        gsap.to('#heroGreeting', { opacity: 1, y: 0, duration: 0.8, delay: 0.5, ease: 'power3.out' });
        gsap.to('#heroName', { opacity: 1, y: 0, duration: 1, delay: 0.7, ease: 'power3.out' });
        gsap.to('#heroSubtitle', { opacity: 1, y: 0, duration: 0.8, delay: 1, ease: 'power3.out' });
        gsap.to('#heroCta', { opacity: 1, y: 0, duration: 0.8, delay: 1.2, ease: 'power3.out' });
    } else {
        document.querySelectorAll('#heroGreeting, #heroName, #heroSubtitle, #heroCta').forEach(el => el.style.opacity = 1);
    }
});
</script>
@endsection
