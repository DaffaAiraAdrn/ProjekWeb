@extends('layouts.app')

@section('title', $report->title . ' — DF_137 Reports')

@section('content')

<div class="reading-progress" id="readingProgress"></div>

{{-- Hero with Parallax --}}
<section class="report-detail-hero" id="reportHero">
    @if($report->cover_image)
        <img src="{{ asset('storage/' . $report->cover_image) }}" alt="{{ $report->title }}" id="parallaxImg">
    @else
        <img src="https://via.placeholder.com/1920x1080/2b0057/C7A6FF?text={{ urlencode($report->title) }}" alt="{{ $report->title }}" id="parallaxImg">
    @endif
    <div class="report-detail-hero-content reveal reveal-up">
        <span class="section-label">{{ $report->category ?? 'Report' }}</span>
        <h1 class="section-title gradient-text" style="margin-bottom:16px;">{{ $report->title }}</h1>
        <div class="blog-meta" style="justify-content:center;">
            <span>{{ $report->created_at ? $report->created_at->format('M d, Y') : '' }}</span>
            @if($report->author)<span>•</span><span>{{ $report->author }}</span>@endif
            @if($report->pages)<span>•</span><span>{{ $report->pages }} pages</span>@endif
        </div>
    </div>
</section>

{{-- Body --}}
<article class="report-detail-body">
    @if($report->abstract)
    <div class="report-section reveal reveal-up">
        <h2>Abstract</h2>
        <p>{{ $report->abstract }}</p>
    </div>
    @endif

    @if($report->introduction)
    <div class="report-section reveal reveal-up">
        <h2>1. Introduction</h2>
        <div>{!! $report->introduction !!}</div>
    </div>
    @endif

    @if($report->methodology)
    <div class="report-section reveal reveal-up">
        <h2>2. Methodology</h2>
        <div>{!! $report->methodology !!}</div>
    </div>
    @endif

    @if($report->results)
    <div class="report-section reveal reveal-up">
        <h2>3. Results & Discussion</h2>
        <div>{!! $report->results !!}</div>
    </div>
    @endif

    @if($report->conclusion)
    <div class="report-section reveal reveal-up">
        <h2>4. Conclusion</h2>
        <div>{!! $report->conclusion !!}</div>
    </div>
    @endif

    {{-- Fallback: if structured fields are empty, show content --}}
    @if(!$report->abstract && !$report->introduction && !$report->methodology && !$report->results && !$report->conclusion && $report->content)
    <div class="report-section reveal reveal-up">
        <h2>Full Report</h2>
        <div>{!! $report->content !!}</div>
    </div>
    @endif

    @if($report->references)
    <div class="report-section reveal reveal-up">
        <h2>References</h2>
        <ol class="report-references">
            @foreach(explode("\n", $report->references) as $ref)
                @if(trim($ref))
                    <li>{{ trim($ref) }}</li>
                @endif
            @endforeach
        </ol>
    </div>
    @endif

    @if($report->file_path || $report->attachments)
    <div class="report-attachments reveal reveal-up">
        <h4>Attachments & Downloads</h4>
        @if($report->file_path)
            <div class="attachment-item">
                <div class="attachment-name">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                    {{ basename($report->file_path) }}
                </div>
                <a href="{{ asset('storage/' . $report->file_path) }}" download class="report-download-btn">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                    Download
                </a>
            </div>
        @endif
        @if($report->attachments)
            @php $attachments = json_decode($report->attachments, true) ?? []; @endphp
            @foreach($attachments as $attachment)
                <div class="attachment-item">
                    <div class="attachment-name">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                        {{ basename($attachment) }}
                    </div>
                    <a href="{{ asset('storage/' . $attachment) }}" download class="report-download-btn">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        Download
                    </a>
                </div>
            @endforeach
        @endif
    </div>
    @endif

    <div style="margin-top:48px;padding-top:32px;border-top:1px solid var(--glass-border);">
        <a href="{{ route('reports.index') }}" class="btn btn-ghost">← Back to Reports</a>
    </div>
</article>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const parallaxImg = document.getElementById('parallaxImg');
    if (parallaxImg && typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);
        gsap.to(parallaxImg, {
            yPercent: 20,
            ease: 'none',
            scrollTrigger: { trigger: '#reportHero', start: 'top top', end: 'bottom top', scrub: true }
        });
    }
});
</script>
@endsection
