@extends('layouts.admin')

@section('title', $item->title)

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $item->title }}</h1>
        <p class="page-subtitle">Portfolio item detail view</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.portfolio.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
        <a href="{{ route('admin.portfolio.edit', $item) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
    </div>
</div>

<div class="card" style="margin-bottom:1.5rem;">
    @if(!empty($item->thumbnail))
        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" style="width:100%;max-height:400px;object-fit:cover;border-radius:12px;margin-bottom:1.5rem;">
    @endif

    <div class="detail-row">
        <div class="detail-label">Category</div>
        <div class="detail-value"><span class="badge badge-purple">{{ $item->category }}</span></div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Featured</div>
        <div class="detail-value">
            @if($item->featured)
                <span class="badge badge-green"><i class="fas fa-star"></i> Featured</span>
            @else
                <span class="badge badge-gray">Not featured</span>
            @endif
        </div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Order</div>
        <div class="detail-value">{{ $item->order ?? '—' }}</div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Description</div>
        <div class="detail-value">{{ $item->description }}</div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Created</div>
        <div class="detail-value">{{ $item->created_at?->format('M d, Y H:i') }}</div>
    </div>
    <div class="detail-row">
        <div class="detail-label">Updated</div>
        <div class="detail-value">{{ $item->updated_at?->format('M d, Y H:i') }}</div>
    </div>
</div>

<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-header"><h2 class="card-title">Content</h2></div>
    <div class="detail-content">{!! $item->content !!}</div>
</div>

@if(!empty($item->images) && count($item->images) > 0)
    <div class="card">
        <div class="card-header"><h2 class="card-title">Project Images</h2></div>
        <div class="preview-grid" style="display:grid;">
            @foreach($item->images as $image)
                <div class="preview-item">
                    <img src="{{ asset('storage/' . ($image->path ?? $image)) }}" alt="Project image {{ $loop->index + 1 }}">
                </div>
            @endforeach
        </div>
    </div>
@endif
@endsection
