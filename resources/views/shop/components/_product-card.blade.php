@php
  // HTTPS-afbeelding zonder DB: seed op ID zodat hij stabiel is
  $imgSmall = "https://picsum.photos/seed/{$product->id}/400/250";
@endphp

<div class="card h-100 shadow-sm border-0">
  <img src="{{ $imgSmall }}" class="card-img-top" alt="{{ $product->name }}">
  <div class="card-body text-center">
    <h6 class="fw-bold mb-1">{{ $product->name }}</h6>
    <p class="text-muted small mb-2">€{{ number_format($product->price, 2) }}</p>

    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
      {{-- TODO: vervang url naar je echte add-to-cart route als je die hebt --}}
      <form method="POST" action="{{ url('/cart/add') }}">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <button class="btn btn-primary btn-sm">
          <i class="bi bi-cart-plus me-1"></i> Add
        </button>
      </form>

      <button class="btn btn-outline-secondary btn-sm"
              data-bs-toggle="modal"
              data-bs-target="#productModal{{ $product->id }}">
        <i class="bi bi-zoom-in me-1"></i> View
      </button>
    </div>
  </div>
</div>
