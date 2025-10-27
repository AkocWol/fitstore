@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
  <h1 class="fw-bold mb-4">Checkout</h1>

  @if (!count($items))
    <div class="alert alert-warning">Je cart is leeg.</div>
    <a href="{{ url('/shop') }}" class="btn btn-outline-secondary">Terug naar shop</a>
  @else
    <div class="row g-4">
      <div class="col-lg-7">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="fw-bold mb-3">Verzendadres</h5>
            <form method="POST" action="{{ route('checkout.place') }}">
              @csrf
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Voornaam</label>
                  <input class="form-control" name="first_name" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Achternaam</label>
                  <input class="form-control" name="last_name" required>
                </div>
                <div class="col-12">
                  <label class="form-label">Adres</label>
                  <input class="form-control" name="address" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Plaats</label>
                  <input class="form-control" name="city" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Postcode</label>
                  <input class="form-control" name="zip" required>
                </div>

                <hr class="mt-4">

                <h5 class="fw-bold mb-3">Betaling (demo)</h5>
                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment" value="ideal" id="p1" checked>
                    <label class="form-check-label" for="p1">iDEAL (demo)</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment" value="card" id="p2">
                    <label class="form-check-label" for="p2">Creditcard (demo)</label>
                  </div>
                </div>

                <div class="col-12 mt-3">
                  <button class="btn btn-success">
                    <i class="bi bi-bag-check me-1"></i> Plaats bestelling (demo)
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <h5 class="fw-bold mb-3">Orderoverzicht</h5>
            <ul class="list-group list-group-flush mb-3">
              @foreach ($items as $it)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <div>
                    <div class="fw-semibold">{{ $it['name'] }}</div>
                    <small class="text-muted">Qty: {{ $it['qty'] }}</small>
                  </div>
                  <div>€{{ number_format($it['price'] * $it['qty'], 2) }}</div>
                </li>
              @endforeach
            </ul>
            <div class="d-flex justify-content-between">
              <span class="fw-semibold">Totaal</span>
              <span class="fw-bold">€{{ number_format($total, 2) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection
