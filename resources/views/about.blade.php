@extends('layouts.app')
@section('title', 'About FitStore')

@section('content')
<div class="container py-5">
  <div class="row align-items-center g-4 mb-5">
    <div class="col-md-6">
      <h1 class="fw-bold mb-3">About FitStore</h1>
      <p class="text-muted">
        FitStore is a straightforward shop for fitness gear, supplements, and accessories.
        We keep things simple: clear products, fair prices, and fast checkout.
      </p>
      <div class="d-flex gap-2">
        <a href="{{ url('/shop') }}" class="btn btn-primary">Shop now</a>
        <a href="mailto:support@fitstore.local" class="btn btn-outline-secondary">Contact us</a>
      </div>
    </div>
    <div class="col-md-6">
      <img src="https://placehold.co/900x550?text=FitStore" class="img-fluid rounded" alt="FitStore">
    </div>
  </div>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Our mission</h5>
          <p class="text-muted mb-0">
            Help you train smarter with essentials that actually matter—no noise, just value.
          </p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body">
          <h5 class="card-title">What we do</h5>
          <ul class="text-muted mb-0 ps-3">
            <li>Quality supplements and gear</li>
            <li>Fast, simple checkout</li>
            <li>Clear product info & pricing</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Why FitStore</h5>
          <ul class="text-muted mb-0 ps-3">
            <li>Hand-picked basics</li>
            <li>No pushy upsells</li>
            <li>Friendly support</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-5">
    <div class="alert alert-light border d-flex justify-content-between align-items-center">
      <div>
        <strong>Want to collaborate or have feedback?</strong><br>
        We’d love to hear from you.
      </div>
      <a href="mailto:support@fitstore.local" class="btn btn-outline-primary">Email us</a>
    </div>
  </div>
</div>
@endsection
