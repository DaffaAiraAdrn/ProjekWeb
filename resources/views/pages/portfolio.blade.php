@extends('layouts.app')

@section('title', 'My Portfolio')

@section('body_class', 'intro-content')

@section('content')
<main class="flex-fill container-fluid py-5 text-center text-light">
    <h1 class="display-4 fw-bold">
        My Portfolio
    </h1>
    <p class="lead">Here are some of my best works across 3D Modelling, Machine Learning, and Programming</p>
    <div class="text-center mb-4">
        <button class="btn btn-outline-light mx-2 tab-btn active" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter All" data-filter="all">All</button>
        <button class="btn btn-outline-light mx-2 tab-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter 3D" data-filter="3d">3D Modelling</button>
        <button class="btn btn-outline-light mx-2 tab-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter ML" data-filter="ml">Machine Learning</button>
        <button class="btn btn-outline-light mx-2 tab-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter Programming" data-filter="code">Programming</button>
    </div>
    <div class="row g-4" id="portfolioGrid">

        
        <div class="col-md-4 portfolio-item" data-category="3d">
            <div class="card bg-dark text-light portfolio-card p-3 flex-fill" data-bs-toggle="modal" data-bs-target="#modal1">
                <img src="{{ asset('images/perfume.png') }}" class="w-100" alt="">
                <h5 class="fw-bold mt-3">3D Perfume Model</h5>                    
                <p>Fully-texture Procedural High-poly Perfume Model</p>
                <span class="badge text-bg-info">3D Modelling</span>
            </div>
        </div>

        <div class="col-md-4 portfolio-item" data-category="3d">
            <div class="card bg-dark text-light portfolio-card p-3 flex-fill" data-bs-toggle="modal" data-bs-target="#modal2">
                <img src="{{ asset('images/perfume2.png') }}" class="w-100" alt="">
                <h5 class="fw-bold mt-3">3D Perfume Model</h5>                    
                <p>Fully-textured Procedural High-poly Perfume Model</p>
                <span class="badge text-bg-info">3D Modelling</span>
            </div>
        </div>

        <div class="col-md-4 portfolio-item" data-category="3d">
            <div class="card bg-dark text-light portfolio-card p-3" data-bs-toggle="modal" data-bs-target="#modal3">
                <img src="{{ asset('images/star.png') }}" class="w-100" alt="">
                <h5 class="fw-bold mt-3">A Star</h5>                    
                <p>Full Procedural Model of a Star using Blender</p>
                <span class="badge text-bg-info">3D Modelling</span>
            </div>
        </div>


        
        <div class="col-md-4 portfolio-item" data-category="ml">
            <div class="card bg-dark text-light portfolio-card p-3" data-bs-toggle="modal" data-bs-target="#modal4">
                <img src="{{ asset('images/CNN.png') }}" class="w-100" alt="">
                <h5 class="fw-bold mt-3">Image Classifier</h5>                    
                <p>CNN for multi-class image classification.</p>
                <span class="badge text-bg-warning">Machine Learning</span>
            </div>
        </div>

        <div class="col-md-4 portfolio-item" data-category="ml">
            <div class="card bg-dark text-light portfolio-card p-3" data-bs-toggle="modal" data-bs-target="#modal5">
                <img src="{{ asset('images/NonLinearNN.png') }}" class="w-100" alt="">
                <h5 class="fw-bold mt-3">Non-Linear Neural Network</h5>                    
                <p>Neural Network for Predicting Non-Linear Data</p>
                <span class="badge text-bg-warning">Machine Learning</span>
            </div>
        </div>


        
        <div class="col-md-4 portfolio-item" data-category="code">
            <div class="card bg-dark text-light portfolio-card p-3" data-bs-toggle="modal" data-bs-target="#modal6">
                <img src="{{ asset('images/laundryapps.png') }}" class="w-100" alt="">
                <h5 class="fw-bold mt-3">Laundry Service Application</h5>                    
                <p>Application for Laundry Service made using Java.</p>
                <span class="badge text-bg-success">Programming</span>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modal1" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">3D Perfume Model</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="carousel1" class="carousel slide mb-3">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/perfume.png') }}" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/perfumeB.png') }}" class="d-block w-100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel1" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel1" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                <p>
                    A high-detail perfume modeled in Blender using hard-surface techniques.  
                    Features baked textures, PBR workflow, and precise curvature.

                </p>
                <p>
                    year: 2025                        
                </p>
                <p>
                    Made in Blender                        
                </p>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal2" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">3D Perfume Model</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="carousel2" class="carousel slide mb-3">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/perfume2.png') }}" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/perfume2B.png') }}" class="d-block w-100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel2" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel2" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                <p>
                    A high-detail perfume modeled in Blender using hard-surface techniques.  
                    Features baked textures, PBR workflow, and precise curvature.

                </p>
                <p>
                    year: 2025                        
                </p>
                <p>
                    Made in Blender                        
                </p>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal3" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Procedural Star</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="carousel3" class="carousel slide mb-3">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/star.png') }}" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/starB.png') }}" class="d-block w-100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel3" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel3" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                <p>
                    A high-detail perfume modeled in Blender using hard-surface techniques.  
                    Features baked textures, PBR workflow, and precise curvature.

                </p>
                <p>
                    year: 2025                        
                </p>
                <p>
                    Made in Blender                        
                </p>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="modal4" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Image Classifier</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="carousel4" class="carousel slide mb-3">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/CNN.png') }}" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/CNNB.png') }}" class="d-block w-100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel4" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel4" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                <p>
                    Convolutional Neural Network for image classification using PyTorch.

                </p>
                <p>
                    year: 2024                        
                </p>
                <p>
                    Made in Google Colab                        
                </p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal5" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Object Detection</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="carousel5" class="carousel slide mb-3">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/NonLinearNN.png') }}" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/NonLinearB.png') }}" class="d-block w-100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel5" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel5" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                <p>
                    Neural Network for predicting Non-Linear Data

                </p>
                <p>
                    year: 2024                        
                </p>
                <p>
                    Made in Google Colab                        
                </p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal6" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Laundry Service Application</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="carousel6" class="carousel slide mb-3">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('images/laundryapps.png') }}" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="{{ asset('images/laundryappsB.png') }}" class="d-block w-100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel6" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carousel6" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                <p>
                    Application for laundary service made using Java integrated with MySQL

                </p>
                <p>
                    year: 2025                        
                </p>
                <p>
                    Made in Eclipse IDE                        
                </p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const tabs = document.querySelectorAll(".tab-btn");
    const items = document.querySelectorAll(".portfolio-item");

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            tabs.forEach(t => t.classList.remove("active"));
            tab.classList.add("active");

            const filter = tab.dataset.filter;

            items.forEach(item => {
                if (filter === "all" || item.dataset.category === filter) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    });
</script>
@endpush