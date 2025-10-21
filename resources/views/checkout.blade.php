@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
  <h1 class="fw-bold mb-4">Checkout</h1>

  <form method="POST" action="{{ url('/checkout') }}">
    @csrf
    <div class="row g-4">
      {{-- LEFT: Customer, Shipping, Payment --}}
      <div class="col-lg-8">
        {{-- Customer Details --}}
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <h5 class="fw-bold mb-3">Customer Details</h5>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">First and last name</label>
                <input type="text" name="first_name" class="form-control" value="{{ old('first_name', auth()->user()->name ?? '') }}" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email ?? '') }}" required>
              </div>
              <div class="col-12">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" placeholder="Street & number" value="{{ old('address') }}" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Postal code</label>
                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code') }}" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Country</label>
                <select name="country" class="form-select" required>
                  <option value="">Select</option>
                  <option value="NL" {{ old('country')=='NL'?'selected':'' }}>Netherlands</option>
                  <option value="BE" {{ old('country')=='BE'?'selected':'' }}>Belgium</option>
                  <option value="DE" {{ old('country')=='DE'?'selected':'' }}>Germany</option>
                  <option value="FR" {{ old('country')=='FR'?'selected':'' }}>France</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        {{-- Shipping Method --}}
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <h5 class="fw-bold mb-3">Shipping</h5>
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="shipping" id="ship_standard" value="standard" checked>
              <label class="form-check-label d-flex justify-content-between w-100" for="ship_standard">
                <span>Standard (2–4 days)</span>
                <span>€2.99</span>
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="shipping" id="ship_express" value="express">
              <label class="form-check-label d-flex justify-content-between w-100" for="ship_express">
                <span>Express (1–2 days)</span>
                <span>€6.99</span>
              </label>
            </div>
          </div>
        </div>

        {{-- Payment Method --}}
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">
            <h5 class="fw-bold mb-3">Payment</h5>

            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="payment" id="pay_card" value="card" checked>
              <label class="form-check-label" for="pay_card">
                Credit/Debit Card
              </label>
            </div>

            <div class="row g-3 ms-4 mb-3">
              <div class="col-12">
                <label class="form-label">Card number</label>
                <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456">
              </div>
              <div class="col-6">
                <label class="form-label">Expiry (MM/YY)</label>
                <input type="text" name="card_expiry" class="form-control" placeholder="MM/YY">
              </div>
              <div class="col-6">
                <label class="form-label">CVC</label>
                <input type="text" name="card_cvc" class="form-control" placeholder="123">
              </div>
            </div>

            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="payment" id="pay_ideal" value="ideal">
              <label class="form-check-label" for="pay_ideal">
                iDEAL
              </label>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="radio" name="payment" id="pay_paypal" value="paypal">
              <label class="form-check-label" for="pay_paypal">
                PayPal
              </label>
            </div>
          </div>
        </div>
      </div>

      {{-- RIGHT: Order Summary --}}
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h5 class="fw-bold mb-3">Order Summary</h5>

            {{-- Example items (replace with real cart data) --}}
            <ul class="list-group list-group-flush mb-3">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Vitamin Boost</span>
                <span>€12.99</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <span>Protein Snacks</span>
                <span>€5.99</span>
              </li>
            </ul>

            <div class="d-flex justify-content-between">
              <span>Subtotal</span>
              <span>€18.98</span>
            </div>
            <div class="d-flex justify-content-between">
              <span>Shipping</span>
              <span id="shipping-amount">€2.99</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between fw-bold">
              <span>Total</span>
              <span>€21.97</span>
            </div>

            <div class="d-grid gap-2 mt-4">
              <a href="{{ url('/cart') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Cart
              </a>
              <button type="submit" class="btn btn-primary">
                <i class="bi bi-lock me-1"></i> Place Order
              </button>
            </div>

            <p class="text-muted small mt-3 mb-0">
              By placing your order, you agree to our terms and confirm your details are correct.
            </p>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
