<!DOCTYPE html>
<html lang="en" class="js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- SEO Meta --}}
    <title>@yield('title', $settings['site_title'] ?? 'DF_137 — Daffa Aira Adrin')</title>
    <meta name="description" content="@yield('meta_description', 'Daffa Aira Adrin (DF_137) — Informatics student passionate about 3D Modeling, Machine Learning, and Programming.')">
    <meta name="keywords" content="Daffa Aira Adrin, DF_137, 3D Modeling, Machine Learning, Programming, Portfolio">
    <meta name="author" content="Daffa Aira Adrin">
    <meta name="theme-color" content="#150B22">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', $settings['site_title'] ?? 'DF_137 — Daffa Aira Adrin')">
    <meta property="og:description" content="Daffa Aira Adrin (DF_137) — 3D Artist • ML Engineer • Developer">
    <meta property="og:image" content="@yield('og_image', asset('img/og-image.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- Google Fonts: Montserrat --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    {{-- Stylesheets --}}
    <link rel="stylesheet" href="{{ asset('css/effects.css') }}?v=1.2">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=1.2">

    {{-- Three.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    {{-- GSAP + ScrollTrigger --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    {{-- Lenis Smooth Scroll --}}
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>

    @stack('head')
</head>
<body>

    {{-- Page Loader --}}
    <div class="page-loader" id="pageLoader">
        <div class="loader-logo">
            <span class="loader-bracket">[</span>
            <span class="loader-text">DF_137</span>
            <span class="loader-bracket">]</span>
        </div>
        <div class="loader-bar"><div class="loader-bar-fill"></div></div>
    </div>

    {{-- Custom Cursor --}}
    <div class="cursor-dot" id="cursorDot"></div>
    <div class="cursor-ring" id="cursorRing"></div>

    {{-- Three.js Canvas --}}
    <canvas id="threeCanvas" class="three-canvas"></canvas>

    {{-- Noise Overlay --}}
    <div class="noise-overlay"></div>

    {{-- Navbar --}}
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="nav-logo">
                <span class="logo-bracket">[</span>
                <span class="logo-text">DF_137</span>
                <span class="logo-bracket">]</span>
            </a>
            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>
            <ul class="nav-links" id="navLinks">
                <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                <li><a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                <li><a href="{{ route('portfolio.index') }}" class="nav-link {{ request()->routeIs('portfolio.*') ? 'active' : '' }}">Portfolio</a></li>
                <li><a href="{{ route('blog.index') }}" class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a></li>
                <li><a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">Reports</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
            </ul>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="main-content">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <div class="footer-glow"></div>
        <div class="footer-container">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="footer-logo">
                    <span class="logo-bracket">[</span>DF_137<span class="logo-bracket">]</span>
                </a>
                <p class="footer-tagline">3D Artist • ML Engineer • Developer</p>
            </div>
            <div class="footer-social">
                <a href="https://github.com/DaffaAiraAdrn" target="_blank" rel="noopener" class="social-link" aria-label="GitHub">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M12 .5C5.37.5 0 5.78 0 12.29c0 5.21 3.44 9.63 8.21 11.19.6.11.82-.25.82-.56v-2.02c-3.34.71-4.04-1.59-4.04-1.59-.55-1.37-1.34-1.74-1.34-1.74-1.09-.73.08-.72.08-.72 1.21.08 1.85 1.22 1.85 1.22 1.07 1.8 2.81 1.28 3.5.98.11-.76.42-1.28.76-1.57-2.67-.3-5.47-1.3-5.47-5.79 0-1.28.47-2.33 1.23-3.15-.12-.3-.53-1.51.12-3.15 0 0 1-.32 3.3 1.2a11.6 11.6 0 0 1 6 0c2.3-1.52 3.3-1.2 3.3-1.2.65 1.64.24 2.85.12 3.15.77.82 1.23 1.87 1.23 3.15 0 4.5-2.81 5.48-5.49 5.78.43.36.81 1.08.81 2.18v3.23c0 .31.22.68.83.56A12.01 12.01 0 0 0 24 12.29C24 5.78 18.63.5 12 .5z"/></svg>
                </a>
                <a href="https://youtube.com/@360hz4" target="_blank" rel="noopener" class="social-link" aria-label="YouTube">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M23.5 6.2a3.02 3.02 0 0 0-2.12-2.14C19.5 3.55 12 3.55 12 3.55s-7.5 0-9.38.51A3.02 3.02 0 0 0 .5 6.2C0 8.08 0 12 0 12s0 3.92.5 5.8a3.02 3.02 0 0 0 2.12 2.14c1.88.51 9.38.51 9.38.51s7.5 0 9.38-.51a3.02 3.02 0 0 0 2.12-2.14C24 15.92 24 12 24 12s0-3.92-.5-5.8zM9.55 15.57V8.43L15.82 12l-6.27 3.57z"/></svg>
                </a>
                <a href="https://instagram.com/df__137" target="_blank" rel="noopener" class="social-link" aria-label="Instagram">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.7 3.7 0 0 1-1.38-.9 3.7 3.7 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63c-.79.31-1.46.72-2.13 1.38A5.9 5.9 0 0 0 .63 4.14c-.3.76-.5 1.64-.56 2.91C.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91.31.79.72 1.46 1.38 2.13.67.66 1.34 1.07 2.13 1.38.76.3 1.64.5 2.91.56C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56a5.9 5.9 0 0 0 2.13-1.38 5.9 5.9 0 0 0 1.38-2.13c.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91a5.9 5.9 0 0 0-1.38-2.13A5.9 5.9 0 0 0 19.86.63c-.76-.3-1.64-.5-2.91-.56C15.67.01 15.26 0 12 0zm0 5.84a6.16 6.16 0 1 0 0 12.32 6.16 6.16 0 0 0 0-12.32zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.41-10.85a1.44 1.44 0 1 0 0 2.88 1.44 1.44 0 0 0 0-2.88z"/></svg>
                </a>
                <a href="mailto:2411531006_daffa@unand.ac.id" class="social-link" aria-label="Email">
                    <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M24 5.46c0-.34-.01-.67-.04-1H0c-.03.33-.04.66-.04 1v13.08c0 1.98 1.6 3.58 3.58 3.58h16.84c1.98 0 3.58-1.6 3.58-3.58V5.46zM3.58 2.04h16.84C22.4 2.04 24 3.64 24 5.62v.06L12 13.5 0 5.68v-.06c0-1.98 1.6-3.58 3.58-3.58z"/></svg>
                </a>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Daffa Aira Adrin (DF_137). All rights reserved.</p>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="{{ asset('js/three-scene.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    {{-- Temporary Visual Debugger for Mobile Overflow (Will highlight overflowing elements in red outline) --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const overflowElements = [];
            document.querySelectorAll('*').forEach(el => {
                // Ignore elements that are not visible to the user
                const style = window.getComputedStyle(el);
                if (style.display === 'none' || style.visibility === 'hidden' || style.opacity === '0') {
                    return;
                }
                const rect = el.getBoundingClientRect();
                if (rect.right > window.innerWidth + 1 || rect.left < -1) {
                    el.style.outline = '2px dashed red';
                    el.style.outlineOffset = '-2px';
                    let elDesc = el.tagName.toLowerCase();
                    if (el.id) elDesc += '#' + el.id;
                    if (el.className) elDesc += '.' + Array.from(el.classList).join('.');
                    overflowElements.push(elDesc);
                }
            });
            if (overflowElements.length > 0) {
                const debugDiv = document.createElement('div');
                debugDiv.style.position = 'fixed';
                debugDiv.style.top = '10px';
                debugDiv.style.left = '10px';
                debugDiv.style.background = 'rgba(239, 68, 68, 0.95)';
                debugDiv.style.color = '#fff';
                debugDiv.style.padding = '12px';
                debugDiv.style.borderRadius = '8px';
                debugDiv.style.zIndex = '999999';
                debugDiv.style.fontSize = '11px';
                debugDiv.style.fontFamily = 'monospace';
                debugDiv.style.maxHeight = '250px';
                debugDiv.style.maxWidth = '300px';
                debugDiv.style.overflowY = 'auto';
                debugDiv.style.boxShadow = '0 10px 30px rgba(0,0,0,0.5)';
                debugDiv.style.border = '1px solid rgba(255,255,255,0.2)';
                debugDiv.innerHTML = '<b>⚠️ Overflow Elements (Red Outline):</b><br><ol style="margin-left:15px;margin-top:5px;">' + 
                    [...new Set(overflowElements)].map(el => '<li>' + el + '</li>').join('') + '</ol>';
                document.body.appendChild(debugDiv);
            }
        }, 1200);
    });
    </script>

    @yield('scripts')
</body>
</html>
