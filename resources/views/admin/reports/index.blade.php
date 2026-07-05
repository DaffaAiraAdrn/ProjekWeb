@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Reports</h1>
        <p class="page-subtitle">Manage your research reports and technical documents.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.reports.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Report</a>
    </div>
</div>

<div class="card">
    @if(!empty($reports) && $reports->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Attachments</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>
                                @if(!empty($report->cover_image))
                                    <img src="{{ asset('storage/' . $report->cover_image) }}" alt="{{ $report->title }}" class="table-thumb">
                                @else
                                    <div class="table-thumb-placeholder"><i class="fas fa-file-alt"></i></div>
                                @endif
                            </td>
                            <td style="max-width:300px;">
                                <a href="{{ route('admin.reports.edit', $report) }}" style="color:var(--text-light);font-weight:500;">{{ $report->title }}</a>
                            </td>
                            <td>
                                @if(!empty($report->attachments) && count($report->attachments) > 0)
                                    <span class="badge badge-purple"><i class="fas fa-paperclip"></i> {{ count($report->attachments) }}</span>
                                @else
                                    <span class="badge badge-gray">—</span>
                                @endif
                            </td>
                            <td>{{ $report->created_at?->format('M d, Y') }}</td>
                            <td>{{ $report->updated_at?->format('M d, Y') }}</td>
                            <td>
                                <div style="display:flex;gap:.4rem;justify-content:flex-end;">
                                    <a href="{{ route('admin.reports.edit', $report) }}" class="btn-icon" title="Edit"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" onsubmit="return confirm('Delete this report and all its attachments?');" style="display:inline;">
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
            <i class="fas fa-chart-line"></i>
            <p>No reports yet. <a href="{{ route('admin.reports.create') }}">Create your first report →</a></p>
        </div>
    @endif
</div>
@endsection
