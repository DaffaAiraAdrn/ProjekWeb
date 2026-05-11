@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
<main class="flex-fill">
    <section class="main-content container-fluid text-start text-light ps-4">
        <div class="row">
            <div class="col-12 col-lg-6 col-md-6 ps-5 pt-5">
                <h1 class="display-1">Welcome to My Little Sanbox</h1>
                <p class="lead">The Place Where I Post About The Little Things I Did</p>
                <hr class="my-4">
                <p></p>
                <a class="btn btn-outline-light btn-lg" data-bs-toggle="tooltip" data-bs-placement="top" title="get in touch with me" href="{{ route('contact') }}" role="button">Contact Me</a>
                <a class="btn btn-outline-light btn-lg ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="See my best works" href="{{ route('portfolio') }}" role="button">Portfolio</a>
            </div>
            <div class="col-12 col-lg-6 col-md-6 text-center text-md-center">
                <img src="{{ asset('images/hero.png') }}" class="img-fluid" alt="logo">
            </div>    
    </section>
    <section class="text-light">
        <div class="feature-section container-fluid rounded-4 my-5 py-5">
            <div class="fw-bold text-center">
                <h1 class="display-5 fw-bold">What I Do</h1>
                <p class="lead">Here are some of the things I enjoy working on</p>

                <div class="row mt-5 gap-4 justify-content-center">
                    <div class="col-12 col-md-12 col-lg-3 d-flex">
                        <div class="feature-card card text-center p-4 shadow-lg rounded-4 border-0 flex-fill">
                            <i class="bi bi-badge-3d display-4 mb-3"></i>
                            <h3 class="fw-bold">3D Modelling</h3>
                            <p class="lead">3D visualizing Products, Texturing, Scenes, Concepts, and Everyday Objects</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-3 d-flex">
                        <div class="feature-card card text-center p-4 shadow-lg rounded-4 border-0 flex-fill">
                            <i class="bi bi-filetype-py display-4 mb-3"></i>
                            <h3 class="fw-bold">Programming</h3>
                            <p class="lead">Building software, scripts and tools to automate tasks and solve real-world problems.</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-3 d-flex">
                        <div class="feature-card card text-center p-4 shadow-lg rounded-4 border-0 flex-fill">
                            <i class="bi bi-lightbulb display-4 mb-3"></i>
                            <h3 class="fw-bold">Machine Learning</h3>
                            <p class="lead">Automating Daily Tasks, and solving real-world problems with Machine Learning</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="galery container rounded-4 mt-5 pt-5">
            <div class="row d-flex">
                <div class="text-center text-light mb-5">
                    <h2 class="display-5 fw-bold">Latest Projects</h2>
                    <p class="lead">Here are some of my latest projects</p>
                </div>

                <div class="col-12 col-md-12">
                    <div id="carouselExampleCaptions" class="carousel slide rounder-4 overflow-hidden">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></button>
                        </div>

                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/perfumeB.png') }}" class="d-block w-100" alt="">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>3D Visualization of a Perfume</h5>
                                    <p>This 3D Model of a Perfume was modeled in Blender using hard-surface and using Cycles to render the realistic looks.</p>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <img src="{{ asset('images/perfume2.png') }}" class="d-block w-100" alt="">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>3D Visualization of a Perfumel</h5>
                                    <p>This 3D Model of a Perfume was modeled in Blender using hard-surface and using Cycles to render the realistic looks</p>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <img src="{{ asset('images/starB.png') }}" class="d-block w-100" alt="">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>3D Procedural Star</h5>
                                    <p>A 3D Star made using procedural workflow in Blender </p>
                                </div>
                            </div>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>        
</main>
@endsection