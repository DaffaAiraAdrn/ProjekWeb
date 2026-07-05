@extends('layouts.admin')

@section('content')
<div class="admin-header">
    <h1>{{ $report->title }}</h1>
    <div class="admin-actions">
        <a href="{{ route('admin.reports.edit', $report) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="detail-card">
    @if($report->cover_image)
    <div class="detail-image">
        <img src="{{ asset($report->cover_image) }}" alt="{{ $report->title }}" style="max-width: 100%; border-radius: 12px;">
    </div>
    @endif

    <div class="detail-meta">
        <div class="meta-row">
            <span class="meta-label">Status:</span>
            <span class="badge badge-{{ $report->status === 'published' ? 'success' : 'warning' }}">{{ ucfirst($report->status) }}</span>
        </div>
        <div class="meta-row">
            <span class="meta-label">Published:</span>
            <span>{{ $report->published_at ? $report->published_at->format('M d, Y') : 'Not published' }}</span>
        </div>
    </div>

    @if($report->abstract)
    <div class="detail-section">
        <h3>Abstract</h3>
        <div class="rich-content">{!! $report->abstract !!}</div>
    </div>
    @endif

    @if($report->introduction)
    <div class="detail-section">
        <h3>Introduction</h3>
        <div class="rich-content">{!! $report->introduction !!}</div>
    </div>
    @endif

    @if($report->methodology)
    <div class="detail-section">
        <h3>Methodology</h3>
        <div class="rich-content">{!! $report->methodology !!}</div>
    </div>
    @endif

    @if($report->results)
    <div class="detail-section">
        <h3>Results</h3>
        <div class="rich-content">{!! $report->results !!}</div>
    </div>
    @endif

    @if($report->conclusion)
    <div class="detail-section">
        <h3>Conclusion</h3>
        <div class="rich-content">{!! $report->conclusion !!}</div>
    </div>
    @endif

    @if($report->references)
    <div class="detail-section">
        <h3>References</h3>
        <div class="rich-content">{!! $report->references !!}</div>
    </div>
    @endif

    @if($report->attachments && count($report->attachments) > 0)
    <div class="detail-section">
        <h3>Attachments</h3>
        <div class="attachment-list">
            @foreach($report->attachments as $attachment)
            <div class="attachment-item">
                <i class="fas fa-file-download"></i>
                <a href="{{ asset($attachment) }}" target="_blank">{{ basename($attachment) }}</a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
