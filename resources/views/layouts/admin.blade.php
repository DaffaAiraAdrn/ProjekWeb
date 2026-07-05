<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') — Portfolio CMS</title>

    {{-- Google Fonts: Montserrat --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Quill Editor --}}
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    {{-- Admin Stylesheet --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    {{-- Sidebar --}}
    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-brand">
            <i class="fas fa-code"></i>DF_137
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('admin.portfolio.index') }}" class="{{ request()->routeIs('admin.portfolio.*') ? 'active' : '' }}">
                <i class="fas fa-briefcase"></i> Portfolio
            </a>
            <a href="{{ route('admin.blog.index') }}" class="{{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                <i class="fas fa-blog"></i> Blog
            </a>
            <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Reports
            </a>
            <a href="{{ route('admin.media.index') }}" class="{{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                <i class="fas fa-photo-video"></i> Media
            </a>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Settings
            </a>
            <a href="{{ route('admin.contact.index') }}" class="{{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Messages
                @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                    <span class="nav-badge">{{ $unreadMessagesCount }}</span>
                @endif
            </a>
        </nav>
        <div class="sidebar-footer">
            <a href="{{ route('home') }}" target="_blank" style="display:flex;align-items:center;gap:.5rem;margin-bottom:.75rem;">
                <i class="fas fa-external-link-alt"></i> View Site
            </a>
            <form method="POST" action="{{ route('admin.logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-icon" title="Logout"><i class="fas fa-sign-out-alt"></i></button>
            </form>
        </div>
    </aside>

    {{-- Sidebar overlay for mobile --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Main --}}
    <div class="main" id="adminMain">
        <header class="topbar">
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div class="topbar-title">@yield('title', 'Dashboard')</div>
            <div class="topbar-actions">
                <div class="topbar-user">
                    <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
                    <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                </div>
            </div>
        </header>

        <main class="content">
            @if(session('success'))
                <div class="flash flash-success content-flash">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flash flash-error content-flash">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    {{-- Toast container --}}
    <div class="toast-container" id="toastContainer"></div>

    {{-- Scripts --}}
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script src="{{ asset('js/admin.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
