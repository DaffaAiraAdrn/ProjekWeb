@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Welcome back, {{ Auth::user()->name ?? 'Admin' }} 👋</h1>
        <p class="page-subtitle">Here's what's happening with your portfolio today.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New Portfolio Item</a>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-outline"><i class="fas fa-pen"></i> New Blog Post</a>
    </div>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-briefcase"></i></div>
        <div class="stat-value">{{ $portfolioCount ?? 0 }}</div>
        <div class="stat-label">Portfolio Items</div>
        <a href="{{ route('admin.portfolio.index') }}" class="stat-link">View all →</a>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-blog"></i></div>
        <div class="stat-value">{{ $blogCount ?? 0 }}</div>
        <div class="stat-label">Blog Posts</div>
        <a href="{{ route('admin.blog.index') }}" class="stat-link">View all →</a>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
        <div class="stat-value">{{ $reportCount ?? 0 }}</div>
        <div class="stat-label">Reports</div>
        <a href="{{ route('admin.reports.index') }}" class="stat-link">View all →</a>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-envelope"></i></div>
        <div class="stat-value">{{ $contactCount ?? 0 }}</div>
        <div class="stat-label">Contact Messages</div>
        @if(($unreadMessagesCount ?? 0) > 0)
            <span class="badge badge-red" style="margin-top:.5rem;display:inline-flex;">
                <i class="fas fa-circle" style="font-size:.5rem;"></i> {{ $unreadMessagesCount }} unread
            </span>
        @else
            <a href="{{ route('admin.contact.index') }}" class="stat-link">View all →</a>
        @endif
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:2rem;" class="dashboard-grid">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Recent Activity</h2>
        </div>
        @if(!empty($recentActivity))
            <ul class="activity-list">
                @foreach($recentActivity as $activity)
                    <li class="activity-item">
                        <div class="activity-icon"><i class="fas fa-{{ $activity['icon'] ?? 'circle' }}"></i></div>
                        <div>
                            <div class="activity-text">{{ $activity['text'] }}</div>
                            <div class="activity-time">{{ $activity['time'] }}</div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty-state">
                <i class="fas fa-clock"></i>
                <p>No recent activity to show.</p>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Quick Actions</h2>
        </div>
        <div class="quick-actions">
            <a href="{{ route('admin.portfolio.create') }}" class="quick-action">
                <i class="fas fa-briefcase"></i>
                <span>Add Portfolio</span>
            </a>
            <a href="{{ route('admin.blog.create') }}" class="quick-action">
                <i class="fas fa-pen-fancy"></i>
                <span>Write Blog</span>
            </a>
            <a href="{{ route('admin.reports.create') }}" class="quick-action">
                <i class="fas fa-file-alt"></i>
                <span>New Report</span>
            </a>
            <a href="{{ route('admin.media.index') }}" class="quick-action">
                <i class="fas fa-upload"></i>
                <span>Upload Media</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="quick-action">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
            <a href="{{ route('admin.contact.index') }}" class="quick-action">
                <i class="fas fa-envelope-open"></i>
                <span>Messages</span>
            </a>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .dashboard-grid { grid-template-columns: 1fr !important; }
    }
</style>
@endsection
