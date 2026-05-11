@extends('layouts.app')

@section('title', 'Practical Reports')

@section('body_class', 'intro-content')

@section('content')
<main class="flex-fill container-fluid py-5 text-center text-light">
    <h1 class="display-4 fw-bold">
        Practical Reports
    </h1>
    <p class="lead">My technical write-ups and practical reports.</p>
    
    <div class="container mt-5 text-start">
        <div class="row g-4">
            @forelse($reports as $report)
            <div class="col-md-6 col-lg-4">
                <div class="card bg-dark text-light p-4 shadow-lg border-0 rounded-4 h-100 feature-card">
                    <h3 class="fw-bold">{{ $report['title'] }}</h3>
                    <p class="text-secondary small mb-3">{{ $report['date'] }}</p>
                    <p>{{ Str::limit($report['excerpt'], 100) }}</p>
                    <div class="mt-auto">
                        <a href="{{ route('blog.show', ['id' => $report['id']]) }}" class="btn btn-outline-light">Read Report</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="lead">No reports available yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</main>
@endsection