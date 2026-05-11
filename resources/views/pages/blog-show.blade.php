@extends('layouts.app')

@section('title', $report['title'])

@section('body_class', 'intro-content')

@section('content')
<main class="flex-fill container-fluid py-5 text-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <a href="{{ route('blog.index') }}" class="btn btn-outline-light mb-4"><i class="bi bi-arrow-left me-2"></i>Back to Reports</a>
                <h1 class="display-4 fw-bold mb-3">{{ $report['title'] }}</h1>
                <p class="text-secondary mb-5">Published on: {{ $report['date'] }}</p>
                
                <div class="report-content lh-lg fs-5">
                    {!! $report['content'] !!}
                </div>
            </div>
        </div>
    </div>
</main>
@endsection