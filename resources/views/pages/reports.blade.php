@extends('layouts.app')

@section('title', 'Reports — DF_137')

@section('content')

<section class="portfolio-section" style="padding-top:140px;">
    <div class="section-header reveal reveal-up">
        <span class="section-label">Research & Analysis</span>
        <h2 class="section-title">Reports</h2>
        <p class="section-subtitle">Technical reports, research papers, and project documentation spanning machine learning experiments, 3D pipelines, and software engineering studies.</p>
    </div>

    <div class="reports-grid">
        @forelse($reports as $report)
            <div class="report-card reveal reveal-up">
                <div class="report-card-icon">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/></svg>
                </div>
                <span class="portfolio-card-category">{{ $report->category ?? 'Report' }}</span>
                <h3 class="report-card-title">{{ $report->title }}</h3>
                <p class="report-card-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($report->abstract ?? $report->content), 120) }}</p>
                <div class="report-card-meta">
                    <span>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                        {{ $report->created_at ? $report->created_at->format('M d, Y') : 'N/A' }}
                    </span>
                    @if($report->author)
                        <span>
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ $report->author }}
                        </span>
                    @endif
                    @if($report->pages)
                        <span>
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            {{ $report->pages }} pages
                        </span>
                    @endif
                </div>
                <div class="report-card-actions">
                    <a href="{{ route('reports.show', $report->slug) }}" class="report-view-btn">Read Report</a>
                    @if($report->file_path)
                        <a href="{{ asset('storage/' . $report->file_path) }}" download class="report-download-btn">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                            Download
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state" style="grid-column:1/-1;">
                <h3>No reports yet</h3>
                <p>Research reports and technical documentation will appear here.</p>
            </div>
        @endforelse
    </div>
</section>

@endsection
