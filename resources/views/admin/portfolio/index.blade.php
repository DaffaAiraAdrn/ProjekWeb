@extends('layouts.admin')

@section('title', 'Portfolio')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Portfolio Items</h1>
        <p class="page-subtitle">Manage your portfolio projects and showcases.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Item</a>
    </div>
</div>

<div class="card">
    @if(!empty($items) && $items->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Featured</th>
                        <th>Order</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>
                                @if(!empty($item->thumbnail))
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" class="table-thumb">
                                @else
                                    <div class="table-thumb-placeholder"><i class="fas fa-image"></i></div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.portfolio.show', $item) }}" style="color:var(--text-light);font-weight:500;">{{ $item->title }}</a>
                            </td>
                            <td><span class="badge badge-purple">{{ $item->category }}</span></td>
                            <td>
                                @if($item->featured)
                                    <span class="badge badge-green"><i class="fas fa-star"></i> Yes</span>
                                @else
                                    <span class="badge badge-gray">No</span>
                                @endif
                            </td>
                            <td>{{ $item->order ?? '—' }}</td>
                            <td>
                                <div style="display:flex;gap:.4rem;justify-content:flex-end;">
                                    <a href="{{ route('admin.portfolio.show', $item) }}" class="btn-icon" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.portfolio.edit', $item) }}" class="btn-icon" title="Edit"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{ route('admin.portfolio.destroy', $item) }}" onsubmit="return confirm('Delete this portfolio item?');" style="display:inline;">
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
            <i class="fas fa-briefcase"></i>
            <p>No portfolio items yet. <a href="{{ route('admin.portfolio.create') }}">Create your first one →</a></p>
        </div>
    @endif
</div>
@endsection
