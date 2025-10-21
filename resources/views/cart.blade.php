@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<div class="container py-5">

  {{-- Header --}}
  <div class="text-center mb-4">
    <h1 class="fw-bold">Your Shopping Cart</h1>
    <p class="text-muted">Review your selected items before checkout.</p>
  </div>

  {{-- Cart Table --}}
  <div class="table-responsive mb-4">
    <table class="table align-middle text-center">
      <thead class="table-light">
        <tr>
          <th scope="col">Product</th>
          <th scope="col">Price</th>
          <th scope="col">Quantity</th>
          <th scope="col">Total</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        {{-- Example items (you can later make this dynamic) --}}
        <tr>
          <td class="text-start">
            <div class="d-flex align-items-center">
              <img src="https://picsum.photos/seed/cart1/80/80" alt="Vitamin Boost" class="rounded me-3">
              <div>
                <div class="fw-semibold">Vitamin Boost</div>
                <small class="text-muted">Daily multivitamins</small>
              </div>
            </div>
          </td>
          <td>€12.99</td>
          <td>
            <input type="number" class="form-control text-center" value="1" min="1" style="width: 80px;">
          </td>
          <td>€12.99</td>
          <td>
            <button class="btn btn-outline-danger btn-sm">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>

        <tr>
          <td class="text-start">
            <div class="d-flex align-items-center">
              <img src="https://picsum.photos/seed/cart2/80/80" alt="Protein Snacks" class="rounded me-3">
              <div>
                <div class="fw-semibold">Protein Snacks</div>
                <small class="text-muted">High-protein healthy treats</small>
              </div>
            </div>
          </td>
          <td>€5.99</td>
          <td>
            <input type="number" class="form-control text-center" value="2" min="1" style="width: 80px;">
          </td>
          <td>€11.98</td>
          <td>
            <button class="btn btn-outline-danger btn-sm">
              <i class="bi bi-trash"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  {{-- Summary --}}
  <div class="row justify-content-end">
    <div class="col-md-5 col-lg-4">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <h5 class="fw-bold mb-3">Order Summary</h5>

          <div class="d-flex justify-content-between">
            <span>Subtotal</span>
            <span>€24.97</span>
          </div>
          <div class="d-flex justify-content-between">
            <span>Shipping</span>
            <span>€2.99</span>
          </div>
          <hr>
          <div class="d-flex justify-content-between fw-bold">
            <span>Total</span>
            <span>€27.96</span>
          </div>

          <div class="d-grid gap-2 mt-4">
            <a href="{{ url('/shop') }}" class="btn btn-outline-secondary">
              <i class="bi bi-arrow-left me-1"></i> Continue Shopping
            </a>
            <a href="{{ url('/checkout') }}" class="btn btn-primary">
              <i class="bi bi-credit-card me-1"></i> Proceed to Checkout
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
