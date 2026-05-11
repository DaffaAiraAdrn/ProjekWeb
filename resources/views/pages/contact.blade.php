@extends('layouts.app')

@section('title', 'Contact Me')

@section('body_class', 'contact-section')

@section('content')
<main>
    <div class="container text-center">
        <h1 class="display-1 fw-semibold pt-5">
        Contact Me
        </h1>
        <p class="lead">Feel free to reach out to me if you want to get anything done</p>
        <div class="row g-5">
            <div class="col-12 col-lg-7 col-md-7">
                <div class="card bg-dark text-light text-start p-4 shadow-lg border-0 rounded-4">
                    <form class="needs-validation" id="contactForm" novalidate>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name *</label>
                            <input type="text" class="form-control" required>
                            <div class="invalid-feedback">Name is required.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email *</label>
                            <input type="email" class="form-control" required>
                            <div class="invalid-feedback">Enter a valid email.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone Number *</label>
                            <input type="tel" class="form-control" required pattern="[0-9]{12,13}">
                            <div class="invalid-feedback">Enter a valid phone number (12–13 digits).</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Subject *</label>
                            <select class="form-select" required>
                                <option value="" disabled selected>Select a subject</option>
                                <option value="Visualization">Visualization</option>
                                <option value="System Development">System Development</option>
                                <option value="Collaboration">Collaboration</option>
                                <option value="Automation by Machine Learning">Automation by Machine Learning</option>
                            </select>
                            <div class="invalid-feedback">Select one subject.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Message *</label>
                            <textarea class="form-control" rows="5" required></textarea>
                            <div class="invalid-feedback">Message cannot be empty.</div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="agreeCheck" required>
                            <label class="form-check-label" for="agreeCheck">
                                I agree to terms and conditions
                            </label>
                            <div class="invalid-feedback">You must agree before submitting.</div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="submitBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Kirim Pesan Anda">
                            Send Message
                        </button>

                    </form>

                </div>
                
            </div>
            <div class="col-12 col-lg-5 col-md-5 text-start">
                <h3 class="fw-bold mb-3">Contact Information</h3>
                <p><i class="bi bi-geo-alt-fill me-2"></i>Padang, West Sumatra, Indonesia</p>
                <p><i class="bi bi-envelope-fill me-2"></i>2411531006_daffa@unand.ac.id</p>
                <p><i class="bi bi-telephone-fill me-2"></i>+62 831-6308-2028</p>

                <h5 class="fw-semibold mt-4 mb-2">My Socials</h5>
                <div class="d-flex gap-3 fs-3">
                    <a href="https://instagram.com/df__137" class="text-primary"><i class="bi bi-instagram"></i></a>
                    <a href="mailto:2411531006_daffa@unand.ac.id" class="text-info"><i class="bi bi-envelope"></i></a>
                    <a href="https://github.com/DaffaAiraAdrn" class="text-light"><i class="bi bi-github"></i></a>
                    <a href="https://youtube.com/@360hz4" class="text-danger"><i class="bi bi-youtube"></i></a>
                </div>
                <div class="mt-4">
                    <h5 class="fw-semibold">Location</h5>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1994.6562470681497!2d100.46176067807919!3d-0.9123601790059307!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b74586486fdf%3A0xe951b3c192902a5f!2sFakultas%20Teknologi%20Pertanian%20Universitas%20Andalas!5e0!3m2!1sen!2sid!4v1765547864888!5m2!1sen!2sid" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        
                    </iframe>
                </div>
            </div>

        </div>
    </div>
</main>

<div class="position-fixed top-0 end-0 p-3" style="z-index: 2000;">
    <div id="successToast" class="toast bg-success text-light border-0 shadow-lg" role="alert">
        <div class="toast-header bg-success text-light border-0">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            Your message has been sent successfully!
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (() => {
        'use strict';

        const form = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');

        const successToastEl = document.getElementById('successToast');
        const successToast = new bootstrap.Toast(successToastEl);

        function checkFormValidity() {
            submitBtn.disabled = !form.checkValidity();
        }

        form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('input', checkFormValidity);
            field.addEventListener('change', checkFormValidity);
        });

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            if (!form.checkValidity()) {
                event.stopPropagation();
                form.classList.add('was-validated');
                submitBtn.disabled = true;
                return;
            }

            successToast.show();

            form.reset();
            form.classList.remove('was-validated');
            submitBtn.disabled = false;
        });

    })();
</script>
@endpush