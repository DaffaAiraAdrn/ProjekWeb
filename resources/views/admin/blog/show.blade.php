@extends('layouts.admin')

@section('content')
<div class="admin-header">
    <h1>{{ $blogPost->title }}</h1>
    <div class="admin-actions">
        <a href="{{ route('admin.blog.edit', $blogPost) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="detail-card">
    @if($blogPost->featured_image)
    <div class="detail-image">
        <img src="{{ asset($blogPost->featured_image) }}" alt="{{ $blogPost->title }}" style="max-width: 100%; border-radius: 12px;">
    </div>
    @endif

    <div class="detail-meta">
        <div class="meta-row">
            <span class="meta-label">Status:</span>
            <span class="badge badge-{{ $blogPost->status === 'published' ? 'success' : 'warning' }}">{{ ucfirst($blogPost->status) }}</span>
        </div>
        <div class="meta-row">
            <span class="meta-label">Published:</span>
            <span>{{ $blogPost->published_at ? $blogPost->published_at->format('M d, Y') : 'Not published' }}</span>
        </div>
        @if($blogPost->tags && count($blogPost->tags) > 0)
        <div class="meta-row">
            <span class="meta-label">Tags:</span>
            <div class="tag-list">
                @foreach($blogPost->tags as $tag)
                <span class="badge badge-info">{{ $tag }}</span>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    @if($blogPost->excerpt)
    <div class="detail-section">
        <h3>Excerpt</h3>
        <p>{{ $blogPost->excerpt }}</p>
    </div>
    @endif

    <div class="detail-section">
        <h3>Content</h3>
        <div class="rich-content">{!! $blogPost->content !!}</div>
    </div>
</div>
@endsection
