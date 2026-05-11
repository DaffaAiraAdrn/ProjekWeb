@extends('layouts.app')

@section('title', 'About Me')

@section('body_class', 'intro-content')

@section('content')
<main class="flex-fill">
    <section class="introduction">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-5 text-center pt-5 mb-4">
                    <img src="{{ asset('images/profilepicture.png') }}" class="img-fluid rounded-4 shadow w-50" alt="Profile Photo">
                </div>
                <div class="col-12 col-md-6 col-lg-5 mt-4 pt-3 text-start">
                    <h1 class="display-3 fw-bold text-light">
                        About Me
                    </h1>
                    <p class="lead text-light fw-semibold">
                        A Quick introduction about who I am and what I do
                    </p>
                    <p class="text-light">
                        Hello, my name is Daffa Aira Adrin, you may call me Daffa. I'm a bachelor student at the Informatics department from Universitas Andalas. 
                    </p> 
                    <p class="text-light">
                        Throughout the years, i've grown a passion<span class="fw-semibold"> 3D modelling, machine learning, and programming.</span>
                    </p>
                    <p class="text-light lead fw-semibold">
                        My Mission
                    </p>
                    <p class="text-light">
                        To contribute to my religion with my knowledge of programming, machine learning, and 3D modelling.
                    </p>
                    <p class="text-light lead fw-semibold">
                        My Vision
                    </p>
                    <p class="text-light mb-5">
                        To build useful digital experiences that help people and improve the world and my religion.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container py-5">
            <h2 class="mb-4 text-center text-light mb-5">A little profile about me</h2>
            <div class="row justify-content-start">
                <div class="col-12 col-md-10 col-lg-12">
                    <div class="accordion" id="timelineAccordion">                            
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="schoolHeader">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#schoolCollapse" aria-expanded="true">
                                    <i class="bi bi-mortarboard-fill me-2"></i> School Timeline
                                </button>
                            </h2>
                            <div id="schoolCollapse" class="accordion-collapse collapse show"
                                data-bs-parent="#timelineAccordion">
                                <div class="accordion-body">
                                    <ul class="timeline">
                                        <li>
                                            <span class="year">2012 - 2018</span>
                                            <h5>SDN 057 Binaharapan Bandung</h5>                                                
                                        </li>
                                        <li>
                                            <span class="year">2018 - 2019</span>
                                            <h5>SMPN 50 Bandung</h5>                                                
                                        </li>
                                        <li>
                                            <span class="year">2019 - 2021</span>
                                            <h5>SMPN 1 Payakumbuh</h5>                                                
                                        </li>
                                        <li>
                                            <span class="year">2021 - 2024</span>
                                            <h5>SMAN 1 Payakumbuh</h5>
                                            <p>Lulusan Jalur SNBP 2024</p>
                                        </li>
                                        <li>
                                            <span class="year">2024 - Present</span>
                                            <h5>Universitas Andalas</h5>
                                            <p>Jurusan Informatika</p>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="experienceHeader">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#experienceCollapse">
                                    <i class="bi bi-briefcase-fill me-2"></i> Experience
                                </button>
                            </h2>
                            <div id="experienceCollapse" class="accordion-collapse collapse"
                                data-bs-parent="#timelineAccordion">
                                <div class="accordion-body">
                                    <ul class="timeline">
                                        <li>
                                            <span class="year">2024</span>
                                            <h5>PyTorch</h5>
                                            <p>Built Machine Learning, Deep Learning models using Pytorch</p>
                                        </li>
                                        <li>
                                            <span class="year">2025</span>
                                            <h5>Staff Divisi Festika</h5>                                                
                                        </li>
                                        <li>
                                            <span class="year">2025</span>
                                            <h5>Visualisasi 3D sebuah konsep produk untuk proposal bisnis dalam ajang National Business Plan Competition (NBPC)</h5>
                                            
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="achievementHeader">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#achievementCollapse">
                                    <i class="bi bi-trophy-fill me-2"></i> Achievements
                                </button>
                            </h2>
                            <div id="achievementCollapse" class="accordion-collapse collapse"
                                data-bs-parent="#timelineAccordion">
                                <div class="accordion-body">
                                    <ul class="timeline">
                                        <li>
                                            <span class="year">2024</span>
                                            <h5>SNPB Graduate 2024</h5>                                        
                                        </li>                                            
                                    </ul>

                                </div>
                            </div>
                        </div>                            
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="skillsHeader">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#skillsCollapse">
                                    <i class="bi bi-lightbulb-fill me-2"></i> Skills
                                </button>
                            </h2>
                            <div id="skillsCollapse" class="accordion-collapse collapse"
                                data-bs-parent="#timelineAccordion">
                                <div class="accordion-body">

                                    <div class="skill mb-3">
                                        <span>Machine Learning with PyTorch</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 70%;">70%</div>
                                        </div>
                                    </div>

                                    <div class="skill mb-3">
                                        <span>3D Visualization with Blender </span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 65%;">65%</div>
                                        </div>
                                    </div>

                                    <div class="skill mb-3">
                                        <span>Java</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 75%;">75%</div>
                                        </div>
                                    </div>

                                    <div class="skill">
                                        <span>Programming with Python</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 65%;">65%</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
</main>
@endsection