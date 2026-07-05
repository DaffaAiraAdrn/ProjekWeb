@extends('layouts.admin')

@section('title', 'Blog Posts')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Blog Posts</h1>
        <p class="page-subtitle">Manage your blog articles and posts.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Post</a>
    </div>
</div>

<div class="card">
    @if(!empty($posts) && $posts->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Featured Image</th>
                        <th>Title</th>
                        <th>Tags</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>
                                @if(!empty($post->featured_image))
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="table-thumb">
                                @else
                                    <div class="table-thumb-placeholder"><i class="fas fa-newspaper"></i></div>
                                @endif
                            </td>
                            <td style="max-width:300px;">
                                <a href="{{ route('admin.blog.edit', $post) }}" style="color:var(--text-light);font-weight:500;">{{ $post->title }}</a>
                            </td>
                            <td>
                                @if(!empty($post->tags))
                                    @foreach(explode(',', $post->tags) as $tag)
                                        <span class="badge badge-purple" style="margin-right:.25rem;margin-bottom:.25rem;">{{ trim($tag) }}</span>
                                    @endforeach
                                @else
                                    <span class="badge badge-gray">—</span>
                                @endif
                            </td>
                            <td>
                                @if($post->status === 'published')
                                    <span class="badge badge-green"><i class="fas fa-check-circle"></i> Published</span>
                                @elseif($post->status === 'draft')
                                    <span class="badge badge-yellow"><i class="fas fa-file"></i> Draft</span>
                                @else
                                    <span class="badge badge-gray">{{ $post->status }}</span>
                                @endif
                            </td>
                            <td>{{ $post->published_at?->format('M d, Y') ?? '—' }}</td>
                            <td>
                                <div style="display:flex;gap:.4rem;justify-content:flex-end;">
                                    <a href="{{ route('admin.blog.edit', $post) }}" class="btn-icon" title="Edit"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" onsubmit="return confirm('Delete this blog post?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon danger" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-blog"></i>
            <p>No blog posts yet. <a href="{{ route('admin.blog.create') }}">Write your first post →</a></p>
        </div>
    @endif
</div>
@endsection
