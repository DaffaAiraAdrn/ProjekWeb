<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portfolio')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column @yield('body_class')">
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg navbar-dark bg-black">            
            <div class="container">                
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('images/hero.png') }}" style="width: 50px; height: 50px;" alt="logo">
                    DF_137
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end text-center" id="navbarNav">
                    <ul class="navbar-nav mb-2 mb-lg-0 gap-3 fs-5">
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('portfolio') ? 'active' : '' }}" href="{{ route('portfolio') }}">Portfolio</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a></li>
                    </ul>                    
                </div>
            </div>
        </nav>        
    </header>
    
    @yield('content')

    <footer class="footer-section container-fluid mt-5 py-5">
        <hr class="border-secondary mb-4">
        <div class="row text-light px-3">
            <div class="col-12 col-md-4 col-lg-4 mb-4 text-md-start text-center">
                <h5 class="fw-bold mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-light text-decoration-none">Home</a></li>
                    <li><a href="{{ route('about') }}" class="text-light text-decoration-none">About</a></li>
                    <li><a href="{{ route('portfolio') }}" class="text-light text-decoration-none">Portfolio</a></li>
                    <li><a href="{{ route('contact') }}" class="text-light text-decoration-none">Contact</a></li>
                    <li><a href="{{ route('blog.index') }}" class="text-light text-decoration-none">Blog</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-4 col-lg-4 mb-4 text-center">
                <h4 class="fw-bold">Daffa Aira Adrin</h4>
                <div class="mt-3">
                    <a href="https://github.com/DaffaAiraAdrn" target="_blank" class="text-light fs-3 me-3">
                        <i class="bi bi-github"></i>
                    </a>
                    <a href="https://youtube.com/@360hz4" target="_blank" class="text-light fs-3 me-3">
                        <i class="bi bi-youtube"></i>
                    </a>
                    <a href="https://instagram.com/df__137" target="_blank" class="text-light fs-3 me-3">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="mailto:2411531006_daffa@unand.ac.id" target="_blank" class="text-light fs-3">
                        <i class="bi bi-envelope"></i>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4 mb-4 text-md-end text-center">
                <h5 class="fw-bold mb-3">About</h5>
                <p class="small">
                    I am Daffa Aira Adrin, an Informatics student passionate about 3D Modeling,
                    Machine Learning, and Programming.  
                    This website is where I share my projects, skills, and ideas.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <span class="text-light lead d-block mt-4">
                    © {{ date('Y') }} DaffaAiraAdrin. All rights reserved.
                </span>
            </div>
        </div>
    </footer>
    
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        window.addEventListener("load", () => {
            document.body.classList.add("page-loaded");
        });
    </script>
    @stack('scripts')
</body>
</html>