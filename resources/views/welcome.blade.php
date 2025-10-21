@extends('layouts.app')

@section('title', 'Welcome to FitStore')

@section('content')
<div class="container py-5 text-center">

    {{-- Hero --}}
    <h1 class="display-4 fw-bold mb-3">
        Welcome to <span class="text-primary">FitStore</span>
    </h1>
    <p class="lead text-muted mb-4">
        Discover quality products that help you live a healthier, stronger life.
    </p>

    <div class="mb-5">
        @guest
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">
                <i class="bi bi-box-arrow-in-right me-1"></i> Log In
            </a>
            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-person-plus me-1"></i> Create Account
            </a>
        @else
            <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg me-2">
                <i class="bi bi-bag-heart me-1"></i> Go to Shop
            </a>
            <a href="{{ url('/cart') }}" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-speedometer2 me-1"></i> My cart
            </a>
        @endguest
    </div>

    {{-- Highlights --}}
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-heart-pulse fs-1 text-primary mb-3"></i>
                    <h5 class="fw-bold">Health Essentials</h5>
                    <p class="text-muted small">Supplements, vitamins, and wellness gear made for you.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-droplet fs-1 text-primary mb-3"></i>
                    <h5 class="fw-bold">Stay Hydrated</h5>
                    <p class="text-muted small">Hydration tools and drinks that keep you energized.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="bi bi-graph-up-arrow fs-1 text-primary mb-3"></i>
                    <h5 class="fw-bold">Boost Performance</h5>
                    <p class="text-muted small">Everything you need to perform and recover better.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
